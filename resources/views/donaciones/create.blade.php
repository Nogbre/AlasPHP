@extends('adminlte::page')

@section('template_title')
    Create Donacione
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create Donación') }}</span>
                    </div>
                    <form method="POST" action="{{ route('donaciones.store') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            @include('donaciones.form')
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Guardar Donación') }}</button>
                            <a href="{{ route('donaciones.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> {{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
