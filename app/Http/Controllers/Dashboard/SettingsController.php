<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\SettingsGroup;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function edit(): Response
    {
        $all = Setting::all()->keyBy('key')->map(fn ($s) => $s->value);

        return Inertia::render('Dashboard/Settings', [
            'settings' => $all,
            'themes'   => config('themes', []),
            'groups'   => collect(SettingsGroup::cases())->map(fn ($g) => ['value' => $g->value, 'label' => $g->label()]),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->except(['_method', '_token']);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }
}
