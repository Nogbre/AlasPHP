<?php

namespace App\Http\Controllers;

use App\Models\RegistrosSalida;
use App\Models\Paquete;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrosSalidaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class RegistrosSalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $registrosSalidas = RegistrosSalida::paginate();

        return view('registros-salida.index', compact('registrosSalidas'))
            ->with('i', ($request->input('page', 1) - 1) * $registrosSalidas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $registrosSalida = new RegistrosSalida();
        $paquetes = Paquete::all();
        return view('registros-salida.create', compact('registrosSalida', 'paquetes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistrosSalidaRequest $request): RedirectResponse
    {
        RegistrosSalida::create($request->validated());

        return Redirect::route('registros-salida.index')
            ->with('success', 'RegistrosSalida created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $registrosSalida = RegistrosSalida::find($id);

        return view('registros-salida.show', compact('registrosSalida'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $registrosSalida = RegistrosSalida::find($id);
        $paquetes = Paquete::all();
        return view('registros-salida.edit', compact('registrosSalida', 'paquetes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegistrosSalidaRequest $request, RegistrosSalida $registrosSalida): RedirectResponse
    {
        $registrosSalida->update($request->validated());

        return Redirect::route('registros-salida.index')
            ->with('success', 'RegistrosSalida updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        RegistrosSalida::find($id)->delete();

        return Redirect::route('registros-salida.index')
            ->with('success', 'RegistrosSalida deleted successfully');
    }
}
