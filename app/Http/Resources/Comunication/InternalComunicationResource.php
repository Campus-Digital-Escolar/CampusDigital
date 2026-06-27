<?php

namespace App\Http\Resources\Comunication;

use App\Http\Resources\Admin\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternalComunicationResource extends JsonResource
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
            'category' => $this->category, // Reunión, Solicitud, Anuncio General
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date ? $this->event_date->toIso8601String() : null,
            'location' => $this->location,
            'send_reminder' => (bool)$this->send_reminder,
            'approval_status' => $this->approval_status, // pendiente, aprobada, rechazada
            'rejection_reason' => $this->rejection_reason, // Corregido el typo semántico
            'created_at' => $this->created_at->toIso8601String(),
            'sender' => [
                'name' => $this->creator->name ?? 'Sistema',
                'lastname' => $this->creator->lastname ?? ''
            ],
            'recipients' => UserResource::collection($this->whenLoaded('users')) // Relación M-M
        ];
    }
}
