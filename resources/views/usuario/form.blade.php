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
        
        @if(isset($usuario) && $usuario->id_usuario)
        <div class="form-group mb-2 mb20">
            <label for="id_usuario" class="form-label">{{ __('Id Usuario') }}</label>
            <input type="text" name="id_usuario" class="form-control" value="{{ old('id_usuario', $usuario->id_usuario) }}" id="id_usuario" readonly>
        </div>
        @endif
        <div class="form-group mb-2 mb20">
            <label for="nombres" class="form-label">{{ __('Nombres') }} <span class="text-danger">*</span></label>
            <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres', $usuario?->nombres) }}" id="nombres" placeholder="Nombres" required maxlength="100">
            @error('nombres')
                <span class="invalid-feedback d-block error-message" role="alert" data-field="nombres">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="invalid-feedback d-block error-message" role="alert" data-field="nombres" style="display: none;">
                <strong><span class="error-text"></span></strong>
            </span>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="apellidos" class="form-label">{{ __('Apellidos') }} <span class="text-danger">*</span></label>
            <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $usuario?->apellidos) }}" id="apellidos" placeholder="Apellidos" required maxlength="150">
            @error('apellidos')
                <span class="invalid-feedback d-block error-message" role="alert" data-field="apellidos">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="invalid-feedback d-block error-message" role="alert" data-field="apellidos" style="display: none;">
                <strong><span class="error-text"></span></strong>
            </span>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="ci" class="form-label">{{ __('Ci') }} <span class="text-danger">*</span></label>
            <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror" value="{{ old('ci', $usuario?->ci) }}" id="ci" placeholder="Ci" required maxlength="20">
            @error('ci')
                <span class="invalid-feedback d-block error-message" role="alert" data-field="ci">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="invalid-feedback d-block error-message" role="alert" data-field="ci" style="display: none;">
                <strong><span class="error-text"></span></strong>
            </span>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="foto_ci" class="form-label">{{ __('Foto Ci') }}</label>
            <input type="text" name="foto_ci" class="form-control @error('foto_ci') is-invalid @enderror" value="{{ old('foto_ci', $usuario?->foto_ci) }}" id="foto_ci" placeholder="Foto Ci">
            @error('foto_ci')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="licencia_conducir" class="form-label">{{ __('Licencia Conducir') }}</label>
            <input type="text" name="licencia_conducir" class="form-control @error('licencia_conducir') is-invalid @enderror" value="{{ old('licencia_conducir', $usuario?->licencia_conducir) }}" id="licencia_conducir" placeholder="Licencia Conducir" maxlength="50">
            @error('licencia_conducir')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="foto_licencia" class="form-label">{{ __('Foto Licencia') }}</label>
            <input type="text" name="foto_licencia" class="form-control @error('foto_licencia') is-invalid @enderror" value="{{ old('foto_licencia', $usuario?->foto_licencia) }}" id="foto_licencia" placeholder="Foto Licencia">
            @error('foto_licencia')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="genero" class="form-label">{{ __('Genero') }}</label>
            <select name="genero" class="form-control @error('genero') is-invalid @enderror" id="genero">
                <option value="">Seleccione un género</option>
                <option value="Masculino" {{ old('genero', $usuario?->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Femenino" {{ old('genero', $usuario?->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="Otro" {{ old('genero', $usuario?->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('genero')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="correo" class="form-label">{{ __('Correo') }} <span class="text-danger">*</span></label>
            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo', $usuario?->correo) }}" id="correo" placeholder="Correo" required maxlength="100">
            @error('correo')
                <span class="invalid-feedback d-block error-message" role="alert" data-field="correo">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="invalid-feedback d-block error-message" role="alert" data-field="correo" style="display: none;">
                <strong><span class="error-text"></span></strong>
            </span>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="telefono" class="form-label">{{ __('Telefono') }}</label>
            <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $usuario?->telefono) }}" id="telefono" placeholder="Telefono" maxlength="20">
            @error('telefono')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="direccion_domicilio" class="form-label">{{ __('Direccion Domicilio') }}</label>
            <input type="text" name="direccion_domicilio" class="form-control @error('direccion_domicilio') is-invalid @enderror" value="{{ old('direccion_domicilio', $usuario?->direccion_domicilio) }}" id="direccion_domicilio" placeholder="Direccion Domicilio">
            @error('direccion_domicilio')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="contrasena" class="form-label">{{ __('Contrasena') }} <span class="text-danger">*</span></label>
            <input type="password" name="contrasena" class="form-control @error('contrasena') is-invalid @enderror" value="{{ old('contrasena') }}" id="contrasena" placeholder="Contrasena" required>
            @error('contrasena')
                <span class="invalid-feedback d-block error-message" role="alert" data-field="contrasena">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="invalid-feedback d-block error-message" role="alert" data-field="contrasena" style="display: none;">
                <strong><span class="error-text"></span></strong>
            </span>
        </div>
        <div class="form-group mb-2 mb20">
            <label for="estado" class="form-label">{{ __('Estado') }}</label>
            <select name="estado" class="form-control @error('estado') is-invalid @enderror" id="estado">
                <option value="">Seleccione un estado</option>
                <option value="Activo" {{ old('estado', $usuario?->estado ?? 'Activo') == 'Activo' ? 'selected' : '' }}>Activo</option>
                <option value="Inactivo" {{ old('estado', $usuario?->estado ?? 'Activo') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="entidad_pertenencia" class="form-label">{{ __('Entidad Pertenencia') }}</label>
            <input type="text" name="entidad_pertenencia" class="form-control @error('entidad_pertenencia') is-invalid @enderror" value="{{ old('entidad_pertenencia', $usuario?->entidad_pertenencia) }}" id="entidad_pertenencia" placeholder="Entidad Pertenencia" maxlength="150">
            @error('entidad_pertenencia')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tipo_sangre" class="form-label">{{ __('Tipo Sangre') }}</label>
            <input type="text" name="tipo_sangre" class="form-control @error('tipo_sangre') is-invalid @enderror" value="{{ old('tipo_sangre', $usuario?->tipo_sangre) }}" id="tipo_sangre" placeholder="Tipo Sangre" maxlength="5">
            @error('tipo_sangre')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2 mb20">
            <label for="id_rol" class="form-label">{{ __('Id Rol') }}</label>
            <input type="text" name="id_rol" class="form-control @error('id_rol') is-invalid @enderror" value="{{ old('id_rol', $usuario?->id_rol) }}" id="id_rol" placeholder="Id Rol">
            @error('id_rol')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        @if(isset($usuario) && $usuario->fecha_registro)
        <div class="form-group mb-2 mb20">
            <label for="fecha_registro" class="form-label">{{ __('Fecha Registro') }}</label>
            <input type="text" name="fecha_registro" class="form-control" value="{{ old('fecha_registro', $usuario->fecha_registro) }}" id="fecha_registro" readonly>
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
        'nombres': {
            required: 'El campo nombres es obligatorio',
            maxlength: 'El campo nombres no puede exceder 100 caracteres'
        },
        'apellidos': {
            required: 'El campo apellidos es obligatorio',
            maxlength: 'El campo apellidos no puede exceder 150 caracteres'
        },
        'ci': {
            required: 'El campo CI es obligatorio',
            maxlength: 'El campo CI no puede exceder 20 caracteres'
        },
        'correo': {
            required: 'El campo correo es obligatorio',
            email: 'Por favor ingrese un correo electrónico válido',
            maxlength: 'El campo correo no puede exceder 100 caracteres'
        },
        'contrasena': 'El campo contraseña es obligatorio'
    };

    // Campos con longitud máxima
    const maxLengthFields = {
        'licencia_conducir': 50,
        'telefono': 20,
        'entidad_pertenencia': 150,
        'tipo_sangre': 5
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

    // Eventos para cada campo
    Object.keys(requiredFields).forEach(function(fieldName) {
        const field = $('#' + fieldName);
        let hasInteracted = false;
        
        // Validar al perder el foco (blur)
        field.on('blur', function() {
            hasInteracted = true;
            const value = $(this).val().trim();
            const maxLength = field.attr('maxlength');
            
            if (!value) {
                const message = typeof requiredFields[fieldName] === 'object' 
                    ? requiredFields[fieldName].required 
                    : requiredFields[fieldName];
                showError(fieldName, message);
            } else if (fieldName === 'correo' && !validateEmail(value)) {
                showError(fieldName, requiredFields[fieldName].email);
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
        field.on('input', function() {
            const value = $(this).val().trim();
            const maxLength = field.attr('maxlength');
            
            if (hasInteracted || value) {
                if (!value) {
                    const message = typeof requiredFields[fieldName] === 'object' 
                        ? requiredFields[fieldName].required 
                        : requiredFields[fieldName];
                    showError(fieldName, message);
                } else if (fieldName === 'correo' && !validateEmail(value)) {
                    showError(fieldName, requiredFields[fieldName].email);
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

    // Validar campos con longitud máxima
    Object.keys(maxLengthFields).forEach(function(fieldName) {
        const field = $('#' + fieldName);
        const maxLength = maxLengthFields[fieldName];
        
        field.on('input', function() {
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
    $('form').on('submit', function(e) {
        let hasErrors = false;
        
        Object.keys(requiredFields).forEach(function(fieldName) {
            const field = $('#' + fieldName);
            const value = field.val().trim();
            const maxLength = field.attr('maxlength');
            
            if (!value) {
                const message = typeof requiredFields[fieldName] === 'object' 
                    ? requiredFields[fieldName].required 
                    : requiredFields[fieldName];
                showError(fieldName, message);
                hasErrors = true;
            } else if (fieldName === 'correo' && !validateEmail(value)) {
                showError(fieldName, requiredFields[fieldName].email);
                hasErrors = true;
            } else if (maxLength && value.length > parseInt(maxLength)) {
                const message = typeof requiredFields[fieldName] === 'object' && requiredFields[fieldName].maxlength
                    ? requiredFields[fieldName].maxlength
                    : `El campo no puede exceder ${maxLength} caracteres`;
                showError(fieldName, message);
                hasErrors = true;
            }
        });

        // Validar campos opcionales con longitud máxima
        Object.keys(maxLengthFields).forEach(function(fieldName) {
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