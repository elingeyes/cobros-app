<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoPrestamoRequest;
use App\Http\Requests\UpdateTipoPrestamoRequest;
use App\Models\TipoPrestamo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TipoPrestamoController extends Controller
{
    /**
     * Listar todos los tipos de préstamo
     */
    public function index(): View
    {
        $tiposPrestamo = TipoPrestamo::all();

        return view('tipos-prestamo.index', compact('tiposPrestamo'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(): View
    {
        return view('tipos-prestamo.create');
    }

    /**
     * Mostrar un tipo de préstamo específico
     */
    public function show(TipoPrestamo $tipoPrestamo): View
    {
        $tipoPrestamo->load('prestamos');

        return view('tipos-prestamo.show', compact('tipoPrestamo'));
    }

    /**
     * Crear un nuevo tipo de préstamo
     */
    public function store(StoreTipoPrestamoRequest $request): RedirectResponse
    {
        TipoPrestamo::create($request->validated());

        return redirect()->route('tipos-prestamo.index')
            ->with('success', 'Tipo de préstamo creado correctamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(TipoPrestamo $tipoPrestamo): View
    {
        return view('tipos-prestamo.edit', compact('tipoPrestamo'));
    }

    /**
     * Actualizar un tipo de préstamo existente
     */
    public function update(UpdateTipoPrestamoRequest $request, TipoPrestamo $tipoPrestamo): RedirectResponse
    {
        $tipoPrestamo->update($request->validated());

        return redirect()->route('tipos-prestamo.index')
            ->with('success', 'Tipo de préstamo actualizado correctamente');
    }

    /**
     * Eliminar un tipo de préstamo
     */
    public function destroy(TipoPrestamo $tipoPrestamo): RedirectResponse
    {
        $tipoPrestamo->delete();

        return redirect()->route('tipos-prestamo.index')
            ->with('success', 'Tipo de préstamo eliminado correctamente');
    }
}
