<?php

namespace App\Http\Controllers\Comunication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comunication\SchoolCalendarRequest;
use App\Http\Resources\Comunication\SchoolCalendarResource;
use App\Models\SchoolCalendar;
use App\Traits\ApiResponse;

class SchoolCalendarController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(SchoolCalendarResource::collection(SchoolCalendar::all()));
    }

    public function store(SchoolCalendarRequest $request)
    {
        $event = SchoolCalendar::create($request->validated());
        return $this->successResponse(new SchoolCalendarResource($event), 'Evento de calendario agregado', 201);
    }

    public function show(SchoolCalendar $schoolCalendar)
    {
        return $this->successResponse(new SchoolCalendarResource($schoolCalendar));
    }

    public function update(SchoolCalendarRequest $request, SchoolCalendar $schoolCalendar)
    {
        $schoolCalendar->update($request->validated());
        return $this->successResponse(new SchoolCalendarResource($schoolCalendar), 'Evento de calendario modificado');
    }

    public function destroy(SchoolCalendar $schoolCalendar)
    {
        $schoolCalendar->delete();
        return $this->successResponse(null, 'Evento de calendario removido');
    }
}
