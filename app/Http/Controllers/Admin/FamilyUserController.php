<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FamilyUserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;

class FamilyUserController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $parents = User::where('role_id', 4)
                ->orderBy('lastname', 'asc')
                ->with([
                    'students' => function($query) {
                        $query->orderBy('lastname', 'asc');
                    },
                    'students.groups' => function($query) {
                        $query->wherePivot('active', true)
                              ->orderBy('section', 'ASC');
                    },
                    'students.groups.groupGrade' => function($query) {
                        $query->orderBy('name', 'ASC');
                    },
                    'students.groups.groupGrade.educationalLevel' => function ($query) {
                        $query->orderBy('name', 'asc');
                    },
                ])
                ->get();

            return $this->successResponse(
                FamilyUserResource::collection($parents),
                "Cuentas de padres de familia y expedientes obtenidos con éxito."
            );
        } catch (Exception $e) {
            return $this->errorResponse("Error al obtener las cuentas familiares", 500, $e->getMessage());
        }
    }
}
