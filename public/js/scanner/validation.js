export function handleDetectedCode() {
    let lastScannedCode = ""; // Último código detectado
    let scanCount = 0; // Veces que se detectó el mismo código
    const requiredScans = 3; // Necesita 3 detecciones seguidas para aceptar un código
    let tempCode = ""; // Almacena un código temporal antes de confirmarlo

    Quagga.onDetected(function (result) {
        const code = result.codeResult.code; // Evento cuando se detecta un código

        // Detectar 3 veces seguidas:
        if (code === lastScannedCode) {
            scanCount++;
        } else {
            if (code === tempCode) {
                lastScannedCode = code;
                scanCount = 1;
            } else {
                tempCode = code;
                scanCount = 0;
            }
        }

        if (scanCount >= requiredScans) { // Si el código es válido:
            console.log("Código confirmado:", code);
            document.getElementById("scanned-code").textContent = code; // Se muestra en la página
            document.getElementById("codigo_barra").value = code; 

            document.getElementById("quagga-container").style.display = "none"; // Se oculta el escáner
            Quagga.stop(); // Se detiene QuaggaJS
            document.getElementById("restart-scanner").style.display = "block"; // Se muestra el botón para reiniciar el escaneo

            // 🔹 Hacer la consulta AJAX después de confirmar el código
            buscarProducto(code);
        }
    });
}

// Función para buscar el producto en la base de datos
function buscarProducto(codigo) {
    fetch(`/buscar-producto?codigo_barra=${codigo}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("nombre").value = data.producto.nombre || "";
                document.getElementById("marca").value = data.producto.marca || "";
                document.getElementById("precio").value = data.producto.precio || "";
            } else {
                console.log("Producto no encontrado, ingresa los datos manualmente.");
            }
        })
        .catch(error => console.error("Error buscando el producto:", error));
}