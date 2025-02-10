import { startScanner } from "./scanner/init.js";
import { lista_cobrar } from "./scanner/lista_cobrar.js";

document.addEventListener("DOMContentLoaded", function () {
    startScanner();

    lista_cobrar();

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
