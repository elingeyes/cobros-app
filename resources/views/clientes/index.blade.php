@extends('adminlte::page')
<!-- @extends('layouts.admin') -->

@section('title', 'Clientes')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Clientes</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Cliente
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Clientes</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>CI</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                                    <td>{{ $cliente->email }}</td>
                                    <td>{{ $cliente->ci }}</td>
                                    <td>{{ $cliente->telefono }}</td>
                                    <td>
                                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este cliente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <i class="fas fa-inbox"></i> No hay clientes registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
