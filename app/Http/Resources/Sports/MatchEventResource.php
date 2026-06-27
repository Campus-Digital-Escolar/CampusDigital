<?php

namespace App\Http\Resources\Sports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchEventResource extends JsonResource
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
            'match_time' => $this->match_time, // Ej: "42'"
            'description' => $this->description,
            'stat_name' => $this->statDefinition->name ?? null, // Ej: "Gol"
            'student_name' => $this->student ? "{$this->student->user->name} {$this->student->user->lastname}" : null
        ];
    }
}
