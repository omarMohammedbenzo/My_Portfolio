<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'school'         => 'required|string|max:255',
            'degree.en'      => 'required|string|max:255',
            'degree.ar'      => 'required|string|max:255',
            'field.en'       => 'required|string|max:255',
            'field.ar'       => 'required|string|max:255',
            'location.en'    => 'nullable|string|max:255',
            'location.ar'    => 'nullable|string|max:255',
            'description.en' => 'nullable|string',
            'description.ar' => 'nullable|string',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'order'          => 'integer|min:0',
        ];
    }
}
