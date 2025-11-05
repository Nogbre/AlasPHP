@extends('adminlte::page')

@section('template_title')
    Estantes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Estantes') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('estante.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Id Almacen</th>
                                        <th>Codigo Estante</th>
                                        <th>Descripcion</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estantes as $estante)
                                        <tr>
                                            <td>{{ ++$i }}</td>
				<td >{{ $estante->id_almacen }}</td>
				<td >{{ $estante->codigo_estante }}</td>
				<td >{{ $estante->descripcion }}</td>

                                            <td>
                                                <form action="{{ route('estante.destroy', $estante->id_estante) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('estante.show', $estante->id_estante) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('estante.edit', $estante->id_estante) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $estantes->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
