<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donante;
use Illuminate\Http\JsonResponse;

class DonanteController extends Controller
{
    /**
     * Get all donantes
     */
    public function index(): JsonResponse
    {
        try {
            $donantes = Donante::select(
                'id_donante',
                'nombre',
                'tipo',
                'email',
                'telefono',
                'direccion'
            )
            ->orderBy('nombre', 'asc')
            ->get();

            return response()->json([
                'success' => true,
                'data' => $donantes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener donantes',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
