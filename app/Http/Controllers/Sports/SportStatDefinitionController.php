<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\SportStatDefinitionRequest;
use App\Http\Resources\Sports\SportStatDefinitionResource;
use App\Models\SportStatDefinition;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SportStatDefinitionController extends Controller
{
    use ApiResponse;

    public function index() {
        return $this->successResponse(SportStatDefinitionResource::collection(SportStatDefinition::all()));
    }

    public function store(SportStatDefinitionRequest $request)
    {
        $def = SportStatDefinition::create($request->validated());
        return $this->successResponse(new SportStatDefinitionResource($def), 'Métrica estadística configurada', 201);
    }
}
