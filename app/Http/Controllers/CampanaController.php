<?php

namespace App\Http\Controllers;

use App\Models\Campana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CampanaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CampanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $campanas = Campana::paginate();

        return view('campana.index', compact('campanas'))
            ->with('i', ($request->input('page', 1) - 1) * $campanas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $campana = new Campana();

        return view('campana.create', compact('campana'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CampanaRequest $request): RedirectResponse
    {
        Campana::create($request->validated());

        return Redirect::route('campana.index')
            ->with('success', 'Campana created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $campana = Campana::find($id);

        return view('campana.show', compact('campana'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $campana = Campana::find($id);

        return view('campana.edit', compact('campana'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CampanaRequest $request, Campana $campana): RedirectResponse
    {
        $campana->update($request->validated());

        return Redirect::route('campana.index')
            ->with('success', 'Campana updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Campana::find($id)->delete();

        return Redirect::route('campana.index')
            ->with('success', 'Campana deleted successfully');
    }
}
