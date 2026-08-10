<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherPermissionRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\Teacher;
use App\Models\TeacherPermission;
use App\Models\User;
use App\Models\UserFcmToken;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $users = User::with(['role', 'school', 'permissions', 'teacher'])
                ->where('id', '!=', 1)
                ->get();
            return $this->successResponse(UserResource::collection($users), "Listado de usuarios obtenido con éxito.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al obtener el listado de usuarios", 500, $e->getMessage());
        }
    }

    /**
     * Obtener listado de personal interno (Administradores y Docentes)
     */
    public function getStaffUsers(Request $request)
    {
        try {
            $authUser = auth()->user();

            if (!$authUser) {
                return $this->errorResponse("Usuario no autenticado.", 401);
            }

            $schoolId = $request->input('school_id') ?? $authUser->school_id;

            $users = User::with(['role', 'school', 'permissions', 'teacher'])
                ->where('id', '!=', 1)
                ->whereHas('role', function ($query) {
                    $query->whereIn('slug', ['admin', 'teacher'])
                        ->orWhereIn('name', ['Administrador', 'Docente']);
                })
                ->when($schoolId, function ($query, $schoolId) {
                    return $query->where('school_id', $schoolId);
                })
                ->get();

            return $this->successResponse(
                UserResource::collection($users),
                "Listado de personal obtenido con éxito."
            );
        } catch (Exception $e) {
            return $this->errorResponse("Error al obtener la lista de personal", 500, $e->getMessage());
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = DB::transaction(function () use ($request, $validated) {
                $signaturePath = null;
                if ($request->hasFile('signature_path')) {
                    $signaturePath = $request->file('signature_path')->store('signatures', 'public');
                }

                $user = User::create([
                    'role_id'   => $validated['role_id'],
                    'school_id' => $validated['school_id'],
                    'name'      => $validated['name'],
                    'lastname'  => $validated['lastname'],
                    'username'  => $validated['username'],
                    'email'     => $validated['email'],
                    'active'    => $validated['active'] ?? true,
                    'password'  => Hash::make($validated['password']),
                    'signature_path'    => $signaturePath,
                    'signature_enabled' => $validated['signature_enabled'] ?? false,
                ]);

                if (!empty($validated['teacher_id'])) {
                    $teacher = Teacher::findOrFail($validated['teacher_id']);
                    $teacher->update(['user_id' => $user->id]);
                }

                if (!empty($validated['permissions'])) {
                    foreach ($validated['permissions'] as $moduleName => $perms) {
                        $user->permissions()->create([
                            'module_name' => $moduleName,
                            'is_visible'  => $perms['is_visible'],
                            'can_add'     => $perms['can_add'],
                            'can_edit'    => $perms['can_edit'],
                            'can_delete'  => $perms['can_delete'],
                        ]);
                    }
                }

                return $user;
            });

            return $this->successResponse(
                new UserResource($user),
                'Usuario registrado con éxito.',
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse("Hubo un fallo al procesar el registro del usuario.", 500, $e->getMessage());
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();

            DB::transaction(function () use ($request, $validated, $user) {
                if ($request->hasFile('signature_path')) {
                    if ($user->signature_path && Storage::disk('public')->exists($user->signature_path)) {
                        Storage::disk('public')->delete($user->signature_path);
                    }
                    $user->signature_path = $request->file('signature_path')->store('signatures', 'public');
                }

                $user->fill([
                    'role_id'   => $validated['role_id'],
                    'school_id' => $validated['school_id'],
                    'name'      => $validated['name'],
                    'lastname'  => $validated['lastname'],
                    'username'  => $validated['username'],
                    'email'     => $validated['email'],
                    'active'    => $validated['active'] ?? $user->active,
                    'signature_enabled' => $validated['signature_enabled'] ?? $user->signature_enabled,
                ]);

                // Actualizar contraseña sólo si fue escrita en el formulario
                if (!empty($validated['password'])) {
                    $user->password = Hash::make($validated['password']);
                }
                $user->save();

                // Sincronizar matriz de permisos (updateOrCreate evita duplicar registros)
                if (isset($validated['permissions'])) {
                    foreach ($validated['permissions'] as $moduleName => $perms) {
                        $user->permissions()->updateOrCreate(
                            ['module_name' => $moduleName],
                            [
                                'is_visible'  => $perms['is_visible'],
                                'can_add'     => $perms['can_add'],
                                'can_edit'    => $perms['can_edit'],
                                'can_delete'  => $perms['can_delete'],
                            ]
                        );
                    }
                }
            });

            return $this->successResponse(
                new UserResource($user->load(['role', 'school', 'permissions', 'teacher'])),
                'Configuración de usuario actualizada correctamente.'
            );
        } catch (Exception $e) {
            return $this->errorResponse("Error al actualizar la configuración del usuario.", 500, $e->getMessage());
        }
    }

    public function show(User $user)
    {
        try {
            return $this->successResponse(
                new UserResource($user->load(['role', 'school', 'teacher', 'student', 'permissions'])),
                "Detalles del usuario obtenidos con éxito."
            );
        } catch (Exception $e) {
            return $this->errorResponse("Error al consultar el expediente del usuario.", 500, $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return $this->successResponse(null, 'Usuario eliminado correctamente.');
        } catch (Exception $e) {
            return $this->errorResponse("No se pudo eliminar el usuario de la plataforma.", 500, $e->getMessage());
        }
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
        } catch (Exception $e) {
            return $this->errorResponse(
                "Error al actualizar la matriz de permisos del docente.",
                500,
                $e->getMessage()
            );
        }
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token'   => 'required|string',
            'device_type' => 'nullable|string',
            'device_name' => 'nullable|string',
        ]);

        $user = $request->user();

        UserFcmToken::updateOrCreate(
            [
                'user_id' => $user->id,
                'fcm_token' => $request->fcm_token, // O puedes buscar por device_type si prefieres un token único por dispositivo
            ],
            [
                'device_type' => $request->device_type ?? 'web',
                'device_name' => $request->device_name,
                'last_used_at' => now(),
            ]
        );

        return response()->json([
            'ok' => true,
            'message' => 'Token FCM guardado correctamente.'
        ]);
    }
}
