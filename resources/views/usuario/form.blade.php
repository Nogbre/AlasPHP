<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="id_usuario" class="form-label">{{ __('Id Usuario') }}</label>
            <input type="text" name="id_usuario" class="form-control @error('id_usuario') is-invalid @enderror" value="{{ old('id_usuario', $usuario?->id_usuario) }}" id="id_usuario" placeholder="Id Usuario">
            {!! $errors->first('id_usuario', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nombres" class="form-label">{{ __('Nombres') }}</label>
            <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres', $usuario?->nombres) }}" id="nombres" placeholder="Nombres">
            {!! $errors->first('nombres', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="apellidos" class="form-label">{{ __('Apellidos') }}</label>
            <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $usuario?->apellidos) }}" id="apellidos" placeholder="Apellidos">
            {!! $errors->first('apellidos', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="ci" class="form-label">{{ __('Ci') }}</label>
            <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror" value="{{ old('ci', $usuario?->ci) }}" id="ci" placeholder="Ci">
            {!! $errors->first('ci', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="foto_ci" class="form-label">{{ __('Foto Ci') }}</label>
            <input type="text" name="foto_ci" class="form-control @error('foto_ci') is-invalid @enderror" value="{{ old('foto_ci', $usuario?->foto_ci) }}" id="foto_ci" placeholder="Foto Ci">
            {!! $errors->first('foto_ci', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="licencia_conducir" class="form-label">{{ __('Licencia Conducir') }}</label>
            <input type="text" name="licencia_conducir" class="form-control @error('licencia_conducir') is-invalid @enderror" value="{{ old('licencia_conducir', $usuario?->licencia_conducir) }}" id="licencia_conducir" placeholder="Licencia Conducir">
            {!! $errors->first('licencia_conducir', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="foto_licencia" class="form-label">{{ __('Foto Licencia') }}</label>
            <input type="text" name="foto_licencia" class="form-control @error('foto_licencia') is-invalid @enderror" value="{{ old('foto_licencia', $usuario?->foto_licencia) }}" id="foto_licencia" placeholder="Foto Licencia">
            {!! $errors->first('foto_licencia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="genero" class="form-label">{{ __('Genero') }}</label>
            <input type="text" name="genero" class="form-control @error('genero') is-invalid @enderror" value="{{ old('genero', $usuario?->genero) }}" id="genero" placeholder="Genero">
            {!! $errors->first('genero', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="correo" class="form-label">{{ __('Correo') }}</label>
            <input type="text" name="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo', $usuario?->correo) }}" id="correo" placeholder="Correo">
            {!! $errors->first('correo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="telefono" class="form-label">{{ __('Telefono') }}</label>
            <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $usuario?->telefono) }}" id="telefono" placeholder="Telefono">
            {!! $errors->first('telefono', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="direccion_domicilio" class="form-label">{{ __('Direccion Domicilio') }}</label>
            <input type="text" name="direccion_domicilio" class="form-control @error('direccion_domicilio') is-invalid @enderror" value="{{ old('direccion_domicilio', $usuario?->direccion_domicilio) }}" id="direccion_domicilio" placeholder="Direccion Domicilio">
            {!! $errors->first('direccion_domicilio', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="contrasena" class="form-label">{{ __('Contrasena') }}</label>
            <input type="text" name="contrasena" class="form-control @error('contrasena') is-invalid @enderror" value="{{ old('contrasena', $usuario?->contrasena) }}" id="contrasena" placeholder="Contrasena">
            {!! $errors->first('contrasena', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
            <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror" value="{{ old('estado', $usuario?->estado) }}" id="estado" placeholder="Estado">
            {!! $errors->first('estado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="entidad_pertenencia" class="form-label">{{ __('Entidad Pertenencia') }}</label>
            <input type="text" name="entidad_pertenencia" class="form-control @error('entidad_pertenencia') is-invalid @enderror" value="{{ old('entidad_pertenencia', $usuario?->entidad_pertenencia) }}" id="entidad_pertenencia" placeholder="Entidad Pertenencia">
            {!! $errors->first('entidad_pertenencia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tipo_sangre" class="form-label">{{ __('Tipo Sangre') }}</label>
            <input type="text" name="tipo_sangre" class="form-control @error('tipo_sangre') is-invalid @enderror" value="{{ old('tipo_sangre', $usuario?->tipo_sangre) }}" id="tipo_sangre" placeholder="Tipo Sangre">
            {!! $errors->first('tipo_sangre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_rol" class="form-label">{{ __('Id Rol') }}</label>
            <input type="text" name="id_rol" class="form-control @error('id_rol') is-invalid @enderror" value="{{ old('id_rol', $usuario?->id_rol) }}" id="id_rol" placeholder="Id Rol">
            {!! $errors->first('id_rol', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_registro" class="form-label">{{ __('Fecha Registro') }}</label>
            <input type="text" name="fecha_registro" class="form-control @error('fecha_registro') is-invalid @enderror" value="{{ old('fecha_registro', $usuario?->fecha_registro) }}" id="fecha_registro" placeholder="Fecha Registro">
            {!! $errors->first('fecha_registro', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>