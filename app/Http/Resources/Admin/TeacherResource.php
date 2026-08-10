<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Academic\GroupResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TeacherResource extends JsonResource
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
            'profession'  => $this->profession,
            'job_position_id' => $this->job_position_id,
            'photo_url'   => $this->photo_path ? asset('storage/' . $this->photo_path) : null,

            'job_position'    => $this->whenLoaded('jobPosition', function () {
                return [
                    'id'          => $this->jobPosition->id,
                    'name'        => $this->jobPosition->name,
                    'department'  => $this->jobPosition->department,
                    'is_academic' => (bool) $this->jobPosition->is_academic,
                ];
            }),

            'tutored_groups' => GroupResource::collection($this->whenLoaded('tutoredGroups')),

            'assignments'    => $this->whenLoaded('groupsTeachers', function () {
                return $this->groupsTeachers->map(function ($gt) {
                    return [
                        'id'         => $gt->id,
                        'group_id'   => $gt->group_id,
                        'group'      => $gt->group ? new GroupResource($gt->group) : null,
                        'subject_id' => $gt->subject_id,
                        'subject'    => $gt->subject ? new SubjectResource($gt->subject) : null,
                    ];
                });
            }, []),



            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
