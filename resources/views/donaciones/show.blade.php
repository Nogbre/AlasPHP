@extends('adminlte::page')

@section('template_title')
    {{ $donacion->id_donacion ?? __('Show') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Donación</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('donaciones.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20"><strong>Id Donación:</strong> {{ $donacion->id_donacion }}</div>
                        <div class="form-group mb-2 mb20"><strong>Donante:</strong> {{ $donacion->donante->nombre ?? 'N/A' }}</div>
                        <div class="form-group mb-2 mb20"><strong>Tipo:</strong> {{ $donacion->tipo }}</div>
                        <div class="form-group mb-2 mb20"><strong>Observaciones:</strong> {{ $donacion->observaciones }}</div>
                        <div class="form-group mb-2 mb20"><strong>Fecha:</strong> {{ $donacion->fecha }}</div>

                        @if($donacion->dinero)
                            <hr>
                            <div class="form-group mb-2 mb20"><strong>Monto:</strong> {{ $donacion->dinero->monto }}</div>
                            <div class="form-group mb-2 mb20"><strong>Método Pago:</strong> {{ $donacion->dinero->metodo_pago }}</div>
                        @endif

                        @if($donacion->detalles && $donacion->detalles->count())
                            <hr>
                            <h5>Detalles</h5>
                            <table class="table table-striped">
                                <thead><tr><th>Producto</th><th>Cantidad</th><th>Espacio</th></tr></thead>
                                <tbody>
                                    @foreach($donacion->detalles as $det)
                                        <tr>
                                            <td>{{ $det->producto->nombre ?? 'N/A' }}</td>
                                            <td>{{ $det->cantidad }}</td>
                                            <td>{{ $det->ubicaciones->first()->espacio->codigo_espacio ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
