<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Información de la Solicitud</h3>
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
                    <label for="id_donante">Donante <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <select name="id_donante" class="form-control @error('id_donante') is-invalid @enderror"
                            id="id_donante" required>
                            <option value="">Seleccione un donante</option>
                            @foreach($donantes ?? [] as $donante)
                                <option value="{{ $donante->id_donante }}" {{ old('id_donante', $solicitudesRecoleccion?->id_donante) == $donante->id_donante ? 'selected' : '' }}>
                                    {{ $donante->nombre }} ({{ $donante->tipo ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_donante')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_recolector">Recolector</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <select name="id_recolector" class="form-control @error('id_recolector') is-invalid @enderror"
                            id="id_recolector">
                            <option value="">Seleccione un recolector</option>
                            @foreach($usuarios ?? [] as $usuario)
                                <option value="{{ $usuario->id_usuario }}" {{ old('id_recolector', $solicitudesRecoleccion?->id_recolector) == $usuario->id_usuario ? 'selected' : '' }}>
                                    {{ $usuario->nombres }} {{ $usuario->apellidos }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_recolector')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_programada">Fecha Programada <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="datetime-local" name="fecha_programada"
                            class="form-control @error('fecha_programada') is-invalid @enderror"
                            value="{{ old('fecha_programada', $solicitudesRecoleccion?->fecha_programada ? \Carbon\Carbon::parse($solicitudesRecoleccion->fecha_programada)->format('Y-m-d\TH:i') : '') }}"
                            id="fecha_programada" required>
                        @error('fecha_programada')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="estado">Estado</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                        </div>
                        <select name="estado" class="form-control @error('estado') is-invalid @enderror" id="estado">
                            <option value="">Seleccione un estado</option>
                            <option value="pendiente" {{ old('estado', $solicitudesRecoleccion?->estado ?? 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_proceso" {{ old('estado', $solicitudesRecoleccion?->estado ?? 'pendiente') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="completada" {{ old('estado', $solicitudesRecoleccion?->estado ?? 'pendiente') == 'completada' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelada" {{ old('estado', $solicitudesRecoleccion?->estado ?? 'pendiente') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('estado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="direccion_recoleccion">Dirección de Recolección <span
                            class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <textarea name="direccion_recoleccion"
                            class="form-control @error('direccion_recoleccion') is-invalid @enderror"
                            id="direccion_recoleccion" placeholder="Dirección completa de recolección" rows="3"
                            required>{{ old('direccion_recoleccion', $solicitudesRecoleccion?->direccion_recoleccion) }}</textarea>
                        @error('direccion_recoleccion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-comment"></i></span>
                        </div>
                        <textarea name="observaciones" class="form-control @error('observaciones') is-invalid @enderror"
                            id="observaciones" placeholder="Observaciones adicionales"
                            rows="3">{{ old('observaciones', $solicitudesRecoleccion?->observaciones) }}</textarea>
                        @error('observaciones')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                @if(isset($solicitudesRecoleccion) && $solicitudesRecoleccion->fecha_creacion)
                    <div class="form-group">
                        <label for="fecha_creacion">Fecha de Creación</label>
                        <input type="text" name="fecha_creacion" class="form-control"
                            value="{{ \Carbon\Carbon::parse($solicitudesRecoleccion->fecha_creacion)->format('d/m/Y H:i') }}"
                            id="fecha_creacion" readonly>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Solicitud</button>
        <a href="{{ route('solicitudes-recoleccions.index') }}" class="btn btn-secondary float-right"><i
                class="fas fa-times"></i> Cancelar</a>
    </div>
</div>

<script>
    $(document).ready(function () {
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
        Object.keys(requiredFields).forEach(function (fieldName) {
            const field = $('#' + fieldName);
            let hasInteracted = false;

            // Validar al perder el foco (blur)
            field.on('blur change', function () {
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
                field.on('change', function () {
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
                field.on('input', function () {
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
        $('form').on('submit', function (e) {
            let hasErrors = false;

            Object.keys(requiredFields).forEach(function (fieldName) {
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