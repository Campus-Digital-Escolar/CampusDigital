<?php

namespace App\Http\Resources\Academic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupGradeResource extends JsonResource
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
            'section' => $this->section,
            'name' => $this->name,
            'order' => $this->order,
            'educational_level'=>[
                'id'=>$this->educationalLevel?->id,
                'name'=>$this->educationalLevel?->name
            ]
        ];
    }
}
