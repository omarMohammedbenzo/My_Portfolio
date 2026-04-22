<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PersonalInfo;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Skill;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $info     = PersonalInfo::main();
        $featured = Project::published()->featured()->ordered()->get();
        $skills   = Skill::ordered()->get()->groupBy(fn ($s) => $s->category->value);

        return Inertia::render('Home', [
            'personalInfo' => [
                'name'     => $info->getTranslations('name'),
                'title'    => $info->getTranslations('title'),
                'summary'  => $info->getTranslations('summary'),
                'email'    => $info->email,
                'phone'    => $info->phone,
                'location' => $info->getTranslations('location'),
                'socials'  => $info->socials,
                'avatar'   => $info->avatar_url,
            ],
            'featuredProjects' => $featured->map(fn ($p) => [
                'id'              => $p->id,
                'slug'            => $p->slug,
                'title'           => $p->getTranslations('title'),
                'description'     => $p->getTranslations('description'),
                'tech_stack'      => $p->tech_stack,
                'cover_url'       => $p->cover_url,
                'gradient_colors' => $p->default_gradient,
                'live_url'        => $p->live_url,
                'short_description' => $p->getTranslations('description'),
                'github_url'      => $p->github_url,
            ]),
            'settings' => [
                'hero_image'      => Setting::get('hero_image'),
                'hero_image_webp' => Setting::get('hero_image_webp'),
                'hero_image_alt'  => Setting::get('hero_image_alt'),
                'og_image'        => Setting::get('og_image'),
            ],
        ]);
    }
}
