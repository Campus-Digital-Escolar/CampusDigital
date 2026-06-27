<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use App\Http\Resources\Admin\StudentResource;
use App\Models\Student;
use App\Traits\ApiResponse;

class StudentController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(StudentResource::collection(Student::with('user')->get()));
    }

    public function store(StudentRequest $request)
    {
        $student = Student::create($request->validated());
        return $this->successResponse(new StudentResource($student), 'Perfil de alumno creado', 201);
    }

    public function show(Student $student)
    {
        return $this->successResponse(new StudentResource($student->load(['user', 'parents'])));
    }

    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        return $this->successResponse(new StudentResource($student), 'Perfil de alumno actualizado');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return $this->successResponse(null, 'Perfil de alumno eliminado');
    }
}
