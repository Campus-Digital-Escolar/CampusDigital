<?php

namespace App\Http\Resources\Comunication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'location_type' => $this->location_type,
            'target_grade' => $this->target_grade,
            'event_date' => $this->event_date->toIso8601String(),
            'status' => $this->status, // programado, reprogramado, cancelado, finalizado
            'reminder_days_before' => $this->reminder_days_before,
            'gallery_id' => $this->gallery_id, // Si el evento finalizó y tiene fotos ligadas
            'created_by_name' => $this->user->name ?? 'Administración'
        ];
    }
}
