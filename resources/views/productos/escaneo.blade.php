@extends('layouts.app')
{{--  
@section('estilos')
    <link rel="manifest" href="/manifest.json">
@endsection  --}}

@section('content')

<div class="container">
    <h2>Escanear</h2>

    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <div id="quagga-container" style="width: 300px; height: 300px; border: 1px solid black;"></div>
    <div id="scanner-container"></div>
    <p><strong>Código detectado:</strong> <span id="scanned-code"></span></p>
    <video id="barcode-video" style="display: none; width: 300px; height: auto;"></video>
    {{--  <p><strong>Código con BarcodeDetector:</strong> <span id="barcode-result">N/A</span></p>  --}}
        
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Quagga.init(
                {
                    inputStream: {
                        type: "LiveStream",
                        target: document.querySelector("#quagga-container"),
                        constraints: {
                            width: 640,  // Mayor resolución para mejorar detalle
                            height: 480,
                            facingMode: "environment",
                            zoom: 2   // Aumenta el zoom digital
                        }
                    },
                    decoder: {
                        readers: ["ean_reader", "code_128_reader"], // Tipos de códigos a escanear
                        multiple: false
                    },
                    locate: true,
                    locator: {
                        patchSize: "small",  // medium   Puedes probar "small" si los códigos son muy pequeños
                        halfSample: true
                    }
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

            Quagga.onDetected(function (result) {
                const code = result.codeResult.code;
                console.log("Código detectado por Quagga:", code);
                document.getElementById("scanned-code").textContent = code;
            
                fetch('/api/codigos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ codigo_barra: code })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message); // Mensaje desde el backend
                    Quagga.stop();
                })
                .catch(error => {
                    console.error("Error al guardar el código:", error);
                    Quagga.stop();
                });
            });
            
            navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "environment",
                    focusMode: "continuous"  // Enfoca automáticamente
                }
            }).then(stream => {
                let video = document.getElementById("barcode-video");
                video.srcObject = stream;
            });

            // Función para usar BarcodeDetector
            async function useBarcodeDetector() {
                if (!('BarcodeDetector' in window)) {
                    alert("BarcodeDetector no es compatible con este navegador.");
                    return;
                }

                const barcodeDetector = new BarcodeDetector({ formats: ['ean_13', 'ean_8', 'code_128'] });
                const video = document.getElementById("barcode-video");
                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");

                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
                    video.srcObject = stream;
                    video.play();

                    // Detener el escaneo después de un tiempo o cuando se confirme
                    setTimeout(async () => {
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                        const barcodes = await barcodeDetector.detect(canvas);
            
                        if (barcodes.length > 0) {
                            alert("Código detectado: " + barcodes[0].rawValue);
                            stream.getTracks().forEach(track => track.stop());
                        } else {
                            alert("No se detectó ningún código.");
                        }
                    }, 2000); // Espera 2 segundos para capturar una imagen nítida
                } catch (error) {
                    console.error("Error al acceder a la cámara:", error);
                }
            }
        });
    </script>
</div>
@endsection
        
       
