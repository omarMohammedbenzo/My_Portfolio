<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class PersonalInfo extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    protected $table = 'personal_info';

    protected $fillable = [
        'type',
        'name',
        'title',
        'summary',
        'location',
        'socials',
        'email',
        'phone',
        'meta',
    ];

    public array $translatable = ['name', 'title', 'summary', 'location'];

    protected function casts(): array
    {
        return [
            'socials' => 'array',
            'meta'    => 'array',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public static function main(): self
    {
        return static::firstOrCreate(['type' => 'main']);
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatar') ?: null;
    }
}
