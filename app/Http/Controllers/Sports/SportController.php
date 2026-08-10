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
use App\Http\Resources\Sports\SportResource;
use App\Http\Resources\Sports\SportStatDefinitionResource;
use App\Models\MatchStatRecord;
use App\Models\SchoolTeam;
use App\Models\Sport;
use App\Models\SportStatDefinition;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SportController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $sports = Sport::with('schools')->get();
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
            $data = $request->validated();

            if ($request->hasFile('icon_path')) {
                $file = $request->file('icon_path');
                $path = $file->store('sports/icons', 'public');
                $data['icon_path'] = $path;
            }

            $schoolId = $data['school_id'];
            unset($data['school_id']);

            $statDefinitions = json_decode($request->input('statDefinitions', '[]'), true);

            $sport = Sport::create($data);

            $sport->schools()->attach($schoolId, [
                'active' => $request->input('active', 1)
            ]);

            if (!empty($statDefinitions)) {
                foreach ($statDefinitions as $statDef) {
                    $sport->statDefinitions()->create([
                        'name' => $statDef['name'],
                        'code' => $statDef['code'] ?? 'STAT',
                        'description' => $statDef['description'] ?? null,
                        'data_type' => $statDef['data_type'] ?? 'conteo',
                    ]);
                }
            }

            return $this->successResponse(
                new SportResource($sport->load(['schools', 'statDefinitions'])),
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

            $data = $request->validated();

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

    public function teams(int $id)
    {
        try {
            $sport = Sport::findOrFail($id);
            return $this->successResponse($sport->teams, "Equipos obtenidos exitosamente.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al consultar los equipos", 500, $e->getMessage());
        }
    }

    public function indexTeams()
    {
        $teams = SchoolTeam::with(['coachTeacher', 'sport'])->get();
        return $this->successResponse(SchoolTeamResource::collection($teams), "Equipos obtenidos exitosamente.");
    }

    public function storeTeam(SchoolTeamRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('icon_path')) {
            $data['icon_path'] = $request->file('icon_path')->store('teams/icons', 'public');
        }

        $team = SchoolTeam::create($data);

        return $this->successResponse(new SchoolTeamResource($team), "Equipo registrado con éxito.", 201);
    }

    public function matches(int $id)
    {
        try {
            $sport = Sport::findOrFail($id);
            return $this->successResponse($sport->sportEvents, "Partidos obtenidos exitosamente.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al consultar los partidos", 500, $e->getMessage());
        }
    }

    public function storeMatch(SportEventRequest $request, int $id)
    {
        try {
            $sport = Sport::findOrFail($id);

            $validated = $request->validated();
            $validated['sport_id'] = $sport->id;
            $validated['status'] = $validated['status'] ?? 'scheduled';

            $match = $sport->sportEvents()->create($validated);

            return $this->successResponse($match, "Partido agendado exitosamente", 201);
        } catch (Exception $e) {
            return $this->errorResponse("No se pudo agendar el partido", 400, $e->getMessage());
        }
    }

    public function statDefinitions(int $id)
    {
        try {
            $sport = Sport::findOrFail($id);
            return $this->successResponse($sport->statDefinitions, "Definiciones estadísticas obtenidas.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al consultar las definiciones", 500, $e->getMessage());
        }
    }

    public function indexBySport(int $sportId)
    {
        $definitions = SportStatDefinition::where('sport_id', $sportId)->get();
        return $this->successResponse(SportStatDefinitionResource::collection($definitions), "Definiciones estadísticas obtenidas.");
    }

    public function storeStatDefinition(SportStatDefinitionRequest $request)
    {
        $definition = SportStatDefinition::create($request->validated());

        return $this->successResponse(new SportStatDefinitionResource($definition), "Definición estadística creada correctamente.", 201);
    }

    public function standings(int $id)
    {
        try {
            return $this->successResponse([], "Tabla general obtenida exitosamente.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al consultar la tabla general", 500, $e->getMessage());
        }
    }

    public function storeMatchStatRecord(MatchStatRecordRequest $request)
    {
        $record = MatchStatRecord::create($request->validated());

        return $this->successResponse(new MatchStatRecordResource($record), "Métrica del partido registrada exitosamente.", 201);
    }

    public function storeLiveEvent(Request $request, int $id)
    {
        try {
            $sport = Sport::findOrFail($id);

            $validated = $request->validate([
                'match_id' => 'nullable|exists:sport_matches,id',
                'team' => 'required|string|max:100',
                'player' => 'required|string|max:100',
                'type' => 'required|string|in:gol,asistencia,falta,tarjeta amarilla,tarjeta roja',
            ]);

            $liveEvent = $sport->liveEvents()->create($validated);

            return $this->successResponse($liveEvent, "Evento registrado con éxito", 201);
        } catch (Exception $e) {
            return $this->errorResponse("No se pudo registrar el evento en vivo", 400, $e->getMessage());
        }
    }
}
