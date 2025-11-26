<?php

namespace App\Http\Controllers;

use App\Models\Estante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EstanteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EstanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $estantes = Estante::paginate();

        return view('estante.index', compact('estantes'))
            ->with('i', ($request->input('page', 1) - 1) * $estantes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $estante = new Estante();

        // load almacenes for FK select
        $almacenes = \App\Models\Almacene::pluck('nombre', 'id_almacen');

        return view('estante.create', compact('estante', 'almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstanteRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Auto-generate codigo_estante
        $idAlmacen = $data['id_almacen'];

        // Get the count of existing estantes for this almacen
        $count = Estante::where('id_almacen', $idAlmacen)->count() + 1;

        // Generate code like: ALM1-EST001, ALM1-EST002, etc.
        $data['codigo_estante'] = 'ALM' . $idAlmacen . '-EST' . str_pad($count, 3, '0', STR_PAD_LEFT);

        Estante::create($data);

        return Redirect::route('estante.index')
            ->with('success', 'Estante creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $estante = Estante::find($id);

        return view('estante.show', compact('estante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $estante = Estante::find($id);

        // load almacenes for FK select
        $almacenes = \App\Models\Almacene::pluck('nombre', 'id_almacen');

        return view('estante.edit', compact('estante', 'almacenes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstanteRequest $request, Estante $estante): RedirectResponse
    {
        $estante->update($request->validated());

        return Redirect::route('estante.index')
            ->with('success', 'Estante updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Estante::find($id)->delete();

        return Redirect::route('estante.index')
            ->with('success', 'Estante deleted successfully');
    }
}
