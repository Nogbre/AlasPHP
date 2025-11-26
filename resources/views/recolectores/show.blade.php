@extends('adminlte::page')

@section('title', 'Detalles del Recolector')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Detalles del Recolector</h1>
    </div>
    <div class="col-sm-6">
        <a class="btn btn-secondary float-right" href="{{ route('recolectores.index') }}">
            Volver al Listado
        </a>
    </div>
</div>
@stop

@section('content')
{{-- Info Boxes Row --}}
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Nombre</span>
                <span class="info-box-number" style="font-size: 1rem;">{{ $recolector->nombres }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-id-card"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">CI</span>
                <span class="info-box-number">{{ $recolector->ci }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-phone"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Teléfono</span>
                <span class="info-box-number" style="font-size: 1rem;">{{ $recolector->telefono ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            @php
                $badgeClass = $recolector->estado === 'Activo' ? 'success' : 'secondary';
            @endphp
            <span class="info-box-icon bg-{{ $badgeClass }}"><i class="fas fa-toggle-on"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Estado</span>
                <span class="info-box-number">{{ $recolector->estado ?? 'Activo' }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Main Information Card --}}
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Información Personal</h3>
        <div class="card-tools">
            <a href="{{ route('recolectores.edit', $recolector->id_usuario) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nombres:</dt>
            <dd class="col-sm-9"><strong>{{ $recolector->nombres }}</strong></dd>

            <dt class="col-sm-3">Apellidos:</dt>
            <dd class="col-sm-9"><strong>{{ $recolector->apellidos }}</strong></dd>

            <dt class="col-sm-3">CI:</dt>
            <dd class="col-sm-9">{{ $recolector->ci }}</dd>

            @if($recolector->licencia_conducir)
                <dt class="col-sm-3">Licencia de Conducir:</dt>
                <dd class="col-sm-9">{{ $recolector->licencia_conducir }}</dd>
            @endif

            @if($recolector->genero)
                <dt class="col-sm-3">Género:</dt>
                <dd class="col-sm-9">{{ $recolector->genero }}</dd>
            @endif

            <dt class="col-sm-3">Correo:</dt>
            <dd class="col-sm-9">{{ $recolector->correo }}</dd>

            @if($recolector->telefono)
                <dt class="col-sm-3">Teléfono:</dt>
                <dd class="col-sm-9">{{ $recolector->telefono }}</dd>
            @endif

            @if($recolector->direccion_domicilio)
                <dt class="col-sm-3">Dirección:</dt>
                <dd class="col-sm-9">{{ $recolector->direccion_domicilio }}</dd>
            @endif

            <dt class="col-sm-3">Estado:</dt>
            <dd class="col-sm-9">
                @if($recolector->estado === 'Activo')
                    <span class="badge badge-success badge-lg">Activo</span>
                @else
                    <span class="badge badge-secondary badge-lg">Inactivo</span>
                @endif
            </dd>

            @if($recolector->fecha_registro)
                <dt class="col-sm-3">Fecha de Registro:</dt>
                <dd class="col-sm-9">
                    {{ \Carbon\Carbon::parse($recolector->fecha_registro)->format('d/m/Y H:i') }}
                </dd>
            @endif
        </dl>
    </div>
</div>

{{-- Action Buttons --}}
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('recolectores.index') }}" class="btn btn-secondary">
            Volver al Listado
        </a>
        <a href="{{ route('recolectores.edit', $recolector->id_usuario) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar Recolector
        </a>
        <form action="{{ route('recolectores.destroy', $recolector->id_usuario) }}" method="POST"
            style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este recolector?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
    .badge-lg {
        font-size: 0.9rem;
        padding: 0.4rem 0.6rem;
    }
</style>
@stop