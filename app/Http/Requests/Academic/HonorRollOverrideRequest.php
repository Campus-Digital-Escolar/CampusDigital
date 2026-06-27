<?php

namespace App\Http\Requests\Academic;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HonorRollOverrideRequest extends FormRequest
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
            'school_year_id'     => 'required|exists:school_years,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'student_id'         => 'required|exists:students,id',
            'action'             => 'required|in:incluir,excluir',
            'reason'             => 'required|string',
            'created_by'         => 'required|exists:users,id'
        ];
    }


    public function messages(): array
    {
        return [
            'student_id.exists' => 'El estudiante seleccionado no pertenece a este plantel escolar.',
            'academic_period_id.exists' => 'El periodo académico seleccionado no está configurado para esta escuela.',
            'action.in' => 'La acción permitida debe ser estrictamente "include" (incluir) o "exclude" (excluir).',
            'reason.min' => 'La justificación institucional del cambio debe contener al menos 10 caracteres.',
        ];
    }
}
