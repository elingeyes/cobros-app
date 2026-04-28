@extends('layouts.admin')

@section('title', 'Editar Préstamo')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Editar Préstamo</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title">Editar Préstamo #{{ $prestamo->id }}</h3>
                </div>
                <form action="{{ route('prestamos.update', $prestamo) }}" method="POST" class="card-body">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" value="{{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellido }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipo" class="form-label">Tipo de Préstamo</label>
                            <input type="text" class="form-control" value="{{ $prestamo->tipoPrestamo->nombre }}" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="text" class="form-control" value="${{ number_format($prestamo->monto, 2) }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="text" class="form-control" value="{{ $prestamo->fecha->format('d/m/Y') }}" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado *</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="activo" {{ $prestamo->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="completado" {{ $prestamo->estado === 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelado" {{ $prestamo->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('estado')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Actualizar
                        </button>
                        <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
