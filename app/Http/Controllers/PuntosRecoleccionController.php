<?php

namespace App\Http\Controllers;

use App\Models\PuntosRecoleccion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PuntosRecoleccionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PuntosRecoleccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $puntosRecoleccions = PuntosRecoleccion::paginate();

        return view('puntos-recoleccion.index', compact('puntosRecoleccions'))
            ->with('i', ($request->input('page', 1) - 1) * $puntosRecoleccions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $puntosRecoleccion = new PuntosRecoleccion();

        return view('puntos-recoleccion.create', compact('puntosRecoleccion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PuntosRecoleccionRequest $request): RedirectResponse
    {
        PuntosRecoleccion::create($request->validated());

        return Redirect::route('puntos-recoleccion.index')
            ->with('success', 'PuntosRecoleccion created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $puntosRecoleccion = PuntosRecoleccion::find($id);

        return view('puntos-recoleccion.show', compact('puntosRecoleccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $puntosRecoleccion = PuntosRecoleccion::find($id);

        return view('puntos-recoleccion.edit', compact('puntosRecoleccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PuntosRecoleccionRequest $request, PuntosRecoleccion $puntosRecoleccion): RedirectResponse
    {
        $puntosRecoleccion->update($request->validated());

        return Redirect::route('puntos-recoleccion.index')
            ->with('success', 'PuntosRecoleccion updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        PuntosRecoleccion::find($id)->delete();

        return Redirect::route('puntos-recoleccion.index')
            ->with('success', 'PuntosRecoleccion deleted successfully');
    }
}
