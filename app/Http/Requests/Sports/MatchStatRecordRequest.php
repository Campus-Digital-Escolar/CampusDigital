<?php

namespace App\Http\Requests\Sports;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MatchStatRecordRequest extends FormRequest
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
            'event_id'           => 'required|exists:sport_events,id',
            'participant_id'     => 'required|exists:event_participants,id',
            'stat_definition_id' => 'required|exists:sport_stat_definitions,id',
            'value'              => 'required|string|max:50'
        ];
    }
}
