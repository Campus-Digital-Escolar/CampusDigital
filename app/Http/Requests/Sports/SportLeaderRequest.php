<?php

namespace App\Http\Requests\Sports;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SportLeaderRequest extends FormRequest
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
            'sport_id'        => 'required|exists:sports,id',
            'student_id'      => 'required|exists:students,id',
            'statistic_type'  => 'required|string|max:50',  // Ej: "Goleador", "Asistencias"
            'statistic_value' => 'required|string|max:50'   // Ej: "14", "85%"
        ];
    }
}
