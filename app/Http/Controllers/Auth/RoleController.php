<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RoleResource;
use App\Models\Role;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(RoleResource::collection(Role::all()));
    }

    public function show(Role $role)
    {
        return $this->successResponse(new RoleResource($role));
    }
}
