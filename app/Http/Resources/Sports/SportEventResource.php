<?php

namespace App\Http\Resources\Sports;

use App\Http\Resources\Admin\SchoolResource;
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
            'school_id' => $this->school_id,
            'sport_id' => $this->sport_id,
            'stage_id' => $this->stage_id,
            'event_date' => $this->event_date->toIso8601String(),
            'is_live' => (bool)$this->is_live,
            'status' => $this->status, // scheduled, ongoing, completed, cancelled

            'school' => new SchoolResource($this->whenLoaded('school')),
            'sport' => new SportResource($this->whenLoaded('sport')),
            'stage' => new SportResource($this->whenLoaded('stage')),

            'participants' => EventParticipantResource::collection($this->whenLoaded('participants'))
        ];
    }
}
