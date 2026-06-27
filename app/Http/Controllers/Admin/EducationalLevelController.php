<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EducationalLevelRequest;
use App\Http\Resources\Admin\EducationalLevelResource;
use App\Models\EducationalLevel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EducationalLevelController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(EducationalLevelResource::collection(EducationalLevel::all()));
    }

    public function store(EducationalLevelRequest $request)
    {
        $level = EducationalLevel::create($request->validated());
        return $this->successResponse(new EducationalLevelResource($level), 'Nivel educativo creado', 201);
    }

    public function update(EducationalLevelRequest $request, EducationalLevel $educationalLevel)
    {
        $educationalLevel->update($request->validated());
        return $this->successResponse(new EducationalLevelResource($educationalLevel), 'Nivel educativo actualizado');
    }

    public function destroy(EducationalLevel $educationalLevel)
    {
        $educationalLevel->delete();
        return $this->successResponse(null, 'Nivel educativo eliminado');
    }
}
