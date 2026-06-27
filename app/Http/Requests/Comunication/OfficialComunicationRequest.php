<?php

namespace App\Http\Requests\Comunication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OfficialComunicationRequest extends FormRequest
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
            'school_id'          => 'required|exists:schools,id',
            'created_by'         => 'required|exists:users,id',
            'title'              => 'required|string|max:255',
            'category'           => 'required|in:Urgente,Información General,Aviso de Evento,Modificación de Calendario',
            'adjective_emotion'  => 'nullable|string|max:100',
            'introduction'       => 'required|string',
            'key_points'         => 'required|array', // Valida que Vue envíe una estructura de lista/objeto
            'closure'            => 'required|string',
            'requires_signature' => 'nullable|boolean',
            'signature_path'     => 'nullable|string|max:255',
            'status'             => 'nullable|in:borrador,emitido'
        ];
    }
}
