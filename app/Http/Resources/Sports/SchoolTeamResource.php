<?php

namespace App\Http\Resources\Sports;

use App\Http\Resources\Admin\SchoolResource;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolTeamResource extends JsonResource
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
            'name' => $this->name,
            'icon_path' => $this->icon_path ? asset('storage/' . $this->icon_path) : null,
            'coach_id' => $this->coach->coach_teacher_id,
            'coach_name' => $this->coach ? "{$this->coach->user->name} {$this->coach->user->lastname}" : null,
            'school_id' => $this->school_id,
            'sport_id' => $this->sport_id,
            'school' => new SchoolResource($this->whenLoaded('schools')),
            'sport' => new SportResource($this->whenLoaded('sport')),
        ];
    }
}
