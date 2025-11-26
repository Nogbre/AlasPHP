@extends('adminlte::page')

@section('title', 'Detalles del Estante')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Detalles del Estante</h1>
    </div>
    <div class="col-sm-6">
        <a class="btn btn-secondary float-right" href="{{ route('estante.index') }}">
            Volver al Listado
        </a>
    </div>
</div>
@stop

@section('content')
{{-- Info Boxes Row --}}
<div class="row">
    <div class="col-md-4 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-layer-group"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Código del Estante</span>
                <span class="info-box-number">{{ $estante->codigo_estante }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-warehouse"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Almacén</span>
                <span class="info-box-number" style="font-size: 1.2rem;">
                    @if($estante->almacene)
                        {{ $estante->almacene->nombre }}
                    @else
                        Sin asignar
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

{{-- Main Content Card --}}
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Información Completa</h3>
        <div class="card-tools">
            <a href="{{ route('estante.edit', $estante->id_estante) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Código del Estante:</dt>
            <dd class="col-sm-9"><strong>{{ $estante->codigo_estante }}</strong></dd>

            <dt class="col-sm-3">Almacén:</dt>
            <dd class="col-sm-9">
                @if($estante->almacene)
                    <span class="badge badge-info badge-lg">
                        {{ $estante->almacene->nombre }}
                    </span>
                    @if($estante->almacene->direccion)
                        <br><small class="text-muted">{{ $estante->almacene->direccion }}</small>
                    @endif
                @else
                    <span class="badge badge-secondary">Sin almacén asignado</span>
                @endif
            </dd>

            <dt class="col-sm-3">Descripción:</dt>
            <dd class="col-sm-9">
                {{ $estante->descripcion ?: 'Sin descripción' }}
            </dd>
        </dl>
    </div>
</div>

{{-- Action Buttons --}}
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('estante.index') }}" class="btn btn-secondary">
            Volver al Listado
        </a>
        <a href="{{ route('estante.edit', $estante->id_estante) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar Estante
        </a>
        <form action="{{ route('estante.destroy', $estante->id_estante) }}" method="POST" style="display: inline;"
            onsubmit="return confirm('¿Está seguro de eliminar este estante?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </form>
    </div>
</div>
@stop