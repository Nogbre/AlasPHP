@extends('adminlte::page')

@section('template_title')
    {{ __('Show') }} Almacene
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Almacene</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('almacene.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $almacene->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Direccion:</strong>
                                    {{ $almacene->direccion }}
                                </div>

                                @if($almacene->latitud && $almacene->longitud)
                                <div class="form-group mb-2 mb20">
                                    <strong>Ubicación:</strong>
                                    <p>Latitud: {{ $almacene->latitud }}, Longitud: {{ $almacene->longitud }}</p>
                                    <div id="map" style="height: 400px; width: 100%; border: 1px solid #ddd; border-radius: 4px;"></div>
                                </div>
                                @else
                                <div class="form-group mb-2 mb20">
                                    <strong>Ubicación:</strong>
                                    <p class="text-muted">No se ha registrado una ubicación para este almacén</p>
                                </div>
                                @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@if($almacene->latitud && $almacene->longitud)
@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
      crossorigin=""/>
@endpush

@push('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
        crossorigin=""></script>
<script>
    const almacenCoords = [{{ $almacene->latitud }}, {{ $almacene->longitud }}];
    
    // Initialize the map
    const map = L.map('map').setView(almacenCoords, 15);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Add marker
    const marker = L.marker(almacenCoords).addTo(map);
    marker.bindPopup('<strong>{{ $almacene->nombre }}</strong><br>{{ $almacene->direccion }}').openPopup();
</script>
@endpush
@endif