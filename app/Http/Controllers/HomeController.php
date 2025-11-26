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
        // Totales para Info Boxes
        $totalDonaciones = \App\Models\Donacione::count();
        $totalPaquetes = \App\Models\Paquete::count();
        $totalSalidas = \App\Models\RegistrosSalida::count();
        $solicitudesPendientes = \App\Models\SolicitudesRecoleccion::where('estado', 'Pendiente')->count();

        // Nuevas Métricas
        $totalDonantes = \App\Models\Donante::count();
        $totalProductos = \App\Models\Producto::count();
        $totalUsuarios = \App\Models\Usuario::count();

        // Datos para Gráfico de Donaciones (Últimos 6 meses)
        $donacionesPorMes = \App\Models\Donacione::selectRaw('EXTRACT(MONTH FROM fecha) as mes, COUNT(*) as total')
            ->where('fecha', '>=', \Carbon\Carbon::now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        $meses = $donacionesPorMes->keys()->map(function ($mes) {
            return \Carbon\Carbon::create()->month($mes)->locale('es')->monthName;
        });
        $cantidadesDonaciones = $donacionesPorMes->values();

        // Datos para Gráfico de Estado de Paquetes
        $paquetesPorEstado = \App\Models\Paquete::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $estadosPaquetes = $paquetesPorEstado->keys();
        $cantidadesPaquetes = $paquetesPorEstado->values();

        // Datos para Top 5 Productos Más Donados
        $topProductos = \App\Models\DonacionDetalle::join('productos', 'donacion_detalles.id_producto', '=', 'productos.id_producto')
            ->select('productos.nombre', \Illuminate\Support\Facades\DB::raw('COUNT(donacion_detalles.id_detalle) as total'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $nombresTopProductos = $topProductos->pluck('nombre');
        $cantidadesTopProductos = $topProductos->pluck('total');

        return view('home', compact(
            'totalDonaciones',
            'totalPaquetes',
            'totalSalidas',
            'solicitudesPendientes',
            'totalDonantes',
            'totalProductos',
            'totalUsuarios',
            'meses',
            'cantidadesDonaciones',
            'estadosPaquetes',
            'cantidadesPaquetes',
            'nombresTopProductos',
            'cantidadesTopProductos'
        ));
    }
}
