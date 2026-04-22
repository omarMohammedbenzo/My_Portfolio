<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PersonalInfoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name.en'     => 'required|string|max:255',
            'name.ar'     => 'required|string|max:255',
            'title.en'    => 'required|string|max:255',
            'title.ar'    => 'required|string|max:255',
            'summary.en'  => 'required|string',
            'summary.ar'  => 'required|string',
            'location.en' => 'required|string|max:255',
            'location.ar' => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'nullable|string|max:30',
            'socials'     => 'nullable|array',
            'socials.*'   => 'nullable|string|url|max:512',
            'meta'        => 'nullable|array',
            'avatar'      => 'nullable|image|max:2048',
        ];
    }
}
