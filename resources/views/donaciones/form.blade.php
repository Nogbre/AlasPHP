@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-ban"></i> {{ __('¡Error de validación!') }}</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li><i class="fas fa-exclamation-triangle mr-1"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Paso 1: Información Básica -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-info-circle"></i> Paso 1: Información Básica</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="id_donante">Donante <span class="text-danger">*</span></label>
            <select name="id_donante" class="form-control @error('id_donante') is-invalid @enderror" id="id_donante">
                <option value="">Seleccione un donante</option>
                @foreach($donantes ?? [] as $id => $name)
                    <option value="{{ $id }}" {{ (string) old('id_donante', $donacion?->id_donante) === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            @error('id_donante')
                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="form-group">
            <label for="tipo">Tipo de Donación <span class="text-danger">*</span></label>
            <select id="tipo" name="tipo" class="form-control @error('tipo') is-invalid @enderror">
                <option value="">-- Seleccione --</option>
                <option value="dinero" {{ old('tipo', $donacion?->tipo) === 'dinero' ? 'selected' : '' }}>Dinero</option>
                <option value="especie" {{ old('tipo', $donacion?->tipo) === 'especie' ? 'selected' : '' }}>Especie</option>
                <option value="ropa" {{ old('tipo', $donacion?->tipo) === 'ropa' ? 'selected' : '' }}>Ropa</option>
            </select>
            @error('tipo')
                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_campana">Campaña (opcional)</label>
                    <select name="id_campana" class="form-control" id="id_campana">
                        <option value="">-- Ninguna --</option>
                        @foreach($campanas ?? [] as $id => $name)
                            <option value="{{ $id }}" {{ (string) old('id_campana', $donacion?->id_campana) === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_punto_recoleccion">Punto de Recolección (opcional)</label>
                    <select name="id_punto_recoleccion" class="form-control" id="id_punto_recoleccion">
                        <option value="">-- Ninguno --</option>
                        @foreach($puntos ?? [] as $id => $name)
                            <option value="{{ $id }}" {{ (string) old('id_punto_recoleccion', $donacion?->id_punto_recoleccion) === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Paso 2: Detalles de Donación (dinero o productos) -->
<div class="card card-success" id="card-step2">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-dollar-sign"></i> Paso 2: Detalles de la Donación</h3>
    </div>
    <div class="card-body">
        <div id="block-dinero" style="display:none;">
            <div class="form-group">
                <label for="monto">Monto <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="monto" class="form-control @error('monto') is-invalid @enderror" value="{{ old('monto', $donacion?->dinero->monto ?? '') }}" placeholder="0.00">
                @error('monto')<span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="moneda">Moneda</label>
                        <input type="text" name="moneda" class="form-control" value="{{ old('moneda', $donacion?->dinero->moneda ?? 'BOB') }}" placeholder="BOB">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="metodo_pago">Método de Pago</label>
                        <select name="metodo_pago" class="form-control">
                            <option value="">-- Seleccione --</option>
                            <option value="efectivo" {{ old('metodo_pago', $donacion?->dinero->metodo_pago ?? '') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia" {{ old('metodo_pago', $donacion?->dinero->metodo_pago ?? '') === 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="pasarela" {{ old('metodo_pago', $donacion?->dinero->metodo_pago ?? '') === 'pasarela' ? 'selected' : '' }}>Pasarela</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="referencia_pago">Referencia de Pago</label>
                <input type="text" name="referencia_pago" class="form-control" value="{{ old('referencia_pago', $donacion?->dinero->referencia_pago ?? '') }}" placeholder="Ej: Nº recibo, código transacción">
            </div>
        </div>

        <div id="block-detalles" style="display:none;">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="detalles-table">
                    <thead class="bg-light">
                        <tr>
                            <th width="35%">Producto <span class="text-danger">*</span></th>
                            <th width="15%">Cantidad <span class="text-danger">*</span></th>
                            <th width="15%">Unidad</th>
                            <th width="25%">Espacio <span class="text-danger">*</span></th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $oldDetalles = old('detalles');
                            $existingDetalles = ($donacion && $donacion->exists && $donacion->detalles) ? $donacion->detalles : null;
                            $hasDetalles = $oldDetalles || ($existingDetalles && $existingDetalles->count() > 0);
                        @endphp
                        
                        @if($hasDetalles)
                            @foreach(($oldDetalles ?? $existingDetalles) as $idx => $det)
                                <tr class="detalle-row">
                                    <td>
                                        <select name="detalles[{{ $idx }}][id_producto]" class="form-control form-control-sm">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($productos ?? [] as $pId => $pName)
                                                <option value="{{ $pId }}" {{ (string) ($det['id_producto'] ?? $det->id_producto ?? '') === (string) $pId ? 'selected' : '' }}>{{ $pName }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input name="detalles[{{ $idx }}][cantidad]" type="number" class="form-control form-control-sm" value="{{ $det['cantidad'] ?? $det->cantidad ?? '' }}" placeholder="1"></td>
                                    <td><input name="detalles[{{ $idx }}][unidad_medida]" class="form-control form-control-sm" value="{{ $det['unidad_medida'] ?? $det->unidad_medida ?? '' }}" placeholder="Ej: kg, unidad"></td>
                                    <td>
                                        <select name="detalles[{{ $idx }}][id_espacio]" class="form-control form-control-sm">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($espacios ?? [] as $espId => $espCode)
                                                <option value="{{ $espId }}" {{ (string) ($det['id_espacio'] ?? '') === (string) $espId ? 'selected' : '' }}>{{ $espCode }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><button class="btn btn-danger btn-sm remove-row" type="button"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            @endforeach
                        @else
                            {{-- Fila inicial para create --}}
                            <tr class="detalle-row">
                                <td>
                                    <select name="detalles[0][id_producto]" class="form-control form-control-sm">
                                        <option value="">-- Seleccione --</option>
                                        @foreach($productos ?? [] as $pId => $pName)
                                            <option value="{{ $pId }}">{{ $pName }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input name="detalles[0][cantidad]" type="number" class="form-control form-control-sm" placeholder="1"></td>
                                <td><input name="detalles[0][unidad_medida]" class="form-control form-control-sm" placeholder="Ej: kg, unidad"></td>
                                <td>
                                    <select name="detalles[0][id_espacio]" class="form-control form-control-sm">
                                        <option value="">-- Seleccione --</option>
                                        @foreach($espacios ?? [] as $espId => $espCode)
                                            <option value="{{ $espId }}">{{ $espCode }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><button class="btn btn-danger btn-sm remove-row" type="button"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <button id="add-row" class="btn btn-secondary btn-sm" type="button"><i class="fas fa-plus"></i> Agregar producto</button>
        </div>
    </div>
</div>

<!-- Paso 3: Información Adicional -->
<div class="card card-info" id="card-step3">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-sticky-note"></i> Paso 3: Información Adicional (Opcional)</h3>
    </div>
    <div class="card-body">>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3" placeholder="Ingrese cualquier observación adicional...">{{ old('observaciones', $donacion?->observaciones ?? '') }}</textarea>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const tipoSelect = document.getElementById('tipo');
    const blockDinero = document.getElementById('block-dinero');
    const blockDetalles = document.getElementById('block-detalles');
    let detalleIndex = 1;
    
    function toggleBlocks(){
        const tipo = tipoSelect.value;
        
        console.log('Tipo seleccionado:', tipo);
        
        if(tipo === 'dinero'){
            blockDinero.style.display = 'block';
            blockDetalles.style.display = 'none';
        } else if(tipo === 'especie' || tipo === 'ropa'){
            blockDinero.style.display = 'none';
            blockDetalles.style.display = 'block';
            
            // Contar filas existentes
            const existingRows = document.querySelectorAll('#detalles-table tbody .detalle-row');
            detalleIndex = existingRows.length;
            console.log('Filas existentes:', detalleIndex);
        } else {
            blockDinero.style.display = 'none';
            blockDetalles.style.display = 'none';
        }
    }
    
    tipoSelect.addEventListener('change', toggleBlocks);
    toggleBlocks();
    
    // Agregar filas - usar event delegation
    document.addEventListener('click', function(e){
        const target = e.target.closest('#add-row');
        if(target){
            e.preventDefault();
            console.log('Agregando nueva fila...');
            
            const tbody = document.querySelector('#detalles-table tbody');
            if(!tbody){
                console.error('No se encontró tbody');
                return;
            }
            
            // Forzar visibilidad temporal para buscar filas
            const wasHidden = blockDetalles.style.display === 'none';
            if(wasHidden){
                blockDetalles.style.display = 'block';
            }
            
            const allRows = tbody.querySelectorAll('tr.detalle-row');
            console.log('Filas encontradas:', allRows.length);
            
            if(wasHidden){
                blockDetalles.style.display = 'none';
            }
            
            if(allRows.length === 0){
                console.error('No hay filas para clonar');
                alert('Error: No se puede agregar fila');
                return;
            }
            
            const templateRow = allRows[0];
            const newRow = templateRow.cloneNode(true);
            
            // Actualizar índices
            newRow.querySelectorAll('input, select, textarea').forEach(function(input){
                const name = input.getAttribute('name');
                if(name){
                    const newName = name.replace(/detalles\[\d+\]/, 'detalles[' + detalleIndex + ']');
                    input.setAttribute('name', newName);
                    input.value = '';
                    if(input.tagName === 'SELECT'){
                        input.selectedIndex = 0;
                    }
                }
            });
            
            tbody.appendChild(newRow);
            detalleIndex++;
            console.log('Fila agregada. Nuevo índice:', detalleIndex);
        }
    });
    
    // Eliminar filas
    document.addEventListener('click', function(e){
        const target = e.target.closest('.remove-row');
        if(target){
            e.preventDefault();
            const row = target.closest('tr');
            const allRows = document.querySelectorAll('#detalles-table tbody tr.detalle-row');
            
            if(allRows.length > 1){
                row.remove();
                console.log('Fila eliminada');
            } else {
                alert('Debe mantener al menos un detalle.');
            }
        }
    });
});
</script>
@endpush
