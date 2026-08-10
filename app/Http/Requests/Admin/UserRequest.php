<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $userId = $this->route('user');

        return [
            'role_id'     => 'required|exists:roles,id|not_in:1',
            'school_id'   => 'required|exists:schools,id',
            'teacher_id'  => 'nullable|exists:teachers,id',
            'name'        => 'required|string|max:255',
            'lastname'    => 'required|string|max:255',
            'title'       => 'nullable|string|max:20',
            'active'      => 'required|boolean',
            'signature_enabled' => 'nullable|boolean',
            'signature_path'    => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',

            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'password' => $userId
                ? 'nullable|string|min:8|confirmed'
                : 'required|string|min:8|confirmed',

            'permissions' => 'nullable|array',
            'permissions.*.is_visible' => 'required|boolean',
            'permissions.*.can_add'    => 'required|boolean',
            'permissions.*.can_edit'   => 'required|boolean',
            'permissions.*.can_delete' => 'required|boolean',
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
