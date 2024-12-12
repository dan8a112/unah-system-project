import { Action } from "./Action.js";
import { HttpRequest } from "../../modules/HttpRequest.js";
import { Modal } from "../../modules/Modal.js";


/**
 * @description Carga y muestra los datos para la vista proceso de admisiones activo
 * @author: afcastillof@unah.hn
 * @version: 0.1.7
 * @date: 24/11/24
 */

// Se obtiene la información que carga la página del detalle de proceso de admisión actual
Action.fetchActiveData();

// Selecciona el botón de enviar correos
const sendEmailsButton = document.getElementById("sendEmailsButton");
const container = document.getElementById("contentt");
const url = "../../../api/get/admission/programEmails/";
const headersLastInscriptionTable = ["#", "DNI", "Examen", "Puntaje", "Mensaje"];
const headerMissingData = ["#", "DNI", "Examen"];

// Se agrega la acción de enviar correos
sendEmailsButton.addEventListener("click", async () => {
    try {
        const response = await HttpRequest.get(url);
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
        const result = await HttpRequest.submitForm(event, '../../../api/update/readCsv/');
        container.innerHTML = "";
        if(result.status == false) {
            let message = document.createElement('p');
            message.innerHTML = result.message;
            container.style.color = 'red';
            container.appendChild(message);
        }
        Action.createTableWithData("Registros invalidos", headersLastInscriptionTable, result.incorrectData, container, 'MissingInscriptionTable', 10, result.incorrectData.length, '', true)
        Action.createTableWithData("Registros que no estaban en el csv", headerMissingData,result.missingData, container, 'MissingInscriptionTable', 10, result.missingData.length, '', true)
        Modal.closeModal();
        
    } catch (error) {
        console.error("Error al cargar el CSV:", error);
    }
});
