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

// Si `uploadCsv` es un formulario, se previene el comportamiento por defecto y se maneja el envío
document.getElementById('formCsv').addEventListener('submit', async (event) => {
    event.preventDefault();  // Prevenir recarga de la página en el submit del formulario

    try {
        const result = await HttpRequest.submitForm(event, '../../../api/update/readCsv');
        console.log(result.message); 
    } catch (error) {
        console.error("Error al cargar el CSV:", error);
    }
});
