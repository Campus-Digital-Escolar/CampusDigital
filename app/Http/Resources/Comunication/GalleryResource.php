<?php

namespace App\Http\Resources\Comunication;

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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category_tag' => $this->category_tag,
            'value_tag' => $this->valueTag->name ?? null,
            'emotion_tag' => $this->emotionTag->name ?? null,
            'likes_count' => $this->likes_count ?? $this->likes()->count(),
            'items' => $this->items->map(function($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->type, // image, video
                    'url' => asset($item->file_path)
                ];
            })
        ];
    }
}
