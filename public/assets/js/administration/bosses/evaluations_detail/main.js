import { Action } from "./Action.js";

//Se renderizan las secciones del maestro
Action.renderSections();

//Se abre la modal
const sectionsContainer = document.querySelector("section#sectionsContainer");
sectionsContainer.addEventListener("click", (e) => { Action.renderEvaluationList(e) })

