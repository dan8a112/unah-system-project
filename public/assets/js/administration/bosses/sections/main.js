import { Action } from "./Action.js";

Action.renderAllPage();

//Accion del boton de agregar seccion
const buttonAdd = document.querySelector("#createBtn");
buttonAdd.addEventListener("click", Action.openCreateSection.bind(Action));

//Accion del boton de aumentar cupos en modal de acciones de modal
const increaseButton = document.querySelector("#increaseBtn");
increaseButton.addEventListener("click", ()=>{
    const inputValue = document.querySelector("input#increaseInput");
    inputValue.value = parseInt(inputValue.value)+1;
})