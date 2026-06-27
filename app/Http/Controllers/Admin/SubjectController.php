<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\SubjectRequest;
use App\Http\Resources\Admin\SubjectResource;
use App\Models\Subject;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(SubjectResource::collection(Subject::with('educationalLevel')->get()));
    }

    public function store(SubjectRequest $request)
    {
        $subject = Subject::create($request->validated());
        return $this->successResponse(new SubjectResource($subject), 'Materia creada', 201);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return $this->successResponse(null, 'Materia eliminada');
    }
}
