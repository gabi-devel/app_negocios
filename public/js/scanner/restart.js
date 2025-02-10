import { startScanner } from "./init.js"; // Importar la función startScanner

export function setupRestartButton() {
    document.getElementById("restart-scanner").addEventListener("click", function () { // Cuando el usuario hace clic en "Reiniciar":
        Quagga.stop(); // Asegurar que se detenga completamente
        startScanner(); // Vuelve a ejecutar startScanner()
        this.style.display = "none"; // Ocultar el botón de reinicio
    });
};
