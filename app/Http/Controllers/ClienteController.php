<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    /**
     * Listar todos los clientes
     */
    public function index(): JsonResponse
    {
        $clientes = Cliente::all();

        return response()->json($clientes);
    }

    /**
     * Mostrar un cliente específico
     */
    public function show(Cliente $cliente): JsonResponse
    {
        return response()->json($cliente->load('prestamos'));
    }

    /**
     * Crear un nuevo cliente
     */
    public function store(StoreClienteRequest $request): JsonResponse
    {
        $cliente = Cliente::create($request->validated());

        return response()->json($cliente, 201);
    }

    /**
     * Actualizar un cliente existente
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente): JsonResponse
    {
        $cliente->update($request->validated());

        return response()->json($cliente);
    }

    /**
     * Eliminar un cliente
     */
    public function destroy(Cliente $cliente): JsonResponse
    {
        $cliente->delete();

        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}
