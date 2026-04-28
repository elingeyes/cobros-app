<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrestamoRequest;
use App\Http\Requests\UpdatePrestamoRequest;
use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\TipoPrestamo;
use App\Services\PrestamoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PrestamoController extends Controller
{
    public function __construct(private PrestamoService $prestamoService) {}

    /**
     * Listar todos los préstamos
     */
    public function index(): View
    {
        $prestamos = Prestamo::with(['cliente', 'tipoPrestamo', 'cuotas'])->get();

        return view('prestamos.index', compact('prestamos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(): View
    {
        $clientes = Cliente::all();
        $tiposPrestamo = TipoPrestamo::all();

        return view('prestamos.create', compact('clientes', 'tiposPrestamo'));
    }

    /**
     * Mostrar un préstamo específico
     */
    public function show(Prestamo $prestamo): View
    {
        $prestamo->load(['cliente', 'tipoPrestamo', 'cuotas.pagos']);

        return view('prestamos.show', compact('prestamo'));
    }

    /**
     * Crear un nuevo préstamo y generar cuotas automáticamente
     */
    public function store(StorePrestamoRequest $request): RedirectResponse
    {
        $prestamo = Prestamo::create(array_merge(
            $request->validated(),
            ['estado' => 'activo']
        ));

        $this->prestamoService->generarCuotas($prestamo);

        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Préstamo creado correctamente con sus cuotas');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Prestamo $prestamo): View
    {
        return view('prestamos.edit', compact('prestamo'));
    }

    /**
     * Actualizar estado de un préstamo
     */
    public function update(UpdatePrestamoRequest $request, Prestamo $prestamo): RedirectResponse
    {
        $prestamo->update($request->validated());

        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Préstamo actualizado correctamente');
    }

    /**
     * Eliminar un préstamo
     */
    public function destroy(Prestamo $prestamo): RedirectResponse
    {
        $prestamo->delete();

        return redirect()->route('prestamos.index')
            ->with('success', 'Préstamo eliminado correctamente');
    }
}
