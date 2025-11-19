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
        
        @if(isset($registrosSalida) && $registrosSalida->id_salida)
        <div class="form-group mb-2 mb20">
            <label for="id_salida" class="form-label">{{ __('Id Salida') }}</label>
            <input type="text" name="id_salida" class="form-control" value="{{ old('id_salida', $registrosSalida->id_salida) }}" id="id_salida" readonly>
        </div>
        @endif
        <div class="form-group mb-2 mb20">
            <label for="id_paquete" class="form-label">{{ __('Id Paquete') }}</label>
            <select name="id_paquete" class="form-control @error('id_paquete') is-invalid @enderror" id="id_paquete">
                <option value="">Seleccione un paquete</option>
                @foreach($paquetes ?? [] as $paquete)
                    <option value="{{ $paquete->id_paquete }}" {{ old('id_paquete', $registrosSalida?->id_paquete) == $paquete->id_paquete ? 'selected' : '' }}>
                        Paquete #{{ $paquete->id_paquete }} - {{ $paquete->codigo_paquete ?? 'Sin código' }}
                    </option>
                @endforeach
            </select>
            @error('id_paquete')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <div class="form-group mb-2 mb20">
            <label for="fecha_salida" class="form-label">{{ __('Fecha Salida') }}</label>
            <input type="datetime-local" name="fecha_salida" class="form-control @error('fecha_salida') is-invalid @enderror" value="{{ old('fecha_salida', $registrosSalida?->fecha_salida ? \Carbon\Carbon::parse($registrosSalida->fecha_salida)->format('Y-m-d\TH:i') : '') }}" id="fecha_salida">
            @error('fecha_salida')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="destino" class="form-label">{{ __('Destino') }}</label>
            <input type="text" name="destino" class="form-control @error('destino') is-invalid @enderror" value="{{ old('destino', $registrosSalida?->destino) }}" id="destino" placeholder="Destino">
            @error('destino')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="observaciones" class="form-label">{{ __('Observaciones') }}</label>
            <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" placeholder="Observaciones" rows="3">{{ old('observaciones', $registrosSalida?->observaciones) }}</textarea>
            @error('observaciones')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

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
