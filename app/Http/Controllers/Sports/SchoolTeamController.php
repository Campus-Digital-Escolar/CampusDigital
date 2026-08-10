<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\SchoolTeamRequest;
use App\Http\Resources\Sports\SchoolTeamResource;
use App\Models\SchoolTeam;
use App\Traits\ApiResponse;

class SchoolTeamController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $teams = SchoolTeam::with(['coach', 'sport'])->get();
        return $this->successResponse(SchoolTeamResource::collection($teams), "Equipos obtenidos exitosamente.");
    }

    public function store(SchoolTeamRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('icon_path')) {
            $data['icon_path'] = $request->file('icon_path')->store('teams/icons', 'public');
        }

        $team = SchoolTeam::create($data);

        return $this->successResponse(new SchoolTeamResource($team), "Equipo registrado con éxito.", 201);
    }
}
