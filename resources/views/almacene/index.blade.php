@extends('adminlte::page')

@section('title', 'Almacenes')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-warehouse"></i> Gestión de Almacenes</h1>
    </div>
    <div class="col-sm-6">
        <a href="{{ route('almacene.create') }}" class="btn btn-primary float-right">
            <i class="fas fa-plus"></i> Nuevo Almacén
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
                <h3>{{ $almacenes->total() }}</h3>
                <p>Total de Almacenes</p>
            </div>
            <div class="icon">
                <i class="fas fa-warehouse"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $almacenes->where('latitud', '!=', null)->count() }}</h3>
                <p>Con Ubicación GPS</p>
            </div>
            <div class="icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
        </div>
    </div>
</div>

{{-- Alert Messages --}}
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- Main Card --}}
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list"></i> Listado de Almacenes</h3>
    </div>
    <div class="card-body">
        <table id="almacenesTable" class="table table-bordered table-striped table-hover">
            <thead class="thead-light">
                <tr>
                    <th width="60px">#</th>
                    <th><i class="fas fa-tag"></i> Nombre</th>
                    <th><i class="fas fa-map-marker-alt"></i> Dirección</th>
                    <th><i class="fas fa-globe"></i> Ubicación GPS</th>
                    <th width="200px" class="text-center"><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($almacenes as $almacene)
                    <tr>
                        <td class="text-center"><strong>{{ ++$i }}</strong></td>
                        <td>
                            <strong>{{ $almacene->nombre }}</strong>
                        </td>
                        <td>{{ $almacene->direccion }}</td>
                        <td class="text-center">
                            @if($almacene->latitud && $almacene->longitud)
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Registrada
                                </span>
                                <br>
                                <small class="text-muted">
                                    {{ number_format($almacene->latitud, 4) }}, {{ number_format($almacene->longitud, 4) }}
                                </small>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-times"></i> Sin ubicación
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a class="btn btn-info btn-sm" href="{{ route('almacene.show', $almacene->id_almacen) }}"
                                    title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('almacene.edit', $almacene->id_almacen) }}"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('almacene.destroy', $almacene->id_almacen) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('¿Está seguro de eliminar este almacén?');">
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
            {!! $almacenes->withQueryString()->links() !!}
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
        $('#almacenesTable').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "search": "Buscar:",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "No hay datos disponibles en la tabla"
            }
        });
    });
</script>
@stop