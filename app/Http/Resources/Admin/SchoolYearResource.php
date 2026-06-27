<?php

namespace App\Http\Resources\Admin;

use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolYearResource extends JsonResource
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
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'active' => (bool)$this->active,

            'academic_periods' => AcademicPeriodResource::collection($this->whenLoaded('academicPeriods')),
        ];
    }
}
