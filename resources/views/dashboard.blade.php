@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Dashboard General</h1>
        <div class="btn-group">
            <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus"></i> Nuevo Cliente
            </a>
            <a href="{{ route('prestamos.create') }}" class="btn btn-success btn-sm ml-2">
                <i class="fas fa-hand-holding-usd"></i> Nuevo Préstamo
            </a>
            <a href="{{ route('pagos.index') }}" class="btn btn-info btn-sm ml-2 text-white">
                <i class="fas fa-receipt"></i> Registrar Pago
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Métricas Principales -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalClientes }}</h3>
                    <p>Clientes Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('clientes.index') }}" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $prestamosActivos }}</h3>
                    <p>Préstamos Activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <a href="{{ route('prestamos.index') }}" class="small-box-footer">Ver todos <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $cuotasPendientes }}</h3>
                    <p>Cuotas Pendientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="{{ route('cuotas.index') }}" class="small-box-footer">Ver todas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $cuotasVencidas }}</h3>
                    <p>Cuotas Vencidas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('cuotas.index') }}" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Métricas Financieras -->
    <div class="row">
        <div class="col-md-4">
            <div class="info-box shadow-none border">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-wave"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Prestado</span>
                    <span class="info-box-number">${{ number_format($montoTotalPrestado, 2) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box shadow-none border">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-piggy-bank"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Recaudado</span>
                    <span class="info-box-number">${{ number_format($montoTotalRecaudado, 2) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box shadow-none border">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-balance-scale"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Saldo Pendiente</span>
                    <span class="info-box-number">${{ number_format($montoTotalAdeudado, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Gráfico de Pagos -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Recaudación (Últimos 7 días)</h3>
                        <a href="{{ route('pagos.index') }}">Ver reporte detallado</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="position-relative mb-4">
                        <canvas id="payments-chart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Préstamos Recientes -->
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Préstamos Recientes</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prestamosRecientes as $prestamo)
                                    <tr>
                                        <td><a href="{{ route('prestamos.show', $prestamo) }}">#{{ $prestamo->id }}</a></td>
                                        <td>{{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellido }}</td>
                                        <td>${{ number_format($prestamo->monto, 2) }}</td>
                                        <td>
                                            @if ($prestamo->estado === 'completado')
                                                <span class="badge badge-success">Completado</span>
                                            @elseif ($prestamo->estado === 'cancelado')
                                                <span class="badge badge-danger">Cancelado</span>
                                            @else
                                                <span class="badge badge-warning">Activo</span>
                                            @endif
                                        </td>
                                        <td>{{ $prestamo->fecha->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay préstamos recientes</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <a href="{{ route('prestamos.create') }}" class="btn btn-sm btn-info float-left text-white">Nuevo Préstamo</a>
                    <a href="{{ route('prestamos.index') }}" class="btn btn-sm btn-secondary float-right">Ver todos</a>
                </div>
            </div>
        </div>

        <!-- Pagos Recientes -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Últimos Pagos</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse ($pagosRecientes as $pago)
                            <li class="item">
                                <div class="product-img">
                                    <i class="fas fa-receipt fa-2x text-success"></i>
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">
                                        {{ $pago->cuota->prestamo->cliente->nombre }}
                                        <span class="badge badge-success float-right">${{ number_format($pago->monto, 2) }}</span>
                                    </a>
                                    <span class="product-description">
                                        {{ $pago->fecha->format('d/m/Y') }} - {{ ucfirst($pago->metodo) }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item text-center p-4">
                                <span class="text-muted">No hay pagos registrados</span>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('pagos.index') }}" class="uppercase">Ver todos los pagos</a>
                </div>
            </div>

            <!-- Resumen de Estados -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Estados de Préstamos</h3>
                </div>
                <div class="card-body">
                    <div class="progress-group">
                        Préstamos Activos
                        <span class="float-right"><b>{{ $prestamosActivos }}</b>/{{ $prestamosActivos + $prestamosCompletados }}</span>
                        <div class="progress progress-sm">
                            @php
                                $totalP = $prestamosActivos + $prestamosCompletados;
                                $porcentajeActivos = $totalP > 0 ? ($prestamosActivos / $totalP) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-warning" style="width: {{ $porcentajeActivos }}%"></div>
                        </div>
                    </div>

                    <div class="progress-group mt-3">
                        Préstamos Completados
                        <span class="float-right"><b>{{ $prestamosCompletados }}</b>/{{ $totalP }}</span>
                        <div class="progress progress-sm">
                            @php
                                $porcentajeCompletados = $totalP > 0 ? ($prestamosCompletados / $totalP) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-success" style="width: {{ $porcentajeCompletados }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            'use strict'

            var ticksStyle = {
                fontColor: '#adb5bd',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            var $paymentsChart = $('#payments-chart')
            var paymentsChart = new Chart($paymentsChart, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($pagosPorDia as $pago)
                            '{{ \Carbon\Carbon::parse($pago->fecha)->format('d/m') }}',
                        @endforeach
                    ],
                    datasets: [
                        {
                            backgroundColor: '#28a745',
                            borderColor: '#28a745',
                            data: [
                                @foreach($pagosPorDia as $pago)
                                    {{ $totalClientes > 0 ? $pago->total : 0 }},
                                @endforeach
                            ]
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(255, 255, 255, .05)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                callback: function (value) {
                                    if (value >= 1000) {
                                        value /= 1000
                                        value += 'k'
                                    }
                                    return '$' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
        })
    </script>
@stop
