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
        return $this->successResponse(SchoolTeamResource::collection(SchoolTeam::with(['sport', 'coach.user'])->get()));
    }

    public function store(SchoolTeamRequest $request)
    {
        $team = SchoolTeam::create($request->validated());
        return $this->successResponse(new SchoolTeamResource($team), 'Equipo escolar registrado', 201);
    }
}
