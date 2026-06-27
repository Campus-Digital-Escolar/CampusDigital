<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\EventParticipantRequest;
use App\Http\Resources\Sports\EventParticipantResource;
use App\Models\EventParticipant;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    use ApiResponse;

    public function store(EventParticipantRequest $request)
    {
        $participant = EventParticipant::updateOrCreate(
            $request->only(['event_id', 'student_id', 'team_id']),
            $request->validated()
        );
        return $this->successResponse(new EventParticipantResource($participant), 'Participante actualizado en el encuentro');
    }
}
