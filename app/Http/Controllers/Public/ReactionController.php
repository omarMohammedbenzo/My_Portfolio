<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\ReactionRequest;
use App\Models\Reaction;
use App\Notifications\NewReactionNotification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class ReactionController extends Controller
{
    public function store(ReactionRequest $request): JsonResponse
    {
        $ip     = $request->ip();
        $ipHash = hash_hmac('sha256', $ip, config('app.key'));

        $country = Cache::remember(
            "geo:{$ipHash}",
            60 * 60 * 24 * 7,
            fn () => $this->geolocate($ip)
        );

        $reaction = Reaction::create([
            'page_url'   => $request->page_url,
            'ip_hash'    => $ipHash,
            'user_agent' => substr($request->userAgent() ?? '', 0, 512),
            'country'    => $country,
        ]);

        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Notification::send($admin, new NewReactionNotification($reaction));
        }

        return response()->json(['ok' => true]);
    }

    private function geolocate(string $ip): ?string
    {
        if (in_array($ip, ['127.0.0.1', '::1']) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return 'Local';
        }
        try {
            $res = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=countryCode");
            if ($res->ok() && $res->json('status') === 'success') {
                return $res->json('countryCode');
            }
        } catch (\Throwable) {}
        return null;
    }
}
