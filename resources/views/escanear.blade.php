@extends('layouts.app')

@section('estilos')
    <link rel="manifest" href="/manifest.json">
@endsection

@section('content')

<div class="container">
    <h2>Escanear</h2>

    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <div id="quagga-container" style="width: 300px; height: 300px; border: 1px solid black;"></div>

    <p><strong>Código detectado:</strong> <span id="scanned-code">N/A</span></p>
    <video id="barcode-video" style="display: none; width: 300px; height: auto;"></video>
    <p><strong>Código con BarcodeDetector:</strong> <span id="barcode-result">N/A</span></p>

    <script>
        // Inicializar Quagga
        Quagga.init(
            {
                inputStream: {
                    type: "LiveStream",
                    target: document.querySelector("#quagga-container"),
                },
                decoder: {
                    readers: ["ean_reader", "code_128_reader"], // Tipos de códigos a escanear
                },
            },
            function (err) {
                if (err) {
                    console.error("Error al inicializar Quagga:", err);
                    return;
                }
                console.log("Quagga inicializado correctamente");
                Quagga.start();
            }
        );

        // Manejamos la detección de Quagga
        Quagga.onDetected(function (result) {
            const code = result.codeResult.code;
            console.log("Código detectado por Quagga:", code);
            document.getElementById("scanned-code").textContent = code;

            // Mostrar un mensaje de confirmación
            const userResponse = confirm(`Código detectado por Quagga: ${code}\n¿Es correcto?`);

            if (userResponse) { // Si el usuario confirma, detener Quagga
                Quagga.stop();
                alert("Código confirmado: " + code);
            } else { // Si el usuario no confirma, detener Quagga y usar BarcodeDetector
                Quagga.stop();
                alert("Intentando escanear con otra tecnología...");
                useBarcodeDetector();
            }
        });

        // Función para usar BarcodeDetector
        async function useBarcodeDetector() {
            if (!('BarcodeDetector' in window)) {
                alert("BarcodeDetector no es compatible con este navegador.");
                return;
            }

            const barcodeDetector = new BarcodeDetector({ formats: ['ean_13', 'ean_8', 'code_128'] });
            const video = document.getElementById("barcode-video");
            video.style.display = "block";

            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
                video.srcObject = stream;
                video.play();

                const scanBarcode = async () => {
                    try {
                        const barcodes = await barcodeDetector.detect(video);
                        if (barcodes.length > 0) {
                            const detectedCode = barcodes[0].rawValue;
                            document.getElementById("barcode-result").textContent = detectedCode;

                            // Preguntar si el código es correcto
                            const userResponse = confirm(`Código detectado con BarcodeDetector: ${detectedCode}\n¿Es correcto?`);

                            if (userResponse) {
                                alert("Código confirmado: " + detectedCode);
                                stream.getTracks().forEach((track) => track.stop());
                                video.style.display = "none";
                            } else {
                                alert("Intentando nuevamente...");
                            }
                        } else {
                            document.getElementById("barcode-result").textContent = "No se detectó ningún código.";
                        }
                    } catch (error) {
                        console.error("Error al detectar el código:", error);
                    }
                };

                // Escanear continuamente cada 500ms
                const interval = setInterval(scanBarcode, 500);

                // Detener el escaneo después de un tiempo o cuando se confirme
                setTimeout(() => {
                    clearInterval(interval);
                    stream.getTracks().forEach((track) => track.stop());
                    video.style.display = "none";
                }, 30000); // Detener tras 30 segundos
            } catch (error) {
                console.error("Error al acceder a la cámara:", error);
            }
        }
    </script>
</div>
@endsection
