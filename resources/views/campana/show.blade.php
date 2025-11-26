@extends('adminlte::page')

@section('title', 'Detalles de la Campaña')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Detalles de la Campaña</h1>
    </div>
    <div class="col-sm-6">
        <a class="btn btn-secondary float-right" href="{{ route('campana.index') }}">
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
            <span class="info-box-icon bg-info"><i class="fas fa-bullhorn"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Nombre de la Campaña</span>
                <span class="info-box-number" style="font-size: 1rem;">{{ $campana->nombre }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="far fa-calendar-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Fecha de Inicio</span>
                <span class="info-box-number"
                    style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($campana->fecha_inicio)->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="far fa-calendar-times"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Fecha de Fin</span>
                <span class="info-box-number"
                    style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($campana->fecha_fin)->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Main Information Card --}}
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Información General</h3>
        <div class="card-tools">
            <a href="{{ route('campana.edit', $campana->id_campana) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nombre:</dt>
            <dd class="col-sm-9"><strong>{{ $campana->nombre }}</strong></dd>

            <dt class="col-sm-3">Descripción:</dt>
            <dd class="col-sm-9">{{ $campana->descripcion }}</dd>

            <dt class="col-sm-3">Fecha de Inicio:</dt>
            <dd class="col-sm-9">
                {{ \Carbon\Carbon::parse($campana->fecha_inicio)->format('d/m/Y') }}
            </dd>

            <dt class="col-sm-3">Fecha de Fin:</dt>
            <dd class="col-sm-9">
                {{ \Carbon\Carbon::parse($campana->fecha_fin)->format('d/m/Y') }}
            </dd>

            <dt class="col-sm-3">Duración:</dt>
            <dd class="col-sm-9">
                @php
                    $inicio = \Carbon\Carbon::parse($campana->fecha_inicio);
                    $fin = \Carbon\Carbon::parse($campana->fecha_fin);
                    $dias = $inicio->diffInDays($fin);
                @endphp
                <span class="badge badge-info">{{ $dias }} días</span>
            </dd>

            <dt class="col-sm-3">Estado:</dt>
            <dd class="col-sm-9">
                @php
                    $now = \Carbon\Carbon::now();
                @endphp
                @if($now->lt($inicio))
                    <span class="badge badge-secondary badge-lg">
                        <i class="fas fa-clock"></i> Próxima
                    </span>
                    <br><small class="text-muted">Comienza en {{ $now->diffInDays($inicio) }} días</small>
                @elseif($now->between($inicio, $fin))
                    <span class="badge badge-success badge-lg">
                        <i class="fas fa-check-circle"></i> Activa
                    </span>
                    <br><small class="text-muted">Finaliza en {{ $now->diffInDays($fin) }} días</small>
                @else
                    <span class="badge badge-danger badge-lg">
                        <i class="fas fa-times-circle"></i> Finalizada
                    </span>
                    <br><small class="text-muted">Finalizó hace {{ $fin->diffInDays($now) }} días</small>
                @endif
            </dd>

            @if($campana->imagen_banner)
                <dt class="col-sm-3">Banner:</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-primary">
                        <i class="fas fa-image"></i> {{ $campana->imagen_banner }}
                    </span>
                </dd>
            @endif
        </dl>
    </div>
</div>

{{-- Action Buttons --}}
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('campana.index') }}" class="btn btn-secondary">
            Volver al Listado
        </a>
        <a href="{{ route('campana.edit', $campana->id_campana) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar Campaña
        </a>
        <form action="{{ route('campana.destroy', $campana->id_campana) }}" method="POST" style="display: inline;"
            onsubmit="return confirm('¿Está seguro de eliminar esta campaña?');">
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