@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Clientes</span>
                    <span class="info-box-number">{{ $totalClientes }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-handshake"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Préstamos Activos</span>
                    <span class="info-box-number">{{ $prestamosActivos }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Cuotas Pendientes</span>
                    <span class="info-box-number">{{ $cuotasPendientes }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Monto Total Adeudado</span>
                    <span class="info-box-number">${{ number_format($montoTotalAdeudado, 0) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Préstamos Recientes</h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($prestamosRecientes as $prestamo)
                                <tr>
                                    <td>
                                        <a href="{{ route('prestamos.show', $prestamo) }}">
                                            {{ $prestamo->cliente->nombre }}
                                        </a>
                                    </td>
                                    <td>${{ number_format($prestamo->monto, 2) }}</td>
                                    <td>
                                        @if ($prestamo->estado === 'completado')
                                            <span class="badge bg-success">Completado</span>
                                        @elseif ($prestamo->estado === 'cancelado')
                                            <span class="badge bg-danger">Cancelado</span>
                                        @else
                                            <span class="badge bg-warning">Activo</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Sin préstamos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title text-white">Pagos Recientes</h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pagosRecientes as $pago)
                                <tr>
                                    <td>
                                        <a href="{{ route('clientes.show', $pago->cuota->prestamo->cliente) }}">
                                            {{ $pago->cuota->prestamo->cliente->nombre }}
                                        </a>
                                    </td>
                                    <td>${{ number_format($pago->monto, 2) }}</td>
                                    <td>{{ $pago->fecha->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Sin pagos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
