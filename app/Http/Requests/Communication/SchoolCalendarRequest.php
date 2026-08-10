<?php

namespace App\Http\Requests\Communication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolCalendarRequest extends FormRequest
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
            'school_id'   => 'required|exists:schools,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'type'        => 'required|in:holiday,administrative,vacation,graduation,event',
            'icon_marker' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048'
        ];
    }

}
