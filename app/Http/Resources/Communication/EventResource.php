<?php

namespace App\Http\Resources\Communication;

use App\Http\Resources\Academic\GroupResource;
use App\Http\Resources\Admin\EducationalLevelResource;
use App\Http\Resources\Communication\GalleryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'created_by' => $this->created_by,
            'educational_level_id' => $this->educational_level_id,
            'group_id' => $this->group_id,

            'educational_level' => new EducationalLevelResource($this->whenLoaded('educationalLevel')),
            'group' => new GroupResource($this->whenLoaded('group')),
            'gallery' => new GalleryResource($this->whenLoaded('gallery')),

            'title' => $this->title,
            'description' => $this->description,
            'location_type' => $this->location_type,
            'event_date' => $this->event_date->toIso8601String(),
            'status' => $this->status,
            'reminder_days_before' => $this->reminder_days_before,

            'creator' => $this->whenLoaded('creator', function () {
                return [
                    'id' => $this->creator->id,
                    'name' => $this->creator->name,
                ];
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
