@extends('adminlte::page')

@section('template_title')
    {{ __('Create') }} Registros Salida
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Registros Salida</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('registros-salida.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('registros-salida.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
