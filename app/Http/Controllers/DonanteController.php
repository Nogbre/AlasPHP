<?php

namespace App\Http\Controllers;

use App\Models\Donante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DonanteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DonanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $donantes = Donante::paginate();

        return view('donante.index', compact('donantes'))
            ->with('i', ($request->input('page', 1) - 1) * $donantes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $donante = new Donante();

        return view('donante.create', compact('donante'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DonanteRequest $request): RedirectResponse
    {
        Donante::create($request->validated());

        return Redirect::route('donante.index')
            ->with('success', 'Donante created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $donante = Donante::find($id);

        return view('donante.show', compact('donante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $donante = Donante::find($id);

        return view('donante.edit', compact('donante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DonanteRequest $request, Donante $donante): RedirectResponse
    {
        $donante->update($request->validated());

        return Redirect::route('donante.index')
            ->with('success', 'Donante updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Donante::find($id)->delete();

        return Redirect::route('donante.index')
            ->with('success', 'Donante deleted successfully');
    }
}
