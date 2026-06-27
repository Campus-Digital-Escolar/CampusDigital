<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    use ApiResponse;

    // Login — devuelve token + usuario con rol
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $user = User::where($fieldType, $request->login)->with('role')->first();

            if (!$user) {
                return $this->errorResponse("Las credenciales introducidas no son correctas.", 401);
            }

            if (!$user->active) {
                return $this->errorResponse("Esta cuenta se encuentra inactiva. Contacte al administrador.", 403);
            }

            if (!$user->role || $user->role->name !== $request->role) {
                return $this->errorResponse("El usuario no cuenta con el rol seleccionado para ingresar.", 403);
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                return $this->errorResponse("Las credenciales introducidas no son correctas.", 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            $data = [
                'user' => [
                    'id'       => $user->id,
                    'name'     => $user->name,
                    'lastname' => $user->lastname,
                    'username' => $user->username,
                    'email'    => $user->email,
                    'role'     => [
                        'id'    => $user->role->id,
                        'name' =>$user->role->name,
                    ]
                ],
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ];

            return $this->successResponse($data, "Inicio de sesión correcto. ¡Bienvenido!");

        } catch (ValidationException $e) {
            return $this->errorResponse("Error de validación", 422, $e->errors());
        } catch (Exception $e) {
            return $this->errorResponse("Hubo un problema en el servidor", 500, $e->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create([
                'name'      => $data['name'],
                'lastname'  => $data['lastname'],
                'username'  => $data['username'],
                'email'     => $data['email'],
                'password'  => Hash::make($data['password']),
                'role_id'   => $request->user()?->role_id ?? ($data['role_id'] ?? null),
                'school_id'  => $data['school_id'],
                'active'     => $data['active'] ?? true,
            ]);

            return $this->successResponse(
                new UserResource($user),
                'Usuario registrado exitosamente en el sistema.',
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse(
                'No se pudo registrar el usuario base.',
                500,
                $e->getMessage()
            );
        }
    }

    // Logout — elimina el token actual
    public function logout(Request $request)
    {
        try {
            // Revoca el token con el que el usuario está autenticado actualmente
            $request->user()->currentAccessToken()->delete();

            return $this->successResponse(null, "Sesión cerrada correctamente.");
        } catch (Exception $e) {
            return $this->errorResponse("No se pudo cerrar la sesión", 500, $e->getMessage());
        }
    }

    // Me — devuelve el usuario autenticado con su rol
    public function me(Request $request)
    {
        $user = $request->user()->load('role');

        return $this->successResponse(new UserResource($user), 'Usuario autenticado', 200);
    }
}
