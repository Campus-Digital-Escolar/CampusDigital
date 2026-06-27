<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\GroupRequest;
use App\Http\Resources\Academic\GroupResource;
use App\Models\Group;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(GroupResource::collection(Group::with(['tutor.user'])->get()));
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
