<?php

namespace App\Http\Resources\Sports;

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
            'icon_url' => $this->icon_path ? asset($this->icon_path) : null,
            'sport_name' => $this->sport->name ?? null,
            'coach_name' => $this->coach ? "{$this->coach->user->name} {$this->coach->user->lastname}" : null
        ];
    }
}
