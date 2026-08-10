<?php

namespace App\Http\Requests\Sports;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolTeamRequest extends FormRequest
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
            'school_id'        => 'required|exists:schools,id',
            'sport_id'         => 'required|exists:sports,id',
            'coach_teacher_id' => 'nullable|exists:teachers,id',
            'name'             => 'required|string|max:100',
            'icon_path'        => 'nullable|file|mimes:svg,webp,png,jpg,jpeg|max:2048'
        ];
    }
}
