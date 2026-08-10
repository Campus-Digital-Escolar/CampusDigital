<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'id'        => $this->id,
            'role_id'   => $this->role_id,
            'school_id' => $this->school_id,
            'name'      => $this->name,
            'lastname'  => $this->lastname,
            'title'     => $this->title,
            'username'  => $this->username,
            'email'     => $this->email,
            'active'    => (bool) $this->active,
            'signature_enabled' => (bool) $this->signature_enabled,
            'signature_url'     => $this->signature_path ? Storage::url($this->signature_path) : null,

            'permissions' => $this->relationLoaded('permissions')
                ? $this->permissions->map(function($perm) {
                    return [
                        'module_name' => $perm->module_name,
                        'is_visible'  => (bool) $perm->is_visible,
                        'can_add'     => (bool) $perm->can_add,
                        'can_edit'    => (bool) $perm->can_edit,
                        'can_delete'  => (bool) $perm->can_delete,
                    ];
                })
                : [],

            'role' => $this->whenLoaded('role', function() {
                return ['id' => $this->role->id, 'name' => $this->role->name];
            }),

            'school' => $this->whenLoaded('school', function() {
                return ['id' => $this->school->id, 'name' => $this->school->name];
            }),

            'teacher' => $this->whenLoaded('teacher', function() {
                return ['id' => $this->teacher->id];
            }),
        ];
    }
}
