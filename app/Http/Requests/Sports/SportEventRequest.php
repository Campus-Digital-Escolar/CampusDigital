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
    public function rules(): array
    {
        return [
            'school_id'            => 'required|exists:schools,id',
            'sport_id'             => 'required|exists:sports,id',
            'parent_event_id'      => 'nullable|exists:sport_events,id', // Para fases ligadas (ej: vuelta de una llave)
            'educational_level_id' => 'required|exists:educational_levels,id',
            'stage_id'             => 'required|exists:sport_stages,id',
            'event_date'           => 'required|date',
            'is_live'              => 'nullable|boolean',
            'status'               => 'nullable|in:scheduled,ongoing,completed,cancelled'
        ];
    }
}
