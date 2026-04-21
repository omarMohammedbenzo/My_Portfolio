<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED = ['en', 'ar'];
    private const DEFAULT   = 'en';

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->resolveLocale($request);

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }

    private function resolveLocale(Request $request): string
    {
        // 1. URL segment (/{locale}/...)
        $segment = $request->segment(1);
        if ($segment && in_array($segment, self::SUPPORTED, true)) {
            return $segment;
        }

        // 2. Session
        $session = Session::get('locale');
        if ($session && in_array($session, self::SUPPORTED, true)) {
            return $session;
        }

        // 3. Browser Accept-Language
        $browser = substr($request->getPreferredLanguage(self::SUPPORTED) ?? '', 0, 2);
        if (in_array($browser, self::SUPPORTED, true)) {
            return $browser;
        }

        return self::DEFAULT;
    }
}
