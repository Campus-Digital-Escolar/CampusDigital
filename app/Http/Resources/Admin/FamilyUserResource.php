<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $student = $this->students->first();
        $group = $student ? $student->groups->first() : null;

        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'lastname'              => $this->lastname,
            'full_name'             => "{$this->name} {$this->lastname}",
            'email'                 => $this->email ?? 'Sin correo registrado',
            'generated_username'    => $this->username,
            'temp_password_plain'   => $this->temp_password_plain ?? $this->username,
            'last_login_at'       => $this->last_login_at ? $this->last_login_at->toISOString() : null,
            'has_logged_in'       => !is_null($this->last_login_at),
            'student'               => $this->whenLoaded('students', function () use ($student, $group) {
                if (!$student) return null;

                return [
                    'id'            => $student->id,
                    'name'          => $student->name,
                    'lastname'      => $student->lastname,
                    'full_name'      => "{$student->name} {$student->lastname}",
                    'birthday'      => $student->birthday,
                    'gender'        => $student->gender,
                    'grade_average' => (float)$student->grade_average,
                    'groups'         => $group ? [
                        'id'                => $group->id,
                        'grade'             => $group->groupGrade ? [
                            'id'    => $group->groupGrade->id,
                            'name'  => $group->groupGrade->name,
                            'order' => $group->groupGrade->order,
                        ] : null,
                        'section'           => $group->section,
                        'full_group'        => $group?->full_group ?? "{$group->groupGrade?->name} {$group->section}",
                        'educational_level' => [
                            'id'   => $group->groupGrade?->educationalLevel?->id,
                            'name' => $group->groupGrade?->educationalLevel->name,
                        ],
                    ] : null,
                    'photo_url'    => $student->photo_path ? asset('storage/' . $student->photo_path) : null,
                ];
            }),
        ];
    }
}
