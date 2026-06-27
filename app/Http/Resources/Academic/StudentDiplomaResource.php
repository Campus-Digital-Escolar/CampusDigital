<?php

namespace App\Http\Resources\Academic;

use App\Http\Resources\Admin\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentDiplomaResource extends JsonResource
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
            'diploma_url' => asset($this->diploma_path),
            'student' => new StudentResource($this->whenLoaded('student')),
            'school_year' => $this->schoolYear->label ?? null,
            'academic_period' => $this->academicPeriod->name ?? null
        ];
    }
}
