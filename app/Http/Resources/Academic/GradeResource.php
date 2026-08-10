<?php

namespace App\Http\Resources\Academic;

use App\Http\Resources\Admin\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
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
            'score' => (float)$this->score,
            'student_id'        => $this->student_id,
            'grading_period_id' => $this->grading_period_id,
            'student'           => new StudentResource($this->whenLoaded('student')),
            'subject'           => $this->subject->name ?? null,
            'academic_period'   => $this->academicPeriod->name ?? null,
            'school_year'       => $this->schoolYear->label ?? null
        ];
    }
}
