<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherPermissionResource extends JsonResource
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
            'module_name' => $this->module_name,
            'is_visible' => (bool)$this->is_visible,
            'can_add' => (bool)$this->can_add,
            'can_edit' => (bool)$this->can_edit,
            'can_delete' => (bool)$this->can_delete,
        ];
    }
}
