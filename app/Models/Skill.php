<?php

namespace App\Models;

use App\Enums\SkillCategory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Skill extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'category',
        'level',
        'icon',
        'order',
    ];

    public array $translatable = ['name'];

    protected function casts(): array
    {
        return [
            'category' => SkillCategory::class,
            'level'    => 'integer',
            'order'    => 'integer',
        ];
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('category');
    }

    public function scopeByCategory($query, SkillCategory $category)
    {
        return $query->where('category', $category->value);
    }
}
