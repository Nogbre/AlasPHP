@extends('layouts.app')

@section('template_title')
    Usuarios
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Usuarios') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
									<th >Id Usuario</th>
									<th >Nombres</th>
									<th >Apellidos</th>
									<th >Ci</th>
									<th >Foto Ci</th>
									<th >Licencia Conducir</th>
									<th >Foto Licencia</th>
									<th >Genero</th>
									<th >Correo</th>
									<th >Telefono</th>
									<th >Direccion Domicilio</th>
									<th >Contrasena</th>
									<th >Estado</th>
									<th >Entidad Pertenencia</th>
									<th >Tipo Sangre</th>
									<th >Id Rol</th>
									<th >Fecha Registro</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $usuario->id_usuario }}</td>
										<td >{{ $usuario->nombres }}</td>
										<td >{{ $usuario->apellidos }}</td>
										<td >{{ $usuario->ci }}</td>
										<td >{{ $usuario->foto_ci }}</td>
										<td >{{ $usuario->licencia_conducir }}</td>
										<td >{{ $usuario->foto_licencia }}</td>
										<td >{{ $usuario->genero }}</td>
										<td >{{ $usuario->correo }}</td>
										<td >{{ $usuario->telefono }}</td>
										<td >{{ $usuario->direccion_domicilio }}</td>
										<td >{{ $usuario->contrasena }}</td>
										<td >{{ $usuario->estado }}</td>
										<td >{{ $usuario->entidad_pertenencia }}</td>
										<td >{{ $usuario->tipo_sangre }}</td>
										<td >{{ $usuario->id_rol }}</td>
										<td >{{ $usuario->fecha_registro }}</td>

                                            <td>
                                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('usuarios.show', $usuario->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('usuarios.edit', $usuario->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
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
                {!! $usuarios->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection
