@extends('layouts.admin')

@section('title', 'Préstamos')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Préstamos</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('prestamos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Préstamo
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Préstamos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($prestamos as $prestamo)
                                <tr>
                                    <td>{{ $prestamo->id }}</td>
                                    <td>
                                        <a href="{{ route('clientes.show', $prestamo->cliente) }}">
                                            {{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellido }}
                                        </a>
                                    </td>
                                    <td>{{ $prestamo->tipoPrestamo->nombre }}</td>
                                    <td>${{ number_format($prestamo->monto, 2) }}</td>
                                    <td>{{ $prestamo->fecha->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($prestamo->estado === 'completado')
                                            <span class="badge bg-success">Completado</span>
                                        @elseif ($prestamo->estado === 'cancelado')
                                            <span class="badge bg-danger">Cancelado</span>
                                        @else
                                            <span class="badge bg-warning">Activo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('prestamos.show', $prestamo) }}" class="btn btn-sm btn-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('prestamos.edit', $prestamo) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        <i class="fas fa-inbox"></i> No hay préstamos registrados
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
