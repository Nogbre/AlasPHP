<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProducto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriasProductoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CategoriasProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $categoriasProductos = CategoriasProducto::paginate();

        return view('categorias-producto.index', compact('categoriasProductos'))
            ->with('i', ($request->input('page', 1) - 1) * $categoriasProductos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categoriasProducto = new CategoriasProducto();

        return view('categorias-producto.create', compact('categoriasProducto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriasProductoRequest $request): RedirectResponse
    {
        CategoriasProducto::create($request->validated());

        return Redirect::route('categorias-producto.index')
            ->with('success', 'CategoriasProducto created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $categoriasProducto = CategoriasProducto::find($id);

        return view('categorias-producto.show', compact('categoriasProducto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $categoriasProducto = CategoriasProducto::find($id);

        return view('categorias-producto.edit', compact('categoriasProducto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriasProductoRequest $request, CategoriasProducto $categoriasProducto): RedirectResponse
    {
        $categoriasProducto->update($request->validated());

        return Redirect::route('categorias-producto.index')
            ->with('success', 'CategoriasProducto updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        CategoriasProducto::find($id)->delete();

        return Redirect::route('categorias-producto.index')
            ->with('success', 'CategoriasProducto deleted successfully');
    }
}
