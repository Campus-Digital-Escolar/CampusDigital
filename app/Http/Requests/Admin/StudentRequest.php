<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'user_id'           => 'nullable|exists:users,id',
            'enrollment_number' => 'required|string|max:255',
            'photo_path'        => 'nullable|string|max:255',
            'grade_average'     => 'nullable|numeric|between:0,10.0'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.unique' => 'Este usuario ya cuenta con un perfil de estudiante registrado.',
            'barcode.unique' => 'Esta matrícula o código de barras ya fue asignado a otro estudiante.',
            'photo.image' => 'El archivo adjunto debe ser una imagen válida.',
            'photo.max' => 'La fotografía de perfil no debe superar los 2 MB.',
        ];
    }
}
