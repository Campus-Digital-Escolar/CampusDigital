<?php

namespace App\Http\Resources\Comunication;

use App\Http\Resources\Admin\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'body' => $this->body,
            'created_at' => $this->created_at->toIso8601String(),
            'author' => [
                'name' => $this->user->name ?? null,
                'title' => $this->user->title ?? null
            ],
            'value_tag' => $this->valueTag->name ?? null,
            'emotion_tag' => $this->emotionTag->name ?? null,
            'gallery' => new GalleryResource($this->whenLoaded('gallery')),
            'tagged_students' => StudentResource::collection($this->whenLoaded('students'))
        ];
    }
}
