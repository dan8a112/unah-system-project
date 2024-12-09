import { Action } from "./Action.js";

//Se renderizan las opciones del select de periodo
Action.renderPeriodSelect();

//Se renderiza la lista de maestros que imparten ese periodo
//idPeriod = 0 -> periodo actual
Action.renderProfessorEvaluations(0);

//Accion al presionar un boton de la tabla (Acciones)
const tableBody = document.querySelector("tbody#table-body");
tableBody.addEventListener("click", (e)=>{Action.openEvaluationsSections(e)});

//Accion al seleccionar un periodo academico desde select
const periodSelect = document.querySelector("select#periodSelect");
periodSelect.addEventListener("change", (e)=>{
    const periodId = e.target.value;
    Action.renderProfessorEvaluations(periodId);
})