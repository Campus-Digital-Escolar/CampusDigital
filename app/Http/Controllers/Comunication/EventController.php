<?php

namespace App\Http\Controllers\Comunication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comunication\EventRequest;
use App\Http\Resources\Comunication\EventResource;
use App\Models\Event;
use App\Traits\ApiResponse;

class EventController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(EventResource::collection(Event::latest()->get()));
    }

    public function store(EventRequest $request)
    {
        $event = Event::create($request->validated());
        return $this->successResponse(new EventResource($event), 'Evento institucional agendado', 201);
    }

    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->validated());
        return $this->successResponse(new EventResource($event), 'Evento actualizado');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return $this->successResponse(null, 'Evento cancelado y eliminado');
    }
}
