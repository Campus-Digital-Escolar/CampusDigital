<?php

namespace App\Http\Resources\Admin;

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
        return [
            'id' => $this->id,
            'enrollment_number' => $this->enrollment_number,
            'photo_url' => $this->photo_path ? asset($this->photo_path) : null,
            'grade_average' => (float)$this->grade_average,
            'user' => new UserResource($this->whenLoaded('user')),
            'parents' => UserResource::collection($this->whenLoaded('parents'))
        ];
    }
}
