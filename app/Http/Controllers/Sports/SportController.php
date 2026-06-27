<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\SportRequest;
use App\Http\Resources\Sports\SportResource;
use App\Models\Sport;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class SportController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $sports = Sport::all();
            return $this->successResponse(
                SportResource::collection($sports),
                "Deportes obtenidos exitosamente."
            );
        } catch (Exception $e) {
            return $this->errorResponse("Error al consultar los deportes", 500, $e->getMessage());
        }
    }

    public function store(SportRequest $request)
    {
        try {
            $sport = Sport::create($request->validated());
            return $this->successResponse(
                new SportResource($sport),
                "Deporte creado exitosamente",
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse("No se pudo registrar el deporte", 400, $e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $sport = Sport::find($id);
            if (!$sport) {
                return $this->errorResponse("Deporte no encontrado", 404);
            }
            return $this->successResponse(new SportResource($sport), "Deporte encontrado.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al buscar el deporte", 500, $e->getMessage());
        }
    }

    public function update(SportRequest $request, int $id)
    {
        try {
            $sport = Sport::find($id);
            if (!$sport) {
                return $this->errorResponse("Deporte no encontrado", 404);
            }

            $sport->update($request->validated());
            return $this->successResponse(new SportResource($sport), "Deporte actualizado exitosamente.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al actualizar el deporte", 400, $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $sport = Sport::find($id);
            if (!$sport) {
                return $this->errorResponse("Deporte no encontrado", 404);
            }

            $sport->delete();
            return $this->successResponse(null, "Deporte eliminado permanentemente.");
        } catch (Exception $e) {
            return $this->errorResponse("No se pudo eliminar el deporte", 500, $e->getMessage());
        }
    }
}
