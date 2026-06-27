<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherPermissionRequest;
use App\Http\Resources\Admin\TeacherPermissionResource;
use App\Models\TeacherPermission;
use App\Traits\ApiResponse;

class TeacherPermissionController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(TeacherPermissionResource::collection(TeacherPermission::all()));
    }

    public function store(TeacherPermissionRequest $request)
    {
        $permission = TeacherPermission::create($request->validated());
        return $this->successResponse(new TeacherPermissionResource($permission), 'Permiso asignado', 201);
    }

    public function update(TeacherPermissionRequest $request, TeacherPermission $teacherPermission)
    {
        $teacherPermission->update($request->validated());
        return $this->successResponse(new TeacherPermissionResource($teacherPermission), 'Permiso actualizado');
    }

    public function destroy(TeacherPermission $teacherPermission)
    {
        $teacherPermission->delete();
        return $this->successResponse(null, 'Permiso revocado');
    }
}
