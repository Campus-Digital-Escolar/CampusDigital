<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\HonorRollOverrideRequest;
use App\Http\Resources\Academic\HonorRollOverrideResource;
use App\Models\HonorRollOverride;
use App\Models\Student;
use App\Traits\ApiResponse;

class HonorRollOverrideController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(HonorRollOverrideResource::collection(HonorRollOverride::with('student.user')->get()));
    }

    public function store(HonorRollOverrideRequest $request)
    {
        $override = HonorRollOverride::create($request->validated());
        return $this->successResponse(new HonorRollOverrideResource($override), 'Excepción de cuadro de honor guardada', 201);
    }
}
