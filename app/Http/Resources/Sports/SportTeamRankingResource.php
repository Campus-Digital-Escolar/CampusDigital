<?php

namespace App\Http\Resources\Sports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportTeamRankingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'team' => new SchoolTeamResource($this->whenLoaded('team')),
            'games_played' => $this->games_played,
            'games_won' => $this->games_won,
            'games_drawn' => $this->games_drawn,
            'games_lost' => $this->games_lost,
            'points' => $this->points,
            'goals_for' => $this->goals_for,
            'goals_against' => $this->goals_against,
            'goal_difference' => $this->goals_for - $this->goals_against
        ];
    }
}
