@extends('layouts.app')

@section('estilos') 
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
    <h3>Cobrar</h3>

    <div id="scanner-wrapper">
        <div id="quagga-container"></div>
    </div>

    <div class="pagina">
        <p><strong>Código detectado:</strong> <span id="scanned-code"></span></p>
        <button id="restart-scanner" class="btn btn-secondary" style="display: none;">Escanear otro código</button>
        
        <h4>Productos escaneados</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="product-list">
                <!-- Aquí se mostrarán los productos escaneados -->
            </tbody>
        </table>
        
        <h4>Total: $<span id="total-amount">0.00</span></h4>
        <button id="dar-total" class="btn btn-primary">Dar el total</button>
        <button id="confirmar-cobro" class="btn btn-success" style="display: none;">Confirmar y Cobrar</button>
        <button id="reiniciar-escaneo" class="btn btn-danger">Reiniciar Escaneo</button>
    
        <br>
        <a href="{{ route('productos.index') }}">Ir a Listado de Productos</a>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <script src="../js/scanner_cobrar.js"></script>
@endsection

        
       
