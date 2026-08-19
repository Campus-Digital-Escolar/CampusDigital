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
use Illuminate\Support\Facades\DB;

class SportEventController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $events = SportEvent::with(['participants.student', 'participants.team'])
            ->when($request->sport_id, function ($query, $sportId) {
                $query->ofSport($sportId);
            })
            ->latest()
            ->paginate(15);

        return SportEventResource::collection($events);
    }

    public function store(SportEventRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $event = SportEvent::create($request->validated());

            foreach ($request->participants as $participant) {
                $event->participants()->create($participant);
            }

            return new SportEventResource($event->load('participants'));
        });
    }

    public function show(SportEvent $event)
    {
        return new SportEventResource($event->load('participants'));
    }

    public function update(SportEventRequest $request, SportEvent $event)
    {
        return DB::transaction(function () use ($request, $event) {
            $event->update($request->validated());

            if ($request->has('participants')) {
                $event->participants()->delete();

                foreach ($request->participants as $participant) {
                    $event->participants()->create($participant);
                }
            }

            return new SportEventResource($event->load(['participants.student', 'participants.team']));
        });
    }
}
