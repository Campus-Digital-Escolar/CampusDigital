<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Communication\OfficialCommunicationRequest;
use App\Http\Resources\Communication\OfficialCommunicationResource;
use App\Models\OfficialCommunication;
use App\Models\OfficialCommunicationAttachment;
use App\Models\PostTagCatalog;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class OfficialCommunicationController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $communications = OfficialCommunication::with(['creator', 'signer.role', 'adjectiveEmotion', 'attachments', 'school'])
            ->latest()
            ->get();

        return $this->successResponse(OfficialCommunicationResource::collection($communications));
    }

    public function store(OfficialCommunicationRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['status'] = $data['status'] ?? 'published';

            if (!empty($data['adjective_emotion'])) {
                $tag = PostTagCatalog::firstOrCreate([
                    'name' => trim($data['adjective_emotion'])
                ]);
                $data['adjective_emotion_id'] = $tag->id;
            }

            if (!empty($data['requires_signature']) && !empty($data['signed_by'])) {
                $signer = User::find($data['signed_by']);
                if ($signer && $signer->signature_path) {
                    $data['signature_snapshot_path'] = $signer->signature_path;
                }
            }

            $com = OfficialCommunication::create($data);

            if ($request->hasFile('attachments')) {
                $this->saveAttachments($com->id, $request->file('attachments'));
            }

            return $this->successResponse(
                new OfficialCommunicationResource($com->load(['creator', 'signer.role', 'adjectiveEmotion', 'attachments', 'school'])),
                'Comunicado oficial emitido correctamente',
                201
            );
        });
    }

    public function show(OfficialCommunication $officialCommunication)
    {
        return $this->successResponse(
            new OfficialCommunicationResource($officialCommunication->load(['creator', 'signer.role', 'adjectiveEmotion', 'attachments', 'school'])),
        );
    }

    public function update(OfficialCommunicationRequest $request, OfficialCommunication $officialCommunication)
    {
        return DB::transaction(function () use ($request, $officialCommunication) {
            $data = $request->validated();

            if (array_key_exists('adjective_emotion', $data)) {
                if (!empty($data['adjective_emotion'])) {
                    $tag = PostTagCatalog::firstOrCreate([
                        'name' => trim($data['adjective_emotion'])
                    ]);
                    $data['adjective_emotion_id'] = $tag->id;
                } else {
                    $data['adjective_emotion_id'] = null;
                }
            }

            if (!empty($data['requires_signature']) && !empty($data['signed_by'])) {
                if ($officialCommunication->signed_by != $data['signed_by'] || !$officialCommunication->signature_snapshot_path) {
                    $signer = User::find($data['signed_by']);
                    if ($signer && $signer->signature_path) {
                        $data['signature_snapshot_path'] = $signer->signature_path;
                    }
                }
            } else {
                $data['signed_by'] = null;
                $data['signature_snapshot_path'] = null;
            }

            $officialCommunication->update($data);

            if ($request->hasFile('attachments')) {
                $this->saveAttachments($officialCommunication->id, $request->file('attachments'));
            }

            return $this->successResponse(
                new OfficialCommunicationResource($officialCommunication->load(['creator', 'signer.role', 'adjectiveEmotion', 'attachments', 'school'])),
                'Comunicado oficial actualizado'
            );
        });
    }

    public function destroy(OfficialCommunication $officialCommunication)
    {
        $officialCommunication->delete();
        return $this->successResponse(null, 'Comunicado oficial eliminado');
    }

    public function searchAdjectives(Request $request)
    {
        $query = $request->get('q', '');
        $tags = PostTagCatalog::when($query, function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })->limit(10)->pluck('name');

        return $this->successResponse($tags);
    }

    public function getSigners(Request $request)
    {
        $signers = User::where('signature_enabled', true)
            ->whereNotNull('signature_path')
            ->select('id', 'name', 'lastname')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'full_name' => trim(($user->title ? $user->title . ' ' : '') . $user->name . ' ' . $user->lastname),
                ];
            });

        return $this->successResponse($signers);
    }

    private function saveAttachments(int $communicationId, array $files): void
    {
        foreach ($files as $file) {
            $path = $file->store('official_communications/attachments', 'public');

            OfficialCommunicationAttachment::create([
                'official_communication_id' => $communicationId,
                'file_path'                 => $path,
                'file_name'                 => $file->getClientOriginalName(),
                'mime_type'                 => $file->getClientMimeType(),
                'file_size'                 => round($file->getSize() / 1024, 2) . ' KB',
            ]);
        }
    }
}
