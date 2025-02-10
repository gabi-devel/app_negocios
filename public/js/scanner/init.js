export function startScanner() { // Inicializa QuaggaJS y configura la cámara para leer códigos de barras
    //document.getElementById("quagga-container").style.display = "block"; // Muestra el área donde se visualizará el escaneo
    Quagga.init({
        inputStream: { // Configura la cámara
            type: "LiveStream", // Cámara en tiempo real
            target: document.querySelector("#quagga-container"), // Dónde mostrar el escaneo en la página
            constraints: { // Usa la cámara trasera (en móviles)
                /* width: 640,
                height: 480, */
                width: { ideal: 400 },
                height: { ideal: 300 },
                facingMode: "environment"
            }
        },
        decoder: {
            readers: ["ean_reader", "code_128_reader"],
            multiple: false
        },
        locate: true,
        locator: {
            patchSize: "medium", // "x-small", "small", "medium", "large"
            halfSample: true
        },
        area: { // top: "10%", bottom: "10%" //, right, left
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
        Quagga.start(); // Activa el escaneo cuando todo está listo
    });
    
}