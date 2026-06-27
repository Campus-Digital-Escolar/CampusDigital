<?php

namespace App\Http\Requests\Comunication;

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
    public function rules(): array
    {
        return [
            'school_id'      => 'required|exists:schools,id',
            'title'          => 'required|string|max:150',
            'description'    => 'nullable|string',
            'value_tag_id'   => 'nullable|exists:post_tags_catalog,id',
            'emotion_tag_id' => 'nullable|exists:post_tags_catalog,id',
            'category_tag'   => 'nullable|string|max:100'
        ];
    }
}
