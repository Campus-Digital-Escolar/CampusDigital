<?php

namespace App\Http\Requests\Academic;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BulkStoreGradesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $user = auth()->user();
        $schoolId = $user?->school_id ?? $this->input('school_id');

        $this->merge([
            'school_id' => $schoolId,
        ]);
    }

    public function rules(): array
    {
        return [
            'school_id'          => 'required|exists:schools,id',
            'subject_id'         => 'required|exists:subjects,id',
            'school_year_id'     => 'required|exists:school_years,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'grading_period_id'  => 'required|exists:grading_periods,id',
            'grades'             => 'required|array|min:1',
            'grades.*.student_id'=> 'required|exists:students,id',
            'grades.*.score'     => 'required|numeric|between:0,10.0'
        ];
    }
}
