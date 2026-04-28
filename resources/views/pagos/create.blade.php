@extends('layouts.admin')

@section('title', 'Nuevo Pago')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Nuevo Pago</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
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
                    <h3 class="card-title text-white">Registrar Pago</h3>
                </div>
                <form action="{{ route('pagos.store') }}" method="POST" class="card-body">
                    @csrf

                    <div class="mb-3">
                        <label for="cuota_id" class="form-label">Cuota *</label>
                        <select class="form-select @error('cuota_id') is-invalid @enderror" id="cuota_id" name="cuota_id" required>
                            <option value="">Seleccionar cuota...</option>
                            @foreach ($cuotasPendientes as $cuota)
                                <option value="{{ $cuota->id }}" 
                                    {{ old('cuota_id') == $cuota->id || request('cuota_id') == $cuota->id ? 'selected' : '' }}
                                    data-saldo="{{ $cuota->saldo }}"
                                    data-numero="{{ $cuota->numero }}"
                                    data-prestamo-id="{{ $cuota->prestamo->id }}"
                                    data-cliente="{{ $cuota->prestamo->cliente->nombre }} {{ $cuota->prestamo->cliente->apellido }}">
                                    Cuota #{{ $cuota->numero }} | Cliente: {{ $cuota->prestamo->cliente->nombre }} | Saldo: ${{ number_format($cuota->saldo, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('cuota_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="alert alert-info d-none" id="cuotaInfo" role="alert">
                        <strong>Detalles de la Cuota:</strong>
                        <br>Préstamo: <a href="#" id="prestamoLink" target="_blank">#<span id="prestamoId">0</span></a>
                        <br>Cliente: <span id="cliente">N/A</span>
                        <br>Saldo Pendiente: <strong id="saldoPendiente">$0.00</strong>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha" class="form-label">Fecha del Pago *</label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                            @error('fecha')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="monto" class="form-label">Monto *</label>
                            <input type="number" class="form-control @error('monto') is-invalid @enderror" id="monto" name="monto" value="{{ old('monto') }}" step="0.01" placeholder="0.00" required>
                            @error('monto')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="metodo" class="form-label">Método de Pago *</label>
                        <select class="form-select @error('metodo') is-invalid @enderror" id="metodo" name="metodo" required>
                            <option value="">Seleccionar método...</option>
                            <option value="efectivo" {{ old('metodo') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="cheque" {{ old('metodo') === 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="transferencia" {{ old('metodo') === 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="tarjeta" {{ old('metodo') === 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        </select>
                        @error('metodo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Registrar Pago
                        </button>
                        <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cuotaSelect = document.getElementById('cuota_id');
            const info = document.getElementById('cuotaInfo');
            const prestamoLink = document.getElementById('prestamoLink');
            const prestamoId = document.getElementById('prestamoId');
            const cliente = document.getElementById('cliente');
            const saldoPendiente = document.getElementById('saldoPendiente');
            const montoInput = document.getElementById('monto');

            function actualizarInfo() {
                const option = cuotaSelect.options[cuotaSelect.selectedIndex];
                const saldo = parseFloat(option.dataset.saldo) || 0;
                const pId = option.dataset.prestamoId;
                const clienteNombre = option.dataset.cliente;

                if (option.value) {
                    prestamoId.textContent = pId;
                    prestamoLink.href = '/prestamos/' + pId;
                    cliente.textContent = clienteNombre;
                    saldoPendiente.textContent = '$' + saldo.toFixed(2);
                    montoInput.max = saldo.toFixed(2);
                    info.classList.remove('d-none');
                } else {
                    info.classList.add('d-none');
                    montoInput.max = '';
                }
            }

            cuotaSelect.addEventListener('change', actualizarInfo);
            actualizarInfo();
        });
    </script>
@endsection
