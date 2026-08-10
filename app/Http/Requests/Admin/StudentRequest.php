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

    protected function prepareForValidation(): void
    {
        $user = auth()->user();
        $schoolId = $this->input('school_id') ?? $user?->school_id;

        $this->merge([
            'school_id' => $schoolId,
        ]);
    }

    public function rules(): array
    {
        return [
            'user_id'           => 'nullable|exists:users,id',
            'school_id'         => 'required|exists:schools,id',
            'name'              => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'birthday'          => 'required|date',
            'gender'            => 'required|in:male,female,other',
            'photo'             => 'nullable|image|max:2048',
            'grade_average'     => 'nullable|numeric|between:0,10.0',
            'group_id'          => 'required|exists:groups,id',

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
