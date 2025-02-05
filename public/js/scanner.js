document.addEventListener('DOMContentLoaded', function () {
    function startScanner() {
        document.getElementById("quagga-container").style.display = "block"; // Mostrar el recuadro al escanear
        Quagga.init({
            inputStream: {
                type: "LiveStream",
                target: document.querySelector("#quagga-container"),
                constraints: {
                    width: 640,
                    height: 480,
                    facingMode: "environment"
                }
            },
            decoder: {
                readers: ["ean_reader", "code_128_reader"],
                multiple: false
            },
            locate: true,
            locator: {
                patchSize: "medium", // Opciones: "x-small", "small", "medium", "large"
                halfSample: true
            },
            area: { // Define un área más pequeña para mejorar precisión
                top: "10%",    // Excluye parte superior
                //right: "20%",  // Excluye parte derecha
                //left: "20%",   // Excluye parte izquierda
                bottom: "10%"  // Excluye parte inferior
            },
            numOfWorkers: navigator.hardwareConcurrency || 4, // Usa múltiples núcleos del procesador
            frequency: 10, // Reduce la cantidad de intentos de detección por segundo (mejora estabilidad)
            debug: false
        }, function (err) {
            if (err) {
                console.error("Error al inicializar Quagga:", err);
                return;
            }
            console.log("Quagga inicializado correctamente");
            Quagga.start();
        });
        
    }

    startScanner();

    let lastScannedCode = "";
    let scanCount = 0;
    const requiredScans = 3; // Número de veces que debe detectarse el mismo código antes de aceptarlo
    let tempCode = "";

    Quagga.onDetected(function (result) {
        const code = result.codeResult.code;

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

        if (scanCount >= requiredScans) {
            console.log("Código confirmado:", code);
            document.getElementById("scanned-code").textContent = code;
            document.getElementById("codigo_barra").value = code;

            document.getElementById("quagga-container").style.display = "none";
            Quagga.stop();
            document.getElementById("restart-scanner").style.display = "block";
        }
    });

    document.getElementById("restart-scanner").addEventListener("click", function () {
        Quagga.stop(); // Asegurar que se detenga completamente
        startScanner();
        this.style.display = "none"; // Ocultar el botón de reinicio
    });
    
});