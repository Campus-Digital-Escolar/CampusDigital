<?php

namespace App\Http\Requests\Communication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OfficialCommunicationRequest extends FormRequest
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
            'school_id' => $schoolId,
            'requires_signature' => filter_var($this->input('requires_signature'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false,
        ]);
    }

    public function rules(): array
    {
        return [
            'school_id'          => 'required|exists:schools,id',
            'created_by'         => 'required|exists:users,id',
            'title'              => 'required|string|max:255',
            'category'           => 'required|in:Urgente,Información General,Aviso de Evento,Modificación de Calendario',
            'adjective_emotion'  => 'nullable|string|max:100',
            'body'               => 'required|string',
            'signed_by'          => 'nullable|exists:users,id',
            'requires_signature' => 'nullable|boolean',
            'status'             => 'nullable|in:draft,published,deleted'
        ];
    }
}
