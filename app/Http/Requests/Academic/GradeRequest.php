<?php

namespace App\Http\Requests\Academic;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
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
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');

        return [
            'school_id'          => $isUpdate ? 'sometimes|exists:schools,id' : 'required|exists:schools,id',
            'student_id'         => $isUpdate ? 'sometimes|exists:students,id' : 'required|exists:students,id',
            'subject_id'         => $isUpdate ? 'sometimes|exists:subjects,id' : 'required|exists:subjects,id',
            'school_year_id'     => $isUpdate ? 'sometimes|exists:school_years,id' : 'required|exists:school_years,id',
            'academic_period_id' => $isUpdate ? 'sometimes|exists:academic_periods,id' : 'required|exists:academic_periods,id',
            'grading_period_id'  => $isUpdate ? 'sometimes|exists:grading_periods,id' : 'required|exists:grading_periods,id',
            'score'              => 'required|numeric|min:0|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.exists' => 'El estudiante seleccionado no pertenece a este plantel escolar.',
            'subject_id.exists' => 'Esta materia no está asignada o autorizada en este plantel.',
            'academic_period_id.exists' => 'El periodo académico seleccionado no está activo para captura de calificaciones.',
            'score.regex' => 'La calificación debe tener un formato numérico con máximo un decimal (ej. 8.5).',
        ];
    }
}
