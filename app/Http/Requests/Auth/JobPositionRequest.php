<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobPositionRequest extends FormRequest
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
        $jobPositionId = $this->route('job_position')?->id ?? $this->route('job_position');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('job_positions', 'name')->ignore($jobPositionId),
            ],
            'department' => [
                'nullable',
                'string',
                'max:100',
            ],
        ];
    }
}
