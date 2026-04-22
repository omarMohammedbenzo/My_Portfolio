<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\SkillCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SkillRequest;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SkillController extends Controller
{
    public function index(): Response
    {
        $skills = Skill::ordered()->get()->map(fn ($s) => [
            'id'       => $s->id,
            'name'     => $s->getTranslations('name'),
            'category' => $s->category->value,
            'level'    => $s->level,
            'icon'     => $s->icon,
            'order'    => $s->order,
        ]);

        return Inertia::render('Dashboard/Skills/Index', [
            'skills'     => $skills,
            'categories' => collect(SkillCategory::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label(), 'color' => $c->color()]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Skills/Create', [
            'categories' => collect(SkillCategory::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
        ]);
    }

    public function store(SkillRequest $request): RedirectResponse
    {
        Skill::create($request->validated());
        return redirect()->route('dashboard.skills.index')->with('success', 'Skill added.');
    }

    public function edit(Skill $skill): Response
    {
        return Inertia::render('Dashboard/Skills/Edit', [
            'skill' => [
                'id'       => $skill->id,
                'name'     => $skill->getTranslations('name'),
                'category' => $skill->category->value,
                'level'    => $skill->level,
                'icon'     => $skill->icon,
                'order'    => $skill->order,
            ],
            'categories' => collect(SkillCategory::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
        ]);
    }

    public function update(SkillRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());
        return redirect()->route('dashboard.skills.index')->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();
        return back()->with('success', 'Skill deleted.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate(['items' => 'required|array', 'items.*.id' => 'required|integer', 'items.*.order' => 'required|integer']);
        foreach ($request->items as $item) {
            Skill::where('id', $item['id'])->update(['order' => $item['order']]);
        }
        return response()->json(['ok' => true]);
    }
}
