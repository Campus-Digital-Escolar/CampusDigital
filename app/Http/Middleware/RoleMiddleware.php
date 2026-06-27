<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    use ApiResponse;

    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();
        if (!$user) {
            return $this->errorResponse("No autenticado.", 401);
        }

        if (!in_array($user->role->name, $roles)) {
            return $this->errorResponse(
                "No tienes los permisos necesarios para acceder a este recurso.",
                403
            );
        }

        return $next($request);
    }
}
