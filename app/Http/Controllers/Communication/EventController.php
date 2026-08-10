<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Communication\EventRequest;
use App\Http\Resources\Communication\EventResource;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\SchoolCalendar;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Event::with(['gallery.items', 'creator', 'educationalLevel', 'group']);

        if ($user->school_id) {
            $query->where('school_id', $user->school_id);
        } elseif ($request->has('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        $events = $query->latest('event_date')->get();

        return $this->successResponse(
            EventResource::collection($events),
            'Eventos recuperados exitosamente.'
        );
    }

    public function store(EventRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();

        $event = DB::transaction(function () use ($validated, $user, $request) {
            $gallery = Gallery::create([
                'school_id' => $validated['school_id'],
                'title' => $validated['title'],
                'description' => 'Álbum oficial del evento: ' . $validated['title'],
            ]);

            $event = Event::create([
                'school_id' => $validated['school_id'],
                'created_by' => $user->id,
                'gallery_id' => $gallery->id,
                'educational_level_id' => $validated['educational_level_id'],
                'group_id' => $validated['group_id'] ?? null,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location_type' => $validated['location_type'],
                'event_date' => $validated['event_date'],
                'status' => 'scheduled',
                'reminder_days_before' => $validated['reminder_days_before'] ?? 1,
            ]);

            if (!empty($validated['sync_to_calendar'])) {
                $iconPath = null;

                if ($request->hasFile('calendar_icon')) {
                    $iconPath = $request->file('calendar_icon')->store('calendar-icons', 'public');
                }

                SchoolCalendar::create([
                    'school_id'   => $validated['school_id'],
                    'title'       => $validated['title'],
                    'description' => $validated['description'],
                    'start_date'  => $validated['event_date'],
                    'end_date'    => $validated['calendar_end_date'],
                    'type'        => $validated['calendar_type'],
                    'icon_marker' => $iconPath, // Guarda la ruta accesible
                ]);
            }

            // 3. Notificar a tutores si la opción es "Todos los grupos"
            /*if (empty($validated['group_id'])) {
                $parents = User::whereHas('students', function ($q) use ($validated) {
                    $q->where('educational_level_id', $validated['educational_level_id']);
                })->get();

                foreach ($parents as $parent) {
                    $parent->notify(new EventNotification($event));
                }
            }*/

            return $event;
        });

        return $this->successResponse(
            new EventResource($event->load(['gallery.items', 'creator'])),
            'Evento registrado correctamente.',
            201
        );
    }

    public function show(Event $event)
    {
        return $this->successResponse(
            new EventResource($event->load(['gallery.items', 'creator'])),
            'Detalles del evento.'
        );
    }

    public function update(EventRequest $request, Event $event)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated, $event) {
            $event->update($validated);

            if (!$event->gallery_id) {
                $gallery = Gallery::create([
                    'school_id' => $event->school_id,
                    'title' => $event->title,
                    'description' => 'Álbum oficial del evento: ' . $event->title,
                ]);
                $event->gallery_id = $gallery->id;
                $event->save();
            } else {
                $gallery = $event->gallery;
            }

            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $mime = $file->getMimeType();
                    $type = str_contains($mime, 'video') ? 'video' : 'image';
                    $path = $file->store("galleries/{$gallery->id}", 'public');

                    GalleryItem::create([
                        'gallery_id' => $gallery->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'type' => $type,
                    ]);
                }
            }
        });

        return $this->successResponse(
            new EventResource($event->fresh(['gallery.items', 'creator'])),
            'Evento actualizado exitosamente.'
        );
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return $this->successResponse(null, 'Evento eliminado correctamente.');
    }
}
