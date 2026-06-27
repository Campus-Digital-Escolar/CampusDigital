<?php

namespace App\Http\Requests\Comunication;

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
    public function rules(): array
    {
        return [
            'school_id'      => 'required|exists:schools,id',
            'user_id'        => 'required|exists:users,id',
            'gallery_id'     => 'nullable|exists:galleries,id',
            'title'          => 'required|string|max:255',
            'body'           => 'required|string',
            'value_tag_id'   => 'nullable|exists:post_tags_catalog,id',
            'emotion_tag_id' => 'nullable|exists:post_tags_catalog,id',
            'student_ids'    => 'nullable|array', // Para la tabla pivote post_student
            'student_ids.*'  => 'exists:students,id'
        ];
    }
}
