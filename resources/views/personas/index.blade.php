@extends('adminlte::page')

@section('title', 'Personas')

@section('content')
<a href="{{ route('personas.create') }}" class="btn btn-primary mb-2">Nueva Persona</a>

<table class="table table-bordered">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Edad</th>
        <th>Acciones</th>
    </tr>

    @foreach($personas as $p)
    <tr>
        <td>{{ $p->nombre }}</td>
        <td>{{ $p->email }}</td>
        <td>{{ $p->edad }}</td>
        <td>
            <a href="{{ route('personas.edit', $p) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('personas.destroy', $p) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection