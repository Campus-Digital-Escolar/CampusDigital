<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TeacherPermissionRequest extends FormRequest
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
            'user_id'     => 'required|exists:users,id',
            'module_name' => 'required|in:C.HONOR,DEPORTES,PUBLICACIONES,C.OFICIALES,GALERIA,P.EVENTOS,COMUNICADOS_INTERNOS',
            'is_visible'  => 'nullable|boolean',
            'can_add'     => 'nullable|boolean',
            'can_edit'    => 'nullable|boolean',
            'can_delete'  => 'nullable|boolean'
        ];
    }
}
