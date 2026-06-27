<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SchoolRequest;
use App\Http\Resources\Admin\SchoolResource;
use App\Models\School;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(SchoolResource::collection(School::all()));
    }

    public function store(SchoolRequest $request)
    {
        $school = School::create($request->validated());
        return $this->successResponse(new SchoolResource($school), 'Escuela registrada', 201);
    }

    public function update(SchoolRequest $request, School $school)
    {
        $school->update($request->validated());
        return $this->successResponse(new SchoolResource($school), 'Datos de la escuela actualizados');
    }
}
