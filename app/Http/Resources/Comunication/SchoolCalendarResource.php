<?php

namespace App\Http\Resources\Comunication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'start' => $this->start_date->format('Y-m-data'),
            'end' => $this->end_date->format('Y-m-data'),
            'type' => $this->type,
            'icon' => $this->icon_marker
        ];
    }
}
