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
    public function rules(): array
    {
        return [
            'school_id'          => 'required|exists:schools,id',
            'student_id'         => 'required|exists:students,id',
            'subject_id'         => 'required|exists:subjects,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'school_year_id'     => 'required|exists:school_years,id',
            'score'              => 'required|numeric|between:0,10.0'
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
