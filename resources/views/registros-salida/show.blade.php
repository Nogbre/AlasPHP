@extends('adminlte::page')

@section('template_title')
    {{ $registrosSalida->name ?? __('Show') . " " . __('Registros Salida') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Registros Salida</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('registros-salida.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Salida:</strong>
                                    {{ $registrosSalida->id_salida }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Paquete:</strong>
                                    {{ $registrosSalida->id_paquete }}
                                </div>
                                
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Salida:</strong>
                                    {{ $registrosSalida->fecha_salida }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Destino:</strong>
                                    {{ $registrosSalida->destino }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Observaciones:</strong>
                                    {{ $registrosSalida->observaciones }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
