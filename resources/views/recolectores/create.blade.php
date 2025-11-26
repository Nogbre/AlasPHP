@extends('adminlte::page')

@section('title', 'Nuevo Recolector')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Nuevo Recolector</h1>
    </div>
    <div class="col-sm-6">
        <a class="btn btn-secondary float-right" href="{{ route('recolectores.index') }}">
            Volver al Listado
        </a>
    </div>
</div>
@stop

@section('content')
<form method="POST" action="{{ route('recolectores.store') }}" role="form" enctype="multipart/form-data">
    @csrf
    @include('recolectores.form')
</form>
@stop