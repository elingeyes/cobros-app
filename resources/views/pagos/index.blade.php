@extends('layouts.admin')

@section('title', 'Pagos')

@section('header-title')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Pagos</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('pagos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Pago
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Pagos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Cuota</th>
                                <th>Fecha Pago</th>
                                <th>Monto</th>
                                <th>Método</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pagos as $pago)
                                <tr>
                                    <td>{{ $pago->id }}</td>
                                    <td>
                                        <a href="{{ route('clientes.show', $pago->cuota->prestamo->cliente) }}">
                                            {{ $pago->cuota->prestamo->cliente->nombre }} {{ $pago->cuota->prestamo->cliente->apellido }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('cuotas.show', $pago->cuota) }}">
                                            Cuota #{{ $pago->cuota->numero }} (Préstamo #{{ $pago->cuota->prestamo->id }})
                                        </a>
                                    </td>
                                    <td>{{ $pago->fecha->format('d/m/Y') }}</td>
                                    <td><strong>${{ number_format($pago->monto, 2) }}</strong></td>
                                    <td><span class="badge bg-info">{{ ucfirst($pago->metodo) }}</span></td>
                                    <td>
                                        <form action="{{ route('pagos.destroy', $pago) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este pago?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
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
@endsection
