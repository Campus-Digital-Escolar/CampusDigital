<?php

namespace App\Http\Requests\Academic;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grade'                => 'required|string|max:5',
            'section'              => 'required|string|max:5',
            'educational_level_id' => 'required|exists:educational_levels,id',
            'school_year_id'       => 'required|exists:school_years,id',
            'tutor_id'             => 'nullable|exists:teachers,id'
        ];
    }
}
