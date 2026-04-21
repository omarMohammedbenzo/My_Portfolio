<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = [
        'page_url',
        'ip_hash',
        'user_agent',
        'country',
    ];

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeForPage($query, string $url)
    {
        return $query->where('page_url', $url);
    }
}
