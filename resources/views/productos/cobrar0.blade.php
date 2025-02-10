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

    {{--  <div class="pagina" style="margin-top:0px;">
        <p><strong>Código detectado:</strong> <span id="scanned-code"></span></p>

        <div class="input-group mb-3">
            <input type="text" id="manualCodigoBarrasInput" class="form-control" placeholder="Ingrese código de barras">
            <button class="btn btn-primary" id="addManualProduct">Agregar</button>
        </div>
        <script>
            document.getElementById("addManualProduct").addEventListener("click", function () {
                const code = document.getElementById("manualCodigoBarrasInput").value.trim();
            
                if (code === "") {
                    alert("Por favor, ingrese un código de barras.");
                    return;
                }
            
                fetch('/api/producto/' + code, {
                    method: "GET",
                    credentials: "include",  // Esto permite enviar la sesión del usuario
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta del servidor:", data);
                    if (!data.success || !data.producto) {
                        alert("Producto no encontrado");
                        return;
                    }
            
                    if (scannedProducts[code]) {
                        scannedProducts[code].cantidad += 1;
                    } else {
                        scannedProducts[code] = {
                            codigo: code,
                            nombre: data.producto.nombre, 
                            precio: parseFloat(data.producto.precio),
                            cantidad: 1,
                        };
                    }
            
                    document.getElementById("manualCodigoBarrasInput").value = ""; // Limpiar input
                })
                .catch(async error => {
                    console.error("Error en la petición:", error);
                
                    try {
                        const responseText = await error.response.text(); // Obtener respuesta como texto
                        console.error("Respuesta del servidor:", responseText);
                    } catch (e) {
                        console.error("No se pudo obtener la respuesta del servidor");
                    }
                });
            });
            
        </script>        

        <button id="restart-scanner" class="btn btn-secondary" style="display: none;">Escanear otro código</button>
          --}}
        {{--  <h4>Productos escaneados</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="product-list">
                <!-- Aquí se mostrarán los productos escaneados -->
            </tbody>
        </table>  --}}
        
      {{--    <h4>Total: $<span id="total-amount">0.00</span></h4>
        <button id="dar-total" class="btn btn-primary">Dar el total</button>
        <button id="confirmar-cobro" class="btn btn-success" style="display: none;">Confirmar y Cobrar</button>
        <button id="reiniciar-escaneo" class="btn btn-danger">Reiniciar Escaneo</button>
      --}}
      <div class="pagina" style="margin-top:0px;">
        <p><strong>Código detectado:</strong> <span id="scanned-code"></span></p> 
        <button id="restart-scanner" class="btn btn-secondary" style="display: none;">Escanear otro código</button>
    
        <!-- Contenedor donde se agregarán los productos escaneados -->
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

        
       
