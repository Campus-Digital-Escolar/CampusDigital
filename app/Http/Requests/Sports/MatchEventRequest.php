<?php

namespace App\Http\Requests\Sports;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MatchEventRequest extends FormRequest
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
            'student_id'         => 'required|exists:students,id',
            'stat_definition_id' => 'required|exists:sport_stat_definitions,id',
            'match_time'         => 'nullable|string|max:10', // Ej: "45+2'", "12:30"
            'description'        => 'nullable|string'
        ];
    }
}
