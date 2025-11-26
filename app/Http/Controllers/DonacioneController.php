<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonacioneRequest;
use App\Models\Donacione;
use App\Models\DonacionesDinero;
use App\Models\DonacionDetalle;
use App\Models\UbicacionesDonacione;
use App\Models\Donante;
use App\Models\Campana;
use App\Models\PuntosRecoleccion;
use App\Models\Producto;
use App\Models\Espacio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DonacioneController extends Controller
{
    public function index(Request $request): View
    {
        $donaciones = Donacione::with(['donante'])->paginate();

        // Calculate statistics
        $totalDonaciones = Donacione::count();
        $donacionesDinero = Donacione::where('tipo', 'dinero')->count();
        $donacionesEspecie = Donacione::where('tipo', 'especie')->count();

        // Calculate total money amount
        $montoTotal = DB::table('donaciones_dinero')
            ->join('donaciones', 'donaciones_dinero.id_donacion', '=', 'donaciones.id_donacion')
            ->sum('donaciones_dinero.monto');

        // Calculate clothing donations (donations with products in 'Ropa' category)
        $donacionesRopa = DB::table('donaciones')
            ->join('donacion_detalles', 'donaciones.id_donacion', '=', 'donacion_detalles.id_donacion')
            ->join('productos', 'donacion_detalles.id_producto', '=', 'productos.id_producto')
            ->join('categorias_productos', 'productos.id_categoria', '=', 'categorias_productos.id_categoria')
            ->where('categorias_productos.nombre', 'LIKE', '%Ropa%')
            ->distinct('donaciones.id_donacion')
            ->count('donaciones.id_donacion');

        return view('donaciones.index', compact('donaciones', 'totalDonaciones', 'donacionesDinero', 'donacionesEspecie', 'montoTotal', 'donacionesRopa'))
            ->with('i', ($request->input('page', 1) - 1) * $donaciones->perPage());
    }

    public function create(): View
    {
        $donantes = Donante::pluck('nombre', 'id_donante');
        $campanas = Campana::pluck('nombre', 'id_campana');
        $puntos = PuntosRecoleccion::pluck('nombre', 'id_punto');
        $productos = Producto::pluck('nombre', 'id_producto');
        $espacios = Espacio::pluck('codigo_espacio', 'id_espacio');

        // Get products with their unit measurements for auto-fill
        $productosData = Producto::select('id_producto', 'nombre', 'unidad_medida')->get();
        $productosUnidades = $productosData->pluck('unidad_medida', 'id_producto')->toArray();

        // Provide an empty model instance so the form can safely access $donacion
        $donacion = new Donacione();

        return view('donaciones.create', compact('donacion', 'donantes', 'campanas', 'puntos', 'productos', 'espacios', 'productosUnidades'));
    }

    public function store(DonacioneRequest $request): RedirectResponse
    {
        $data = $request->validated();

        \Log::info('=== INICIO STORE DONACION ===');
        \Log::info('Datos validados:', $data);

        try {
            DB::transaction(function () use ($data) {
                \Log::info('Iniciando transacción...');

                $donacion = Donacione::create([
                    'id_donante' => $data['id_donante'],
                    'tipo' => $data['tipo'],
                    'id_campana' => $data['id_campana'] ?? null,
                    'id_punto_recoleccion' => $data['id_punto_recoleccion'] ?? null,
                    'observaciones' => $data['observaciones'] ?? null,
                    'fecha' => now(),
                ]);

                \Log::info('Donación creada:', ['id' => $donacion->id_donacion, 'tipo' => $donacion->tipo]);

                if ($data['tipo'] === 'dinero') {
                    \Log::info('Creando registro de dinero...');
                    \Log::info('Datos dinero:', [
                        'id_donacion' => $donacion->id_donacion,
                        'monto' => $data['monto'] ?? 'NULL',
                        'moneda' => $data['moneda'] ?? 'NULL',
                        'metodo_pago' => $data['metodo_pago'] ?? 'NULL',
                        'referencia_pago' => $data['referencia_pago'] ?? 'NULL',
                    ]);

                    DonacionesDinero::create([
                        'id_donacion' => $donacion->id_donacion,
                        'monto' => $data['monto'],
                        'moneda' => $data['moneda'] ?? null,
                        'metodo_pago' => $data['metodo_pago'] ?? null,
                        'referencia_pago' => $data['referencia_pago'] ?? null,
                    ]);

                    \Log::info('Registro de dinero creado exitosamente');
                } else {
                    \Log::info('Creando detalles de productos...', ['cantidad_detalles' => count($data['detalles'] ?? [])]);

                    foreach ($data['detalles'] as $index => $det) {
                        \Log::info("Procesando detalle #{$index}:", $det);

                        $detalle = DonacionDetalle::create([
                            'id_donacion' => $donacion->id_donacion,
                            'id_producto' => $det['id_producto'],
                            'cantidad' => (int) $det['cantidad'],
                            'unidad_medida' => $det['unidad_medida'] ?? null,
                            'descripcion' => $det['descripcion'] ?? null,
                            'id_talla' => $det['id_talla'] ?? null,
                            'id_genero' => $det['id_genero'] ?? null,
                        ]);

                        \Log::info("Detalle #{$index} creado:", ['id' => $detalle->id_detalle]);

                        UbicacionesDonacione::create([
                            'id_detalle' => $detalle->id_detalle,
                            'id_espacio' => $det['id_espacio'],
                            'fecha_ingreso' => now(),
                        ]);

                        \Log::info("Ubicación para detalle #{$index} creada");
                    }
                }

                \Log::info('Transacción completada exitosamente');
            });

            \Log::info('=== FIN STORE DONACION (SUCCESS) ===');
            return Redirect::route('donaciones.index')->with('success', 'Donación creada correctamente.');

        } catch (\Throwable $e) {
            \Log::error('=== ERROR EN STORE DONACION ===');
            \Log::error('Mensaje: ' . $e->getMessage());
            \Log::error('Archivo: ' . $e->getFile() . ':' . $e->getLine());
            \Log::error('Trace: ' . $e->getTraceAsString());

            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al crear la donación: ' . $e->getMessage()]);
        }
    }

    public function show($id): View
    {
        $donacion = Donacione::with(['detalles.producto', 'dinero', 'donante'])->find($id);
        return view('donaciones.show', compact('donacion'));
    }

    public function edit($id): View
    {
        $donacion = Donacione::with(['detalles'])->find($id);

        $donantes = Donante::pluck('nombre', 'id_donante');
        $campanas = Campana::pluck('nombre', 'id_campana');
        $puntos = PuntosRecoleccion::pluck('nombre', 'id_punto');
        $productos = Producto::pluck('nombre', 'id_producto');
        $espacios = Espacio::pluck('codigo_espacio', 'id_espacio');

        // Get products with their unit measurements for auto-fill
        $productosData = Producto::select('id_producto', 'nombre', 'unidad_medida')->get();
        $productosUnidades = $productosData->pluck('unidad_medida', 'id_producto')->toArray();

        return view('donaciones.edit', compact('donacion', 'donantes', 'campanas', 'puntos', 'productos', 'espacios', 'productosUnidades'));
    }

    public function update(DonacioneRequest $request, Donacione $donacione): RedirectResponse
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, $donacione) {
                $donacione->update([
                    'id_donante' => $data['id_donante'],
                    'tipo' => $data['tipo'],
                    'id_campana' => $data['id_campana'] ?? null,
                    'id_punto_recoleccion' => $data['id_punto_recoleccion'] ?? null,
                    'observaciones' => $data['observaciones'] ?? null,
                ]);

                // borrar detalles y ubicaciones previas si aplica
                if ($donacione->detalles()->count()) {
                    foreach ($donacione->detalles as $oldDet) {
                        // eliminar ubicaciones relacionadas
                        UbicacionesDonacione::where('id_detalle', $oldDet->id_detalle)->delete();
                    }
                    $donacione->detalles()->delete();
                }

                // borrar dinero si existía
                DonacionesDinero::where('id_donacion', $donacione->id_donacion)->delete();

                if ($data['tipo'] === 'dinero') {
                    DonacionesDinero::create([
                        'id_donacion' => $donacione->id_donacion,
                        'monto' => $data['monto'],
                        'moneda' => $data['moneda'] ?? null,
                        'metodo_pago' => $data['metodo_pago'] ?? null,
                        'referencia_pago' => $data['referencia_pago'] ?? null,
                    ]);
                } else {
                    foreach ($data['detalles'] as $det) {
                        $detalle = DonacionDetalle::create([
                            'id_donacion' => $donacione->id_donacion,
                            'id_producto' => $det['id_producto'],
                            'cantidad' => (int) $det['cantidad'],
                            'unidad_medida' => $det['unidad_medida'] ?? null,
                            'descripcion' => $det['descripcion'] ?? null,
                            'id_talla' => $det['id_talla'] ?? null,
                            'id_genero' => $det['id_genero'] ?? null,
                        ]);

                        UbicacionesDonacione::create([
                            'id_detalle' => $detalle->id_detalle,
                            'id_espacio' => $det['id_espacio'],
                            'fecha_ingreso' => now(),
                        ]);
                    }
                }
            });

            return Redirect::route('donaciones.index')->with('success', 'Donación actualizada correctamente.');
        } catch (\Throwable $e) {
            \Log::error('Error actualizando donacion: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al actualizar la donación.']);
        }
    }

    public function destroy($id): RedirectResponse
    {
        $donacion = Donacione::find($id);
        if ($donacion) {
            DB::transaction(function () use ($donacion) {
                // eliminar ubicaciones, detalles y registros de dinero
                foreach ($donacion->detalles as $det) {
                    UbicacionesDonacione::where('id_detalle', $det->id_detalle)->delete();
                }
                $donacion->detalles()->delete();
                DonacionesDinero::where('id_donacion', $donacion->id_donacion)->delete();
                $donacion->delete();
            });
        }

        return Redirect::route('donaciones.index')->with('success', 'Donación eliminada correctamente.');
    }
}
