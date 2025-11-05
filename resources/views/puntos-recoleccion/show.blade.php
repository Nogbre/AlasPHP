@extends('adminlte::page')

@section('template_title')
    {{ $puntosRecoleccion->name ?? __('Show') . " " . __('Puntos Recoleccion') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Puntos Recoleccion</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('puntos-recoleccion.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $puntosRecoleccion->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Direccion:</strong>
                                    {{ $puntosRecoleccion->direccion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Contacto:</strong>
                                    {{ $puntosRecoleccion->contacto }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
