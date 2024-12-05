import { Action } from "./Action.js";

Action.renderSections("Hola");

//Accion al presionar un boton de la tabla (Acciones)
const tableBody = document.querySelector("tbody#table-body");
tableBody.addEventListener("click", Action.openSectionActions);

//Accion del boton de agregar seccion
const buttonAdd = document.querySelector("#createBtn");
buttonAdd.addEventListener("click", Action.openCreateSection);

//Accion del boton de aumentar cupos en modal de acciones de modal
const increaseButton = document.querySelector("#increaseBtn");
increaseButton.addEventListener("click", ()=>{
    const inputValue = document.querySelector("input#increaseInput");
    inputValue.value = parseInt(inputValue.value)+1;
})