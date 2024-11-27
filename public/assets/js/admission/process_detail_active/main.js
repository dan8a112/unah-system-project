import { Action } from "./Action.js";
import { HttpRequest } from "../../modules/HttpRequest.js";
import { Modal } from "../../modules/Modal.js";

// Se obtiene la información que carga la página del detalle de proceso de admisión actual
Action.fetchActiveData();

// Selecciona el botón de enviar correos
const sendEmailsButton = document.getElementById("sendEmailsButton");
const container = document.getElementById("contentt")
const url = "../../../api/get/admission/programEmails";
const headersLastInscriptionTable = ["#", "DNI", "Examen", "Puntaje", "Mensaje"];

// Se agrega la acción de enviar correos
sendEmailsButton.addEventListener("click", async () => {
    try {
        const response = await HttpRequest.get(url);
        console.log("Correos enviados:", response);
        Modal.closeModal();
        const sendButton = document.getElementById('sendMail');
        sendButton.disabled = true;
        sendButton.style.backgroundColor = '#878787';
    } catch (error) {
        console.error("Error al enviar correos:", error);
    }
});
// Se agrega la accion de mandar archivo csv
document.getElementById('formCsv').addEventListener('submit', async (event) => {
    event.preventDefault(); 

    try {
        const result = await HttpRequest.submitForm(event, '../../../api/update/readCsv');
        console.log(result.message); 
        console.log(result); 
        container.innerHTML = "";
        Action.createTableWithData("Registros que no estaban en el csv", headersLastInscriptionTable, result.incorrectData, container, 'MissingInscriptionTable')
        Action.createTableWithData("Registros que no estaban en el csv", headersLastInscriptionTable,result.missingData, container, 'MissingInscriptionTable')
        Modal.closeModal();
        
    } catch (error) {
        console.error("Error al cargar el CSV:", error);
    }
});
