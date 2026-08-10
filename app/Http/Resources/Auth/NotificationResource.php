<?php

namespace App\Http\Resources\Auth;

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
            'id'                => $this->id,
            'user_id'           => $this->user_id,
            'type'              => $this->type,
            'title'             => $this->title,
            'body'              => $this->body,
            'data'              => $this->data,
            'notifiable_type'   => $this->notifiable_type,
            'notifiable_id'     => $this->notifiable_id,
            'is_read'           => $this->read_at !== null,
            'read_at'           => $this->read_at?->toIso8601String(),
            'created_at'        => $this->created_at?->toIso8601String(),
            'updated_at'        => $this->updated_At?->toIso8601String(),
        ];
    }
}
