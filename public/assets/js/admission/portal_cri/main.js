import { Action } from "./Action.js"

/**
 * Se renderiza por primera vez la data de la pagina
 * 1 -> Primera vez
 * 0 -> Otras veces
 */

Action.renderAllPage(1);

const reviewModal = document.querySelector("div#reviewModal");
reviewModal.addEventListener('hidden.bs.modal', ()=>{Action.reloadAfterDismiss()})
