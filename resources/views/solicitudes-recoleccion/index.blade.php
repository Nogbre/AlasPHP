@extends('adminlte::page')

@section('template_title')
    Solicitudes Recoleccions
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Solicitudes Recoleccions') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('solicitudes-recoleccions.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Id Solicitud</th>
									<th >Id Donante</th>
									<th >Id Recolector</th>
									<th >Direccion Recoleccion</th>
									<th >Fecha Programada</th>
									<th >Observaciones</th>
									<th >Estado</th>
									<th >Fecha Creacion</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudesRecoleccions as $solicitudesRecoleccion)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $solicitudesRecoleccion->id_solicitud }}</td>
										<td >{{ $solicitudesRecoleccion->id_donante }}</td>
										<td >{{ $solicitudesRecoleccion->id_recolector }}</td>
										<td >{{ $solicitudesRecoleccion->direccion_recoleccion }}</td>
										<td >{{ $solicitudesRecoleccion->fecha_programada }}</td>
										<td >{{ $solicitudesRecoleccion->observaciones }}</td>
										<td >{{ $solicitudesRecoleccion->estado }}</td>
										<td >{{ $solicitudesRecoleccion->fecha_creacion }}</td>

                                            <td>
                                                <form action="{{ route('solicitudes-recoleccions.destroy', $solicitudesRecoleccion->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('solicitudes-recoleccions.show', $solicitudesRecoleccion->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('solicitudes-recoleccions.edit', $solicitudesRecoleccion->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $solicitudesRecoleccions->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
