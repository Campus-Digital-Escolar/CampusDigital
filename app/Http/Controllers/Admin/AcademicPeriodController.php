<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AcademicPeriodRequest;
use App\Http\Resources\Admin\AcademicPeriodResource;
use App\Models\AcademicPeriod;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class AcademicPeriodController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $periods = AcademicPeriod::with('schoolYear')->orderByDesc('start_date')->get();
            return $this->successResponse(
                AcademicPeriodResource::collection($periods),
                'Periodos académicos obtenidos exitosamente.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Error al consultar los periodos académicos.', 500, $e->getMessage());
        }
    }

    public function store(AcademicPeriodRequest $request)
    {
        try {
            $data = $request->validated();

            $period = AcademicPeriod::create([
                'school_year_id' => $data['school_year_id'],
                'name'           => $data['name'],
                'start_date'     => $data['start_date'],
                'end_date'       => $data['end_date'],
            ]);

            return $this->successResponse(
                new AcademicPeriodResource($period),
                'Periodo académico registrado exitosamente.',
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo registrar el periodo académico.', 500, $e->getMessage());
        }
    }

    public function show(AcademicPeriod $academicPeriod)
    {
        try {
            return $this->successResponse(
                new AcademicPeriodResource($academicPeriod->load(['schoolYear', 'gradingPeriods'])),
                'Periodo académico encontrado.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Error al buscar el periodo académico.', 500, $e->getMessage());
        }
    }

    public function update(AcademicPeriodRequest $request, AcademicPeriod $academicPeriod)
    {
        try {
            $data = $request->validated();

            $academicPeriod->update([
                'school_year_id' => $data['school_year_id'],
                'name'           => $data['name'],
                'start_date'     => $data['start_date'],
                'end_date'       => $data['end_date'],
            ]);

            return $this->successResponse(
                new AcademicPeriodResource($academicPeriod),
                'Periodo académico actualizado correctamente.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo actualizar el periodo académico.', 500, $e->getMessage());
        }
    }

    public function destroy(AcademicPeriod $academicPeriod)
    {
        try {
            if ($academicPeriod->gradingPeriods()->exists()) {
                return $this->errorResponse('No se puede eliminar porque contiene parciales de evaluación configurados.', 422);
            }

            $academicPeriod->delete();
            return $this->successResponse(null, 'Periodo académico eliminado correctamente.');
        } catch (Exception $e) {
            return $this->errorResponse('No se pudo eliminar el periodo académico.', 500, $e->getMessage());
        }
    }
}
