<?php

namespace App\Http\Requests\Sports;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SportStatDefinitionRequest extends FormRequest
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
            'sport_id'  => 'required|exists:sports,id',
            'name'      => 'required|string|max:100', // Ej: "Goles", "Tarjetas Amarillas", "Faltas"
            'data_type' => 'required|in:conteo,tiempo,texto'
        ];
    }
}
