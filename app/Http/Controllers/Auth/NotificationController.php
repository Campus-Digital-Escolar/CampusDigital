<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NotificationRequest;
use App\Http\Resources\Comunication\NotificationResource;
use App\Models\Notification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        // Filtra dinámicamente las notificaciones por el usuario autenticado
        $notifications = Notification::where('user_id', $request->user()->id)->latest()->get();
        return $this->successResponse(NotificationResource::collection($notifications));
    }

    public function store(NotificationRequest $request)
    {
        $notification = Notification::create($request->validated());
        return $this->successResponse(new NotificationResource($notification), 'Notificación enviada', 201);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['read_at' => now()]);
        return $this->successResponse(new NotificationResource($notification), 'Notificación marcada como leída');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return $this->successResponse(null, 'Notificación eliminada');
    }
}
