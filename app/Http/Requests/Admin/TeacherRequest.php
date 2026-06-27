<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'user_id'           => 'required|exists:users,id',
            'enrollment_number' => 'required|string|max:255',
            'profession'        => 'required|string|max:150',
            'photo_path'        => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'profession.required' => 'Es obligatorio registrar la profesión o título del docente.',
        ];
    }
}
