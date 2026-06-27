<?php

namespace App\Http\Resources\Admin;

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
            'enrollment_number' => $this->enrollment_number,
            'profession' => $this->profession,
            'photo_url' => $this->photo_path ? asset($this->photo_path) : null,
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
