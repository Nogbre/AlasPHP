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

        return view('estante.create', compact('estante'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstanteRequest $request): RedirectResponse
    {
        Estante::create($request->validated());

        return Redirect::route('estante.index')
            ->with('success', 'Estante created successfully.');
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

        return view('estante.edit', compact('estante'));
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
