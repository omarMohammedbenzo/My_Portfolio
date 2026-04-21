<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'body',
        'ip',
        'user_agent',
        'read_at',
        'replied_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at'    => 'datetime',
            'replied_at' => 'datetime',
        ];
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function markAsRead(): void
    {
        if (! $this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }
}
