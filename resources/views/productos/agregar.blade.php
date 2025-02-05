@extends('layouts.app')

@section('estilos') 
    {{--  <link rel="manifest" href="/manifest.json">  --}}
    <style>
        #scanner-wrapper { /* quagga-container */
            width: 300px; 
            height: 300px; 
            border: 1px solid black;
        }
    </style>
    <link rel="stylesheet" href="../../css/responsive.css">
@endsection

@section('content')
<div class="container">
    {{--  <h4>Escanear Código de Barras</h4>  --}}
    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>

    {{--  Contenedor del escáner  --}}
    <div id="scanner-wrapper">
        <div id="quagga-container"></div>
    </div>    

    <div class="pagina">
        <p><strong>Código detectado:</strong> <span id="scanned-code"></span></p>
        
        <button id="restart-scanner" class="btn btn-secondary" style="display: none;">Escanear otro código</button>

        <form id="producto-form" method="POST" action="{{ route('productos.store') }}">
            @csrf
            <h4>Agregar o Editar más datos</h4>
            <div class="mb-3">
                <label for="codigo_barra" class="form-label">Código de Barras</label>
                <input type="text" id="codigo_barra" name="codigo_barra" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="producto" class="form-label">Nombre del Producto</label>
                <input type="text" id="producto" name="producto" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" id="marca" name="marca" class="form-control">
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" id="precio" name="precio" class="form-control" step="0.01">
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">(Opcional) Cantidad de productos</label>
                <input type="number" id="cantidad" name="cantidad" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Producto</button>
        </form>

        <br>
        <a href="{{ route('productos.index') }}">  Ir a Listado de Productos </a>
    </div>
</div>

@endsection

@section('scripts') <script src="../js/scanner.js"></script> @endsection
        
       
