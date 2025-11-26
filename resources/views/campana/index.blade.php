@extends('adminlte::page')

@section('title', 'Gestión de Campañas')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Gestión de Campañas</h1>
    </div>
    <div class="col-sm-6">
        <a href="{{ route('campana.create') }}" class="btn btn-primary float-right">
            Nueva Campaña
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
                <h3>{{ $campanas->total() }}</h3>
                <p>Total de Campañas</p>
            </div>
            <div class="icon">
                <i class="fas fa-bullhorn"></i>
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
        <h3 class="card-title">Listado de Campañas</h3>
    </div>
    <div class="card-body">
        <table id="campanasTable" class="table table-bordered table-striped table-hover">
            <thead class="thead-light">
                <tr>
                    <th width="60px">#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th width="200px" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campanas as $campana)
                    <tr>
                        <td class="text-center"><strong>{{ ++$i }}</strong></td>
                        <td><strong>{{ $campana->nombre }}</strong></td>
                        <td>{{ Str::limit($campana->descripcion, 50) }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($campana->fecha_inicio)->format('d/m/Y') }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($campana->fecha_fin)->format('d/m/Y') }}
                        </td>
                        <td>
                            @php
                                $now = \Carbon\Carbon::now();
                                $inicio = \Carbon\Carbon::parse($campana->fecha_inicio);
                                $fin = \Carbon\Carbon::parse($campana->fecha_fin);
                            @endphp
                            @if($now->lt($inicio))
                                <span class="badge badge-secondary">
                                    <i class="fas fa-clock"></i> Próxima
                                </span>
                            @elseif($now->between($inicio, $fin))
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Activa
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle"></i> Finalizada
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a class="btn btn-info btn-sm" href="{{ route('campana.show', $campana->id_campana) }}"
                                    title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('campana.edit', $campana->id_campana) }}"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('campana.destroy', $campana->id_campana) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta campaña?');">
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
            {!! $campanas->withQueryString()->links() !!}
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
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#campanasTable').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "search": "Buscar:",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "No hay campañas registradas"
            }
        });
    });
</script>
@stop