@extends('layouts.admin')

@section('title', 'Detalles Préstamo')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Detalles del Préstamo</h1>
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
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title text-white">Información General</h3>
                </div>
                <div class="card-body">
                    <strong>Préstamo #</strong>
                    <p>{{ $prestamo->id }}</p>

                    <strong>Cliente</strong>
                    <p>
                        <a href="{{ route('clientes.show', $prestamo->cliente) }}">
                            {{ $prestamo->cliente->nombre }} {{ $prestamo->cliente->apellido }}
                        </a>
                    </p>

                    <strong>Tipo</strong>
                    <p>{{ $prestamo->tipoPrestamo->nombre }}</p>

                    <strong>Monto Inicial</strong>
                    <p><span class="badge bg-primary">${{ number_format($prestamo->monto, 2) }}</span></p>

                    <strong>Interés</strong>
                    <p><span class="badge bg-warning">{{ $prestamo->tipoPrestamo->interes }}%</span></p>

                    <strong>Plazo</strong>
                    <p><span class="badge bg-secondary">{{ $prestamo->tipoPrestamo->plazo }} meses</span></p>

                    <strong>Fecha</strong>
                    <p>{{ $prestamo->fecha->format('d/m/Y') }}</p>

                    <strong>Estado</strong>
                    <p>
                        @if ($prestamo->estado === 'completado')
                            <span class="badge bg-success">Completado</span>
                        @elseif ($prestamo->estado === 'cancelado')
                            <span class="badge bg-danger">Cancelado</span>
                        @else
                            <span class="badge bg-warning">Activo</span>
                        @endif
                    </p>

                    <div class="d-flex gap-2">
                        <a href="{{ route('prestamos.edit', $prestamo) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Cuotas del Préstamo</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Cuota #</th>
                                    <th>Vencimiento</th>
                                    <th>Monto</th>
                                    <th>Saldo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prestamo->cuotas as $cuota)
                                    <tr>
                                        <td><strong>{{ $cuota->numero }}</strong></td>
                                        <td>{{ $cuota->vencimiento->format('d/m/Y') }}</td>
                                        <td>${{ number_format($cuota->monto, 2) }}</td>
                                        <td>${{ number_format($cuota->saldo, 2) }}</td>
                                        <td>
                                            @if ($cuota->estado === 'pagada')
                                                <span class="badge bg-success">Pagada</span>
                                            @elseif ($cuota->estado === 'parcial')
                                                <span class="badge bg-warning">Parcial</span>
                                            @else
                                                <span class="badge bg-danger">Pendiente</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('cuotas.show', $cuota) }}" class="btn btn-xs btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($cuota->estado !== 'pagada')
                                                <a href="{{ route('pagos.create', ['cuota_id' => $cuota->id]) }}" class="btn btn-xs btn-success" title="Registrar Pago">
                                                    <i class="fas fa-money-bill"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            <i class="fas fa-inbox"></i> No hay cuotas
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-success">
                    <h3 class="card-title text-white">Pagos Realizados</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Cuota</th>
                                    <th>Fecha Pago</th>
                                    <th>Monto Pagado</th>
                                    <th>Método</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prestamo->cuotas->flatMap->pagos as $pago)
                                    <tr>
                                        <td>#{{ $pago->cuota->numero }}</td>
                                        <td>{{ $pago->fecha->format('d/m/Y') }}</td>
                                        <td>${{ number_format($pago->monto, 2) }}</td>
                                        <td><span class="badge bg-info">{{ ucfirst($pago->metodo) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            <i class="fas fa-inbox"></i> No hay pagos registrados
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
