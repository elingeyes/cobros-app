@extends('layouts.admin')

@section('title', 'Editar Tipo de Préstamo')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Editar Tipo de Préstamo</h1>
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
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title">Editar: {{ $tipoPrestamo->nombre }}</h3>
                </div>
                <form action="{{ route('tipos-prestamo.update', $tipoPrestamo) }}" method="POST" class="card-body">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $tipoPrestamo->nombre) }}" required>
                        @error('nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="interes" class="form-label">Interés (%) *</label>
                            <input type="number" class="form-control @error('interes') is-invalid @enderror" id="interes" name="interes" value="{{ old('interes', $tipoPrestamo->interes) }}" step="0.01" required>
                            @error('interes')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="plazo" class="form-label">Plazo (meses) *</label>
                            <input type="number" class="form-control @error('plazo') is-invalid @enderror" id="plazo" name="plazo" value="{{ old('plazo', $tipoPrestamo->plazo) }}" required>
                            @error('plazo')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $tipoPrestamo->descripcion) }}</textarea>
                        @error('descripcion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Actualizar
                        </button>
                        <a href="{{ route('tipos-prestamo.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
