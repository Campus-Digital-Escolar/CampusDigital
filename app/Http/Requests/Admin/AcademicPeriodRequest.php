<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademicPeriodRequest extends FormRequest
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
            'school_year_id' => 'required|integer|exists:school_years,id',
            'name'           => 'required|string|max:100',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'school_year_id.required' => 'El ciclo escolar macro es obligatorio.',
            'school_year_id.exists'   => 'El ciclo escolar seleccionado no existe en el sistema.',
            'name.required'           => 'El nombre del periodo (ej. Cuatrimestre) es obligatorio.',
            'start_date.required'     => 'La fecha de inicio del periodo es obligatoria.',
            'end_date.required'       => 'La fecha de fin del periodo es obligatoria.',
        ];
    }
}
