@extends('adminlte::page')

@section('template_title')
    {{ $usuario->name ?? __('Show') . " " . __('Usuario') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Usuario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('usuarios.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombres:</strong>
                                    {{ $usuario->nombres }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Apellido Paterno:</strong>
                                    {{ $usuario->apellido_paterno }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Apellido Materno:</strong>
                                    {{ $usuario->apellido_materno }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Nacimiento:</strong>
                                    {{ $usuario->fecha_nacimiento }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Direccion Domiciliaria:</strong>
                                    {{ $usuario->direccion_domiciliaria }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Correo Electronico:</strong>
                                    {{ $usuario->correo_electronico }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Contrasena:</strong>
                                    {{ $usuario->contrasena }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Telefono:</strong>
                                    {{ $usuario->telefono }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Ci:</strong>
                                    {{ $usuario->ci }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado:</strong>
                                    {{ $usuario->estado }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Rol:</strong>
                                    {{ $usuario->rol }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
