@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Principal</h1>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Info Boxes Fila 1 -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-gift"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Donaciones</span>
                        <span class="info-box-number">{{ $totalDonaciones }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-box"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Paquetes Creados</span>
                        <span class="info-box-number">{{ $totalPaquetes }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-truck-loading"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Salidas Registradas</span>
                        <span class="info-box-number">{{ $totalSalidas }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-clipboard-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Solicitudes Pendientes</span>
                        <span class="info-box-number">{{ $solicitudesPendientes }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Boxes Fila 2 -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-hand-holding-heart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Donantes</span>
                        <span class="info-box-number">{{ $totalDonantes }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-box-open"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Productos Registrados</span>
                        <span class="info-box-number">{{ $totalProductos }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Usuarios del Sistema</span>
                        <span class="info-box-number">{{ $totalUsuarios }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row">
            <!-- Gráfico de Donaciones -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Donaciones por Mes</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donacionesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <!-- Gráfico de Paquetes -->
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Estado de Paquetes</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="paquetesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Gráfico Top Productos -->
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Top 5 Productos Más Donados</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="topProductosChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            // Gráfico de Donaciones (Bar Chart)
            var donacionesChartCanvas = $('#donacionesChart').get(0).getContext('2d')
            var donacionesData = {
                labels: {!! json_encode($meses) !!},
                datasets: [
                    {
                        label: 'Donaciones',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: {!! json_encode($cantidadesDonaciones) !!}
                    }
                ]
            }
            var donacionesChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                }
            }
            new Chart(donacionesChartCanvas, {
                type: 'bar',
                data: donacionesData,
                options: donacionesChartOptions
            })

            // Gráfico de Paquetes (Donut Chart)
            var paquetesChartCanvas = $('#paquetesChart').get(0).getContext('2d')
            var paquetesData = {
                labels: {!! json_encode($estadosPaquetes) !!},
                datasets: [
                    {
                        data: {!! json_encode($cantidadesPaquetes) !!},
                        backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                    }
                ]
            }
            var paquetesOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            new Chart(paquetesChartCanvas, {
                type: 'doughnut',
                data: paquetesData,
                options: paquetesOptions
            })

            // Gráfico Top Productos (Horizontal Bar Chart)
            var topProductosChartCanvas = $('#topProductosChart').get(0).getContext('2d')
            var topProductosData = {
                labels: {!! json_encode($nombresTopProductos) !!},
                datasets: [
                    {
                        label: 'Cantidad de Donaciones',
                        backgroundColor: 'rgba(0, 192, 239, 0.9)',
                        borderColor: 'rgba(0, 192, 239, 0.8)',
                        data: {!! json_encode($cantidadesTopProductos) !!}
                    }
                ]
            }
            var topProductosOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
            new Chart(topProductosChartCanvas, {
                type: 'horizontalBar',
                data: topProductosData,
                options: topProductosOptions
            })
        })
    </script>
@stop