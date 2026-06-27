<?php

namespace App\Http\Resources\Academic;

use App\Http\Resources\Admin\StudentResource;
use App\Http\Resources\Admin\TeacherResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'grade' => $this->grade,
            'section' => $this->section,
            'full_group' => "{$this->grade}° '{$this->section}'",
            'educational_level' => $this->educationalLevel->name ?? null,
            'school_year' => $this->schoolYear->label ?? null,
            'tutor' => new TeacherResource($this->whenLoaded('tutor')),
            'students' => StudentResource::collection($this->whenLoaded('students'))
        ];
    }
}
