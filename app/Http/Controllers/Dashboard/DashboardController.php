<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\PageView;
use App\Models\Reaction;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalViews    = PageView::count();
        $uniqueVisitors = PageView::distinct('ip_hash')->count('ip_hash');
        $totalHearts   = Reaction::count();
        $totalMessages = Message::count();
        $unreadMessages = Message::unread()->count();

        $conversionRate = $uniqueVisitors > 0
            ? round(($totalMessages / $uniqueVisitors) * 100, 2)
            : 0;

        $viewsPerDay = PageView::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $topPages = PageView::selectRaw('page_url, COUNT(*) as count')
            ->groupBy('page_url')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'page_url');

        return Inertia::render('Dashboard/Overview', [
            'stats' => [
                'total_views'      => $totalViews,
                'unique_visitors'  => $uniqueVisitors,
                'total_hearts'     => $totalHearts,
                'total_messages'   => $totalMessages,
                'unread_messages'  => $unreadMessages,
                'conversion_rate'  => $conversionRate,
            ],
            'charts' => [
                'views_per_day' => $viewsPerDay,
                'top_pages'     => $topPages,
            ],
        ]);
    }
}
