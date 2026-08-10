<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Communication\InternalCommunicationRequest;
use App\Http\Resources\Communication\InternalCommunicationResource;
use App\Models\InternalCommunication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InternalComunicationNotification;
use App\Traits\ApiResponse;

class InternalCommunicationController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(InternalCommunicationResource::collection(
            InternalCommunication::with(['creator', 'users'])->latest()->get())
        );
    }

    public function store(InternalCommunicationRequest $request)
    {
        $validated = $request->validated();
        $com = InternalCommunication::create($validated);

        $com->users()->sync($validated['user_ids']);

        $recipients = User::whereIn('id', $validated['user_ids'])->get();
        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new InternalComunicationNotification($com));
        }
        return $this->successResponse(new InternalCommunicationResource($com->load('creator', 'users')), 'Comunicado interno enviado', 201);
    }

    public function show(InternalCommunication $internalCommunication)
    {
        return $this->successResponse(new InternalCommunicationResource($internalCommunication->load(['creator', 'users'])));
    }

    public function update(InternalCommunicationRequest $request, InternalCommunication $internalCommunication)
    {
        $validated = $request->validated();
        $internalCommunication->update($validated);

        if (isset($validated['user_ids'])) {
            $internalCommunication->users()->sync($validated['user_ids']);
        }

        return $this->successResponse(new InternalCommunicationResource(
            $internalCommunication->load('creator', 'users')),
            'Comunicado interno actualizado');
    }

    public function destroy(InternalCommunication $internalCommunication)
    {
        $internalCommunication->delete();
        return $this->successResponse(null, 'Comunicado interno eliminado');
    }

    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $user = auth()->user();
        $communication = InternalCommunication::findOrFail($id);

        $isCreator = $communication->created_by === $user->id;
        $isRecipient = $communication->users()->where('user_id', $user->id)->exists();

        if (!$isCreator && !$isRecipient) {
            return response()->json([
                'ok' => false,
                'message' => 'No estás asignado a esta junta o comunicado.'
            ], 403);
        }

        if (!$isRecipient) {
            $communication->users()->attach($user->id, [
                'notes' => $request->input('notes', '')
            ]);
        } else {
            $communication->users()->updateExistingPivot($user->id, [
                'notes' => $request->input('notes', '')
            ]);
        }

        return response()->json([
            'ok' => true,
            'message' => 'Notas guardadas correctamente.'
        ]);
    }
}
