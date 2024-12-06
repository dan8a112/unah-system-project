import { Action } from "./Action.js";

//Se hace la petición de los maestros
Action.fetchProfessors();

//Se agrega acción de botón de crear maestro
const createButton = document.querySelector("#createBtn");
createButton.addEventListener("click", () => Action.openCreateForm());

//Se agrega acción al enviar el formulario de creación de profesor
const createProfessorForm = document.querySelector("#createProfessorForm");
createProfessorForm.addEventListener("submit", (event) => {
    Action.submitFormProfessor(createProfessorForm, event);
});

//Se agrega acción al enviar el formulario de editar un profesor
const editProfessorForm = document.querySelector("#editProfessorForm");
editProfessorForm.addEventListener("submit", (event) => {
    Action.submitFormEditProfessor(editProfessorForm, event);
});

const table = document.getElementById('table');

// Agregar un event listener al contenedor
table.addEventListener('click', function(event) {
  // Verificar si el elemento que se hizo clic es un botón (o un elemento específico)
  if (event.target.matches('.editBtn')) {
    // Aquí va la lógica que quieres ejecutar cuando el botón es clickeado
    console.log(event.target.dataset.professorId)
    const buttonId = parseInt(event.target.dataset.professorId, 10);
    Action.openEditiForm(buttonId);
  }
});

