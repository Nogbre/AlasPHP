@extends('layouts.app')

@section('template_title')
    Donantes
@endsection

@section('content')
<div class="mb-3">
    <a href="{{ route('home') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al inicio
    </a>
</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Donantes') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('donantes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Nombres</th>
									<th >Apellido Paterno</th>
									<th >Apellido Materno</th>
									<th >Correo</th>
									<th >Telefono</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donantes as $donante)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $donante->nombres }}</td>
										<td >{{ $donante->apellido_paterno }}</td>
										<td >{{ $donante->apellido_materno }}</td>
										<td >{{ $donante->correo }}</td>
										<td >{{ $donante->telefono }}</td>

                                            <td>
                                                <form action="{{ route('donantes.destroy', $donante->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('donantes.show', $donante->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('donantes.edit', $donante->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $donantes->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
