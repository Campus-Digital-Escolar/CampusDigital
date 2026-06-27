<?php

namespace App\Http\Resources\Sports;

use App\Http\Resources\Admin\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportLeaderResource extends JsonResource
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
            'statistic_type' => $this->statistic_type, // Ej: "Goleador"
            'statistic_value' => $this->statistic_value, // Ej: "12"
            'student' => new StudentResource($this->whenLoaded('student')),
            'sport_name' => $this->sport->name ?? null
        ];
    }
}
