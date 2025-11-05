@extends('adminlte::page')

@section('template_title')
    Registros Salidas
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Registros Salidas') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('registros-salida.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Id Salida</th>
									<th >Id Paquete</th>
									<th >Id Almacen</th>
									<th >Fecha Salida</th>
									<th >Destino</th>
									<th >Observaciones</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registrosSalidas as $registrosSalida)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $registrosSalida->id_salida }}</td>
										<td >{{ $registrosSalida->id_paquete }}</td>
										<td >{{ $registrosSalida->id_almacen }}</td>
										<td >{{ $registrosSalida->fecha_salida }}</td>
										<td >{{ $registrosSalida->destino }}</td>
										<td >{{ $registrosSalida->observaciones }}</td>

                                            <td>
                                                <form action="{{ route('registros-salida.destroy', $registrosSalida->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('registros-salida.show', $registrosSalida->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('registros-salida.edit', $registrosSalida->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $registrosSalidas->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
