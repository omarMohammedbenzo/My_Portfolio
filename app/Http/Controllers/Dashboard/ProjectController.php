<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Project::withTrashed()->ordered()->get()->map(fn ($p) => [
            'id'         => $p->id,
            'title'      => $p->getTranslations('title'),
            'slug'       => $p->slug,
            'status'     => $p->status->value,
            'featured'   => $p->featured,
            'year'       => $p->year,
            'tech_stack' => $p->tech_stack,
            'cover_url'  => $p->cover_url,
            'gradient'   => $p->default_gradient,
            'order'      => $p->order,
            'deleted_at' => $p->deleted_at?->toDateString(),
        ]);

        return Inertia::render('Dashboard/Projects/Index', [
            'projects' => $projects,
            'statuses' => collect(ProjectStatus::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Projects/Create', [
            'statuses' => collect(ProjectStatus::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
        ]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $data         = $request->validated();
        $data['slug'] = Str::slug($request->input('title.en'));

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->storeCover($request->file('cover_image'));
        }

        Project::create($data);
        return redirect()->route('dashboard.projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project): Response
    {
        return Inertia::render('Dashboard/Projects/Edit', [
            'project' => [
                'id'               => $project->id,
                'title'            => $project->getTranslations('title'),
                'slug'             => $project->slug,
                'description'      => $project->getTranslations('description'),
                'long_description' => $project->getTranslations('long_description'),
                'tech_stack'       => $project->tech_stack ?? [],
                'gradient_colors'  => $project->gradient_colors,
                'cover_url'        => $project->cover_url,
                'live_url'         => $project->live_url,
                'github_url'       => $project->github_url,
                'featured'         => $project->featured,
                'status'           => $project->status->value,
                'year'             => $project->year,
                'order'            => $project->order,
                'images'           => $project->images->map(fn ($i) => [
                    'id'      => $i->id,
                    'url'     => asset($i->path),
                    'caption' => $i->getTranslations('caption'),
                    'order'   => $i->order,
                ]),
            ],
            'statuses' => collect(ProjectStatus::cases())->map(fn ($c) => ['value' => $c->value, 'label' => $c->label()]),
        ]);
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->storeCover($request->file('cover_image'));
        }

        $project->update($data);
        return redirect()->route('dashboard.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        return back()->with('success', 'Project archived.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate(['items' => 'required|array', 'items.*.id' => 'required|integer', 'items.*.order' => 'required|integer']);
        foreach ($request->items as $item) {
            Project::where('id', $item['id'])->update(['order' => $item['order']]);
        }
        return response()->json(['ok' => true]);
    }

    public function uploadImage(Request $request, Project $project): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:4096']);
        $path = $request->file('image')->store('projects/' . $project->id, 'public');
        $img  = ProjectImage::create([
            'project_id' => $project->id,
            'path'       => 'storage/' . $path,
            'order'      => $project->images()->count(),
        ]);
        return response()->json(['id' => $img->id, 'url' => asset($img->path)]);
    }

    public function deleteImage(Project $project, ProjectImage $image): JsonResponse
    {
        Storage::disk('public')->delete(str_replace('storage/', '', $image->path));
        $image->delete();
        return response()->json(['ok' => true]);
    }

    private function storeCover(\Illuminate\Http\UploadedFile $file): string
    {
        $path = $file->store('projects/covers', 'public');
        return 'storage/' . $path;
    }
}
