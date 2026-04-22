<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\PageView;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AnalyticsController extends Controller
{
    public function index(Request $request): Response
    {
        $days = (int) $request->query('days', 30);
        $days = in_array($days, [7, 30, 90]) ? $days : 30;

        $viewsPerDay = PageView::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')->orderBy('date')
            ->pluck('count', 'date');

        $topPages = PageView::selectRaw('page_url, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('page_url')->orderByDesc('count')->limit(10)
            ->pluck('count', 'page_url');

        $topReferrers = PageView::selectRaw('referrer, COUNT(*) as count')
            ->whereNotNull('referrer')->where('referrer', '!=', '')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('referrer')->orderByDesc('count')->limit(10)
            ->pluck('count', 'referrer');

        $countryBreakdown = PageView::selectRaw('country, COUNT(*) as count')
            ->whereNotNull('country')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('country')->orderByDesc('count')->limit(15)
            ->pluck('count', 'country');

        $totalViews     = PageView::where('created_at', '>=', now()->subDays($days))->count();
        $uniqueVisitors = PageView::where('created_at', '>=', now()->subDays($days))->distinct('ip_hash')->count('ip_hash');
        $totalHearts    = Reaction::where('created_at', '>=', now()->subDays($days))->count();
        $totalMessages  = Message::where('created_at', '>=', now()->subDays($days))->count();

        return Inertia::render('Dashboard/Analytics', [
            'days'   => $days,
            'stats'  => [
                'total_views'     => $totalViews,
                'unique_visitors' => $uniqueVisitors,
                'total_hearts'    => $totalHearts,
                'total_messages'  => $totalMessages,
                'conversion_rate' => $uniqueVisitors > 0 ? round(($totalMessages / $uniqueVisitors) * 100, 2) : 0,
            ],
            'charts' => [
                'views_per_day'    => $viewsPerDay,
                'top_pages'        => $topPages,
                'top_referrers'    => $topReferrers,
                'country_breakdown'=> $countryBreakdown,
            ],
        ]);
    }
}
