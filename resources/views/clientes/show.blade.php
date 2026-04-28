@extends('adminlte::page')
<!-- @extends('layouts.admin') -->

@section('title', 'Detalles Cliente')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Detalles del Cliente</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title text-white">{{ $cliente->nombre }} {{ $cliente->apellido }}</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nombre:</strong>
                            <p>{{ $cliente->nombre }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Apellido:</strong>
                            <p>{{ $cliente->apellido }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>CI:</strong>
                            <p>{{ $cliente->ci }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong>
                            <p>{{ $cliente->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Teléfono:</strong>
                            <p>{{ $cliente->telefono ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Dirección:</strong>
                            <p>{{ $cliente->direccion ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este cliente?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Préstamos del Cliente</h3>
                </div>
                <div class="card-body">
                    @if ($cliente->prestamos->count())
                        <ul class="list-unstyled">
                            @foreach ($cliente->prestamos as $prestamo)
                                <li class="mb-2">
                                    <a href="{{ route('prestamos.show', $prestamo) }}">
                                        <strong>Préstamo #{{ $prestamo->id }}</strong>
                                    </a>
                                    <br>
                                    <small class="text-muted">
                                        Monto: ${{ number_format($prestamo->monto, 2) }} | 
                                        Estado: <span class="badge bg-{{ $prestamo->estado === 'completado' ? 'success' : 'warning' }}">{{ $prestamo->estado }}</span>
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center">Este cliente no tiene préstamos</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
