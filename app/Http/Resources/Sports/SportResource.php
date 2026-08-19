<?php

namespace App\Http\Resources\Sports;

use App\Http\Resources\Admin\SchoolResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportResource extends JsonResource
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
            'category' => $this->category,
            'icon_path' => $this->icon_path,
            'rules' => $this->rules,
            'status' => $this->status,

            'teams_count' => $this->whenCounted('teams'),
            'matches_count' => $this->whenCounted('sportEvents'),

            'school_id' => $this->whenLoaded('schools', function () {
                return $this->schools->first()?->id;
            }),
            'school' => new SchoolResource($this->whenLoaded('schools')),
        ];
    }
}
