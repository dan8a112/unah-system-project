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

const addSectionForm = document.querySelector("#addSectionForm");
addSectionForm.addEventListener("submit", (event)=>Action.submitCreateSection(event))

const updateSectionButton = document.querySelector("#updateButton");
const editSectionForm = document.querySelector("#editSectionForm");

updateSectionButton.addEventListener("click", ()=>{
    //Se envia el formulario
    editSectionForm.dispatchEvent(new Event("submit"));
})

editSectionForm.addEventListener("submit", (event)=>{Action.submitEditSection(event)})

const deleteSectionButton = document.querySelector("#deleteSectionBtn");
deleteSectionButton.addEventListener("click", ()=>{Action.submitDeleteSection()})

const buttonCloseModal = document.querySelector("#btnClose");
buttonCloseModal.addEventListener("click", ()=>{window.location.reload()})