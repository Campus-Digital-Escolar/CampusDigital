<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\SportTeamRankingRequest;
use App\Http\Resources\Sports\SportTeamRankingResource;
use App\Models\SportTeamRanking;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SportTeamRankingController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(SportTeamRankingResource::collection(SportTeamRanking::with('team')->orderByDesc('points')->get()));
    }

    public function store(SportTeamRankingRequest $request)
    {
        $ranking = SportTeamRanking::updateOrCreate(
            $request->only(['school_id', 'sport_id', 'school_year_id', 'team_id']),
            $request->validated()
        );
        return $this->successResponse(new SportTeamRankingResource($ranking), 'Tabla de posiciones actualizada');
    }
}
