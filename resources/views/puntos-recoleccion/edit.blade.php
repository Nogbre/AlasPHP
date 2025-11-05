@extends('adminlte::page')

@section('template_title')
    {{ __('Update') }} Puntos Recoleccion
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Puntos Recoleccion</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('puntos-recoleccion.update', $puntosRecoleccion->id_punto) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('puntos-recoleccion.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
