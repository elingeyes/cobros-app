@extends('layouts.admin')

@section('title', 'Detalles Cuota')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Detalles de Cuota</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('cuotas.index') }}" class="btn btn-secondary">
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
                    <h3 class="card-title text-white">Información de la Cuota</h3>
                </div>
                <div class="card-body">
                    <strong>Préstamo</strong>
                    <p>
                        <a href="{{ route('prestamos.show', $cuota->prestamo) }}">
                            Préstamo #{{ $cuota->prestamo->id }}
                        </a>
                    </p>

                    <strong>Cliente</strong>
                    <p>
                        <a href="{{ route('clientes.show', $cuota->prestamo->cliente) }}">
                            {{ $cuota->prestamo->cliente->nombre }} {{ $cuota->prestamo->cliente->apellido }}
                        </a>
                    </p>

                    <strong>Cuota Número</strong>
                    <p><span class="badge bg-primary">#{{ $cuota->numero }}</span></p>

                    <strong>Vencimiento</strong>
                    <p>{{ $cuota->vencimiento->format('d/m/Y') }}</p>

                    <strong>Monto de Cuota</strong>
                    <p>${{ number_format($cuota->monto, 2) }}</p>

                    <strong>Saldo Pendiente</strong>
                    <p><span class="badge bg-warning">${{ number_format($cuota->saldo, 2) }}</span></p>

                    <strong>Estado</strong>
                    <p>
                        @if ($cuota->estado === 'pagada')
                            <span class="badge bg-success">Pagada</span>
                        @elseif ($cuota->estado === 'parcial')
                            <span class="badge bg-warning">Parcial</span>
                        @else
                            <span class="badge bg-danger">Pendiente</span>
                        @endif
                    </p>

                    @if ($cuota->estado !== 'pagada')
                        <a href="{{ route('pagos.create', ['cuota_id' => $cuota->id]) }}" class="btn btn-sm btn-success w-100">
                            <i class="fas fa-money-bill"></i> Registrar Pago
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title text-white">Pagos de Esta Cuota</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha de Pago</th>
                                    <th>Monto Pagado</th>
                                    <th>Método</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cuota->pagos as $pago)
                                    <tr>
                                        <td>{{ $pago->id }}</td>
                                        <td>{{ $pago->fecha->format('d/m/Y') }}</td>
                                        <td><strong>${{ number_format($pago->monto, 2) }}</strong></td>
                                        <td><span class="badge bg-info">{{ ucfirst($pago->metodo) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            <i class="fas fa-inbox"></i> No hay pagos realizados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($cuota->pagos->count())
                        <div class="alert alert-info mt-3">
                            <strong>Total Pagado:</strong> ${{ number_format($cuota->pagos->sum('monto'), 2) }}
                            <br><strong>Pendiente:</strong> ${{ number_format($cuota->saldo, 2) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
