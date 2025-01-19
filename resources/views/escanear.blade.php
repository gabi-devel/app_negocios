@extends('layouts.app')

@section('content')

<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    <div class="max-w-7xl mx-auto p-6 lg:p-8">

        <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
        <div id="scanner-container"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Quagga.init(
            {
                inputStream: {
                    name: 'Live',
                    type: 'LiveStream',
                    target: document.querySelector('#scanner-container'), // Dónde mostrar el video
                },
                decoder: {
                    readers: ['code_128_reader', 'ean_reader'], // Tipos de códigos de barras que deseas leer
                },
            },
            function (err) {
                if (err) {
                    console.error('Error inicializando Quagga:', err);
                    return;
                }
                console.log('Quagga inicializado correctamente');
                Quagga.start();
            }
        );

        // Escucha los resultados de escaneo
        Quagga.onDetected(function (data) {
            const codBarra = data.codeResult.code;
            console.log('Código detectado:', codBarra);
            alert(`Código detectado: ${codBarra}`);
            Quagga.stop(); // Detiene el escáner después de detectar un código
    
            // Mandar al backend:
            // Send the detected barcode to the backend
            fetch('/guardar-codigobarra', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ codBarra: codBarra }), // Send the barcode data
            })
            .then(response => response.json())
            .then(result => {
                console.log('Código guardado:', result);
            })
            .catch(error => {
                console.error('Error al guardar el código:', error);
            });
        });
    });

</script>

        
        <div class="mt-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                <p>Holaa</p>
            </div>
        </div>
    </div>
</div>
@endsection