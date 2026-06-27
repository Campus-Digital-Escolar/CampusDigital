<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\EventParticipantRequest;
use App\Http\Requests\Sports\SportEventRequest;
use App\Http\Resources\Sports\SportEventResource;
use App\Models\EventParticipant;
use App\Models\SportEvent;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class SportEventController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $events = SportEvent::with(['sport', 'stage', 'participants.team', 'participants.student.user'])->get();
        return $this->successResponse(SportEventResource::collection($events));
    }

    public function store(SportEventRequest $request)
    {
        $event = SportEvent::create($request->validated());
        return $this->successResponse(new SportEventResource($event), 'Encuentro deportivo agendado', 201);
    }
}
