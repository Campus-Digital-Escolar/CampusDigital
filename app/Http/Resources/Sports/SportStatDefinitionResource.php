<?php

namespace App\Http\Resources\Sports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportStatDefinitionResource extends JsonResource
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
            'sport_id' => $this->sport_id,
            'sport' => new SportResource($this->whenLoaded('sport')),
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'data_type' => $this->data_type // conteo, tiempo, texto
        ];
    }
}
