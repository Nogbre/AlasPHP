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

        @if(isset($donante) && $donante->id_donante)
            <div class="form-group mb-2 mb20">
                <label for="id_donante" class="form-label">{{ __('Id Donante') }}</label>
                <input type="text" name="id_donante" class="form-control"
                    value="{{ old('id_donante', $donante->id_donante) }}" id="id_donante" readonly>
            </div>
        @endif
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }} <span class="text-danger">*</span></label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                value="{{ old('nombre', $donante?->nombre) }}" id="nombre" placeholder="Nombre" required
                maxlength="150">
            @error('nombre')
                <span class="invalid-feedback d-block error-message" role="alert" data-field="nombre">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="invalid-feedback d-block error-message" role="alert" data-field="nombre"
                style="display: none;">
                <strong><span class="error-text"></span></strong>
            </span>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
            <select name="tipo" class="form-control @error('tipo') is-invalid @enderror" id="tipo">
                <option value="">Seleccione un tipo</option>
                <option value="persona" {{ old('tipo', $donante?->tipo) == 'persona' ? 'selected' : '' }}>Persona</option>
                <option value="empresa" {{ old('tipo', $donante?->tipo) == 'empresa' ? 'selected' : '' }}>Empresa</option>
            </select>
            @error('tipo')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $donante?->email) }}" id="email" placeholder="Email" maxlength="100">
            @error('email')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="telefono" class="form-label">{{ __('Telefono') }}</label>
            <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                value="{{ old('telefono', $donante?->telefono) }}" id="telefono" placeholder="Telefono" maxlength="20">
            @error('telefono')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="direccion" class="form-label">{{ __('Direccion') }}</label>
            <textarea name="direccion" class="form-control @error('direccion') is-invalid @enderror" id="direccion"
                placeholder="Direccion" rows="3">{{ old('direccion', $donante?->direccion) }}</textarea>
            @error('direccion')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        @if(isset($donante) && $donante->fecha_registro)
            <div class="form-group mb-2 mb20">
                <label for="fecha_registro" class="form-label">{{ __('Fecha Registro') }}</label>
                <input type="text" name="fecha_registro" class="form-control"
                    value="{{ old('fecha_registro', $donante->fecha_registro) }}" id="fecha_registro" readonly>
            </div>
        @endif

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Validación en tiempo real para campos requeridos
        const requiredFields = {
            'nombre': {
                required: 'El campo nombre es obligatorio',
                maxlength: 'El campo nombre no puede exceder 150 caracteres'
            }
        };

        // Campos con longitud máxima
        const maxLengthFields = {
            'email': 100,
            'telefono': 20
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

        // Validar email
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Eventos para cada campo requerido
        Object.keys(requiredFields).forEach(function (fieldName) {
            const field = $('#' + fieldName);
            let hasInteracted = false;

            // Validar al perder el foco (blur)
            field.on('blur', function () {
                hasInteracted = true;
                const value = $(this).val().trim();
                const maxLength = field.attr('maxlength');

                if (!value) {
                    const message = typeof requiredFields[fieldName] === 'object'
                        ? requiredFields[fieldName].required
                        : requiredFields[fieldName];
                    showError(fieldName, message);
                } else if (maxLength && value.length > parseInt(maxLength)) {
                    const message = typeof requiredFields[fieldName] === 'object' && requiredFields[fieldName].maxlength
                        ? requiredFields[fieldName].maxlength
                        : `El campo no puede exceder ${maxLength} caracteres`;
                    showError(fieldName, message);
                } else {
                    hideError(fieldName);
                }
            });

            // Validar mientras escribe (input) - solo si ya interactuó
            field.on('input', function () {
                const value = $(this).val().trim();
                const maxLength = field.attr('maxlength');

                if (hasInteracted || value) {
                    if (!value) {
                        const message = typeof requiredFields[fieldName] === 'object'
                            ? requiredFields[fieldName].required
                            : requiredFields[fieldName];
                        showError(fieldName, message);
                    } else if (maxLength && value.length > parseInt(maxLength)) {
                        const message = typeof requiredFields[fieldName] === 'object' && requiredFields[fieldName].maxlength
                            ? requiredFields[fieldName].maxlength
                            : `El campo no puede exceder ${maxLength} caracteres`;
                        showError(fieldName, message);
                    } else {
                        hideError(fieldName);
                    }
                }
            });
        });

        // Validar email
        $('#email').on('blur', function () {
            const value = $(this).val().trim();
            if (value && !validateEmail(value)) {
                $(this).addClass('is-invalid').removeClass('is-valid');
                if (!$(this).next('.invalid-feedback').length) {
                    $(this).after('<span class="invalid-feedback d-block" role="alert"><strong>Por favor ingrese un correo electrónico válido</strong></span>');
                }
            } else if (value) {
                $(this).removeClass('is-invalid').addClass('is-valid');
                $(this).next('.invalid-feedback').remove();
            }
        });

        $('#email').on('input', function () {
            const value = $(this).val().trim();
            if (value && !validateEmail(value)) {
                $(this).addClass('is-invalid').removeClass('is-valid');
                if (!$(this).next('.invalid-feedback').length) {
                    $(this).after('<span class="invalid-feedback d-block" role="alert"><strong>Por favor ingrese un correo electrónico válido</strong></span>');
                }
            } else if (value) {
                $(this).removeClass('is-invalid').addClass('is-valid');
                $(this).next('.invalid-feedback').remove();
            }
        });

        // Validar campos con longitud máxima
        Object.keys(maxLengthFields).forEach(function (fieldName) {
            const field = $('#' + fieldName);
            const maxLength = maxLengthFields[fieldName];

            field.on('input', function () {
                const value = $(this).val();
                if (value.length > maxLength) {
                    field.addClass('is-invalid').removeClass('is-valid');
                    if (!field.next('.invalid-feedback').length) {
                        field.after(`<span class="invalid-feedback d-block" role="alert"><strong>El campo no puede exceder ${maxLength} caracteres</strong></span>`);
                    }
                } else {
                    field.removeClass('is-invalid').addClass('is-valid');
                    field.next('.invalid-feedback').remove();
                }
            });
        });

        // Validar formulario antes de enviar
        $('form').on('submit', function (e) {
            let hasErrors = false;

            Object.keys(requiredFields).forEach(function (fieldName) {
                const field = $('#' + fieldName);
                const value = field.val().trim();
                const maxLength = field.attr('maxlength');

                if (!value) {
                    const message = typeof requiredFields[fieldName] === 'object'
                        ? requiredFields[fieldName].required
                        : requiredFields[fieldName];
                    showError(fieldName, message);
                    hasErrors = true;
                } else if (maxLength && value.length > parseInt(maxLength)) {
                    const message = typeof requiredFields[fieldName] === 'object' && requiredFields[fieldName].maxlength
                        ? requiredFields[fieldName].maxlength
                        : `El campo no puede exceder ${maxLength} caracteres`;
                    showError(fieldName, message);
                    hasErrors = true;
                }
            });

            // Validar email
            const emailValue = $('#email').val().trim();
            if (emailValue && !validateEmail(emailValue)) {
                $('#email').addClass('is-invalid').removeClass('is-valid');
                if (!$('#email').next('.invalid-feedback').length) {
                    $('#email').after('<span class="invalid-feedback d-block" role="alert"><strong>Por favor ingrese un correo electrónico válido</strong></span>');
                }
                hasErrors = true;
            }

            // Validar campos opcionales con longitud máxima
            Object.keys(maxLengthFields).forEach(function (fieldName) {
                const field = $('#' + fieldName);
                const value = field.val();
                const maxLength = maxLengthFields[fieldName];

                if (value && value.length > maxLength) {
                    field.addClass('is-invalid').removeClass('is-valid');
                    if (!field.next('.invalid-feedback').length) {
                        field.after(`<span class="invalid-feedback d-block" role="alert"><strong>El campo no puede exceder ${maxLength} caracteres</strong></span>`);
                    }
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