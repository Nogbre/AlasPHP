@extends('adminlte::page')

@section('template_title')
    Donaciones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">{{ __('Donaciones') }}</span>
                            <div class="float-right">
                                <a href="{{ route('donaciones.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">{{ __('Create New') }}</a>
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
                                        <th>Id Donacion</th>
                                        <th>Donante</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donaciones as $donacion)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $donacion->id_donacion }}</td>
                                            <td>{{ $donacion->donante->nombre ?? 'N/A' }}</td>
                                            <td>{{ $donacion->tipo }}</td>
                                            <td>{{ $donacion->fecha }}</td>
                                            <td>
                                                <form action="{{ route('donaciones.destroy', $donacion->id_donacion) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('donaciones.show', $donacion->id_donacion) }}">{{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('donaciones.edit', $donacion->id_donacion) }}">{{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">{{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $donaciones->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
