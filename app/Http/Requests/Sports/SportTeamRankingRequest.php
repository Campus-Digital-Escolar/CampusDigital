<?php

namespace App\Http\Requests\Sports;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SportTeamRankingRequest extends FormRequest
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
            'school_id'      => 'required|exists:schools,id',
            'sport_id'       => 'required|exists:sports,id',
            'school_year_id' => 'required|exists:school_years,id',
            'team_id'        => 'required|exists:school_teams,id',
            'games_played'   => 'nullable|integer|min:0',
            'games_won'      => 'nullable|integer|min:0',
            'games_drawn'    => 'nullable|integer|min:0',
            'games_lost'     => 'nullable|integer|min:0',
            'points'         => 'nullable|integer|min:0',
            'goals_for'      => 'nullable|integer|min:0',
            'goals_against'  => 'nullable|integer|min:0'
        ];
    }
}
