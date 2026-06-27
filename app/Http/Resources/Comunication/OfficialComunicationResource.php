<?php

namespace App\Http\Resources\Comunication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficialComunicationResource extends JsonResource
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
            'category' => $this->category,
            'adjective_emotion' => $this->adjective_emotion,
            'introduction' => $this->introduction,
            'key_points' => $this->key_points,
            'closure' => $this->closure,
            'requires_signature' => (bool)$this->requires_signature,
            'signature_url' => $this->signature_path ? asset($this->signature_path) : null,
            'status' => $this->status,
            'created_at' => $this->created_at->toIso8601String(),
            'sender' => $this->creator->name ?? 'Dirección'
        ];
    }
}
