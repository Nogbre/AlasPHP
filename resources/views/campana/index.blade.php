@extends('adminlte::page')

@section('template_title')
    Campanas
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Campanas') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('campana.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Imagen Banner</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($campanas as $campana)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td >{{ $campana->nombre }}</td>
                                            <td >{{ $campana->descripcion }}</td>
                                            <td >{{ $campana->fecha_inicio }}</td>
                                            <td >{{ $campana->fecha_fin }}</td>
                                            <td >{{ $campana->imagen_banner }}</td>

                                            <td>
                                                <form action="{{ route('campana.destroy', $campana->id_campana) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('campana.show', $campana->id_campana) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('campana.edit', $campana->id_campana) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $campanas->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
