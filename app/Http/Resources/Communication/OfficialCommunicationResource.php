<?php

namespace App\Http\Resources\Communication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OfficialCommunicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'school_id'          => $this->school_id,
            'school'             => $this->whenLoaded('school', function () {
                return [
                    'id'       => $this->school->id,
                    'name'     => $this->school->name,
                    'logo_url' => $this->school->logo_path
                        ? Storage::url($this->school->logo_path)
                        : null,
                    'code'     => $this->school->code ?? null,
                ];
            }),
            'created_by'         => $this->created_by,
            'title'                 => $this->title,
            'category'              => $this->category,
            'adjective_emotion'     => $this->adjective_emotion,
            'body'                  => $this->body,
            'requires_signature'    => (bool)$this->requires_signature,
            'signature_url' => $this->signature_snapshot_path
                ? asset(Storage::url('signatures/' . ltrim($this->signature_snapshot_path, '/')))
                : null,
            'signer'                => $this->signer
                ? [
                    'id' => $this->signer->id,
                    'name' => $this->signer->name,
                    'lastname' => $this->signer->lastname,
                    'full_name' => $this->signer->full_name,
                    'position' => $this->signer->role->name ?? null
                ]
                : null,
            'status'                => $this->status,
            'sender'                => $this->creator->name ?? 'Dirección',
            'attachments'           => $this->attachments->map(function ($attachment) {
                return [
                    'id'                    => $attachment->id,
                    'name'                  => $attachment->file_name,
                    'url'                   => Storage::url($attachment->file_path),
                    'size'                   => $attachment->file_size,
                    'mime_type'              => $attachment->mime_type,
                ];
            }),
            'created_at'            => $this->created_at->toIso8601String(),
            'updated_at'         => $this->updated_at?->toIso8601String(),
        ];
    }
}
