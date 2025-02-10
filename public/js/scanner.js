import { startScanner } from "./scanner/init.js";
import { InputCodigoBarras } from "./scanner/input_codigo.js";
import { handleDetectedCode } from "./scanner/validation.js";
import { setupRestartButton } from "./scanner/restart.js";

document.addEventListener('DOMContentLoaded', function () { // Espera a que el documento HTML termine de cargarse antes de ejecutar el código
    startScanner(); // init.js

    handleDetectedCode(); // validation.js // Detectar 3 veces el código de barras

    InputCodigoBarras(); // Detecta cuando el valor del input cambia


    setupRestartButton(); // restart.js // Para el botón de reiniciar el escaneo
});