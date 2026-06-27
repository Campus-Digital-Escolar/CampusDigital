<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicPeriodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'school_year_id' => $this->school_year_id,
            'name'           => $this->name,
            'start_date'     => $this->start_date?->format('Y-m-d'),
            'end_date'       => $this->end_date?->format('Y-m-d'),

            // Relaciones condicionales (Padre e Hijos)
            'school_year'    => new SchoolYearResource($this->whenLoaded('schoolYear')),
            'grading_periods' => GradingPeriodResource::collection($this->whenLoaded('gradingPeriods')),
        ];
    }
}
