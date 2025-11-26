@extends('adminlte::page')

@section('template_title')
    {{ $donante->name ?? __('Show') . " " . __('Donante') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Donante</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('donante.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                        <div class="form-group mb-2 mb20">
                            <strong>Id Donante:</strong>
                            {{ $donante->id_donante }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $donante->nombre }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo:</strong>
                            {{ $donante->tipo }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Email:</strong>
                            {{ $donante->email }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Telefono:</strong>
                            {{ $donante->telefono }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Direccion:</strong>
                            {{ $donante->direccion }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha Registro:</strong>
                            {{ $donante->fecha_registro }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Deleted By:</strong>
                            {{ $donante->deleted_by }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection