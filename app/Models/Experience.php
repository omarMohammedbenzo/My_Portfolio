<?php

namespace App\Models;

use App\Enums\EmploymentType;
use App\Enums\LocationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Experience extends Model
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'company',
        'role',
        'location',
        'description',
        'start_date',
        'end_date',
        'is_current',
        'employment_type',
        'location_type',
        'order',
    ];

    public array $translatable = ['role', 'location', 'description'];

    protected function casts(): array
    {
        return [
            'start_date'      => 'date',
            'end_date'        => 'date',
            'is_current'      => 'boolean',
            'employment_type' => EmploymentType::class,
            'location_type'   => LocationType::class,
            'order'           => 'integer',
        ];
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('start_date');
    }
}
