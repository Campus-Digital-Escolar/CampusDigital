<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\StudentDiplomaRequest;
use App\Http\Resources\Academic\StudentDiplomaResource;
use App\Models\StudentDiploma;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class StudentDiplomaController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(StudentDiplomaResource::collection(StudentDiploma::with('student.user')->get()));
    }

    public function store(StudentDiplomaRequest $request)
    {
        $diploma = StudentDiploma::create($request->validated());
        return $this->successResponse(new StudentDiplomaResource($diploma), 'Diploma registrado exitosamente', 201);
    }
}
