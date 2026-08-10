<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Academic\GroupResource;
use App\Http\Resources\Academic\StudentDiplomaResource;
use App\Models\StudentDiploma;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $firstTutor = $this->parents->first();
        $currentGroup = $this->relationLoaded('groups') && $this->groups->isNotEmpty()
            ? $this->groups->first()
            : $this->group;

        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'lastname'  => $this->lastname,
            'full_name' => "{$this->lastname} {$this->name}",
            'birthday'  => $this->birthday,
            'gender'    => $this->gender,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
            'grade_average' => $this->grade_average ?? 0.0,
            'parent_username' => $firstTutor ? $firstTutor->username : null,
            'user' => new UserResource($this->whenLoaded('user')),

            'groups' => $currentGroup ? new GroupResource($currentGroup) : null,

            'tutor' => $firstTutor ? [
                'name'     => $firstTutor->name,
                'lastname' => $firstTutor->lastname,
                'username' => $firstTutor->username,
                'email'    => $firstTutor->email ?? '',
            ] : null,

            'diplomas' => StudentDiplomaResource::collection($this->whenLoaded('diplomas')),
        ];
    }
}
