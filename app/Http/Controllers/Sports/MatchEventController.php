<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\MatchEventRequest;
use App\Http\Resources\Sports\MatchEventResource;
use App\Models\MatchEvent;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class MatchEventController extends Controller
{
    use ApiResponse;

    public function store(MatchEventRequest $request)
    {
        $matchEvent = MatchEvent::create($request->validated());
        return $this->successResponse(new MatchEventResource($matchEvent), 'Incidencia registrada en vivo', 201);
    }
}
