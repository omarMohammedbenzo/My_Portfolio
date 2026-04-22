<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
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
        $info        = PersonalInfo::main();
        $featured    = Project::published()->featured()->ordered()->get();
        $skills      = Skill::ordered()->get()->groupBy(fn ($s) => $s->category->value);
        $experiences = Experience::ordered()->get();
        $educations  = Education::orderBy('order')->get();

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
                'github_url'      => $p->github_url,
            ]),

            'skills' => $skills->map(fn ($group) => $group->map(fn ($s) => [
                'id'         => $s->id,
                'name'       => $s->getTranslations('name'),
                'level'      => $s->level,
                'icon_set'   => $s->icon_set,
                'icon_slug'  => $s->icon_slug,
                'icon_color' => $s->icon_color,
                'years'      => $s->years,
            ]))->toArray(),

            'experiences' => $experiences->map(fn ($e) => [
                'id'              => $e->id,
                'company'         => $e->company,
                'role'            => $e->getTranslations('role'),
                'location'        => $e->getTranslations('location'),
                'description'     => $e->getTranslations('description'),
                'tech_stack'      => $e->tech_stack ?? [],
                'start_date'      => $e->start_date?->toDateString(),
                'end_date'        => $e->end_date?->toDateString(),
                'is_current'      => $e->is_current,
                'employment_type' => $e->employment_type->value,
                'location_type'   => $e->location_type->value,
            ]),

            'educations' => $educations->map(fn ($ed) => [
                'id'         => $ed->id,
                'school'     => $ed->school,
                'degree'     => $ed->getTranslations('degree'),
                'field'      => $ed->getTranslations('field'),
                'location'   => $ed->getTranslations('location'),
                'start_date' => $ed->start_date?->toDateString(),
                'end_date'   => $ed->end_date?->toDateString(),
                'gpa'        => $ed->gpa ?? null,
            ]),

            'settings' => [
                // Images
                'hero_image'      => Setting::get('hero_image'),
                'hero_image_webp' => Setting::get('hero_image_webp'),
                'hero_image_alt'  => Setting::get('hero_image_alt'),
                'about_image_1'   => Setting::get('about_image_1'),
                'og_image'        => Setting::get('og_image'),
                // Hero & Home content
                'hero_eyebrow'         => Setting::get('hero_eyebrow'),
                'hero_title_template'  => Setting::get('hero_title_template'),
                'hero_rotating_titles' => Setting::get('hero_rotating_titles'),
                'hero_tagline'         => Setting::get('hero_tagline'),
                'about_brief'          => Setting::get('about_brief'),
                'stat_experience'      => Setting::get('stat_experience'),
                'stat_projects'        => Setting::get('stat_projects'),
                'stat_technologies'    => Setting::get('stat_technologies'),
                'stat_languages'       => Setting::get('stat_languages'),
                // General
                'contact_email' => Setting::get('contact_email'),
            ],
        ]);
    }
}
