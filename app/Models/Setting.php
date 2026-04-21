<?php

namespace App\Models;

use App\Enums\SettingsGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    protected function casts(): array
    {
        return [
            'value' => 'array',
            'group' => SettingsGroup::class,
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::remember(
            "setting:{$key}",
            now()->addHour(),
            fn () => static::where('key', $key)->first()
        );

        return $setting?->value ?? $default;
    }

    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        Cache::forget("setting:{$key}");
    }

    public static function forGroup(SettingsGroup $group): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('group', $group->value)->get()->keyBy('key');
    }
}
