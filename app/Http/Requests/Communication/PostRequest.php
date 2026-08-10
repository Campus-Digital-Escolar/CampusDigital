<?php

namespace App\Http\Requests\Communication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'user_id'   => $user?->id,
            'school_id' => $schoolId,
        ]);
    }
    public function rules(): array
    {
        return [
            'school_id'      => 'required|exists:schools,id',
            'user_id'        => 'required|exists:users,id',
            'title'          => 'required|string|max:255',
            'body'           => 'required|string',
            'value_tag_id'   => 'nullable|exists:post_tags_catalog,id',
            'emotion_tag_id' => 'nullable|exists:post_tags_catalog,id',
            'student_ids'    => 'nullable|array',
            'student_ids.*'  => 'exists:students,id',
            'media'          => 'nullable|array',
            'media.*'        => 'file|mimes:jpeg,jpg,png,gif,webp,mp4,mov,avi|max:51200',
        ];
    }
}
