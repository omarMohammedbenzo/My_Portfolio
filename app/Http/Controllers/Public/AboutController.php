<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PersonalInfo;
use App\Models\Setting;
use App\Models\Skill;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        $info        = PersonalInfo::main();
        $experiences = Experience::ordered()->get();
        $educations  = Education::ordered()->get();
        $skills      = Skill::ordered()->get();

        return Inertia::render('Public/About', [
            'personalInfo' => [
                'name'     => $info->getTranslations('name'),
                'title'    => $info->getTranslations('title'),
                'summary'  => $info->getTranslations('summary'),
                'socials'  => $info->socials,
                'avatar'   => $info->avatar_url,
            ],
            'experiences' => $experiences->map(fn ($e) => [
                'id'              => $e->id,
                'company'         => $e->company,
                'role'            => $e->getTranslations('role'),
                'location'        => $e->getTranslations('location'),
                'description'     => $e->getTranslations('description'),
                'start_date'      => $e->start_date?->format('Y-m-d'),
                'end_date'        => $e->end_date?->format('Y-m-d'),
                'is_current'      => $e->is_current,
                'employment_type' => $e->employment_type->value,
                'location_type'   => $e->location_type->value,
            ]),
            'educations' => $educations->map(fn ($e) => [
                'id'         => $e->id,
                'school'     => $e->school,
                'degree'     => $e->getTranslations('degree'),
                'field'      => $e->getTranslations('field'),
                'location'   => $e->getTranslations('location'),
                'start_date' => $e->start_date?->format('Y-m-d'),
                'end_date'   => $e->end_date?->format('Y-m-d'),
            ]),
            'skills' => $skills->map(fn ($s) => [
                'id'       => $s->id,
                'name'     => $s->getTranslations('name'),
                'category' => $s->category->value,
                'level'    => $s->level,
                'icon'     => $s->icon,
            ]),
            'settings' => [
                'about_image_1'      => Setting::get('about_image_1'),
                'about_image_1_webp' => Setting::get('about_image_1_webp'),
                'about_image_1_alt'  => Setting::get('about_image_1_alt'),
                'about_image_2'      => Setting::get('about_image_2'),
                'about_image_2_webp' => Setting::get('about_image_2_webp'),
                'about_image_2_alt'  => Setting::get('about_image_2_alt'),
                'og_image'           => Setting::get('og_image'),
            ],
        ]);
    }
}
