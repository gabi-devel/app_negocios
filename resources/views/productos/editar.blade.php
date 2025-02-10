@extends('layouts.app')

@section('content')
<div class="container">
    <form id="producto-form" method="POST" action="{{ route('productos.update', $producto->id) }}">
        @csrf
        @method('PUT')
        <h4>Editar</h4>
        <div class="mb-3">
            <label for="codigo_barra" class="form-label">Código de Barras</label>
            <input type="text" id="codigo_barra" name="codigo_barra" class="form-control"  required value="{{ old('codigo_barra', $producto->codigo_barra) }}">
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Producto</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required value="{{ old('nombre', $producto->nombre) }}">
        </div>
        <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" id="marca" name="marca" class="form-control" value="{{ old('marca', $producto->marca) }}">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" id="precio" name="precio" class="form-control" step="0.01" value="{{ old('precio', $producto->precio) }}">
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">(Opcional) Cantidad de productos</label>
            <input type="number" id="cantidad" name="cantidad" class="form-control" value="{{ old('cantidad', $producto->cantidad) }}">
        </div>
        <div class="mb-3">
            <input type="checkbox" name="disponible" value="1" {{ old('disponible', $producto->disponible) ? 'checked' : '' }}>
            Hay stock{{--   type="hidden"  --}}
        </div>
        <button type="submit" class="btn btn-primary">Guardar Producto</button>
    </form>

    <br>
    <a href="{{ route('productos.index') }}">  Ir a Listado de Productos </a>
</div>

@endsection


        
       
