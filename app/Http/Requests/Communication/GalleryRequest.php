<?php

namespace App\Http\Requests\Communication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
            'school_id'      => 'nullable|exists:schools,id',
            'title'          => 'required|string|max:150',
            'description'    => 'nullable|string',
            'value_tag_id'   => 'nullable|exists:post_tags_catalog,id',
            'emotion_tag_id' => 'nullable|exists:post_tags_catalog,id',
            'category_tag'   => 'nullable|string|max:100'
        ];
    }
}
