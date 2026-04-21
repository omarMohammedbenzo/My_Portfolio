<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'long_description',
        'tech_stack',
        'gradient_colors',
        'cover_image',
        'live_url',
        'github_url',
        'featured',
        'status',
        'year',
        'order',
    ];

    public array $translatable = ['title', 'description', 'long_description'];

    protected function casts(): array
    {
        return [
            'tech_stack'      => 'array',
            'gradient_colors' => 'array',
            'featured'        => 'boolean',
            'status'          => ProjectStatus::class,
            'year'            => 'integer',
            'order'           => 'integer',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', ProjectStatus::Published);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('year');
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_image
            ? asset($this->cover_image)
            : null;
    }

    public function getDefaultGradientAttribute(): array
    {
        return $this->gradient_colors ?? [
            'from' => 'from-violet-500',
            'via'  => 'via-purple-500',
            'to'   => 'to-indigo-600',
        ];
    }
}
