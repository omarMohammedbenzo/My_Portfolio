<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title.en'               => 'required|string|max:255',
            'title.ar'               => 'required|string|max:255',
            'description.en'         => 'required|string',
            'description.ar'         => 'required|string',
            'long_description.en'    => 'nullable|string',
            'long_description.ar'    => 'nullable|string',
            'tech_stack'             => 'nullable|array',
            'tech_stack.*'           => 'string|max:100',
            'gradient_colors'        => 'nullable|array',
            'gradient_colors.from'   => 'nullable|string|max:100',
            'gradient_colors.via'    => 'nullable|string|max:100',
            'gradient_colors.to'     => 'nullable|string|max:100',
            'cover_image'            => 'nullable|image|max:4096',
            'live_url'               => 'nullable|url|max:512',
            'github_url'             => 'nullable|url|max:512',
            'featured'               => 'boolean',
            'status'                 => ['required', new Enum(ProjectStatus::class)],
            'year'                   => 'nullable|integer|min:2000|max:2099',
            'order'                  => 'integer|min:0',
        ];
    }
}
