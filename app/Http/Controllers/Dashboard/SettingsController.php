<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\SettingsGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function edit(): Response
    {
        $all = Setting::all()->keyBy('key')->map(fn ($s) => $s->value);

        return Inertia::render('Dashboard/Settings', [
            'settings' => $all,
            'groups'   => collect(SettingsGroup::cases())->map(fn ($g) => ['value' => $g->value, 'label' => $g->label()]),
        ]);
    }

    public function update(SettingsRequest $request): RedirectResponse
    {
        foreach ($request->validated()['settings'] as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }
}
