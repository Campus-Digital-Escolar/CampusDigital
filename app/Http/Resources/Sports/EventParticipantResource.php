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
            'sport_event_id' => $this->sport_event_id,
            'student_id' => $this->student_id,
            'school_team_id' => $this->school_team_id,

            'external_participant_name' => $this->external_participant_name,
            'external_institution' => $this->external_institution,

            'result_value' => $this->result_value, // Goles o puntos actuales
            'is_winner' => (bool)$this->is_winner,
            'result_position' => $this->result_position,

            'sport' => new SportResource($this->whenLoaded('event')),
            'school_team' => new SchoolTeamResource($this->whenLoaded('team')),
            'student' => new StudentResource($this->whenLoaded('student'))
        ];
    }
}
