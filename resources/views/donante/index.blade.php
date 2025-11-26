@extends('adminlte::page')

@section('template_title')
    Donantes
@endsection

@section('content')
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
                                <a href="{{ route('donante.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
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

                                        <th>Id Donante</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Direccion</th>
                                        <th>Fecha Registro</th>
                                        <th>Deleted By</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donantes as $donante)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $donante->id_donante }}</td>
                                            <td>{{ $donante->nombre }}</td>
                                            <td>{{ $donante->tipo }}</td>
                                            <td>{{ $donante->email }}</td>
                                            <td>{{ $donante->telefono }}</td>
                                            <td>{{ $donante->direccion }}</td>
                                            <td>{{ $donante->fecha_registro }}</td>
                                            <td>{{ $donante->deleted_by }}</td>

                                            <td>
                                                <form action="{{ route('donante.destroy', $donante->id_donante) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('donante.show', $donante->id_donante) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('donante.edit', $donante->id_donante) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;"><i
                                                            class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
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