<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'page_url',
        'ip_hash',
        'session_id',
        'user_agent',
        'referrer',
        'country',
    ];

    public function scopeInPeriod($query, int $days)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeUniqueVisitors($query)
    {
        return $query->distinct('ip_hash');
    }
}
