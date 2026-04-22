<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\SkillCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SkillRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name.en'    => 'required|string|max:100',
            'name.ar'    => 'required|string|max:100',
            'category'   => ['required', new Enum(SkillCategory::class)],
            'level'      => 'required|integer|min:1|max:5',
            'icon_slug'  => 'nullable|string|max:100',
            'icon_set'   => 'nullable|string|in:simple-icons,lucide',
            'icon_color' => 'nullable|string|max:30',
            'years'      => 'nullable|integer|min:0|max:99',
            'order'      => 'integer|min:0',
        ];
    }
}
