@extends('adminlte::page')

@section('template_title')
    Espacios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Espacios') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('espacio.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        <th>Id Estante</th>
                                        <th>Codigo Espacio</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($espacios as $espacio)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                <td >{{ $espacio->id_estante }}</td>
                <td >{{ $espacio->codigo_espacio }}</td>

                                            <td>
                                                <form action="{{ route('espacio.destroy', $espacio->id_espacio) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('espacio.show', $espacio->id_espacio) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('espacio.edit', $espacio->id_espacio) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $espacios->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
