<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolYearRequest extends FormRequest
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
            'name'      => 'required|string|max:20', // Ej: "2025-2026"
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal::start_date',
            'active' => 'nullable|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'El nombre del ciclo escolar es obligatorio.',
            'start_date.required' => 'La fecha de inicio del ciclo es obligatoria.',
            'end_date.required'   => 'La fecha de fin del ciclo es obligatoria.',
            'end_date.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
        ];
    }
}
