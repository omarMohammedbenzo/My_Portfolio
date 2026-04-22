<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\EmploymentType;
use App\Enums\LocationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ExperienceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'company'            => 'required|string|max:255',
            'role.en'            => 'required|string|max:255',
            'role.ar'            => 'required|string|max:255',
            'location.en'        => 'required|string|max:255',
            'location.ar'        => 'required|string|max:255',
            'description.en'     => 'required|string',
            'description.ar'     => 'required|string',
            'start_date'         => 'required|date',
            'end_date'           => 'nullable|date|after_or_equal:start_date',
            'is_current'         => 'boolean',
            'employment_type'    => ['required', new Enum(EmploymentType::class)],
            'location_type'      => ['required', new Enum(LocationType::class)],
            'order'              => 'integer|min:0',
        ];
    }
}
