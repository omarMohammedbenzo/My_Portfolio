<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\EducationRequest;
use App\Models\Education;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EducationController extends Controller
{
    public function index(): Response
    {
        $educations = Education::ordered()->get()->map(fn ($e) => [
            'id'         => $e->id,
            'school'     => $e->school,
            'degree'     => $e->getTranslations('degree'),
            'field'      => $e->getTranslations('field'),
            'location'   => $e->getTranslations('location'),
            'start_date' => $e->start_date?->format('Y-m-d'),
            'end_date'   => $e->end_date?->format('Y-m-d'),
            'order'      => $e->order,
        ]);

        return Inertia::render('Dashboard/Educations/Index', ['educations' => $educations]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Educations/Create');
    }

    public function store(EducationRequest $request): RedirectResponse
    {
        Education::create($request->validated());
        return redirect()->route('dashboard.educations.index')->with('success', 'Education added.');
    }

    public function edit(Education $education): Response
    {
        return Inertia::render('Dashboard/Educations/Edit', [
            'education' => [
                'id'          => $education->id,
                'school'      => $education->school,
                'degree'      => $education->getTranslations('degree'),
                'field'       => $education->getTranslations('field'),
                'location'    => $education->getTranslations('location'),
                'description' => $education->getTranslations('description'),
                'start_date'  => $education->start_date?->format('Y-m-d'),
                'end_date'    => $education->end_date?->format('Y-m-d'),
                'order'       => $education->order,
            ],
        ]);
    }

    public function update(EducationRequest $request, Education $education): RedirectResponse
    {
        $education->update($request->validated());
        return redirect()->route('dashboard.educations.index')->with('success', 'Education updated.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->delete();
        return back()->with('success', 'Education deleted.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate(['items' => 'required|array', 'items.*.id' => 'required|integer', 'items.*.order' => 'required|integer']);
        foreach ($request->items as $item) {
            Education::where('id', $item['id'])->update(['order' => $item['order']]);
        }
        return response()->json(['ok' => true]);
    }
}
