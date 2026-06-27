<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SchoolYearRequest;
use App\Http\Resources\Admin\SchoolYearResource;
use App\Models\SchoolYear;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $years = SchoolYear::orderByDesc('start_date')->get();
            return $this->successResponse(
                SchoolYearResource::collection($years),
                'Ciclos escolares obtenidos exitosamente.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Error al consultar los ciclos escolares.', 500, $e->getMessage());
        }
    }

    public function store(SchoolYearRequest $request)
    {
        try {
            $data = $request->validated();

            $schoolYear = SchoolYear::create([
                'name'       => $data['name'],
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'],
                'active'  => $data['active'] ?? false,
            ]);

            return $this->successResponse(
                new SchoolYearResource($schoolYear),
                'Ciclo escolar creado exitosamente.',
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo registrar el ciclo escolar.', 500, $e->getMessage());
        }
    }

    public function show(SchoolYear $schoolYear)
    {
        try {
            return $this->successResponse(
                new SchoolYearResource($schoolYear->load('academicPeriods')),
                'Ciclo escolar encontrado.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Error al buscar el ciclo escolar.', 500, $e->getMessage());
        }
    }

    public function update(SchoolYearRequest $request, SchoolYear $schoolYear)
    {
        try {
            $data = $request->validated();

            $schoolYear->update([
                'name'       => $data['name'],
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'],
                'active'  => $data['active'] ?? $schoolYear->active,
            ]);

            return $this->successResponse(
                new SchoolYearResource($schoolYear),
                'Ciclo escolar actualizado correctamente.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo actualizar el ciclo escolar.', 500, $e->getMessage());
        }
    }

    public function destroy(SchoolYear $schoolYear)
    {
        try {
            if ($schoolYear->academicPeriods()->exists()) {
                return $this->errorResponse('No se puede eliminar el ciclo escolar porque contiene periodos académicos activos.', 422);
            }

            $schoolYear->delete();
            return $this->successResponse(null, 'Ciclo escolar eliminado permanentemente.');
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo eliminar el ciclo escolar.', 500, $e->getMessage());
        }
    }
}
