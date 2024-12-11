import { Action } from "./Action.js";

Action.loadPage();

sectionsContainer.addEventListener("click", (e)=>{Action.redirectSectionDetail(e)})
