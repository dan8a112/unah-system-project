import { Action } from "./Action.js";

Action.renderSections();

//Accion al presionar un boton de la tabla (Acciones)
const tableBody = document.querySelector("tbody#table-body");
tableBody.addEventListener("click", (e)=>{Action.openEvaluation(e)});