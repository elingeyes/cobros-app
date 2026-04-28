@extends('layouts.admin')

@section('title', 'Tipos de Préstamo')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Tipos de Préstamo</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('tipos-prestamo.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Tipo
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Tipos de Préstamo</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Interés (%)</th>
                                <th>Plazo (meses)</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tiposPrestamo as $tipo)
                                <tr>
                                    <td>{{ $tipo->id }}</td>
                                    <td><strong>{{ $tipo->nombre }}</strong></td>
                                    <td><span class="badge bg-info">{{ $tipo->interes }}%</span></td>
                                    <td><span class="badge bg-secondary">{{ $tipo->plazo }} meses</span></td>
                                    <td>{{ $tipo->descripcion ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('tipos-prestamo.edit', $tipo) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tipos-prestamo.destroy', $tipo) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este tipo?');">
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
                                        <i class="fas fa-inbox"></i> No hay tipos de préstamo registrados
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
