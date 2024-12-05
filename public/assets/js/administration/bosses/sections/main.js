import { Action } from "./Action.js";

Action.renderSections("Hola");

const tableBody = document.querySelector("tbody#table-body");

tableBody.addEventListener("click", Action.openSectionActions);

const buttonAdd = document.querySelector("#createBtn");

buttonAdd.addEventListener("click", Action.openCreateSection);