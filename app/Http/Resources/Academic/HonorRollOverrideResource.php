<?php

namespace App\Http\Resources\Academic;

use App\Http\Resources\Admin\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HonorRollOverrideResource extends JsonResource
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
            'action' => $this->action, // incluir, excluir
            'reason' => $this->reason,
            'student' => new StudentResource($this->whenLoaded('student')),
            'school_year' => $this->schoolYear->label ?? null,
            'academic_period' => $this->academicPeriod->name ?? null,
            'authorized_by' => $this->creator->name ?? 'Sistema'
        ];
    }
}
