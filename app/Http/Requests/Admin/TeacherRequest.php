<?php

namespace App\Http\Requests\Admin;

use App\Models\JobPosition;
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
        return [
            'user_id'           => 'nullable|exists:users,id',
            'school_id'         => 'required|exists:schools,id',
            'name'              => 'required|string|max:255',
            'lastname'           => 'required|string|max:255',
            'title'             => 'required|string|max:20',
            'profession'        => 'required|string|max:150',
            'job_position_id'     => 'required|exists:job_positions,id',
            'photo'             => 'nullable|image|max:2048',

            'groups'              => 'nullable|array',
            'groups.*.group_id'   => 'required_with:groups|exists:groups,id',
            'groups.*.subject_id' => 'required_with:groups|exists:subjects,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'El título académico u honorífico es obligatorio.',
            'job_position_id.required' => 'El puesto institucional es obligatorio.',
            'job_position_id.exists'   => 'El puesto institucional seleccionado no es válido.',
            'profession.required'   => 'La profesión o licenciatura es obligatoria.',
            'photo.image'           => 'La fotografía debe ser una imagen válida.',
            'photo.max'             => 'La fotografía no debe pesar más de 2MB.'
        ];
    }
}
