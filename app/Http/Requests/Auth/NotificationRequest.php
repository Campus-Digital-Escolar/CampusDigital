<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationRequest extends FormRequest
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
            'user_id'       => 'required|exists:users,id',
            'type'          => ['required',
                Rule::in([
                    'official_comunication', 'internal_comunication', 'grades',
                    'sports', 'event', 'post', 'honor_roll',
                ]),
            ],
            'title'             => 'required|string',
            'body'              => 'required|string',
            'data'              => 'nullable|array',
            'notifiable_type'   => 'nullable|string',
            'notifiable_id'     => 'nullable|integer',
        ];
    }
}
