<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EspacioRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EspacioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $espacios = Espacio::paginate();

        return view('espacio.index', compact('espacios'))
            ->with('i', ($request->input('page', 1) - 1) * $espacios->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $espacio = new Espacio();

        // load estantes for FK select
        $estantes = \App\Models\Estante::pluck('codigo_estante', 'id_estante');

        return view('espacio.create', compact('espacio', 'estantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EspacioRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Auto-generate codigo_espacio
        $idEstante = $data['id_estante'];

        // Get the count of existing espacios for this estante
        $count = Espacio::where('id_estante', $idEstante)->count() + 1;

        // Generate code like: EST1-ESP001, EST1-ESP002, etc.
        $data['codigo_espacio'] = 'EST' . $idEstante . '-ESP' . str_pad($count, 3, '0', STR_PAD_LEFT);

        Espacio::create($data);

        return Redirect::route('espacio.index')
            ->with('success', 'Espacio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $espacio = Espacio::find($id);

        return view('espacio.show', compact('espacio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $espacio = Espacio::find($id);

        // load estantes for FK select
        $estantes = \App\Models\Estante::pluck('codigo_estante', 'id_estante');

        return view('espacio.edit', compact('espacio', 'estantes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EspacioRequest $request, Espacio $espacio): RedirectResponse
    {
        $espacio->update($request->validated());

        return Redirect::route('espacio.index')
            ->with('success', 'Espacio updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Espacio::find($id)->delete();

        return Redirect::route('espacio.index')
            ->with('success', 'Espacio deleted successfully');
    }
}
