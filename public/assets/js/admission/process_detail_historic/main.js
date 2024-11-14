import { Action } from "./Action.js";
import { Modal } from "../../modules/Modal.js";

//Se crea objeto de parametros
const params = new URLSearchParams(window.location.search);

//Existe el parametro id
if (params.has("id")) {
    const processId = params.get("id");
    Action.fetchHistoricData(processId)
}else{
    //Si no tiene un parametro id limpia el contenido
    const processContent = document.querySelector("div#processContent");
    processContent.innerHTML = "";

    //Muestra una modal informando al usuario
    const modal = document.querySelector("#modalDom")
    const content = "Ocurrió un error: no se está especificando el id del proceso de admisión que se requiere. Vuelva a intentarlo."
    Modal.openModal(modal,content,"static");
}


