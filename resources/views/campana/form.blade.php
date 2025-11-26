<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-bullhorn"></i> Información de la Campaña</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nombre">Nombre de la Campaña <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-heading"></i></span>
                        </div>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre', $campana?->nombre) }}" id="nombre"
                            placeholder="Ingrese el nombre de la campaña" required>
                        @error('nombre')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                        </div>
                        <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                            id="descripcion" rows="3" placeholder="Describa el objetivo de la campaña"
                            required>{{ old('descripcion', $campana?->descripcion) }}</textarea>
                        @error('descripcion')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="date" name="fecha_inicio"
                            class="form-control @error('fecha_inicio') is-invalid @enderror"
                            value="{{ old('fecha_inicio', $campana?->fecha_inicio) }}" id="fecha_inicio" required>
                        @error('fecha_inicio')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha_fin">Fecha de Fin <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-times"></i></span>
                        </div>
                        <input type="date" name="fecha_fin"
                            class="form-control @error('fecha_fin') is-invalid @enderror"
                            value="{{ old('fecha_fin', $campana?->fecha_fin) }}" id="fecha_fin" required>
                        @error('fecha_fin')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="imagen_banner">URL Imagen Banner (Opcional)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                        </div>
                        <input type="text" name="imagen_banner"
                            class="form-control @error('imagen_banner') is-invalid @enderror"
                            value="{{ old('imagen_banner', $campana?->imagen_banner) }}" id="imagen_banner"
                            placeholder="https://ejemplo.com/imagen.jpg">
                        @error('imagen_banner')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Campaña</button>
        <a href="{{ route('campana.index') }}" class="btn btn-secondary float-right"><i class="fas fa-times"></i>
            Cancelar</a>
    </div>
</div>