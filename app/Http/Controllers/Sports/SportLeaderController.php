<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\SportLeaderRequest;
use App\Http\Resources\Sports\SportLeaderResource;
use App\Models\SportLeader;
use App\Traits\ApiResponse;

class SportLeaderController extends Controller
{
    use ApiResponse;

    public function index() {
        return $this->successResponse(SportLeaderResource::collection(SportLeader::with(['student.user', 'sport'])->get()));
    }

    public function store(SportLeaderRequest $request)
    {
        $leader = SportLeader::updateOrCreate(
            $request->only(['sport_id', 'student_id', 'statistic_type']),
            ['statistic_value' => $request->input('statistic_value')]
        );
        return $this->successResponse(new SportLeaderResource($leader), 'Líder de tabla individual actualizado');
    }
}
