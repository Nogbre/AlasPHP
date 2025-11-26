<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PuntosRecoleccion;
use Illuminate\Http\Request;

class PuntoRecoleccionController extends Controller
{
    /**
     * GET /api/puntos-de-recoleccion/campana/{id}
     */
    public function getByCampana($idCampana)
    {
        try {
            $puntos = PuntosRecoleccion::where('id_campana', $idCampana)
                ->with('campana')
                ->get();

            return response()->json($puntos, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener puntos de recolección'], 500);
        }
    }

    public function index()
    {
        return PuntosRecoleccion::with('campana')->get();
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
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
