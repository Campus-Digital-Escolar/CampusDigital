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
            'event_id'     => 'required|exists:sport_events,id',
            'student_id'   => 'required_without:team_id|nullable|exists:students,id',
            'team_id'      => 'required_without:student_id|nullable|exists:school_teams,id',
            'result_value' => 'nullable|string|max:50', // Marcador actual (goles, puntos)
            'is_winner'    => 'nullable|boolean'
        ];
    }
}
