<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Reaction;
use Inertia\Inertia;
use Inertia\Response;

class ReactionController extends Controller
{
    public function index(): Response
    {
        $reactions = Reaction::latest()->paginate(30)->through(fn ($r) => [
            'id'         => $r->id,
            'page_url'   => $r->page_url,
            'country'    => $r->country,
            'created_at' => $r->created_at->toDateTimeString(),
        ]);

        $byPage = Reaction::selectRaw('page_url, COUNT(*) as count')
            ->groupBy('page_url')->orderByDesc('count')->limit(10)
            ->pluck('count', 'page_url');

        return Inertia::render('Dashboard/Reactions/Index', [
            'reactions' => $reactions,
            'byPage'    => $byPage,
            'total'     => Reaction::count(),
        ]);
    }
}
