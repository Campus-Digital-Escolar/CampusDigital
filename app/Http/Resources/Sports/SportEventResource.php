<?php

namespace App\Http\Resources\Sports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportEventResource extends JsonResource
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
            'event_date' => $this->event_date->toIso8601String(),
            'is_live' => (bool)$this->is_live,
            'status' => $this->status, // scheduled, ongoing, completed, cancelled
            'sport' => $this->sport->name ?? null,
            'sport_icon' => $this->sport->icon_path ? asset($this->sport->icon_path) : null,
            'stage' => $this->stage->name ?? null,
            'educational_level' => $this->educationalLevel->name ?? null,
            'participants' => EventParticipantResource::collection($this->whenLoaded('participants'))
        ];
    }
}
