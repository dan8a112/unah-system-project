import {Action} from "./Action.js";

//Se hace la peticion de los maestros
Action.fetchProfessors();

const createButton = document.querySelector("#createBtn");

//Se agrega accion de boton de crear maestro
createButton.addEventListener('click', Action.fetchFormProfessors);

const createProfessorForm = document.querySelector("#createProfessorForm")

createProfessorForm.addEventListener('submit', Action.submitFormProfessor.bind(createProfessorForm));