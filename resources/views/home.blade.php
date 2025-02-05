@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <div class="list-group">
        <a href="{{ route('productos.cobrar') }}" class="list-group-item list-group-item-action">
            Cobrar
        </a>
        <a href="{{ route('productos.create') }}" class="list-group-item list-group-item-action">
            Agregar Producto
        </a>
        <a href="{{ route('productos.index') }}" class="list-group-item list-group-item-action">
            Listado de Productos
        </a>
    </div>
</div>
@endsection
