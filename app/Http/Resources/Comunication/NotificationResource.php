<?php

namespace App\Http\Resources\Comunication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'type' => $this->type,
            'is_read' => $this->read_at !== null,
            'read_at' => $this->read_at ? $this->read_at->toIso8601String() : null,
            'created_at' => $this->created_at->diffForHumans(),
            'action_navigation' => [
                'action' => $this->target_action,
                'target_id' => $this->target_id
            ]
        ];
    }
}
