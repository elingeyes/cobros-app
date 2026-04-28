@extends('layouts.admin')

@section('title', 'Detalles Tipo de Préstamo')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Detalles del Tipo de Préstamo</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('tipos-prestamo.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title text-white">{{ $tipoPrestamo->nombre }}</h3>
                </div>
                <div class="card-body">
                    <strong>Nombre</strong>
                    <p>{{ $tipoPrestamo->nombre }}</p>

                    <strong>Interés</strong>
                    <p><span class="badge bg-warning">{{ $tipoPrestamo->interes }}%</span></p>

                    <strong>Plazo</strong>
                    <p><span class="badge bg-secondary">{{ $tipoPrestamo->plazo }} meses</span></p>

                    <strong>Descripción</strong>
                    <p>{{ $tipoPrestamo->descripcion ?? 'N/A' }}</p>

                    <div class="d-flex gap-2">
                        <a href="{{ route('tipos-prestamo.edit', $tipoPrestamo) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('tipos-prestamo.destroy', $tipoPrestamo) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este tipo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Préstamos con Este Tipo</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tipoPrestamo->prestamos as $prestamo)
                                    <tr>
                                        <td>{{ $prestamo->id }}</td>
                                        <td>
                                            <a href="{{ route('clientes.show', $prestamo->cliente) }}">
                                                {{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellido }}
                                            </a>
                                        </td>
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
                                            <a href="{{ route('prestamos.show', $prestamo) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            <i class="fas fa-inbox"></i> No hay préstamos de este tipo
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
