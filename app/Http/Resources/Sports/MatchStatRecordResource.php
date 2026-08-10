<?php

namespace App\Http\Resources\Sports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchStatRecordResource extends JsonResource
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
            'event_id' => $this->event_id,
            'team_id' => $this->team_id,
            'participant_id' => $this->participant_id,
            'stat_definition_id' => $this->stat_definition_id,
            'value' => $this->value,
            'created_at' => $this->created_at?->toIso8601String(),

            'team' => new SchoolTeamResource($this->whenLoaded('team')),
            'participant' => new EventParticipantResource($this->whenLoaded('participant')),
            'stat_definition' => new SportStatDefinitionResource($this->whenLoaded('statDefinition')),
        ];
    }
}
