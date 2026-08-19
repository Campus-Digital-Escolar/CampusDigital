<?php

namespace App\Http\Requests\Sports;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SportEventRequest extends FormRequest
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
            'school_id'            => 'required|exists:schools,id',
            'sport_id'             => 'required|exists:sports,id',
            'stage_id'             => 'required|exists:sport_stages,id',
            'event_date'           => 'required|date',
            'is_live'              => 'nullable|boolean',
            'status'               => 'nullable|in:scheduled,ongoing,completed,cancelled',

            'participants' => 'required|array|min:1',
            'participants.*.student_id' => 'nullable|exists:students,id',
            'participants.*.school_team_id' => 'nullable|exists:school_teams,id',
            'participants.*.external_participant_name' => 'nullable|string',
            'participants.*.external_institution' => 'nullable|string',
        ];
    }
}
