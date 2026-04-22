<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ExperienceController extends Controller
{
    public function index(): Response
    {
        $experiences = Experience::ordered()->get()->map(fn ($e) => [
            'id'              => $e->id,
            'company'         => $e->company,
            'role'            => $e->getTranslations('role'),
            'location'        => $e->getTranslations('location'),
            'start_date'      => $e->start_date?->format('Y-m-d'),
            'end_date'        => $e->end_date?->format('Y-m-d'),
            'is_current'      => $e->is_current,
            'employment_type' => $e->employment_type->value,
            'location_type'   => $e->location_type->value,
            'order'           => $e->order,
        ]);

        return Inertia::render('Dashboard/Experiences/Index', [
            'experiences'     => $experiences,
            'employmentTypes' => collect(EmploymentType::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
            'locationTypes'   => collect(LocationType::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Experiences/Create', [
            'employmentTypes' => collect(EmploymentType::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
            'locationTypes'   => collect(LocationType::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
        ]);
    }

    public function store(ExperienceRequest $request): RedirectResponse
    {
        Experience::create($request->validated());
        return redirect()->route('dashboard.experiences.index')->with('success', 'Experience added.');
    }

    public function edit(Experience $experience): Response
    {
        return Inertia::render('Dashboard/Experiences/Edit', [
            'experience' => [
                'id'              => $experience->id,
                'company'         => $experience->company,
                'role'            => $experience->getTranslations('role'),
                'location'        => $experience->getTranslations('location'),
                'description'     => $experience->getTranslations('description'),
                'start_date'      => $experience->start_date?->format('Y-m-d'),
                'end_date'        => $experience->end_date?->format('Y-m-d'),
                'is_current'      => $experience->is_current,
                'employment_type' => $experience->employment_type->value,
                'location_type'   => $experience->location_type->value,
                'order'           => $experience->order,
            ],
            'employmentTypes' => collect(EmploymentType::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
            'locationTypes'   => collect(LocationType::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
        ]);
    }

    public function update(ExperienceRequest $request, Experience $experience): RedirectResponse
    {
        $experience->update($request->validated());
        return redirect()->route('dashboard.experiences.index')->with('success', 'Experience updated.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();
        return back()->with('success', 'Experience deleted.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate(['items' => 'required|array', 'items.*.id' => 'required|integer', 'items.*.order' => 'required|integer']);
        foreach ($request->items as $item) {
            Experience::where('id', $item['id'])->update(['order' => $item['order']]);
        }
        return response()->json(['ok' => true]);
    }
}
