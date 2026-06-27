<?php

namespace App\Http\Requests\Comunication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InternalComunicationRequest extends FormRequest
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
            'school_id'         => 'required|exists:schools,id',
            'created_by'        => 'required|exists:users,id',
            'category'          => 'required|in:meeting,request,general_announcement',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'event_date'        => 'nullable|date',
            'location'          => 'nullable|string|max:150',
            'send_reminder'     => 'nullable|boolean',
            'approval_status'   => 'nullable|in:pending,approved,rejected',
            'rejection_reason' => 'nullable|string',
            'user_ids'          => 'required|array',
            'user_ids.*'        => 'exists:users,id'
        ];
    }
}
