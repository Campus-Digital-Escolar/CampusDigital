<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\JobPositionRequest;
use App\Http\Resources\Auth\JobPositionResource;
use App\Models\JobPosition;
use App\Traits\ApiResponse;
use PHPUnit\Exception;

class JobPositionController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $positions = JobPosition::orderBy('name', 'asc')->get();

            return $this->successResponse(
                JobPositionResource::collection($positions),
                'Lista de puestos obtenida correctamente.'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Error al consultar los puestos de trabajo.',
                500,
                $e->getMessage()
            );
        }
    }

    public function store(JobPositionRequest $request)
    {
        try {
            $position = JobPosition::create($request->validated());

            return $this->successResponse(
                new JobPositionResource($position),
                'Puesto de trabajo creado exitosamente.',
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Ocurrió un error al registrar el puesto de trabajo.',
                500,
                $e->getMessage()
            );
        }
    }

    public function show(JobPosition $jobPosition)
    {
        try {
            return $this->successResponse(
                new JobPositionResource($jobPosition),
                'Detalle del puesto de trabajo obtenido correctamente.'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Error al consultar el puesto de trabajo.',
                500,
                $e->getMessage()
            );
        }
    }

    public function update(JobPositionRequest $request, JobPosition $jobPosition)
    {
        try {
            $jobPosition->update($request->validated());

            return $this->successResponse(
                new JobPositionResource($jobPosition),
                'Puesto de trabajo actualizado correctamente.'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Error al actualizar el puesto de trabajo.',
                500,
                $e->getMessage()
            );
        }
    }

    public function destroy(JobPosition $jobPosition)
    {
        try {
            if ($jobPosition->teachers()->exists()) {
                return $this->errorResponse(
                    'No se puede eliminar el puesto porque está asignado a uno o más empleados.',
                    422
                );
            }

            $jobPosition->delete();

            return $this->successResponse(
                null,
                'Puesto de trabajo eliminado correctamente.'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Error al eliminar el puesto de trabajo.',
                500,
                $e->getMessage()
            );
        }
    }
}
