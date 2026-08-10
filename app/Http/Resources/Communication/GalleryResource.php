<?php

namespace App\Http\Resources\Communication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'category_tag'  => $this->category_tag,
            'value_tag'     => $this->valueTag->name ?? null,
            'emotion_tag'   => $this->emotionTag->name ?? null,
            'items'         => GalleryItemResource::collection($this->whenLoaded('items')),
            'created_at'    => $this->created_at?->toISOString(),
            'updated_at'    => $this->updated_at?->toISOString(),
            'likes_count'   => $this->likes_count ?? $this->likes()->count(),
        ];
    }
}
