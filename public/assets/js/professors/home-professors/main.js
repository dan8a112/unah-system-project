import {Action} from './Action.js'

Action.renderPage();

const sectionsContainer = document.querySelector("#sectionsContainer");

sectionsContainer.addEventListener("click", (e)=>{Action.redirectSectionDetail(e)})