<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Detectar el rol del usuario autenticado
        $user = auth()->user();

        // Si es almacenista, mostrar dashboard específico
        if ($user->hasRole('Almacenista')) {
            return $this->dashboardAlmacenista();
        }

        // Dashboard general para Administrador y Voluntario
        return $this->dashboardGeneral();
    }

    /**
     * Dashboard general para Administrador y Voluntario
     */
    private function dashboardGeneral()
    {
        // ============================================
        // KPI CARDS - 7 Métricas Principales
        // ============================================
        $totalDonaciones = \App\Models\Donacione::count();
        $totalPaquetes = \App\Models\Paquete::count();
        $totalSalidas = \App\Models\RegistrosSalida::count();
        $solicitudesPendientes = \App\Models\SolicitudesRecoleccion::where('estado', 'Pendiente')->count();
        $totalDonantes = \App\Models\Donante::count();
        $totalProductos = \App\Models\Producto::count();
        $totalUsuarios = \App\Models\Usuario::count();

        // Campañas activas (basado en fechas)
        $campanasActivas = \App\Models\Campana::where('fecha_inicio', '<=', \Carbon\Carbon::now())
            ->where('fecha_fin', '>=', \Carbon\Carbon::now())
            ->count();

        // Promedio de donaciones por día (últimos 30 días)
        $donacionesUltimos30Dias = \App\Models\Donacione::where('fecha', '>=', \Carbon\Carbon::now()->subDays(30))->count();
        $promedioDonacionesDia = $donacionesUltimos30Dias > 0 ? round($donacionesUltimos30Dias / 30, 1) : 0;

        // ============================================
        // VISUALIZACIÓN 1: Tendencia de Donaciones (12 meses) - LINE CHART
        // ============================================
        $donacionesPorMes = \App\Models\Donacione::selectRaw('EXTRACT(YEAR FROM fecha) as anio, EXTRACT(MONTH FROM fecha) as mes, COUNT(*) as total')
            ->where('fecha', '>=', \Carbon\Carbon::now()->subMonths(12))
            ->groupBy('anio', 'mes')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();

        $mesesLabels = [];
        $cantidadesDonaciones = [];

        for ($i = 11; $i >= 0; $i--) {
            $fecha = \Carbon\Carbon::now()->subMonths($i);
            $mesesLabels[] = $fecha->locale('es')->isoFormat('MMM YYYY');

            $registro = $donacionesPorMes->first(function ($item) use ($fecha) {
                return $item->mes == $fecha->month && $item->anio == $fecha->year;
            });

            $cantidadesDonaciones[] = $registro ? $registro->total : 0;
        }

        // ============================================
        // VISUALIZACIÓN 2: Estado de Paquetes - DOUGHNUT CHART
        // ============================================
        $paquetesPorEstado = \App\Models\Paquete::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $estadosPaquetes = $paquetesPorEstado->keys();
        $cantidadesPaquetes = $paquetesPorEstado->values();

        // ============================================
        // VISUALIZACIÓN 3: Top 5 Categorías - BAR CHART
        // ============================================
        $topCategorias = \App\Models\DonacionDetalle::join('productos', 'donacion_detalles.id_producto', '=', 'productos.id_producto')
            ->join('categorias_productos', 'productos.id_categoria', '=', 'categorias_productos.id_categoria')
            ->select('categorias_productos.nombre', \Illuminate\Support\Facades\DB::raw('COUNT(donacion_detalles.id_detalle) as total'))
            ->groupBy('categorias_productos.nombre')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $nombresTopCategorias = $topCategorias->pluck('nombre');
        $cantidadesTopCategorias = $topCategorias->pluck('total');


        // ============================================
        // VISUALIZACIÓN 4: Tendencia de Donaciones en Dinero (12 meses) - LINE CHART
        // ============================================
        $donacionesDineroPorMes = \App\Models\DonacionesDinero::join('donaciones', 'donaciones_dinero.id_donacion', '=', 'donaciones.id_donacion')
            ->selectRaw('EXTRACT(YEAR FROM donaciones.fecha) as anio, EXTRACT(MONTH FROM donaciones.fecha) as mes, SUM(donaciones_dinero.monto) as total_monto')
            ->where('donaciones.fecha', '>=', \Carbon\Carbon::now()->subMonths(12))
            ->groupBy('anio', 'mes')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();

        $mesesDineroLabels = [];
        $montoDonacionesDinero = [];

        for ($i = 11; $i >= 0; $i--) {
            $fecha = \Carbon\Carbon::now()->subMonths($i);
            $mesesDineroLabels[] = $fecha->locale('es')->isoFormat('MMM YYYY');

            $registro = $donacionesDineroPorMes->first(function ($item) use ($fecha) {
                return $item->mes == $fecha->month && $item->anio == $fecha->year;
            });

            $montoDonacionesDinero[] = $registro ? (float) $registro->total_monto : 0;
        }

        // Total de donaciones en dinero para KPI
        $totalDonacionesDinero = \App\Models\DonacionesDinero::sum('monto');


        // ============================================
        // VISUALIZACIÓN 5: Top 5 Donantes - HORIZONTAL BAR CHART
        // ============================================
        $topDonantes = \App\Models\Donante::leftJoin('donaciones', 'donantes.id_donante', '=', 'donaciones.id_donante')
            ->select('donantes.nombre', \Illuminate\Support\Facades\DB::raw('COUNT(donaciones.id_donacion) as total_donaciones'))
            ->groupBy('donantes.id_donante', 'donantes.nombre')
            ->orderByDesc('total_donaciones')
            ->take(5)
            ->get();

        $nombresTopDonantes = $topDonantes->pluck('nombre');
        $cantidadesTopDonantes = $topDonantes->pluck('total_donaciones');

        // ============================================
        // VISUALIZACIÓN 6: Actividad Reciente - TIMELINE
        // ============================================
        $actividadesRecientes = [];

        // Últimas donaciones
        $ultimasDonaciones = \App\Models\Donacione::with('donante')
            ->orderBy('fecha', 'desc')
            ->take(5)
            ->get()
            ->map(function ($donacion) {
                return [
                    'tipo' => 'donacion',
                    'icono' => 'fas fa-gift',
                    'color' => 'info',
                    'titulo' => 'Nueva Donación',
                    'descripcion' => 'Donación de ' . ($donacion->donante ? $donacion->donante->nombre : 'Anónimo'),
                    'fecha' => \Carbon\Carbon::parse($donacion->fecha)
                ];
            });

        // Últimos paquetes
        $ultimosPaquetes = \App\Models\Paquete::orderBy('fecha_creacion', 'desc')
            ->take(5)
            ->get()
            ->map(function ($paquete) {
                return [
                    'tipo' => 'paquete',
                    'icono' => 'fas fa-box',
                    'color' => 'success',
                    'titulo' => 'Paquete Creado',
                    'descripcion' => 'Código: ' . $paquete->codigo_paquete . ' - Estado: ' . $paquete->estado,
                    'fecha' => \Carbon\Carbon::parse($paquete->fecha_creacion)
                ];
            });

        // Combinar y ordenar
        $actividadesRecientes = $ultimasDonaciones->concat($ultimosPaquetes)
            ->sortByDesc('fecha')
            ->take(10)
            ->values();

        return view('home', compact(
            // KPIs
            'totalDonaciones',
            'totalPaquetes',
            'totalSalidas',
            'solicitudesPendientes',
            'totalDonantes',
            'totalProductos',
            'totalUsuarios',
            'campanasActivas',
            'promedioDonacionesDia',
            'totalDonacionesDinero',
            // Viz 1: Tendencia Donaciones
            'mesesLabels',
            'cantidadesDonaciones',
            // Viz 2: Estado Paquetes
            'estadosPaquetes',
            'cantidadesPaquetes',
            // Viz 3: Top Categorías
            'nombresTopCategorias',
            'cantidadesTopCategorias',
            // Viz 4: Tendencia Donaciones en Dinero
            'mesesDineroLabels',
            'montoDonacionesDinero',
            // Viz 5: Top Donantes
            'nombresTopDonantes',
            'cantidadesTopDonantes',
            // Viz 6: Actividades Recientes
            'actividadesRecientes'
        ));
    }

    /**
     * Dashboard específico para Almacenista
     */
    private function dashboardAlmacenista()
    {
        // ============================================
        // KPIs para Almacenista
        // ============================================
        $totalAlmacenes = \App\Models\Almacene::count();
        $totalEstantes = \App\Models\Estante::count();
        $totalEspacios = \App\Models\Espacio::count();

        // Los espacios pueden tener estado 'Lleno', 'Vacio' o NULL (que significa vacío)
        $espaciosLlenos = \App\Models\Espacio::where('estado', 'Lleno')->count();
        $espaciosDisponibles = $totalEspacios - $espaciosLlenos; // Todo lo que no está lleno está disponible


        // Productos en inventario (ubicaciones activas)
        $productosInventario = \App\Models\UbicacionesDonacione::count();

        // ============================================
        // VIZ 1: Utilización por Almacén (Bar Chart Horizontal)
        // ============================================
        $almacenesData = \Illuminate\Support\Facades\DB::table('almacenes')
            ->leftJoin('estantes', 'almacenes.id_almacen', '=', 'estantes.id_almacen')
            ->leftJoin('espacios', 'estantes.id_estante', '=', 'espacios.id_estante')
            ->select(
                'almacenes.nombre',
                \Illuminate\Support\Facades\DB::raw('COUNT(espacios.id_espacio) as total_espacios'),
                \Illuminate\Support\Facades\DB::raw("COUNT(CASE WHEN espacios.estado = 'Lleno' THEN 1 END) as espacios_llenos")
            )
            ->groupBy('almacenes.id_almacen', 'almacenes.nombre')
            ->get();

        $nombresAlmacenes = [];
        $porcentajesUtilizacion = [];

        foreach ($almacenesData as $almacen) {
            $nombresAlmacenes[] = $almacen->nombre;

            if ($almacen->total_espacios > 0) {
                $porcentajesUtilizacion[] = round(($almacen->espacios_llenos / $almacen->total_espacios) * 100, 1);
            } else {
                $porcentajesUtilizacion[] = 0;
            }
        }

        // ============================================
        // VIZ 2: Productos por Categoría (Doughnut)
        // ============================================
        $productosPorCategoria = \App\Models\UbicacionesDonacione::join('donacion_detalles', 'ubicaciones_donaciones.id_detalle', '=', 'donacion_detalles.id_detalle')
            ->join('productos', 'donacion_detalles.id_producto', '=', 'productos.id_producto')
            ->join('categorias_productos', 'productos.id_categoria', '=', 'categorias_productos.id_categoria')
            ->select('categorias_productos.nombre', \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'))
            ->groupBy('categorias_productos.nombre')
            ->orderByDesc('total')
            ->get();

        $nombresCategorias = $productosPorCategoria->pluck('nombre');
        $cantidadesCategorias = $productosPorCategoria->pluck('total');

        // ============================================
        // VIZ 3: Estado de Espacios (Doughnut)
        // ============================================
        // Ya tenemos espaciosDisponibles y espaciosLlenos

        // ============================================
        // VIZ 4: Movimientos Recientes (Timeline)
        // ============================================
        $movimientosRecientes = [];

        // Últimas entradas (donaciones)
        $ultimasEntradas = \App\Models\UbicacionesDonacione::with(['detalle.donacion', 'espacio.estante.almacene'])
            ->orderBy('id_ubicacion', 'desc')
            ->take(5)
            ->get()
            ->map(function ($ubicacion) {
                return [
                    'tipo' => 'entrada',
                    'icono' => 'fas fa-arrow-down',
                    'color' => 'success',
                    'titulo' => 'Ingreso al Almacén',
                    'descripcion' => 'Producto ingresado a ' . ($ubicacion->espacio->estante->almacene->nombre ?? 'Almacén'),
                    'fecha' => $ubicacion->detalle && $ubicacion->detalle->donacion ? \Carbon\Carbon::parse($ubicacion->detalle->donacion->fecha) : \Carbon\Carbon::now()
                ];
            });

        // Últimas salidas
        $ultimasSalidas = \App\Models\RegistrosSalida::orderBy('fecha_salida', 'desc')
            ->take(5)
            ->get()
            ->map(function ($salida) {
                return [
                    'tipo' => 'salida',
                    'icono' => 'fas fa-arrow-up',
                    'color' => 'warning',
                    'titulo' => 'Salida del Almacén',
                    'descripcion' => 'Productos despachados - Destino: ' . ($salida->destino ?? 'No especificado'),
                    'fecha' => \Carbon\Carbon::parse($salida->fecha_salida)
                ];
            });

        $movimientosRecientes = $ultimasEntradas->concat($ultimasSalidas)
            ->sortByDesc('fecha')
            ->take(10)
            ->values();

        // ============================================
        // VIZ 5: Top 5 Productos Almacenados (Bar Chart)
        // ============================================
        $topProductosAlmacenados = \App\Models\UbicacionesDonacione::join('donacion_detalles', 'ubicaciones_donaciones.id_detalle', '=', 'donacion_detalles.id_detalle')
            ->join('productos', 'donacion_detalles.id_producto', '=', 'productos.id_producto')
            ->select('productos.nombre', \Illuminate\Support\Facades\DB::raw('COUNT(*) as cantidad'))
            ->groupBy('productos.id_producto', 'productos.nombre')
            ->orderByDesc('cantidad')
            ->take(5)
            ->get();

        $nombresTopProductos = $topProductosAlmacenados->pluck('nombre');
        $cantidadesTopProductos = $topProductosAlmacenados->pluck('cantidad');

        return view('home-almacenista', compact(
            // KPIs
            'totalAlmacenes',
            'totalEstantes',
            'totalEspacios',
            'espaciosDisponibles',
            'espaciosLlenos',
            'productosInventario',
            // Viz 1: Utilización por Almacén
            'nombresAlmacenes',
            'porcentajesUtilizacion',
            // Viz 2: Productos por Categoría
            'nombresCategorias',
            'cantidadesCategorias',
            // Viz 3: Estado Espacios (ya están en KPIs)
            // Viz 4: Movimientos Recientes
            'movimientosRecientes',
            // Viz 5: Top Productos
            'nombresTopProductos',
            'cantidadesTopProductos'
        ));
    }
}
