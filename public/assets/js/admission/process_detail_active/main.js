import { Action } from "./Action.js"

//Se obtiene la información que carga la pagina del detalle de proceso de admision actual
Action.fetchActiveData();

const downloadCSVButton = document.getElementById("downloadCsvBtn");

//Se agrega accion al boton de descargar csv
downloadCSVButton.addEventListener("click", Action.downloadCSV);
