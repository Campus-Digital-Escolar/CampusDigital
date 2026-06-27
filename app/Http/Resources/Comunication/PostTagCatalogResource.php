<?php

namespace App\Http\Resources\Comunication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostTagCatalogResource extends JsonResource
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
            'type' => $this->type // valor, emocion
        ];
    }
}
