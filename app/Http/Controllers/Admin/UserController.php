<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use App\Http\Requests\Admin\TeacherPermissionRequest;
use App\Http\Requests\Admin\TeacherRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherPermission;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(UserResource::collection(User::with(['role', 'school'])->get()));
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        return $this->successResponse(new UserResource($user), 'Usuario creado', 201);
    }

    public function show(User $user)
    {
        return $this->successResponse(new UserResource($user->load(['role', 'school', 'teacher', 'student'])));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return $this->successResponse(new UserResource($user), 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponse(null, 'Usuario eliminado');
    }
    public function storeUser(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['password'] = Hash::make($validated['password']);
            $validated['school_id'] = $request->user()->school_id;

            $user = User::create($validated);

            return $this->successResponse(
                $user,
                "Usuario base registrado exitosamente.",
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                "Error al dar de alta el usuario base.",
                500,
                $e->getMessage()
            );
        }
    }

    public function storeStudentProfile(StudentRequest $request)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('photo')) {
                $validated['photo_path'] = $request->file('photo')->store('students/photos', 'public');
            }

            $student = Student::create($validated);

            return $this->successResponse($student, "Perfil académico del estudiante creado con éxito.", 201);
        } catch (\Exception $e) {
            return $this->errorResponse("Error al persistir el perfil del alumno.", 500, $e->getMessage());
        }
    }

    /**
     * Registro de la información operativa de un Profesor (Tabla teachers)
     */
    public function storeTeacherProfile(TeacherRequest $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $validated = $request->validated();

                if ($request->hasFile('photo')) {
                    $path = $request->file('photo')->store('teachers/photos', 'public');
                    $validated['photo'] = $path;
                }

                $teacher = Teacher::create($validated);

                return $this->successResponse(
                    $teacher,
                    "Perfil extendido del docente guardado correctamente.",
                    201
                );
            } catch (Exception $e) {
                return $this->errorResponse(
                    "Error al persistir el perfil del docente.",
                    500,
                    $e->getMessage()
                );
            }
        });
    }

    /**
     * Configuración granular de permisos de módulos para un Docente
     */
    public function updateTeacherPermissions(TeacherPermissionRequest $request)
    {
        try {
            $validated = $request->validated();

            $permission = TeacherPermission::updateOrCreate(
                [
                    'user_id'     => $validated['user_id'],
                    'module_name' => $validated['module_name'],
                ],
                [
                    'is_visible'  => $validated['is_visible'],
                    'can_add'     => $validated['can_add'],
                    'can_edit'    => $validated['can_edit'],
                    'can_delete'  => $validated['can_delete'],
                ]
            );

            return $this->successResponse(
                $permission,
                "Permisos asignados al docente actualizados de forma exitosa."
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                "Error al actualizar la matriz de permisos del docente.",
                500,
                $e->getMessage()
            );
        }
    }
}
