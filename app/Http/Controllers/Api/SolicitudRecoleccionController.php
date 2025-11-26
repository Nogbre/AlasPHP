<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SolicitudesRecoleccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SolicitudRecoleccionController extends Controller
{
    /**
     * POST /api/solicitudesRecoleccion
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ubicacion' => 'nullable|string|max:500',
            'detalle_solicitud' => 'nullable|string',
            'id_donante' => 'required|exists:donantes,id_donante',
            'id_campana' => 'nullable|exists:campanas,id_campana',
        ]);

        try {
            $solicitud = SolicitudesRecoleccion::create([
                'direccion_recoleccion' => $validated['ubicacion'] ?? null,
                'observaciones' => $validated['detalle_solicitud'] ?? null,
                'id_donante' => $validated['id_donante'],
                'id_campana' => $validated['id_campana'] ?? null,
                'estado' => 'pendiente',
            ]);

            return response()->json([
                'id' => $solicitud->id_solicitud,
                'message' => 'Solicitud creada exitosamente'
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creando solicitud: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al crear solicitud',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        return SolicitudesRecoleccion::with(['donante', 'campana'])->paginate(20);
    }

    public function show(string $id)
    {
        return SolicitudesRecoleccion::with(['donante', 'imagenes'])->findOrFail($id);
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
