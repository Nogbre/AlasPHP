@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::hasSection('login_url') ? View::getSection('login_url') : config('adminlte.login_url', 'login') )
@php( $register_url = View::hasSection('register_url') ? View::getSection('register_url') : config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
@php(    $login_url = $login_url ? route($login_url) : '' )
@php(    $register_url = $register_url ? route($register_url) : '' )
@else
@php(    $login_url = $login_url ? url($login_url) : '' )
@php(    $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', 'Registrar Nueva Cuenta')

@section('auth_body')
<form action="{{ $register_url }}" method="post">
    @csrf

    {{-- Name field --}}
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}" placeholder="Nombre Completo" autofocus>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    {{-- Email field --}}
    <div class="input-group mb-3">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}" placeholder="Correo Electrónico">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    {{-- Password field --}}
    <div class="input-group mb-3">
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
            placeholder="Contraseña">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    {{-- Confirm password field --}}
    <div class="input-group mb-3">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar Contraseña">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>

    {{-- Register button --}}
    <button type="submit" class="btn btn-primary btn-block">
        <span class="fas fa-user-plus"></span>
        Registrarse
    </button>

</form>
@stop

@section('auth_footer')
<p class="my-0">
    <a href="{{ $login_url }}">
        Ya tengo una cuenta
    </a>
</p>
@stop