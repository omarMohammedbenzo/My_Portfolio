<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PersonalInfoRequest;
use App\Models\PersonalInfo;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PersonalInfoController extends Controller
{
    public function edit(): Response
    {
        $info = PersonalInfo::main();

        return Inertia::render('Dashboard/PersonalInfo/Edit', [
            'info' => [
                'name'     => $info->getTranslations('name'),
                'title'    => $info->getTranslations('title'),
                'summary'  => $info->getTranslations('summary'),
                'location' => $info->getTranslations('location'),
                'email'    => $info->email,
                'phone'    => $info->phone,
                'socials'  => $info->socials ?? [],
                'meta'     => $info->meta ?? [],
                'avatar'   => $info->avatar_url,
            ],
        ]);
    }

    public function update(PersonalInfoRequest $request): RedirectResponse
    {
        $info = PersonalInfo::main();

        $info->update([
            'name'     => $request->name,
            'title'    => $request->title,
            'summary'  => $request->summary,
            'location' => $request->location,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'socials'  => $request->socials,
            'meta'     => $request->meta ?? [],
        ]);

        if ($request->hasFile('avatar')) {
            $info->clearMediaCollection('avatar');
            $info->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }

        return back()->with('success', 'Personal info updated.');
    }
}
