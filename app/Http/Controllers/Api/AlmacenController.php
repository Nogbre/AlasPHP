<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Almacene;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    /**
     * GET /api/almacenes
     */
    public function index()
    {
        try {
            $almacenes = Almacene::select('id_almacen', 'nombre', 'direccion', 'latitud', 'longitud')
                ->get();

            return response()->json($almacenes, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener almacenes'], 500);
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        return Almacene::with('estantes')->findOrFail($id);
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
