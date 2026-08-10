<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\AuditResource;
use App\Models\Audit;
use App\Traits\ApiResponse;

class AuditController extends Controller
{
    use ApiResponse;

    public function index()
    {
        // Solo lectura de bitácora para administradores
        $audits = Audit::with(['user', 'school'])->latest()->paginate(50);
        return $this->successResponse(AuditResource::collection($audits));
    }

    public function show(Audit $audit)
    {
        return $this->successResponse(new AuditResource($audit->load('user')));
    }
}
