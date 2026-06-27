<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\BulkStoreGradesRequest;
use App\Http\Requests\Academic\GradeRequest;
use App\Http\Resources\Academic\GradeResource;
use App\Models\Grade;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(GradeResource::collection(Grade::with(['student.user', 'subject'])->get()));
    }

    public function store(GradeRequest $request)
    {
        $grade = Grade::updateOrCreate(
            $request->only(['school_id', 'student_id', 'subject_id', 'academic_period_id', 'school_year_id']),
            ['score' => $request->input('score')]
        );
        return $this->successResponse(new GradeResource($grade), 'Calificación asentada', 201);
    }
}
