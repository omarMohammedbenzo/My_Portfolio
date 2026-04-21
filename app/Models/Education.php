<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Education extends Model
{
    use HasTranslations;

    protected $table = 'educations';

    protected $fillable = [
        'school',
        'degree',
        'field',
        'location',
        'description',
        'start_date',
        'end_date',
        'order',
    ];

    public array $translatable = ['degree', 'field', 'location', 'description'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
            'order'      => 'integer',
        ];
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('start_date');
    }
}
