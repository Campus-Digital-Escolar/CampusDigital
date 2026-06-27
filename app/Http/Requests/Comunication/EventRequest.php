<?php

namespace App\Http\Requests\Comunication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'created_by'           => 'required|exists:users,id',
            'gallery_id'           => 'nullable|exists:galleries,id',
            'title'                => 'required|string|max:255',
            'description'          => 'required|string',
            'location_type'        => 'required|in:dentro,fuera',
            'target_grade'         => 'required|string|max:100', // Ej: "3° A, 4° B"
            'event_date'           => 'required|date|after_or_equal:today',
            'status'               => 'nullable|in:programado,reprogramado,cancelado,finalizado',
            'reminder_days_before' => 'nullable|integer|min:0'
        ];
    }
}
