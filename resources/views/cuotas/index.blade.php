@extends('layouts.admin')

@section('title', 'Cuotas')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Cuotas</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Cuotas</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Préstamo</th>
                                <th>Cuota #</th>
                                <th>Vencimiento</th>
                                <th>Monto</th>
                                <th>Saldo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cuotas as $cuota)
                                <tr>
                                    <td>{{ $cuota->id }}</td>
                                    <td>
                                        <a href="{{ route('prestamos.show', $cuota->prestamo) }}">
                                            Préstamo #{{ $cuota->prestamo->id }}
                                        </a>
                                    </td>
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
                                        <a href="{{ route('cuotas.show', $cuota) }}" class="btn btn-sm btn-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($cuota->estado !== 'pagada')
                                            <a href="{{ route('pagos.create', ['cuota_id' => $cuota->id]) }}" class="btn btn-sm btn-success" title="Registrar Pago">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        <i class="fas fa-inbox"></i> No hay cuotas registradas
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
