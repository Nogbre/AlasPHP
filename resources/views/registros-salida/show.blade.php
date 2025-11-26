@extends('adminlte::page')

@section('title', 'Ver Registro de Salida')

@section('content_header')
<h1>Detalle de Salida</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Información del Registro</h3>
                        <div class="card-tools">
                            <a href="{{ route('registros-salida.index') }}" class="btn btn-default btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">Paquete:</dt>
                                    <dd class="col-sm-8">
                                        @if($registrosSalida->paquete)
                                            <a href="{{ route('paquete.show', $registrosSalida->id_paquete) }}">
                                                {{ $registrosSalida->paquete->codigo_paquete }}
                                            </a>
                                        @else
                                            <span class="text-muted">No asignado</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Fecha Salida:</dt>
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($registrosSalida->fecha_salida)->format('d/m/Y H:i') }}
                                    </dd>

                                    <dt class="col-sm-4">Destino:</dt>
                                    <dd class="col-sm-8">{{ $registrosSalida->destino }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">Observaciones:</dt>
                                    <dd class="col-sm-8">{{ $registrosSalida->observaciones ?: 'Sin observaciones' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('registros-salida.edit', $registrosSalida->id_salida) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop