export function InputCodigoBarras() {
    document.getElementById("codigo_barra").addEventListener("input", function () {
        let codigo = this.value.trim(); // Obtenemos el valor del input
    
        if (codigo !== "") { // Si el código no está vacío
            // Realizamos la petición AJAX para obtener los datos del producto
            fetch(`/api/producto/${codigo}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Si el producto se encuentra, se llenan los campos
                        document.getElementById("nombre").value = data.producto.nombre;
                        document.getElementById("marca").value = data.producto.marca || "";
                        document.getElementById("precio").value = data.producto.precio || 0;
                    } else {
                        // Si no se encuentra el producto, limpiar los campos
                        alert("Producto no encontrado");
                        document.getElementById("nombre").value = "";
                        document.getElementById("marca").value = "";
                        document.getElementById("precio").value = "";
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Hubo un error al buscar el producto");
                });
        } else {
            // Si el campo está vacío, limpiar los otros campos
            document.getElementById("nombre").value = "";
            document.getElementById("marca").value = "";
            document.getElementById("precio").value = "";
        }
    });

    document.getElementById("codigo_barra").addEventListener("change", function () {
        let codigo = this.value;

        if (codigo.trim() !== "") {
            fetch(`/api/producto/${codigo}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("nombre").value = data.producto.nombre;
                        document.getElementById("marca").value = data.producto.marca || "";
                        document.getElementById("precio").value = data.producto.precio || 0;
                    } else {
                        alert("Producto no encontrado");
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    });
}