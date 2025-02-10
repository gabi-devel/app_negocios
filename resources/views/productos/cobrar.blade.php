@extends('layouts.app')

@section('estilos') 
    <link rel="stylesheet" href="../../css/responsive.css">
@endsection

@section('content')
<div class="container">
    <h3>Cobrar</h3>

    <div id="scanner-wrapper">
        <div id="quagga-container"></div>
    </div>

      <div class="pagina" style="margin-top:0px;">
        <p><strong>Código detectado:</strong> <span id="scanned-code"></span></p> 
        <button id="restart-scanner" class="btn btn-secondary" style="display: none;">Escanear otro código</button>
    
        {{--  Contenedor donde se agregarán los productos escaneados  --}}
        <div id="product-form-container"></div>
    
        <h4>Total: $<span id="total-amount">0.00</span></h4>
    
        <button id="dar-total" class="btn btn-primary">Dar el total</button>
        <button id="confirmar-cobro" class="btn btn-success" style="display: none;">Confirmar y Cobrar</button>
        <button id="reiniciar-escaneo" class="btn btn-danger">Reiniciar Escaneo</button>
    </div>

        <br>
        <a href="{{ route('productos.index') }}">Ir a Listado de Productos</a>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <script src="../js/scanner_cobrar.js"></script>
@endsection