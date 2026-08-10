<?php

namespace App\Http\Resources\Communication;

use App\Http\Resources\Admin\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternalCommunicationResource extends JsonResource
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
            'school_id'     => $this->school_id,
            'category'      => $this->category,
            'title'         => $this->title,
            'description'   => $this->description,
            'event_date'    => $this->event_date ? $this->event_date->toIso8601String() : null,
            'location'      => $this->location,
            'status'        => $this->status,
            'send_reminder' => (bool)$this->send_reminder,
            'created_by'    => [
                'id'        => $this->creator->id,
                'name'      => $this->creator->name ?? 'Sistema',
                'lastname'  => $this->creator->lastname ?? ''
            ],
            'created_at'    => $this->created_at->toIso8601String(),
            'updated_at'    => $this->updated_at->toIso8601String(),
            'recipients'    => $this->whenLoaded('users', function () {
                return $this->users->map(function ($user) {
                    return [
                        'id'       => $user->id,
                        'name'     => $user->name,
                        'lastname' => $user->lastname,
                        'title'    => $user->title ?? null,
                        'pivot'    => [
                            'notes' => $user->pivot->notes ?? ''
                        ]
                    ];
                });
            }),
        ];
    }
}
