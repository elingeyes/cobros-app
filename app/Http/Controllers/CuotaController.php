<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use Illuminate\Http\JsonResponse;

class CuotaController extends Controller
{
    /**
     * Listar todas las cuotas
     */
    public function index(): JsonResponse
    {
        $cuotas = Cuota::with(['prestamo', 'pagos'])->get();

        return response()->json($cuotas);
    }

    /**
     * Mostrar una cuota específica
     */
    public function show(Cuota $cuota): JsonResponse
    {
        $cuota->load(['prestamo', 'pagos']);

        return response()->json($cuota);
    }

    /**
     * Eliminar una cuota
     */
    public function destroy(Cuota $cuota): JsonResponse
    {
        $cuota->delete();

        return response()->json(['message' => 'Cuota eliminada correctamente'], 200);
    }
}
