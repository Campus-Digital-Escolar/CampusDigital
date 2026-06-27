<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GradingPeriodRequest extends FormRequest
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
            'academic_period_id' => 'required|integer|exists:academic_periods,id',
            'name'               => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'academic_period_id.required' => 'El periodo académico es obligatorio.',
            'academic_period_id.exists'   => 'El periodo académico seleccionado no es válido.',
            'name.required'               => 'El nombre de la evaluación (ej. Parcial 1) es obligatorio.',
            'start_date.required' => 'La fecha de apertura del sistema de captura es obligatoria.',
            'end_date.required'   => 'La fecha límite de captura es obligatoria.',
            'end_date.after_or_equal' => 'La fecha límite de captura no puede ser menor a la fecha de apertura.',
        ];
    }
}
