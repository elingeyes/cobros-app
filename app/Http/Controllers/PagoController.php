<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagoRequest;
use App\Models\Cuota;
use App\Models\Pago;
use App\Services\PrestamoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PagoController extends Controller
{
    public function __construct(private PrestamoService $prestamoService) {}

    /**
     * Listar todos los pagos
     */
    public function index(): View
    {
        $pagos = Pago::with(['cuota.prestamo.cliente'])->get();

        return view('pagos.index', compact('pagos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(): View
    {
        $cuotasPendientes = Cuota::where('estado', '!=', 'pagada')
            ->with('prestamo.cliente')
            ->get();

        return view('pagos.create', compact('cuotasPendientes'));
    }

    /**
     * Mostrar un pago específico
     */
    public function show(Pago $pago): View
    {
        $pago->load(['cuota.prestamo']);

        return view('pagos.show', compact('pago'));
    }

    /**
     * Crear un nuevo pago y actualizar estado de cuota
     */
    public function store(StorePagoRequest $request): RedirectResponse
    {
        $pago = Pago::create($request->validated());
        $cuota = $pago->cuota;

        $this->prestamoService->procesarPago($cuota, $pago->monto);

        return redirect()->route('cuotas.show', $cuota)
            ->with('success', 'Pago registrado correctamente');
    }

    /**
     * Eliminar un pago
     */
    public function destroy(Pago $pago): RedirectResponse
    {
        $pago->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago eliminado correctamente');
    }
}
