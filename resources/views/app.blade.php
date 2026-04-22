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

    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-sans antialiased bg-background text-foreground">
    @inertia
</body>
</html>
