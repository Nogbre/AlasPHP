<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donacione;
use App\Models\DonacionesDinero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DonacionController extends Controller
{
    /**
     * POST /api/donaciones
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_donacion' => 'required|in:dinero,especie,ropa',
            'fecha_donacion' => 'required|date',
            'id_donante' => 'required|exists:donantes,id_donante',
            'id_campana' => 'nullable|exists:campanas,id_campana',
        ]);

        try {
            $donacion = Donacione::create([
                'tipo' => $validated['tipo_donacion'],
                'fecha' => $validated['fecha_donacion'],
                'id_donante' => $validated['id_donante'],
                'id_campana' => $validated['id_campana'] ?? null,
            ]);

            return response()->json([
                'id' => $donacion->id_donacion,
                'message' => 'Donación creada exitosamente'
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creando donación: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al crear donación',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PUT /api/donaciones-en-dinero/{id}
     */
    public function updateMoneyDonation($id, Request $request)
    {
        $validated = $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'divisa' => 'nullable|string|max:10',
            'nombre_cuenta' => 'nullable|string|max:255',
            'numero_cuenta' => 'nullable|string|max:255',
            'comprobante_url' => 'nullable|string',
            'estado_validacion' => 'nullable|string|in:pendiente,validado,rechazado',
        ]);

        try {
            $comprobantePath = null;
            if ($request->has('comprobante_url') && !empty($request->comprobante_url)) {
                $base64Image = $request->comprobante_url;
                
                if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                    $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                    $type = strtolower($type[1]);
                } else {
                    $type = 'jpg';
                }
                
                $imageData = base64_decode($base64Image);
                $filename = 'comprobante_' . time() . '.' . $type;
                Storage::disk('public')->put('comprobantes/' . $filename, $imageData);
                $comprobantePath = 'comprobantes/' . $filename;
            }

            DonacionesDinero::updateOrCreate(
                ['id_donacion' => $id],
                [
                    'monto' => $validated['monto'],
                    'moneda' => $validated['divisa'] ?? 'BOB',
                    'metodo_pago' => 'transferencia',
                    'referencia_pago' => $validated['numero_cuenta'] ?? null,
                    'comprobante_imagen' => $comprobantePath,
                    'estado' => $validated['estado_validacion'] ?? 'pendiente',
                    'entidad_bancaria' => $validated['nombre_cuenta'] ?? null,
                ]
            );

            return response()->json([
                'message' => 'Donación en dinero actualizada exitosamente'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error actualizando donación en dinero: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al actualizar donación en dinero',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/donantes/{id}/donaciones
     */
    public function getByDonante($donanteId)
    {
        try {
            $donaciones = Donacione::where('id_donante', $donanteId)
                ->with(['detalles.producto', 'campana'])
                ->orderBy('fecha', 'desc')
                ->get();

            return response()->json($donaciones, 200);

        } catch (\Exception $e) {
            Log::error('Error obteniendo donaciones: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener donaciones'], 500);
        }
    }

    /**
     * GET /api/donaciones-en-dinero/getAllById/{id}
     */
    public function getMoneyDonationsByDonante($donanteId)
    {
        try {
            $donaciones = Donacione::where('id_donante', $donanteId)
                ->where('tipo', 'dinero')
                ->with('dinero')
                ->orderBy('fecha', 'desc')
                ->get();

            return response()->json($donaciones, 200);

        } catch (\Exception $e) {
            Log::error('Error obteniendo donaciones en dinero: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener donaciones en dinero'], 500);
        }
    }

    /**
     * PATCH /api/donaciones/estado/{id}
     */
    public function updateEstado($id, Request $request)
    {
        $validated = $request->validate([
            'estado_validacion' => 'required|string',
        ]);

        try {
            $donacion = Donacione::findOrFail($id);
            
            if ($donacion->dinero) {
                $donacion->dinero->update([
                    'estado' => $validated['estado_validacion']
                ]);
            }

            return response()->json(['message' => 'Estado actualizado exitosamente'], 200);

        } catch (\Exception $e) {
            Log::error('Error actualizando estado: ' . $e->getMessage());
            return response()->json(['error' => 'Error al actualizar estado'], 500);
        }
    }

    /**
     * GET /api/donaciones/dinero
     */
    public function getAllMoneyDonations()
    {
        try {
            $donaciones = Donacione::where('tipo', 'dinero')
                ->with(['dinero', 'donante', 'campana'])
                ->orderBy('fecha', 'desc')
                ->get();

            return response()->json($donaciones, 200);

        } catch (\Exception $e) {
            Log::error('Error obteniendo donaciones en dinero: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener donaciones en dinero'], 500);
        }
    }

    public function index()
    {
        return Donacione::with(['donante', 'campana'])->paginate(20);
    }

    public function show(string $id)
    {
        return Donacione::with(['detalles', 'dinero', 'donante'])->findOrFail($id);
    }
}
