<?php

namespace App\Http\Resources\Audit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditResource extends JsonResource
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
            'action' => $this->action, // create, update, delete...
            'table_name' => $this->table_name,
            'row_id' => $this->row_id,
            'old_values' => json_decode($this->old_values), // Lo enviamos limpio a Vue
            'new_values' => json_decode($this->new_values),
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'created_at' => $this->created_at->toDateTimeString(),
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user->name ?? 'Sistema / Automatizado'
            ]
        ];
    }
}
