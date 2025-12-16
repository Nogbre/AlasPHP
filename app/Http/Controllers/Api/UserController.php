<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * GET /api/users/{userId}
     */
    public function show($id)
    {
        try {
            $usuario = Usuario::select('id_usuario', 'nombres', 'apellidos', 'ci', 'telefono', 'email', 'rol')
                ->findOrFail($id);

            return response()->json($usuario, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }

    public function index()
    {
        return Usuario::select('id_usuario', 'nombres', 'apellidos', 'ci', 'email', 'rol')->paginate(20);
    }

    /**
     * GET /api/users/ci
     * Retorna lista de todos los CIs de usuarios
     */
    public function getCIList()
    {
        try {
            $cis = Usuario::whereNotNull('ci')
                ->pluck('ci')
                ->toArray();

            return response()->json([
                'lista_ci' => $cis,
                'total' => count($cis)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener lista de CIs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
