<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagoRequest;
use App\Models\Pago;
use App\Services\PrestamoService;
use Illuminate\Http\JsonResponse;

class PagoController extends Controller
{
    public function __construct(private PrestamoService $prestamoService) {}

    /**
     * Listar todos los pagos
     */
    public function index(): JsonResponse
    {
        $pagos = Pago::with(['cuota.prestamo'])->get();

        return response()->json($pagos);
    }

    /**
     * Mostrar un pago específico
     */
    public function show(Pago $pago): JsonResponse
    {
        $pago->load(['cuota.prestamo']);

        return response()->json($pago);
    }

    /**
     * Crear un nuevo pago y actualizar estado de cuota
     */
    public function store(StorePagoRequest $request): JsonResponse
    {
        $pago = Pago::create($request->validated());
        $cuota = $pago->cuota;

        $this->prestamoService->procesarPago($cuota, $pago->monto);
        $pago->load(['cuota.prestamo']);

        return response()->json($pago, 201);
    }

    /**
     * Eliminar un pago
     */
    public function destroy(Pago $pago): JsonResponse
    {
        $pago->delete();

        return response()->json(['message' => 'Pago eliminado correctamente'], 200);
    }
}
