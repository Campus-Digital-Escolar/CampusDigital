<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GradingPeriodRequest;
use App\Http\Resources\Admin\GradingPeriodResource;
use App\Models\GradingPeriod;
use App\Traits\ApiResponse;
use Exception;

class GradingPeriodController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $gradingPeriods = GradingPeriod::with('academicPeriod')->get();

            return $this->successResponse(
                GradingPeriodResource::collection($gradingPeriods),
                'Periodos de evaluación (parciales) obtenidos con éxito.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Error al consultar las fechas de los parciales.', 500, $e->getMessage());
        }
    }

    public function store(GradingPeriodRequest $request)
    {
        try {
            $data = $request->validated();

            $gradingPeriod = GradingPeriod::create([
                'academic_period_id' => $data['academic_period_id'],
                'name'               => $data['name'],
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'],
            ]);

            return $this->successResponse(
                new GradingPeriodResource($gradingPeriod),
                'Periodo de parcial configurado exitosamente.',
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo configurar el parcial.', 500, $e->getMessage());
        }
    }

    public function show(GradingPeriod $gradingPeriod)
    {
        try {
            return $this->successResponse(
                new GradingPeriodResource($gradingPeriod->load('academicPeriod')),
                'Periodo de evaluación encontrado.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Error al buscar el parcial.', 500, $e->getMessage());
        }
    }

    public function update(GradingPeriodRequest $request, GradingPeriod $gradingPeriod)
    {
        try {
            $data = $request->validated();

            $gradingPeriod->update([
                'academic_period_id' => $data['academic_period_id'],
                'name'               => $data['name'],
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'],
            ]);

            return $this->successResponse(
                new GradingPeriodResource($gradingPeriod),
                'Configuración del parcial actualizada.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo actualizar el parcial.', 500, $e->getMessage());
        }
    }

    public function destroy(GradingPeriod $gradingPeriod)
    {
        try {
            // Nota: Si en el futuro creas la tabla 'grades' (Calificaciones),
            // deberás validar aquí que ($gradingPeriod->grades()->exists()) antes de tumbarlo.

            $gradingPeriod->delete();
            return $this->successResponse(null, 'Periodo de parcial eliminado del sistema.');
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo eliminar el periodo de evaluación.', 500, $e->getMessage());
        }
    }
}
