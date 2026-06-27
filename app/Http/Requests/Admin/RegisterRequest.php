<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $isUserCreation = $this->isMethod('post');

        return [
            'name' => 'required|string|max:150',
            'lastname' => 'required|string|max:150',
            'username' => 'required|string|max:50|unique:users,username,' . ($this->user?->id ?? ''),
            'email' => 'required|email|max:150|unique:users,email,' . ($this->user?->id ?? ''),
            'password' => $isUserCreation
                ? 'required|string|min:8|confirmed'
                : 'nullable|string|min:8|confirmed',
            'role_id' => 'required|integer|exists:roles,id',
            'school_id' => 'nullable|integer|exists:schools,id',
            'active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre completo es obligatorio.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'Este nombre de usuario ya se encuentra registrado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un formato de correo válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'password.required' => 'La contraseña es obligatoria para nuevos usuarios.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'role_id.required' => 'Debes asignar un rol válido al usuario.',
            'role_id.exists' => 'El rol seleccionado no es válido en el sistema.',
            'school_id.exists' => 'El plantel escolar seleccionado no existe.',
        ];
    }
}
