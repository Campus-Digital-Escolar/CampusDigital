<?php

namespace App\Http\Requests\Communication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InternalCommunicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $user = auth()->user();
        $schoolId = $user?->school_id ?? $this->input('school_id');

        $this->merge([
            'created_by' => $user?->id,
            'school_id' => $schoolId,
        ]);
    }
    public function rules(): array
    {
        return [
            'school_id'         => 'required|exists:schools,id',
            'created_by'        => 'required|exists:users,id',
            'category'          => 'required|in:meeting,general_announcement',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'event_date'        => 'nullable|date',
            'location'          => 'nullable|string|max:150',
            'send_reminder'     => 'nullable|boolean',
            'status'            => 'required|in:draft,published,scheduled,rescheduled,completed,cancelled,deleted',
            'user_ids'          => 'nullable|array',
            'user_ids.*'        => 'exists:users,id'
        ];
    }
}
