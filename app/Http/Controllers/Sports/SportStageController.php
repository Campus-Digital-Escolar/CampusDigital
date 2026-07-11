<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\SportStageRequest;
use App\Http\Resources\Sports\SportStageResource;
use App\Models\SportStage;
use App\Traits\ApiResponse;

class SportStageController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $stages = SportStage::all();
        return $this->successResponse(SportStageResource::collection($stages), 'Fases obtenidas exitosamente');
    }

    public function store(SportStageRequest $request)
    {
        $stage = SportStage::create($request->validated());
        return $this->successResponse(new SportStageResource($stage), 'Fase de torneo creada correctamente', 201);
    }

    public function show(SportStage $sportStage)
    {
        return $this->successResponse(new SportStageResource($sportStage));
    }

    public function update(SportStageRequest $request, SportStage $sportStage)
    {
        $sportStage->update($request->validated());
        return $this->successResponse(new SportStageResource($sportStage), 'Fase de torneo actualizada correctamente');
    }

    public function destroy(SportStage $sportStage)
    {
        if ($sportStage->sportEvents()->exists()) {
            return $this->errorResponse('No se puede eliminar la fase porque contiene partidos registrados', 422);
        }

        $sportStage->delete();
        return $this->successResponse(null, 'Fase de torneo eliminada correctamente');
    }
}
