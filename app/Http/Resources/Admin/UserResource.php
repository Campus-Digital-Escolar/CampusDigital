<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'lastname' => $this->lastname,
            'full_name' => "{$this->name} {$this->lastname}",
            'title' => $this->title,
            'username' => $this->username,
            'email' => $this->email,
            'active' => (bool)$this->active,
            'role' => new RoleResource($this->whenLoaded('role')),
            'school' => new SchoolResource($this->whenLoaded('school')),
            'teacher_profile' => new TeacherResource($this->whenLoaded('teacher')),
            'student_profile' => new StudentResource($this->whenLoaded('student')),
        ];
    }
}
