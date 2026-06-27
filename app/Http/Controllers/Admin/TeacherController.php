<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherRequest;
use App\Http\Resources\Admin\TeacherResource;
use App\Models\Teacher;
use App\Traits\ApiResponse;

class TeacherController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(TeacherResource::collection(Teacher::with('user')->get()));
    }

    public function store(TeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());
        return $this->successResponse(new TeacherResource($teacher), 'Perfil de profesor creado', 201);
    }

    public function show(Teacher $teacher)
    {
        return $this->successResponse(new TeacherResource($teacher->load('user')));
    }

    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());
        return $this->successResponse(new TeacherResource($teacher), 'Perfil de profesor actualizado');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return $this->successResponse(null, 'Perfil de profesor eliminado');
    }
}
