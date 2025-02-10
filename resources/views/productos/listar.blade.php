@extends('layouts.app')

@section('content')
<style>
{{--  :root {
    --color-de-la-marca: #c6538c;
    --color2: 20px;
}
.container {
    h2 {
        color:red;
    }
    table {
        background-color: yellow;
        tr {
            font-size: var(--color2);
        }
    }
}  --}}
</style>
<div class="container">
    <h2>Lista de Productos</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Código de Barras</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->codigo_barra }}</td>
                    <td>{{ $producto->marca }}</td>
                    <td>${{ number_format($producto->precio, 2, ',', '.') }}</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</button>
                        </form>                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('productos.create') }}">Agregar Productos</a>
</div>
@endsection
