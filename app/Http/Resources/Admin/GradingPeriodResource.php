<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradingPeriodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'academic_period_id' => $this->academic_period_id,
            'name'               => $this->name,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date'   => $this->end_date?->format('Y-m-d'),

            // Helper booleano calculado directo en el modelo
            'is_open'            => $this->relationLoaded('academicPeriod') ? $this->isOpenForCapture() : null,
            'academic_period'    => new AcademicPeriodResource($this->whenLoaded('academicPeriod')),
        ];
    }
}
