document.addEventListener("DOMContentLoaded", function () {
    function startScanner() {
        document.getElementById("quagga-container").style.display = "block";
        Quagga.init(
            {
                inputStream: {
                    type: "LiveStream",
                    target: document.querySelector("#quagga-container"),
                    constraints: {
                        width: 640,
                        height: 480,
                        facingMode: "environment",
                    },
                },
                decoder: {
                    readers: ["ean_reader", "code_128_reader"],
                    multiple: false,
                },
                locate: true,
                locator: {
                    patchSize: "medium",
                    halfSample: true,
                },
                area: {
                    top: "10%",
                    bottom: "10%",
                },
                numOfWorkers: navigator.hardwareConcurrency || 4,
                frequency: 10,
                debug: false,
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
    }

    startScanner();

    let scannedProducts = {};
    let lastScannedCode = "";
    let scanCount = 0;
    const requiredScans = 3;
    let tempCode = "";

    function updateTable() {
        const tableBody = document.getElementById("product-list");
        tableBody.innerHTML = "";
        let total = 0;

        Object.values(scannedProducts).forEach((product) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${product.codigo}</td>
                <td>${product.nombre}</td>
                <td>${product.marca}</td>
                <td>$${product.precio.toFixed(2)}</td>
                <td>
                    <input type="number" class="cantidad-input" data-codigo="${product.codigo}" value="${product.cantidad}" min="1" style="width: 50px;">
                </td>
                <td>
                    <button class="btn btn-danger btn-sm remove-product" data-codigo="${product.codigo}">Eliminar</button>
                </td>
            `;
            tableBody.appendChild(row);
            total += product.precio * product.cantidad;
        });

        document.getElementById("total-amount").textContent = `$${total.toFixed(2)}`;
    }

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

            if (scannedProducts[code]) {
                scannedProducts[code].cantidad += 1;
            } else {
                // Simulación de datos del producto (se debería hacer una consulta real a la base de datos)
                scannedProducts[code] = {
                    codigo: code,
                    nombre: "Producto " + code,
                    marca: "Marca X",
                    precio: Math.floor(Math.random() * 100) + 1,
                    cantidad: 1,
                };
            }

            updateTable();
        }
    });

    document.getElementById("product-table").addEventListener("input", function (event) {
        if (event.target.classList.contains("cantidad-input")) {
            const codigo = event.target.getAttribute("data-codigo");
            const nuevaCantidad = parseInt(event.target.value);
            if (nuevaCantidad > 0) {
                scannedProducts[codigo].cantidad = nuevaCantidad;
                updateTable();
            }
        }
    });

    document.getElementById("product-table").addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-product")) {
            const codigo = event.target.getAttribute("data-codigo");
            delete scannedProducts[codigo];
            updateTable();
        }
    });

    document.getElementById("dar-total").addEventListener("click", function () {
        Quagga.stop();
        document.getElementById("quagga-container").style.display = "none";
        document.getElementById("dar-total").style.display = "none";
        document.getElementById("confirmar-cobro").style.display = "block";
    });

    document.getElementById("reiniciar-escaneo").addEventListener("click", function () {
        scannedProducts = {};
        updateTable();
        document.getElementById("scanned-code").textContent = "";
        document.getElementById("quagga-container").style.display = "block";
        document.getElementById("dar-total").style.display = "block";
        document.getElementById("confirmar-cobro").style.display = "none";
        startScanner();
    });
});
