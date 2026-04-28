<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClienteController extends Controller
{
    /**
     * Listar todos los clientes
     */
    public function index(): View
    {
        $clientes = Cliente::all();

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(): View
    {
        return view('clientes.create');
    }

    /**
     * Mostrar un cliente específico
     */
    public function show(Cliente $cliente): View
    {
        $cliente->load('prestamos');

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Crear un nuevo cliente
     */
    public function store(StoreClienteRequest $request): RedirectResponse
    {
        Cliente::create($request->validated());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado correctamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar un cliente existente
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $cliente->update($request->validated());

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * Eliminar un cliente
     */
    public function destroy(Cliente $cliente): RedirectResponse
    {
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente');
    }
}
