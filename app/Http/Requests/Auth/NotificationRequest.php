<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            'user_id'       => 'required|exists:users,id',
            'title'         => 'required|string|max:150',
            'body'          => 'required|string',
            'type'          => 'required|in:comunicado,calificacion,deportes,evento,publicacion,cuadro_honor',
            'target_action' => 'nullable|string|max:100',
            'target_id'     => 'nullable|integer',
            'read_at'       => 'nullable|date'
        ];
    }
}
