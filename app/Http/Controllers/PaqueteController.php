<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\SolicitudesRecoleccion;
use App\Models\Donacione;
use App\Models\DonacionDetalle;
use App\Models\PaqueteDetalle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PaqueteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PaqueteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $paquetes = Paquete::paginate();

        return view('paquete.index', compact('paquetes'))
            ->with('i', ($request->input('page', 1) - 1) * $paquetes->perPage());
    }

    /**
     * Helper para obtener productos con stock agrupado
     */
    private function getProductosConStock()
    {
        // Obtener todos los detalles de donaciones en especie
        $detalles = DonacionDetalle::with(['producto', 'paqueteDetalles'])
            ->whereHas('donacion', function ($query) {
                $query->where('tipo', 'especie');
            })
            ->get();

        $productosAgrupados = [];

        foreach ($detalles as $detalle) {
            $idProducto = $detalle->id_producto;

            // Calcular cantidad ya usada en otros paquetes
            $usado = $detalle->paqueteDetalles->sum('cantidad_usada');
            $disponible = $detalle->cantidad - $usado;

            if ($disponible > 0) {
                if (!isset($productosAgrupados[$idProducto])) {
                    $productosAgrupados[$idProducto] = [
                        'id_producto' => $idProducto,
                        'nombre' => $detalle->producto->nombre ?? 'Producto Desconocido',
                        'descripcion' => $detalle->producto->descripcion ?? '', // Usar descripción del producto base
                        'unidad_medida' => $detalle->unidad_medida,
                        'total_disponible' => 0
                    ];
                }
                $productosAgrupados[$idProducto]['total_disponible'] += $disponible;
            }
        }

        return array_values($productosAgrupados);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $paquete = new Paquete();
        $solicitudes = SolicitudesRecoleccion::all();
        $productosDisponibles = $this->getProductosConStock();

        return view('paquete.create', compact('paquete', 'solicitudes', 'productosDisponibles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaqueteRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['codigo_paquete'])) {
            $data['codigo_paquete'] = $this->generarCodigoPaquete();
        }
        $data['fecha_creacion'] = now();

        try {
            DB::beginTransaction();

            $paquete = Paquete::create($data);

            if ($request->has('detalles')) {
                $this->procesarDetallesPaquete($paquete, $request->detalles);
            }

            DB::commit();

            return Redirect::route('paquete.index')
                ->with('success', 'Paquete creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()
                ->withInput()
                ->withErrors(['error' => 'Error al guardar el paquete: ' . $e->getMessage()]);
        }
    }

    /**
     * Lógica FIFO para asignar productos desde los lotes de donación
     */
    private function procesarDetallesPaquete($paquete, $detallesSolicitados)
    {
        foreach ($detallesSolicitados as $solicitud) {
            if (empty($solicitud['id_producto']) || empty($solicitud['cantidad_usada'])) {
                continue;
            }

            $cantidadRequerida = $solicitud['cantidad_usada'];
            $idProducto = $solicitud['id_producto'];

            // Buscar lotes disponibles ordenados por fecha (FIFO)
            // Nota: Ordenamos por ID de donación como proxy de fecha si no hacemos join complejo, 
            // o hacemos join con donaciones para ordenar por fecha real.
            $lotes = DonacionDetalle::where('id_producto', $idProducto)
                ->whereHas('donacion', function ($q) {
                    $q->where('tipo', 'especie');
                })
                ->with(['donacion', 'paqueteDetalles'])
                ->get()
                ->sortBy(function ($lote) {
                    return $lote->donacion->fecha;
                });

            foreach ($lotes as $lote) {
                if ($cantidadRequerida <= 0)
                    break;

                $usado = $lote->paqueteDetalles->sum('cantidad_usada');
                $disponibleEnLote = $lote->cantidad - $usado;

                if ($disponibleEnLote > 0) {
                    $cantidadATomar = min($cantidadRequerida, $disponibleEnLote);

                    PaqueteDetalle::create([
                        'id_paquete' => $paquete->id_paquete,
                        'id_detalle_donacion' => $lote->id_detalle,
                        'cantidad_usada' => $cantidadATomar
                    ]);

                    $cantidadRequerida -= $cantidadATomar;
                }
            }

            if ($cantidadRequerida > 0) {
                throw new \Exception("No hay suficiente stock disponible para el producto ID: $idProducto. Faltan $cantidadRequerida unidades.");
            }
        }
    }

    /**
     * Generar código único para el paquete
     */
    private function generarCodigoPaquete(): string
    {
        do {
            // Formato: PKG-YYYYMMDD-XXXX (ej: PKG-20231126-0001)
            $codigo = 'PKG-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Paquete::where('codigo_paquete', $codigo)->exists());

        return $codigo;
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $paquete = Paquete::with(['paqueteDetalles.donacionDetalle.producto', 'paqueteDetalles.donacionDetalle.donacion.donante'])->find($id);

        return view('paquete.show', compact('paquete'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $paquete = Paquete::with(['paqueteDetalles.donacionDetalle.producto'])->find($id);
        $solicitudes = SolicitudesRecoleccion::all();
        $productosDisponibles = $this->getProductosConStock();

        // Necesitamos transformar los detalles actuales del paquete para que coincidan con la estructura agrupada
        // Agrupamos los detalles del paquete por producto para mostrar la cantidad total usada de ese producto en este paquete
        $detallesAgrupados = [];
        foreach ($paquete->paqueteDetalles as $detalle) {
            $prodId = $detalle->donacionDetalle->id_producto;
            if (!isset($detallesAgrupados[$prodId])) {
                $detallesAgrupados[$prodId] = [
                    'id_producto' => $prodId,
                    'cantidad_usada' => 0
                ];
            }
            $detallesAgrupados[$prodId]['cantidad_usada'] += $detalle->cantidad_usada;
        }

        // Inyectamos estos detalles agrupados en el objeto paquete para que la vista los use
        $paquete->detalles_agrupados = array_values($detallesAgrupados);

        return view('paquete.edit', compact('paquete', 'solicitudes', 'productosDisponibles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaqueteRequest $request, Paquete $paquete): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $paquete->update($request->validated());

            // Liberar stock anterior (borrar detalles previos)
            // Nota: Esto es simplificado. En un sistema real de inventario querrías ajustar diferencias,
            // pero borrar y recrear es válido para recalcular FIFO.
            $paquete->paqueteDetalles()->delete();

            if ($request->has('detalles')) {
                $this->procesarDetallesPaquete($paquete, $request->detalles);
            }

            DB::commit();

            return Redirect::route('paquete.index')
                ->with('success', 'Paquete actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar el paquete: ' . $e->getMessage()]);
        }
    }

    public function destroy($id): RedirectResponse
    {
        Paquete::find($id)->delete();

        return Redirect::route('paquete.index')
            ->with('success', 'Paquete eliminado exitosamente');
    }
}
