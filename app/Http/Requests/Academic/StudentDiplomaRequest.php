<?php

namespace App\Http\Requests\Academic;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentDiplomaRequest extends FormRequest
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
            'student_id'         => 'required|exists:students,id',
            'school_year_id'     => 'required|exists:school_years,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'title'              => 'required|string|max:150',
            'diploma_path'       => 'required|string|max:255'
        ];
    }
}
