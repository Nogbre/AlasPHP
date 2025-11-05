@extends('adminlte::page')

@section('template_title')
    {{ $solicitudesRecoleccion->name ?? __('Show') . " " . __('Solicitudes Recoleccion') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Solicitudes Recoleccion</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('solicitudes-recoleccions.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Solicitud:</strong>
                                    {{ $solicitudesRecoleccion->id_solicitud }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Donante:</strong>
                                    {{ $solicitudesRecoleccion->id_donante }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Recolector:</strong>
                                    {{ $solicitudesRecoleccion->id_recolector }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Direccion Recoleccion:</strong>
                                    {{ $solicitudesRecoleccion->direccion_recoleccion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Programada:</strong>
                                    {{ $solicitudesRecoleccion->fecha_programada }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Observaciones:</strong>
                                    {{ $solicitudesRecoleccion->observaciones }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado:</strong>
                                    {{ $solicitudesRecoleccion->estado }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Creacion:</strong>
                                    {{ $solicitudesRecoleccion->fecha_creacion }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
