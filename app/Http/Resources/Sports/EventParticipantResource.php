<?php

namespace App\Http\Resources\Sports;

use App\Http\Resources\Admin\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventParticipantResource extends JsonResource
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
            'result_value' => $this->result_value, // Goles o puntos actuales
            'is_winner' => (bool)$this->is_winner,
            'type' => $this->team_id ? 'team' : 'individual',
            'team' => new SchoolTeamResource($this->whenLoaded('team')),
            'student' => new StudentResource($this->whenLoaded('student'))
        ];
    }
}
