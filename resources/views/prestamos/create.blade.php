@extends('layouts.admin')

@section('title', 'Nuevo Préstamo')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Nuevo Préstamo</h1>
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
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Formulario de Préstamo</h3>
                </div>
                <form action="{{ route('prestamos.store') }}" method="POST" class="card-body">
                    @csrf

                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">Cliente *</label>
                        <select class="form-select @error('cliente_id') is-invalid @enderror" id="cliente_id" name="cliente_id" required>
                            <option value="">Seleccionar cliente...</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }} {{ $cliente->apellido }} ({{ $cliente->ci }})
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tipo_prestamo_id" class="form-label">Tipo de Préstamo *</label>
                        <select class="form-select @error('tipo_prestamo_id') is-invalid @enderror" id="tipo_prestamo_id" name="tipo_prestamo_id" required>
                            <option value="">Seleccionar tipo...</option>
                            @foreach ($tiposPrestamo as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_prestamo_id') == $tipo->id ? 'selected' : '' }} data-interes="{{ $tipo->interes }}" data-plazo="{{ $tipo->plazo }}">
                                    {{ $tipo->nombre }} ({{ $tipo->interes }}% - {{ $tipo->plazo }} meses)
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_prestamo_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto Inicial *</label>
                        <input type="number" class="form-control @error('monto') is-invalid @enderror" id="monto" name="monto" value="{{ old('monto') }}" step="0.01" placeholder="10000.00" required>
                        @error('monto')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha del Préstamo *</label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                        @error('fecha')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="alert alert-info d-none" id="calculoAlert" role="alert">
                        <strong>Cálculo del Préstamo:</strong>
                        <br>Monto: <span id="calcMonto">$0.00</span>
                        <br>Interés: <span id="calcInteres">0%</span>
                        <br>Plazo: <span id="calcPlazo">0 meses</span>
                        <br><strong>Cuota Mensual: $<span id="cuotaMensual">0.00</span></strong>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Crear Préstamo
                        </button>
                        <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const montoInput = document.getElementById('monto');
            const tipoSelect = document.getElementById('tipo_prestamo_id');
            const alert = document.getElementById('calculoAlert');
            const calcMonto = document.getElementById('calcMonto');
            const calcInteres = document.getElementById('calcInteres');
            const calcPlazo = document.getElementById('calcPlazo');
            const cuotaMensual = document.getElementById('cuotaMensual');

            function calcularCuota() {
                const monto = parseFloat(montoInput.value) || 0;
                const tipoOption = tipoSelect.options[tipoSelect.selectedIndex];
                const interes = parseFloat(tipoOption.dataset.interes) || 0;
                const plazo = parseInt(tipoOption.dataset.plazo) || 0;

                if (monto > 0 && plazo > 0) {
                    const montoConInteres = monto * (1 + interes / 100);
                    const cuota = montoConInteres / plazo;

                    calcMonto.textContent = '$' + monto.toFixed(2);
                    calcInteres.textContent = interes + '%';
                    calcPlazo.textContent = plazo + ' meses';
                    cuotaMensual.textContent = cuota.toFixed(2);
                    alert.classList.remove('d-none');
                } else {
                    alert.classList.add('d-none');
                }
            }

            montoInput.addEventListener('input', calcularCuota);
            tipoSelect.addEventListener('change', calcularCuota);
        });
    </script>
@endsection
