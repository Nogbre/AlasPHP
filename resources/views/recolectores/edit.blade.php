@extends('adminlte::page')

@section('title', 'Editar Recolector')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Editar Recolector</h1>
    </div>
    <div class="col-sm-6">
        <a class="btn btn-secondary float-right" href="{{ route('recolectores.index') }}">
            Volver al Listado
        </a>
    </div>
</div>
@stop

@section('content')
<form method="POST" action="{{ route('recolectores.update', $recolector->id_usuario) }}" role="form"
    enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    @include('recolectores.form')
</form>
@stop