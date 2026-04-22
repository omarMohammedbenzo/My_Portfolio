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
            'name.en'  => 'required|string|max:100',
            'name.ar'  => 'required|string|max:100',
            'category' => ['required', new Enum(SkillCategory::class)],
            'level'    => 'required|integer|min:1|max:5',
            'icon'     => 'nullable|string|max:100',
            'order'    => 'integer|min:0',
        ];
    }
}
