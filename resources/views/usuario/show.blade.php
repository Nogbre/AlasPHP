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
                            <a class="btn btn-primary btn-sm" href="{{ route('usuario.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Usuario:</strong>
                                    {{ $usuario->id_usuario }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombres:</strong>
                                    {{ $usuario->nombres }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Apellidos:</strong>
                                    {{ $usuario->apellidos }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Ci:</strong>
                                    {{ $usuario->ci }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Foto Ci:</strong>
                                    {{ $usuario->foto_ci }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Licencia Conducir:</strong>
                                    {{ $usuario->licencia_conducir }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Foto Licencia:</strong>
                                    {{ $usuario->foto_licencia }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Genero:</strong>
                                    {{ $usuario->genero }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Correo:</strong>
                                    {{ $usuario->correo }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Telefono:</strong>
                                    {{ $usuario->telefono }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Direccion Domicilio:</strong>
                                    {{ $usuario->direccion_domicilio }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Contrasena:</strong>
                                    {{ $usuario->contrasena }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado:</strong>
                                    {{ $usuario->estado }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Entidad Pertenencia:</strong>
                                    {{ $usuario->entidad_pertenencia }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tipo Sangre:</strong>
                                    {{ $usuario->tipo_sangre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Id Rol:</strong>
                                    {{ $usuario->id_rol }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Registro:</strong>
                                    {{ $usuario->fecha_registro }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
