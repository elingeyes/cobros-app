<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoPrestamoRequest;
use App\Http\Requests\UpdateTipoPrestamoRequest;
use App\Models\TipoPrestamo;
use Illuminate\Http\JsonResponse;

class TipoPrestamoController extends Controller
{
    /**
     * Listar todos los tipos de préstamo
     */
    public function index(): JsonResponse
    {
        $tiposPrestamo = TipoPrestamo::all();

        return response()->json($tiposPrestamo);
    }

    /**
     * Mostrar un tipo de préstamo específico
     */
    public function show(TipoPrestamo $tipoPrestamo): JsonResponse
    {
        return response()->json($tipoPrestamo->load('prestamos'));
    }

    /**
     * Crear un nuevo tipo de préstamo
     */
    public function store(StoreTipoPrestamoRequest $request): JsonResponse
    {
        $tipoPrestamo = TipoPrestamo::create($request->validated());

        return response()->json($tipoPrestamo, 201);
    }

    /**
     * Actualizar un tipo de préstamo existente
     */
    public function update(UpdateTipoPrestamoRequest $request, TipoPrestamo $tipoPrestamo): JsonResponse
    {
        $tipoPrestamo->update($request->validated());

        return response()->json($tipoPrestamo);
    }

    /**
     * Eliminar un tipo de préstamo
     */
    public function destroy(TipoPrestamo $tipoPrestamo): JsonResponse
    {
        $tipoPrestamo->delete();

        return response()->json(['message' => 'Tipo de préstamo eliminado correctamente'], 200);
    }
}
