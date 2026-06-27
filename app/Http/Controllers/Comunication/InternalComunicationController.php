<?php

namespace App\Http\Controllers\Comunication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comunication\InternalComunicationRequest;
use App\Http\Resources\Comunication\InternalComunicationResource;
use App\Models\InternalComunication;
use App\Traits\ApiResponse;

class InternalComunicationController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(InternalComunicationResource::collection(
            InternalComunication::with(['creator', 'users'])->latest()->get())
        );
    }

    public function store(InternalComunicationRequest $request)
    {
        $validated = $request->validated();
        $com = InternalComunication::create($validated);
        $com->users()->sync($validated['user_ids']);

        return $this->successResponse(new InternalComunicationResource($com->load('users')), 'Comunicado interno enviado', 201);
    }

    public function show(InternalComunication $internalComunication)
    {
        return $this->successResponse(new InternalComunicationResource($internalComunication->load(['creator', 'users'])));
    }

    public function update(InternalComunicationRequest $request, InternalComunication $internalComunication)
    {
        $validated = $request->validated();
        $internalComunication->update($validated);

        if (isset($validated['user_ids'])) {
            $internalComunication->users()->sync($validated['user_ids']);
        }

        return $this->successResponse(new InternalComunicationResource(
            $internalComunication->load('users')),
            'Comunicado interno actualizado');
    }

    public function destroy(InternalComunication $internalComunication)
    {
        $internalComunication->delete();
        return $this->successResponse(null, 'Comunicado interno eliminado');
    }
}
