<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\MatchStatRecordRequest;
use App\Http\Requests\Sports\SchoolTeamRequest;
use App\Http\Requests\Sports\SportEventRequest;
use App\Http\Requests\Sports\SportRequest;
use App\Http\Requests\Sports\SportStatDefinitionRequest;
use App\Http\Resources\Sports\MatchStatRecordResource;
use App\Http\Resources\Sports\SchoolTeamResource;
use App\Http\Resources\Sports\SportEventResource;
use App\Http\Resources\Sports\SportResource;
use App\Http\Resources\Sports\SportStatDefinitionResource;
use App\Models\MatchStatRecord;
use App\Models\SchoolTeam;
use App\Models\Sport;
use App\Models\SportEvent;
use App\Models\SportStatDefinition;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SportController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $sports = Sport::with('schools')->withCount(['teams', 'sportEvents'])->get();
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
        return DB::transaction(function () use ($request) {
            try {
                $validated = $request->validated();

                $iconPath = null;
                if ($request->hasFile('icon_path')) {
                    $iconPath = $request->file('icon_path')->store('sports/icons', 'public');
                }

                $statDefinitions = $validated['stat_definitions'] ?? [];
                $schoolId = $validated['school_id'];
                unset($validated['stat_definitions'], $validated['school_id']);

                if ($iconPath) {
                    $validated['icon_path'] = $iconPath;
                }

                $sport = Sport::create($validated);

                $sport->schools()->attach($schoolId, [
                    'active' => $request->input('active', 1)
                ]);

                foreach ($statDefinitions as $statDef) {
                    $sport->statDefinitions()->create([
                        'name'        => $statDef['name'],
                        'code'        => $statDef['code'],
                        'description' => $statDef['description'] ?? null,
                        'data_type'   => $statDef['data_type'] ?? 'conteo',
                    ]);
                }

                return $this->successResponse(
                    new SportResource($sport->load(['schools', 'statDefinitions'])),
                    "Deporte creado exitosamente",
                    201
                );
            } catch (Exception $e) {
                return $this->errorResponse("No se pudo registrar el deporte", 400, $e->getMessage());
            }
        });
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

            $data = $request->validated();
            unset($data['stat_definitions'], $data['school_id']);

            if ($request->hasFile('icon_path')) {
                if ($sport->icon_path && Storage::disk('public')->exists($sport->icon_path)) {
                    Storage::disk('public')->delete($sport->icon_path);
                }
                $file = $request->file('icon_path');
                $data['icon_path'] = $file->store('sports/icons', 'public');
            }

            $sport->update($data);

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

            if ($sport->icon_path && Storage::disk('public')->exists($sport->icon_path)) {
                Storage::disk('public')->delete($sport->icon_path);
            }

            $sport->delete();
            return $this->successResponse(null, "Deporte eliminado permanentemente.");
        } catch (Exception $e) {
            return $this->errorResponse("No se pudo eliminar el deporte", 500, $e->getMessage());
        }
    }
}
