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
     * Login de donante
     * 
     * Endpoint esperado por app móvil: POST /api/donante-auth/login
     * Body: { "usuario": "string", "contraseña_hash": "string" }
     * Response: { "token": "string", "donante": { "id": int, "nombres": "string" } }
     */
    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'contraseña_hash' => 'required|string',
        ]);

        // Buscar donante por email
        $donante = Donante::where('email', $request->usuario)->first();

        if (!$donante) {
            throw ValidationException::withMessages([
                'usuario' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        // Verificar contraseña
        if (!Hash::check($request->contraseña_hash, $donante->password)) {
            throw ValidationException::withMessages([
                'usuario' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        // Generar token
        $token = $donante->createToken('donante-app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'donante' => [
                'id' => $donante->id_donante,
                'nombres' => $donante->nombre,
            ]
        ], 200);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
