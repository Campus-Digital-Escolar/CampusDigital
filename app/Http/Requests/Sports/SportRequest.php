<?php

namespace App\Http\Requests\Sports;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SportRequest extends FormRequest
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
            'school_id'  => $schoolId,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'icon_path' => 'nullable|file|mimes:svg,webp,png,jpg,jpeg|max:2048',
            'rules' => 'nullable|string',
            'status' => 'nullable|in:active,in_development',

            // tabla pivote
            'school_id' => 'required|exists:schools,id',

            'stat_definitions' => 'nullable|array',
            'stat_definitions.*.name' => 'required|string|max:100',
            'stat_definitions.*.code' => 'required|string|max:20',
            'stat_definitions.*.description' => 'nullable|string',
            'stat_definitions.*.data_type' => 'required|in:conteo,tiempo,texto',
        ];
    }
}
