<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ProjectImage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'project_id',
        'path',
        'caption',
        'order',
    ];

    public array $translatable = ['caption'];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getUrlAttribute(): string
    {
        return asset($this->path);
    }
}
