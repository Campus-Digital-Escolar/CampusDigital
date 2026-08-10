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
        $gradeLoaded = $this->relationLoaded('groupGrade') && $this->groupGrade;

        return [
            'id' => $this->id,
            'grade' => $this->whenLoaded('groupGrade', function () {
                if (!$this->groupGrade) return null;
                return [
                    'id' => $this->groupGrade->id,
                    'name' => $this->groupGrade->name,
                    'order' => $this->groupGrade->order,
                ];
            }),
            'section' => $this->section,
            'full_group' => $gradeLoaded
                ? "{$this->groupGrade->name} '{$this->section}'"
                : "Sin Grado '{$this->section}'",

            'educational_level' => $this->whenLoaded('groupGrade', function () {
                return [
                    'id'   => $this->groupGrade->educationalLevel?->id,
                    'name' => $this->groupGrade->educationalLevel?->name ?? 'Sin Nivel Asignado',
                ];
            }),
            'school_year' => $this->schoolYear->name ?? null,
            'tutor' => new TeacherResource($this->whenLoaded('tutor')),
            'students' => StudentResource::collection($this->whenLoaded('students'))
        ];
    }
}
