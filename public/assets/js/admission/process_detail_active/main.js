import { Action } from "./Action.js";
import { HttpRequest } from "../../modules/HttpRequest.js";
import { Modal } from "../../modules/Modal.js";

// Se obtiene la información que carga la página del detalle de proceso de admisión actual
Action.fetchActiveData();

// Selecciona el botón de enviar correos
const sendEmailsButton = document.getElementById("sendEmailsButton");
const url = "../../../api/get/admission/sendMails";

// Agrega la acción de enviar correos
sendEmailsButton.addEventListener("click", async () => {
    try {
        const response = await HttpRequest.get(url);
        console.log("Correos enviados:", response);
        Modal.closeModal();
    } catch (error) {
        console.error("Error al enviar correos:", error);
    }
});
