<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Información del Recolector</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5>¡Error de validación!</h5>
                <p>Por favor, corrige los siguientes errores antes de continuar:</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombres">Nombres <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror"
                            value="{{ old('nombres', $recolector?->nombres) }}" id="nombres" placeholder="Nombres"
                            required maxlength="100">
                        @error('nombres')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="apellidos"
                            class="form-control @error('apellidos') is-invalid @enderror"
                            value="{{ old('apellidos', $recolector?->apellidos) }}" id="apellidos"
                            placeholder="Apellidos" required maxlength="150">
                        @error('apellidos')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ci">CI <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror"
                            value="{{ old('ci', $recolector?->ci) }}" id="ci" placeholder="Carnet de Identidad" required
                            maxlength="20">
                        @error('ci')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="licencia_conducir">Licencia de Conducir</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-car"></i></span>
                        </div>
                        <input type="text" name="licencia_conducir"
                            class="form-control @error('licencia_conducir') is-invalid @enderror"
                            value="{{ old('licencia_conducir', $recolector?->licencia_conducir) }}"
                            id="licencia_conducir" placeholder="Número de licencia" maxlength="50">
                        @error('licencia_conducir')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="genero">Género</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                        </div>
                        <select name="genero" class="form-control @error('genero') is-invalid @enderror" id="genero">
                            <option value="">Seleccione un género</option>
                            <option value="Masculino" {{ old('genero', $recolector?->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('genero', $recolector?->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('genero', $recolector?->genero) == 'Otro' ? 'selected' : '' }}>
                                Otro</option>
                        </select>
                        @error('genero')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="correo">Correo Electrónico <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror"
                            value="{{ old('correo', $recolector?->correo) }}" id="correo"
                            placeholder="correo@ejemplo.com" required maxlength="100">
                        @error('correo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                            value="{{ old('telefono', $recolector?->telefono) }}" id="telefono"
                            placeholder="Teléfono de contacto" maxlength="20">
                        @error('telefono')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion_domicilio">Dirección de Domicilio</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                        </div>
                        <textarea name="direccion_domicilio"
                            class="form-control @error('direccion_domicilio') is-invalid @enderror"
                            id="direccion_domicilio" placeholder="Dirección completa"
                            rows="2">{{ old('direccion_domicilio', $recolector?->direccion_domicilio) }}</textarea>
                        @error('direccion_domicilio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="contrasena">Contraseña @if(!isset($recolector->id_usuario)) <span
                    class="text-danger">*</span> @endif</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" name="contrasena"
                            class="form-control @error('contrasena') is-invalid @enderror" id="contrasena"
                            placeholder="{{ isset($recolector->id_usuario) ? 'Dejar en blanco para mantener actual' : 'Contraseña' }}"
                            {{ !isset($recolector->id_usuario) ? 'required' : '' }}>
                        @error('contrasena')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @if(isset($recolector->id_usuario))
                        <small class="form-text text-muted">Dejar en blanco para mantener la contraseña actual</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="estado">Estado</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                        </div>
                        <select name="estado" class="form-control @error('estado') is-invalid @enderror" id="estado">
                            <option value="Activo" {{ old('estado', $recolector?->estado ?? 'Activo') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ old('estado', $recolector?->estado ?? 'Activo') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                @if(isset($recolector) && $recolector->fecha_registro)
                    <div class="form-group">
                        <label for="fecha_registro">Fecha de Registro</label>
                        <input type="text" class="form-control"
                            value="{{ \Carbon\Carbon::parse($recolector->fecha_registro)->format('d/m/Y H:i') }}" readonly>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Recolector</button>
        <a href="{{ route('recolectores.index') }}" class="btn btn-secondary float-right"><i class="fas fa-times"></i>
            Cancelar</a>
    </div>
</div>