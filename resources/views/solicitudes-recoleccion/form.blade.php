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
        
        @if(isset($solicitudesRecoleccion) && $solicitudesRecoleccion->id_solicitud)
        <div class="form-group mb-2 mb20">
            <label for="id_solicitud" class="form-label">{{ __('Id Solicitud') }}</label>
            <input type="text" name="id_solicitud" class="form-control" value="{{ old('id_solicitud', $solicitudesRecoleccion->id_solicitud) }}" id="id_solicitud" readonly>
        </div>
        @endif
        <div class="form-group mb-2 mb20">
            <label for="id_donante" class="form-label">{{ __('Id Donante') }} <span class="text-danger">*</span></label>
            <select name="id_donante" class="form-control @error('id_donante') is-invalid @enderror" id="id_donante" required>
                <option value="">Seleccione un donante</option>
                @foreach($donantes ?? [] as $donante)
                    <option value="{{ $donante->id_donante }}" {{ old('id_donante', $solicitudesRecoleccion?->id_donante) == $donante->id_donante ? 'selected' : '' }}>
                        {{ $donante->nombre }} ({{ $donante->tipo ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
            @error('id_donante')
                <span class="invalid-feedback d-block error-message" role="alert" data-field="id_donante">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="invalid-feedback d-block error-message" role="alert" data-field="id_donante" style="display: none;">
                <strong><span class="error-text"></span></strong>
            </span>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_recolector" class="form-label">{{ __('Id Recolector') }}</label>
            <select name="id_recolector" class="form-control @error('id_recolector') is-invalid @enderror" id="id_recolector">
                <option value="">Seleccione un recolector</option>
                @foreach($usuarios ?? [] as $usuario)
                    <option value="{{ $usuario->id_usuario }}" {{ old('id_recolector', $solicitudesRecoleccion?->id_recolector) == $usuario->id_usuario ? 'selected' : '' }}>
                        {{ $usuario->nombres }} {{ $usuario->apellidos }}
                    </option>
                @endforeach
            </select>
            @error('id_recolector')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="direccion_recoleccion" class="form-label">{{ __('Direccion Recoleccion') }} <span class="text-danger">*</span></label>
            <textarea name="direccion_recoleccion" class="form-control @error('direccion_recoleccion') is-invalid @enderror" id="direccion_recoleccion" placeholder="Direccion Recoleccion" rows="3" required>{{ old('direccion_recoleccion', $solicitudesRecoleccion?->direccion_recoleccion) }}</textarea>
            @error('direccion_recoleccion')
                <span class="invalid-feedback d-block error-message" role="alert" data-field="direccion_recoleccion">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="invalid-feedback d-block error-message" role="alert" data-field="direccion_recoleccion" style="display: none;">
                <strong><span class="error-text"></span></strong>
            </span>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="fecha_programada" class="form-label">{{ __('Fecha Programada') }} <span class="text-danger">*</span></label>
            <input type="datetime-local" name="fecha_programada" class="form-control @error('fecha_programada') is-invalid @enderror" value="{{ old('fecha_programada', $solicitudesRecoleccion?->fecha_programada ? \Carbon\Carbon::parse($solicitudesRecoleccion->fecha_programada)->format('Y-m-d\TH:i') : '') }}" id="fecha_programada" required>
            @error('fecha_programada')
                <span class="invalid-feedback d-block error-message" role="alert" data-field="fecha_programada">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="invalid-feedback d-block error-message" role="alert" data-field="fecha_programada" style="display: none;">
                <strong><span class="error-text"></span></strong>
            </span>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="observaciones" class="form-label">{{ __('Observaciones') }}</label>
            <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" placeholder="Observaciones" rows="3">{{ old('observaciones', $solicitudesRecoleccion?->observaciones) }}</textarea>
            @error('observaciones')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
            <select name="estado" class="form-control @error('estado') is-invalid @enderror" id="estado">
                <option value="">Seleccione un estado</option>
                <option value="pendiente" {{ old('estado', $solicitudesRecoleccion?->estado ?? 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_proceso" {{ old('estado', $solicitudesRecoleccion?->estado ?? 'pendiente') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                <option value="completada" {{ old('estado', $solicitudesRecoleccion?->estado ?? 'pendiente') == 'completada' ? 'selected' : '' }}>Completada</option>
                <option value="cancelada" {{ old('estado', $solicitudesRecoleccion?->estado ?? 'pendiente') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
            @error('estado')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        @if(isset($solicitudesRecoleccion) && $solicitudesRecoleccion->fecha_creacion)
        <div class="form-group mb-2 mb20">
            <label for="fecha_creacion" class="form-label">{{ __('Fecha Creacion') }}</label>
            <input type="text" name="fecha_creacion" class="form-control" value="{{ old('fecha_creacion', $solicitudesRecoleccion->fecha_creacion) }}" id="fecha_creacion" readonly>
        </div>
        @endif

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

<script>
$(document).ready(function() {
    // Validación en tiempo real para campos requeridos
    const requiredFields = {
        'id_donante': 'El campo donante es obligatorio',
        'direccion_recoleccion': 'El campo dirección de recolección es obligatorio',
        'fecha_programada': 'El campo fecha programada es obligatorio'
    };

    // Función para mostrar error
    function showError(fieldName, message) {
        const field = $('#' + fieldName);
        const errorSpan = $(`.error-message[data-field="${fieldName}"]`);
        
        field.addClass('is-invalid').removeClass('is-valid');
        errorSpan.find('.error-text').text(message);
        errorSpan.show();
    }

    // Función para ocultar error
    function hideError(fieldName) {
        const field = $('#' + fieldName);
        const errorSpan = $(`.error-message[data-field="${fieldName}"]`);
        
        field.removeClass('is-invalid').addClass('is-valid');
        errorSpan.hide();
    }

    // Eventos para cada campo requerido
    Object.keys(requiredFields).forEach(function(fieldName) {
        const field = $('#' + fieldName);
        let hasInteracted = false;
        
        // Validar al perder el foco (blur)
        field.on('blur change', function() {
            hasInteracted = true;
            let value;
            
            if (field.is('select')) {
                value = field.val();
            } else {
                value = field.val().trim();
            }
            
            if (!value) {
                showError(fieldName, requiredFields[fieldName]);
            } else {
                hideError(fieldName);
            }
        });

        // Validar mientras cambia (para select)
        if (field.is('select')) {
            field.on('change', function() {
                const value = field.val();
                if (hasInteracted || value) {
                    if (!value) {
                        showError(fieldName, requiredFields[fieldName]);
                    } else {
                        hideError(fieldName);
                    }
                }
            });
        } else {
            // Validar mientras escribe (input) - solo si ya interactuó
            field.on('input', function() {
                const value = $(this).val().trim();
                
                if (hasInteracted || value) {
                    if (!value) {
                        showError(fieldName, requiredFields[fieldName]);
                    } else {
                        hideError(fieldName);
                    }
                }
            });
        }
    });

    // Validar formulario antes de enviar
    $('form').on('submit', function(e) {
        let hasErrors = false;
        
        Object.keys(requiredFields).forEach(function(fieldName) {
            const field = $('#' + fieldName);
            let value;
            
            if (field.is('select')) {
                value = field.val();
            } else {
                value = field.val().trim();
            }
            
            if (!value) {
                showError(fieldName, requiredFields[fieldName]);
                hasErrors = true;
            }
        });
        
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
