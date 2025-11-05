<?php

namespace App\Http\Controllers;

use App\Models\SolicitudesRecoleccion;
use App\Models\Donante;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitudesRecoleccionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SolicitudesRecoleccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $solicitudesRecoleccions = SolicitudesRecoleccion::paginate();

        return view('solicitudes-recoleccion.index', compact('solicitudesRecoleccions'))
            ->with('i', ($request->input('page', 1) - 1) * $solicitudesRecoleccions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $solicitudesRecoleccion = new SolicitudesRecoleccion();
        $donantes = Donante::all();
        $usuarios = Usuario::all();

        return view('solicitudes-recoleccion.create', compact('solicitudesRecoleccion', 'donantes', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SolicitudesRecoleccionRequest $request): RedirectResponse
    {
        SolicitudesRecoleccion::create($request->validated());

        return Redirect::route('solicitudes-recoleccions.index')
            ->with('success', 'SolicitudesRecoleccion created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $solicitudesRecoleccion = SolicitudesRecoleccion::find($id);

        return view('solicitudes-recoleccion.show', compact('solicitudesRecoleccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $solicitudesRecoleccion = SolicitudesRecoleccion::find($id);
        $donantes = Donante::all();
        $usuarios = Usuario::all();

        return view('solicitudes-recoleccion.edit', compact('solicitudesRecoleccion', 'donantes', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SolicitudesRecoleccionRequest $request, SolicitudesRecoleccion $solicitudesRecoleccion): RedirectResponse
    {
        $solicitudesRecoleccion->update($request->validated());

        return Redirect::route('solicitudes-recoleccions.index')
            ->with('success', 'SolicitudesRecoleccion updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        SolicitudesRecoleccion::find($id)->delete();

        return Redirect::route('solicitudes-recoleccions.index')
            ->with('success', 'SolicitudesRecoleccion deleted successfully');
    }
}
