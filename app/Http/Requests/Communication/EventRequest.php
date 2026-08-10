<?php

namespace App\Http\Requests\Communication;

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

    protected function prepareForValidation(): void
    {
        $user = auth()->user();
        $schoolId = $user?->school_id ?? $this->input('school_id');

        $this->merge([
            'created_by' => $user?->id,
            'school_id'  => $schoolId,
        ]);
    }

    public function rules(): array
    {
        return [
            'school_id'            => 'required|exists:schools,id',
            'created_by'           => 'required|exists:users,id',
            'gallery_id'           => 'nullable|exists:galleries,id',
            'title'                => 'required|string|max:255',
            'description'          => 'required|string',
            'location_type'        => 'required|in:outside,inside',
            'educational_level_id' => 'required|exists:educational_levels,id',
            'group_id'             => 'nullable|exists:groups,id',
            'event_date'           => 'required|date|after_or_equal:today',
            'status'               => 'nullable|in:scheduled,rescheduled,cancelled,completed',
            'reminder_days_before' => 'required|integer|min:0',
            'media'                => 'nullable|array',
            'media.*'              => 'file|mimes:jpeg,jpg,png,gif,webp,mp4,mov,avi|max:51200',

            // Reglas condicionales para el calendario escolar
            'sync_to_calendar'     => 'nullable|boolean',
            'calendar_end_date'    => 'required_if:sync_to_calendar,1,true|nullable|date|after_or_equal:event_date',
            'calendar_type'        => 'required_if:sync_to_calendar,1,true|nullable|in:holiday,administrative,vacation,graduation,event',
            'calendar_icon'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ];
    }
}
