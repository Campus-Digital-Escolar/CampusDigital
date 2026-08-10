<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NotificationRequest;
use App\Http\Resources\Comunication\NotificationResource;
use App\Models\Notification;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $notifications = Notification::where('user_id', $request->user()->id)
                ->latest()
                ->paginate($request->get('per_page', 15));

            return $this->successResponse([
                'notifications' => NotificationResource::collection($notifications),
                'pagination' => [
                    'total'        => $notifications->total(),
                    'per_page'     => $notifications->perPage(),
                    'current_page' => $notifications->currentPage(),
                    'last_page'    => $notifications->lastPage(),
                ],
            ], "Notificaciones recuperadas con éxito");
        } catch (Exception $e) {
            return $this->errorResponse("Error al obtener las notificaciones", 500, $e->getMessage());
        }
    }

    public function unread(Request $request)
    {
        try {
            $unreadNotifications = Notification::where('user_id', $request->user()->id)
                ->unread()
                ->latest()
                ->get();

            return $this->successResponse([
                'unread_count'  => $unreadNotifications->count(),
                'notifications' => NotificationResource::collection($unreadNotifications),
            ], "Notificaciones no leídas recuperadas con éxito");
        } catch (Exception $e) {
            return $this->errorResponse("Error al consultar notificaciones no leídas", 500, $e->getMessage());
        }
    }

    public function show(Request $request, Notification $notification)
    {
        if ($notification->user_id !== $request->user()->id) {
            return $this->errorResponse("No tienes autorización para ver esta notificación", 403);
        }

        return $this->successResponse(
            new NotificationResource($notification),
            "Detalle de la notificación recuperado"
        );
    }

    public function markAsRead(Request $request, Notification $notification)
    {
        if ($notification->user_id !== $request->user()->id) {
            return $this->errorResponse("No tienes autorización para realizar esta acción", 403);
        }

        try {
            if (!$notification->read_at) {
                $notification->update(['read_at' => now()]);
            }

            return $this->successResponse(
                new NotificationResource($notification),
                "Notificación marcada como leída"
            );
        } catch (Exception $e) {
            return $this->errorResponse("Error al actualizar la notificación", 500, $e->getMessage());
        }
    }

    public function markAllAsRead(Request $request)
    {
        try {
            $updated = Notification::where('user_id', $request->user()->id)
                ->unread()
                ->update(['read_at' => now()]);

            return $this->successResponse(
                ['updated_count' => $updated],
                "Todas las notificaciones se marcaron como leídas"
            );
        } catch (Exception $e) {
            return $this->errorResponse("Error al actualizar las notificaciones", 500, $e->getMessage());
        }
    }

    public function destroy(Request $request, Notification $notification)
    {
        if ($notification->user_id !== $request->user()->id) {
            return $this->errorResponse("No tienes autorización para eliminar esta notificación", 403);
        }

        try {
            $notification->delete();

            return $this->successResponse(null, "Notificación eliminada correctamente");
        } catch (Exception $e) {
            return $this->errorResponse("Error al eliminar la notificación", 500, $e->getMessage());
        }
    }
}
