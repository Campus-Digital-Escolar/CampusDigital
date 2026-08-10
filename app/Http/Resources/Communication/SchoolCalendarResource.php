<?php

namespace App\Http\Resources\Communication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SchoolCalendarResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'start' => $this->start_date->format('Y-m-d'),
            'end' => $this->end_date->format('Y-m-d'),
            'type' => $this->type,
            'icon' => $this->icon_marker ? asset(Storage::url($this->icon_marker)) : null,
        ];
    }
}
