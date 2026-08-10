<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Communication\SchoolCalendarRequest;
use App\Http\Resources\Communication\SchoolCalendarResource;
use App\Models\SchoolCalendar;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Storage;

class SchoolCalendarController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(SchoolCalendarResource::collection(SchoolCalendar::all()));
    }

    public function store(SchoolCalendarRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('icon_marker')) {
            $data['icon_marker'] = $request->file('icon_marker')->store('calendar-icons', 'public');
        }

        $event = SchoolCalendar::create($data);

        return $this->successResponse(new SchoolCalendarResource($event), 'Evento de calendario agregado', 201);
    }

    public function show(SchoolCalendar $schoolCalendar)
    {
        return $this->successResponse(new SchoolCalendarResource($schoolCalendar));
    }

    public function update(SchoolCalendarRequest $request, SchoolCalendar $schoolCalendar)
    {
        $data = $request->validated();

        if ($request->hasFile('icon_marker')) {
            if ($schoolCalendar->icon_marker && Storage::disk('public')->exists($schoolCalendar->icon_marker)) {
                Storage::disk('public')->delete($schoolCalendar->icon_marker);
            }

            // Guardar nueva imagen
            $data['icon_marker'] = $request->file('icon_marker')->store('calendar-icons', 'public');
        } else {
            unset($data['icon_marker']);
        }

        $schoolCalendar->update($data);

        return $this->successResponse(new SchoolCalendarResource($schoolCalendar), 'Evento de calendario modificado');
    }

    public function destroy(SchoolCalendar $schoolCalendar)
    {
        if ($schoolCalendar->icon_marker && Storage::disk('public')->exists($schoolCalendar->icon_marker)) {
            Storage::disk('public')->delete($schoolCalendar->icon_marker);
        }

        $schoolCalendar->delete();
        return $this->successResponse(null, 'Evento de calendario removido');
    }
}
