<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LogPageView
{
    private const BOT_PATTERNS = [
        'bot', 'crawler', 'spider', 'googlebot', 'bingbot', 'slurp',
        'duckduckbot', 'baiduspider', 'yandexbot', 'facebookexternalhit',
        'twitterbot', 'linkedinbot', 'whatsapp', 'curl', 'wget', 'python',
        'postman', 'insomnia', 'axios', 'go-http-client',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldLog($request, $response)) {
            $this->log($request);
        }

        return $response;
    }

    private function shouldLog(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        $ua = strtolower($request->userAgent() ?? '');
        foreach (self::BOT_PATTERNS as $pattern) {
            if (str_contains($ua, $pattern)) {
                return false;
            }
        }

        return true;
    }

    private function log(Request $request): void
    {
        try {
            $ip     = $request->ip();
            $ipHash = hash_hmac('sha256', $ip, config('app.key'));
            $ua     = $request->userAgent() ?? '';
            $url    = $request->path();

            $country = Cache::remember(
                "geo:{$ipHash}",
                60 * 60 * 24 * 7,
                fn () => $this->geolocate($ip)
            );

            PageView::create([
                'page_url'   => $url,
                'ip_hash'    => $ipHash,
                'user_agent' => substr($ua, 0, 512),
                'referrer'   => substr($request->header('referer', ''), 0, 512),
                'country'    => $country,
            ]);
        } catch (\Throwable) {
            // Never block the request for analytics failures
        }
    }

    private function geolocate(string $ip): ?string
    {
        if ($ip === '127.0.0.1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return 'Local';
        }

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=countryCode");
            if ($response->ok() && $response->json('status') === 'success') {
                return $response->json('countryCode');
            }
        } catch (\Throwable) {
        }

        return null;
    }
}
