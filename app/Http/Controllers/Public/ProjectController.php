<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Project::published()->with('images')->ordered();

        if ($tech = $request->query('tech')) {
            $query->whereJsonContains('tech_stack', $tech);
        }

        $projects = $query->get()->map(fn ($p) => [
            'id'              => $p->id,
            'slug'            => $p->slug,
            'title'           => $p->getTranslations('title'),
            'short_description' => $p->getTranslations('description'),
            'tech_stack'      => $p->tech_stack,
            'cover_url'       => $p->cover_url,
            'gradient_colors' => $p->default_gradient,
            'featured'        => $p->featured,
            'year'            => $p->year,
            'live_url'        => $p->live_url,
            'github_url'      => $p->github_url,
        ]);

        $allTech = Project::published()->get()
            ->flatMap(fn ($p) => $p->tech_stack ?? [])
            ->unique()->values();

        return Inertia::render('Projects/Index', [
            'projects'   => $projects,
            'allTech'    => $allTech,
            'activetech' => $tech,
        ]);
    }

    public function show(string $locale, string $slug): Response
    {
        $project = Project::published()->with('images')->where('slug', $slug)->firstOrFail();

        $next = Project::published()
            ->where('order', '>', $project->order)
            ->ordered()->first();

        return Inertia::render('Projects/Show', [
            'project' => [
                'id'               => $project->id,
                'slug'             => $project->slug,
                'title'            => $project->getTranslations('title'),
                'description'      => $project->getTranslations('description'),
                'long_description' => $project->getTranslations('long_description'),
                'tech_stack'       => $project->tech_stack,
                'cover_url'        => $project->cover_url,
                'gradient_colors'  => $project->default_gradient,
                'images'           => $project->images->map(fn ($i) => [
                    'id'      => $i->id,
                    'url'     => asset($i->path),
                    'caption' => $i->getTranslations('caption'),
                ]),
                'live_url'   => $project->live_url,
                'github_url' => $project->github_url,
                'year'       => $project->year,
            ],
            'nextProject' => $next ? [
                'slug'  => $next->slug,
                'title' => $next->getTranslations('title'),
            ] : null,
        ]);
    }
}
