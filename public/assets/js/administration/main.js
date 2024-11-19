import {Action} from "./Action.js";

//Se hace la peticion de los maestros
Action.fetchProfessors();

//Se agrega accion de boton de crear maestro
const createButton = document.querySelector("#createBtn");
createButton.addEventListener('click', ()=>Action.openCreateForm());

//Se agrega accion al enviar el formulario de creacion de profesor
const createProfessorForm = document.querySelector("#createProfessorForm")
createProfessorForm.addEventListener('submit', Action.submitFormProfessor.bind(createProfessorForm));

//Se agrega accion al enviar el formulario de editar un profesors
const editProfessorForm = document.querySelector("#editProfessorForm")
editProfessorForm.addEventListener('submit', Action.submitFormEditProfessor);

//Se agrega accion de boton para cerrar sesion
const logoutButton = document.querySelector("button#logoutBtn")
logoutButton.addEventListener("click", Action.logout)