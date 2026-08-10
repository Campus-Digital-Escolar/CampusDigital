<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\GroupRequest;
use App\Http\Resources\Academic\GroupResource;
use App\Models\Group;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $groups = Group::with(['groupGrade.educationalLevel', 'schoolYear'])
                ->get();
            $formattedGroups = GroupResource::collection($groups);

            return $this->successResponse($formattedGroups, "Catálogo de grupos obtenido con éxito.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al consultar los grupos", 500, $e->getMessage());
        }
    }

    public function store(GroupRequest $request)
    {
        $group = Group::create($request->validated());
        return $this->successResponse(new GroupResource($group), 'Grupo académico creado', 201);
    }

    public function show(Group $group)
    {
        return $this->successResponse(new GroupResource($group->load(['tutor.user', 'students.user'])));
    }
}
