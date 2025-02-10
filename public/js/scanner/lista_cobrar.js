export function lista_cobrar() {
    let scannedProducts = {};
    let lastScannedCode = "";
    let scanCount = 0;
    const requiredScans = 3;
    let tempCode = "";

    function updateTotal() {
        let total = 0;
        Object.values(scannedProducts).forEach(product => {
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

            fetch(`/api/producto/${code}`, {
                method: "GET",
                credentials: "include",
                headers: { "Content-Type": "application/json" }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success || !data.producto) {
                    alert("Producto no encontrado");
                    return;
                }

                if (!scannedProducts[code]) {
                    scannedProducts[code] = {
                        codigo: code,
                        nombre: data.producto.nombre, 
                        precio: parseFloat(data.producto.precio),
                        cantidad: 1
                    };

                    // Agregar inputs al formulario
                    const formContainer = document.getElementById("product-form-container");
                    const productDiv = document.createElement("div");
                    productDiv.setAttribute("id", `product-${code}`);
                    productDiv.innerHTML = `
                        <label>${data.producto.nombre}</label>
                        <input type="number" class="cantidad-input" data-codigo="${code}" value="1" min="1" style="width: 50px;">
                        <input type="number" class="precio-input" data-codigo="${code}" value="${data.producto.precio.toFixed(2)}" min="0" step="0.01" style="width: 70px;">
                    `;
                    formContainer.appendChild(productDiv);
                } else {
                    alert(`El producto ya está agregado. Puedes modificar la cantidad.`);
                }

                updateTotal();
            })
            .catch(error => console.error("Error en la petición:", error));
        }
    });

    // Actualizar cantidad y precio en tiempo real
    document.getElementById("product-form-container").addEventListener("input", function (event) {
        const target = event.target;
        const codigo = target.getAttribute("data-codigo");

        if (!codigo || !scannedProducts[codigo]) return;

        if (target.classList.contains("cantidad-input")) {
            scannedProducts[codigo].cantidad = parseInt(target.value) || 1;
        } else if (target.classList.contains("precio-input")) {
            scannedProducts[codigo].precio = parseFloat(target.value) || 0;
        }

        updateTotal();
    });

    document.getElementById("dar-total").addEventListener("click", function () {
        Quagga.stop();
        document.getElementById("quagga-container").style.display = "none";
        document.getElementById("dar-total").style.display = "none";
        document.getElementById("confirmar-cobro").style.display = "block";
    });
//
    /* Quagga.onDetected(function (result) {
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
        
            // Hacemos una petición para obtener datos reales
            fetch(`/api/producto/${code}`, {
                method: "GET",
                credentials: "include", // Esto se asegura de enviar las cookies junto con la petición
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log("Respuesta del servidor:", data); // DEBUG

                if (!data.success || !data.producto) {
                    alert("Producto no encontrado");
                    return;
                }

                if (scannedProducts[code]) {
                    scannedProducts[code].cantidad += 1;
                } else {
                    scannedProducts[code] = {
                        codigo: code,
                        producto: data.producto.nombre, 
                        precio: parseFloat(data.producto.precio),
                        cantidad: 1,
                    };
                }
                // Mostrar alerta con la información del producto
                alert(`Producto: ${scannedProducts[code].producto}\nCantidad: ${scannedProducts[code].cantidad}`);
                

                // updateTable();
                
                // document.getElementById("manualCodigoBarrasInput").value = ""; // Limpiar input
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
            
            
        }
        
    });

    document.getElementById("dar-total").addEventListener("click", function () {
        Quagga.stop();
        document.getElementById("quagga-container").style.display = "none";
        document.getElementById("dar-total").style.display = "none";
        document.getElementById("confirmar-cobro").style.display = "block";
    });
    document.getElementById("dar-total").addEventListener("click", function () {
        let total = 0;
        Object.values(scannedProducts).forEach(producto => {
            total += producto.precio * producto.cantidad;
        });
    
        document.getElementById("total-amount").textContent = total.toFixed(2);
        document.getElementById("confirmar-cobro").style.display = "block"; // Mostrar botón de cobro
    }); */
    
}