<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campana;
use Illuminate\Http\Request;

class CampanaController extends Controller
{
    /**
     * GET /api/campanas - Lista campañas activas
     */
    public function index()
    {
        try {
            $campanas = Campana::where('fecha_fin', '>=', now())
                ->orderBy('fecha_inicio', 'desc')
                ->get();

            return response()->json($campanas, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener campañas',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $campana = Campana::with(['puntosRecoleccion', 'donaciones'])->findOrFail($id);
            return response()->json($campana, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Campaña no encontrada'], 404);
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
