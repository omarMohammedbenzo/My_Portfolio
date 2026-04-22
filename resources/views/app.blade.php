@php
    use App\Models\Setting;
    $activeThemeKey = Setting::get('active_theme') ?? 'violet';
    $themes         = config('themes', []);
    $theme          = $themes[$activeThemeKey] ?? $themes['violet'] ?? [
        'primary'       => '#8b5cf6',
        'secondary'     => '#6366f1',
        'glow'          => '#a78bfa',
        'primary_rgb'   => '139, 92, 246',
        'secondary_rgb' => '99, 102, 241',
    ];
@endphp
<!DOCTYPE html>
<html
    lang="{{ $page['props']['locale'] ?? app()->getLocale() }}"
    dir="{{ in_array($page['props']['locale'] ?? app()->getLocale(), ['ar']) ? 'rtl' : 'ltr' }}"
    class=""
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- SEO: filled by Inertia <Head> per page --}}
    <title inertia>{{ config('app.name') }}</title>

    {{-- Preconnect for Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    {{-- Inter (Latin) + Cairo (Arabic) --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700&display=swap"
        rel="stylesheet"
    />

    {{-- Active theme CSS variables — injected server-side so they apply before any JS --}}
    <style>
        :root {
            --color-accent-primary:       {{ $theme['primary'] }};
            --color-accent-secondary:     {{ $theme['secondary'] }};
            --color-accent-glow:          {{ $theme['glow'] }};
            --color-accent-primary-rgb:   {{ $theme['primary_rgb'] }};
            --color-accent-secondary-rgb: {{ $theme['secondary_rgb'] }};
        }
    </style>

    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-sans antialiased bg-background text-foreground theme-{{ $activeThemeKey }}">
    @inertia
</body>
</html>
