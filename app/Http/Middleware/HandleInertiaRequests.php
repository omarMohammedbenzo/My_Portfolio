<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $locale = app()->getLocale();

        $activeThemeKey = Setting::get('active_theme') ?? 'violet';
        $themes         = config('themes', []);
        $theme          = $themes[$activeThemeKey] ?? $themes['violet'] ?? [];

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'locale'       => $locale,
            'locales'      => ['en', 'ar'],
            'translations' => $this->loadTranslations($locale),
            'flash'        => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
            ],
            'theme' => [
                'key'           => $activeThemeKey,
                'primary'       => $theme['primary']       ?? '#8b5cf6',
                'secondary'     => $theme['secondary']     ?? '#6366f1',
                'glow'          => $theme['glow']          ?? '#a78bfa',
                'primary_rgb'   => $theme['primary_rgb']   ?? '139, 92, 246',
                'secondary_rgb' => $theme['secondary_rgb'] ?? '99, 102, 241',
            ],
            'mascot' => [
                'enabled'       => (bool) (Setting::get('mascot_enabled') ?? true),
                'animation_url' => Setting::get('mascot_animation_url') ?? '/lottie/mascot.json',
            ],
        ];
    }

    private function loadTranslations(string $locale): array
    {
        $path = lang_path("{$locale}.json");

        if (File::exists($path)) {
            return json_decode(File::get($path), true) ?? [];
        }

        return [];
    }
}
