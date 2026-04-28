<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CuotaController extends Controller
{
    /**
     * Listar todas las cuotas
     */
    public function index(): View
    {
        $cuotas = Cuota::with(['prestamo', 'pagos'])->get();

        return view('cuotas.index', compact('cuotas'));
    }

    /**
     * Mostrar una cuota específica
     */
    public function show(Cuota $cuota): View
    {
        $cuota->load(['prestamo', 'pagos']);

        return view('cuotas.show', compact('cuota'));
    }

    /**
     * Eliminar una cuota
     */
    public function destroy(Cuota $cuota): RedirectResponse
    {
        $cuota->delete();

        return redirect()->route('cuotas.index')
            ->with('success', 'Cuota eliminada correctamente');
    }
}
