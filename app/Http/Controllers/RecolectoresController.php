<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RecolectorRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class RecolectoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $recolectores = Usuario::paginate();

        return view('recolectores.index', compact('recolectores'))
            ->with('i', ($request->input('page', 1) - 1) * $recolectores->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $recolector = new Usuario();

        return view('recolectores.create', compact('recolector'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecolectorRequest $request): RedirectResponse
    {
        Usuario::create($request->validated());

        return Redirect::route('recolectores.index')
            ->with('success', 'Recolector creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $recolector = Usuario::find($id);

        return view('recolectores.show', compact('recolector'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $recolector = Usuario::find($id);

        return view('recolectores.edit', compact('recolector'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecolectorRequest $request, Usuario $recolector): RedirectResponse
    {
        $recolector->update($request->validated());

        return Redirect::route('recolectores.index')
            ->with('success', 'Recolector actualizado exitosamente');
    }

    public function destroy($id): RedirectResponse
    {
        Usuario::find($id)->delete();

        return Redirect::route('recolectores.index')
            ->with('success', 'Recolector eliminado exitosamente');
    }
}
