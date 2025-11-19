<div class="row padding-1 p-1">
    <div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> {{ __('¡Error de validación!') }}</h5>
                <p>{{ __('Por favor, corrige los siguientes errores antes de continuar:') }}</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-triangle mr-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(isset($paquete) && $paquete->id_paquete)
        <div class="form-group mb-2 mb20">
            <label for="id_paquete" class="form-label">{{ __('Id Paquete') }}</label>
            <input type="text" name="id_paquete" class="form-control" value="{{ old('id_paquete', $paquete->id_paquete) }}" id="id_paquete" readonly>
        </div>
        @endif
        <div class="form-group mb-2 mb20">
            <label for="codigo_paquete" class="form-label">{{ __('Codigo Paquete') }}</label>
            <input type="text" name="codigo_paquete" class="form-control @error('codigo_paquete') is-invalid @enderror" value="{{ old('codigo_paquete', $paquete?->codigo_paquete) }}" id="codigo_paquete" placeholder="Codigo Paquete">
            @error('codigo_paquete')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- Paquetes no tienen asociado id_usuario en el esquema actual --}}
        <div class="form-group mb-2 mb20">
            <label for="id_solicitud" class="form-label">{{ __('Id Solicitud') }}</label>
            <select name="id_solicitud" class="form-control @error('id_solicitud') is-invalid @enderror" id="id_solicitud">
                <option value="">Seleccione una solicitud</option>
                @foreach($solicitudes ?? [] as $solicitud)
                    <option value="{{ $solicitud->id_solicitud }}" {{ old('id_solicitud', $paquete?->id_solicitud) == $solicitud->id_solicitud ? 'selected' : '' }}>
                        Solicitud #{{ $solicitud->id_solicitud }} - {{ $solicitud->donante->nombre ?? 'N/A' }}
                    </option>
                @endforeach
            </select>
            @error('id_solicitud')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
            <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror" value="{{ old('estado', $paquete?->estado) }}" id="estado" placeholder="Estado">
            @error('estado')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="codigo_solicitud_externa" class="form-label">{{ __('Codigo Solicitud Externa') }}</label>
            <input type="text" name="codigo_solicitud_externa" class="form-control @error('codigo_solicitud_externa') is-invalid @enderror" value="{{ old('codigo_solicitud_externa', $paquete?->codigo_solicitud_externa) }}" id="codigo_solicitud_externa" placeholder="Codigo Solicitud Externa">
            @error('codigo_solicitud_externa')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        @if(isset($paquete) && $paquete->fecha_creacion)
        <div class="form-group mb-2 mb20">
            <label for="fecha_creacion" class="form-label">{{ __('Fecha Creacion') }}</label>
            <input type="text" name="fecha_creacion" class="form-control" value="{{ old('fecha_creacion', $paquete->fecha_creacion) }}" id="fecha_creacion" readonly>
        </div>
        @endif

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

<script>
$(document).ready(function() {
    // Validar formulario antes de enviar
    $('form').on('submit', function(e) {
        let hasErrors = false;
        
        // Validación básica si es necesario
        // Por ahora no hay campos requeridos según el modelo
        
        if (hasErrors) {
            e.preventDefault();
            // Mostrar alerta general
            if ($('.alert-danger').length === 0) {
                $('.card-body').prepend(
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                    '<h5><i class="icon fas fa-ban"></i> Por favor, corrige los errores antes de continuar</h5>' +
                    '</div>'
                );
            }
            // Scroll al primer error
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });
});
</script>
