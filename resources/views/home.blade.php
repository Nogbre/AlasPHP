@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1 class="text-center">Panel Principal</h1>
@stop

@section('content')
<div class="container text-center mt-5">

    <div class="row justify-content-center">
        <div class="col-md-4">
            <a href="{{ route('usuario.index') }}" class="btn btn-primary btn-lg w-100 mb-4">
                <i class="fas fa-users-cog"></i> Gestionar Usuarios
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('donante.index') }}" class="btn btn-success btn-lg w-100 mb-4">
                <i class="fas fa-hand-holding-heart"></i> Gestionar Donantes
            </a>
        </div>
    </div>

</div>
@stop
