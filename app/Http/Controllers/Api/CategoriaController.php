<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriasProducto;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
    /**
     * Get all categories with their products
     */
    public function getAllWithProducts(): JsonResponse
    {
        try {
            $categorias = CategoriasProducto::with(['productos' => function($query) {
                $query->select('id_producto', 'id_categoria', 'nombre', 'descripcion', 'unidad_medida');
            }])
            ->select('id_categoria', 'nombre')
            ->get();

            return response()->json([
                'success' => true,
                'data' => $categorias
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener categorías',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
