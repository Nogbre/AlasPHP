@extends('adminlte::page')

@section('title', 'Gestión de Donaciones')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Gestión de Donaciones</h1>
    </div>
    <div class="col-sm-6">
        <a href="{{ route('donaciones.create') }}" class="btn btn-primary float-right">
            Nueva Donación
        </a>
    </div>
</div>
@stop

@section('content')
{{-- Statistics Row --}}
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalDonaciones }}</h3>
                <p>Total de Donaciones</p>
            </div>
            <div class="icon">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $donacionesDinero }}</h3>
                <p>Donaciones en Dinero</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $donacionesEspecie }}</h3>
                <p>Donaciones en Especie</p>
            </div>
            <div class="icon">
                <i class="fas fa-box-open"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Bs. {{ number_format($montoTotal, 2) }}</h3>
                <p>Monto Total Recaudado</p>
            </div>
            <div class="icon">
                <i class="fas fa-coins"></i>
            </div>
        </div>
    </div>
</div>

{{-- Alert Messages --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- Main Card --}}
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Listado de Donaciones</h3>
    </div>
    <div class="card-body">
        <table id="donacionesTable" class="table table-bordered table-striped table-hover">
            <thead class="thead-light">
                <tr>
                    <th width="60px">#</th>
                    <th>Donante</th>
                    <th>Tipo</th>
                    <th>Fecha y Hora</th>
                    <th width="200px" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donaciones as $donacion)
                    <tr>
                        <td class="text-center"><strong>{{ ++$i }}</strong></td>
                        <td>
                            @if($donacion->donante)
                                {{ $donacion->donante->nombre }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($donacion->tipo === 'dinero')
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-dollar-sign"></i> Dinero
                                </span>
                            @else
                                <span class="badge badge-warning badge-lg">
                                    <i class="fas fa-box-open"></i> Especie
                                </span>
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($donacion->fecha)->format('d/m/Y H:i') }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a class="btn btn-info btn-sm" href="{{ route('donaciones.show', $donacion->id_donacion) }}"
                                    title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-warning btn-sm"
                                    href="{{ route('donaciones.edit', $donacion->id_donacion) }}" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('donaciones.destroy', $donacion->id_donacion) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta donación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="float-right">
            {!! $donaciones->withQueryString()->links() !!}
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<style>
    .small-box {
        border-radius: 0.25rem;
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
    }

    .btn-group .btn {
        margin: 0 2px;
    }

    .badge-lg {
        font-size: 0.9rem;
        padding: 0.4rem 0.6rem;
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#donacionesTable').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "order": [[3, 'desc']], // Order by date descending
            "language": {
                "search": "Buscar:",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "No hay donaciones registradas"
            }
        });
    });
</script>
@stop