<?php

namespace App\Http\Requests\Sports;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EventParticipantRequest extends FormRequest
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
            'sport_event_id'     => 'required|exists:sport_events,id',
            'student_id'   => 'required_without:team_id|nullable|exists:students,id',
            'school_team_id'      => 'required_without:student_id|nullable|exists:school_teams,id',
            'external_participant_name' => 'nullable|string',
            'external_institution' => 'nullable|string',
            'result_value' => 'nullable|string', // Marcador actual (goles, puntos)
            'is_winner'    => 'nullable|boolean',
            'result_position' => 'nullable|string',
        ];
    }
}
