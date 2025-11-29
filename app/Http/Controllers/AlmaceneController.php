<?php

namespace App\Http\Controllers;

use App\Models\Almacene;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AlmaceneRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AlmaceneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $almacenes = Almacene::paginate();

        return view('almacene.index', compact('almacenes'))
            ->with('i', ($request->input('page', 1) - 1) * $almacenes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $almacene = new Almacene();
        $returnUrl = $request->query('return_url');

        return view('almacene.create', compact('almacene', 'returnUrl'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlmaceneRequest $request): RedirectResponse
    {
        $almacene = Almacene::create($request->validated());

        // Check if there's a return URL
        if ($request->has('return_url') && $request->input('return_url')) {
            return Redirect::to($request->input('return_url'))
                ->with('success', 'Almacén creado exitosamente.')
                ->with('new_almacen_id', $almacene->id_almacen);
        }

        return Redirect::route('almacene.index')
            ->with('success', 'Almacén creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $almacene = Almacene::find($id);
        $estantes = $almacene->estantes()->with('espacios')->get();

        return view('almacene.show', compact('almacene', 'estantes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $almacene = Almacene::find($id);

        return view('almacene.edit', compact('almacene'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlmaceneRequest $request, Almacene $almacene): RedirectResponse
    {
        $almacene->update($request->validated());

        return Redirect::route('almacene.index')
            ->with('success', 'Almacene updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Almacene::find($id)->delete();

        return Redirect::route('almacene.index')
            ->with('success', 'Almacene deleted successfully');
    }

    public function getEstantes($id)
    {
        return response()->json(Almacene::find($id)->estantes()->select('id_estante', 'codigo_estante', 'descripcion')->get());
    }
}
