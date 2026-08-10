<?php

namespace App\Http\Resources\Communication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GalleryItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'file_name'     => $this->file_name,
            'file_url'      => url(Storage::url($this->file_path)),
            'type'          => $this->type,
            'created_at'    => $this->created_at?->toISOString(),
            'updated_at'    => $this->updated_at?->toISOString(),
        ];
    }
}
