<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrestamoRequest;
use App\Http\Requests\UpdatePrestamoRequest;
use App\Models\Prestamo;
use App\Services\PrestamoService;
use Illuminate\Http\JsonResponse;

class PrestamoController extends Controller
{
    public function __construct(private PrestamoService $prestamoService) {}

    /**
     * Listar todos los préstamos
     */
    public function index(): JsonResponse
    {
        $prestamos = Prestamo::with(['cliente', 'tipoPrestamo', 'cuotas'])->get();

        return response()->json($prestamos);
    }

    /**
     * Mostrar un préstamo específico
     */
    public function show(Prestamo $prestamo): JsonResponse
    {
        $prestamo->load(['cliente', 'tipoPrestamo', 'cuotas.pagos']);

        return response()->json($prestamo);
    }

    /**
     * Crear un nuevo préstamo y generar cuotas automáticamente
     */
    public function store(StorePrestamoRequest $request): JsonResponse
    {
        $prestamo = Prestamo::create(array_merge(
            $request->validated(),
            ['estado' => 'activo']
        ));

        $this->prestamoService->generarCuotas($prestamo);
        $prestamo->load(['cuotas']);

        return response()->json($prestamo, 201);
    }

    /**
     * Actualizar estado de un préstamo
     */
    public function update(UpdatePrestamoRequest $request, Prestamo $prestamo): JsonResponse
    {
        $prestamo->update($request->validated());

        return response()->json($prestamo);
    }

    /**
     * Eliminar un préstamo
     */
    public function destroy(Prestamo $prestamo): JsonResponse
    {
        $prestamo->delete();

        return response()->json(['message' => 'Préstamo eliminado correctamente'], 200);
    }
}
