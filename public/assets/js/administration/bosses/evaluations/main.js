import { Action } from "./Action.js";
/**
 * @author: dochoa@unah.hn
* @version: 0.1.5
* date: 7/12/24
 */
//Se renderizan las opciones del select de periodo
Action.renderPeriodSelect();

//Se renderiza la lista de maestros que imparten ese periodo
//idPeriod = 0 -> periodo actual
Action.renderProfessorEvaluations(0);

//Accion al seleccionar un periodo academico desde select
const periodSelect = document.querySelector("select#periodSelect");
periodSelect.addEventListener("change", (e)=>{
    const periodId = e.target.value;
    Action.renderProfessorEvaluations(periodId);
})