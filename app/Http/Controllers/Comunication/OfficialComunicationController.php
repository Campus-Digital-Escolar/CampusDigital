<?php

namespace App\Http\Controllers\Comunication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comunication\OfficialComunicationRequest;
use App\Http\Resources\Comunication\OfficialComunicationResource;
use App\Models\OfficialComunication;
use App\Traits\ApiResponse;
use Exception;

class OfficialComunicationController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(OfficialComunicationResource::collection(OfficialComunication::with('creator')->latest()->get()));
    }

    public function store(OfficialComunicationRequest $request)
    {
        $com = OfficialComunication::create($request->validated());
        return $this->successResponse(new OfficialComunicationResource($com), 'Comunicado oficial emitido', 201);
    }

    public function show(OfficialComunication $officialComunication)
    {
        return $this->successResponse(new OfficialComunicationResource($officialComunication->load('creator')));
    }

    public function update(OfficialComunicationRequest $request, OfficialComunication $officialComunication)
    {
        $officialComunication->update($request->validated());
        return $this->successResponse(new OfficialComunicationResource($officialComunication), 'Comunicado oficial actualizado');
    }

    public function destroy(OfficialComunication $officialComunication)
    {
        $officialComunication->delete();
        return $this->successResponse(null, 'Comunicado oficial eliminado');
    }
}
