<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Donante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DonanteAuthController extends Controller
{
    /**
     * Registro de nuevo donante
     * 
     * POST /api/donante-auth/register
     * Body: { "nombre": "string", "email": "string", "telefono": "string", "contrasena_hash": "string", "direccion": "string", "tipo": "persona|empresa" }
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:donantes,email',
                'telefono' => 'required|string|max:20',
                'contrasena_hash' => 'required|string|min:6',
                'direccion' => 'nullable|string',
                'tipo' => 'required|in:persona,empresa',
            ], [
                'email.unique' => 'El correo electrónico ya está registrado.',
                'tipo.in' => 'El tipo debe ser "persona" o "empresa".',
            ]);

            // Crear el donante
            $donante = Donante::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'tipo' => $request->tipo,
                'password' => Hash::make($request->contrasena_hash),
                'fecha_registro' => now(),
                'cambiar_password' => false,
            ]);

            // Generar token
            $token = $donante->createToken('donante-app')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Donante registrado exitosamente',
                'token' => $token,
                'donante' => [
                    'id' => $donante->id_donante,
                    'nombre' => $donante->nombre,
                    'email' => $donante->email,
                    'telefono' => $donante->telefono,
                    'tipo' => $donante->tipo,
                    'cambiar_password' => $donante->cambiar_password,
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el donante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Login de donante
     * 
     * Endpoint esperado por app móvil: POST /api/donante-auth/login
     * Body: { "usuario": "string", "contrasena_hash": "string" }
     * Response: { "token": "string", "donante": { "id": int, "nombres": "string" } }
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'usuario' => 'required|string',
                'contrasena_hash' => 'required|string',
            ]);

            // Buscar donante por email
            $donante = Donante::where('email', $request->usuario)->first();

            if (!$donante) {
                return response()->json([
                    'success' => false,
                    'message' => 'Las credenciales proporcionadas son incorrectas.',
                    'errors' => [
                        'usuario' => ['Usuario no encontrado']
                    ]
                ], 401);
            }

            // Verificar contraseña
            if (!Hash::check($request->contrasena_hash, $donante->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Las credenciales proporcionadas son incorrectas.',
                    'errors' => [
                        'contrasena_hash' => ['Contraseña incorrecta']
                    ]
                ], 401);
            }

            // Generar token
            $token = $donante->createToken('donante-app')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'donante' => [
                    'id' => $donante->id_donante,
                    'nombres' => $donante->nombre,
                    'cambiar_password' => $donante->cambiar_password,
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Cambiar contraseña
     */
    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'nueva_password' => 'required|string|min:6',
            ]);

            $donante = $request->user();
            
            $donante->update([
                'password' => Hash::make($request->nueva_password),
                'cambiar_password' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada exitosamente',
                'cambiar_password' => false,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
