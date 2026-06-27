<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'role_id' => 'required|exists:roles,id',
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'title'     => 'nullable|in:Dir.,Lic.,Prof.,Ing.,Student.,Parent',
            'username'  => 'required|string|max:255|unique:users,username,' . $this->route('user'),
            'email'     => 'nullable|email|max:255|unique:users,email,' . $this->route('user'),
            'password' => 'required|string|min:8',
            'active'    => 'nullable|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'username.unique' => 'Este nombre de usuario ya se encuentra registrado.',
            'email.unique' => 'Este email ya se encuentra registrado.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}
