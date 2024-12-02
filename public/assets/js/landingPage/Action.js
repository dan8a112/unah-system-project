import { Modal } from "../modules/Modal.js";
import { HttpRequest } from "../modules/HttpRequest.js";

const modal = document.querySelector("#modalDom");

export async function redirectPageToInscription() {
    const url = '../../../api/get/admission/activeAdmissionProcess/';

    try {
        const response = await HttpRequest.get(url);
        const status = response.status;
        console.log(status);

        if (status) {
            window.location.href = '/assets/views/admission/inscription_view.php';
        } else {
            const content = "No hay un proceso de admisión activo por el momento. Revisa nuestro calendario académico y mantente pendiente del próximo proceso de admisiones.";
            Modal.openModal(modal, content, "Ups!");
        }
    } catch (error) {
        console.error("Error al realizar la solicitud a la API:", error);
    }
}

export const closeModal = () => {
    Modal.closeModal(); 
};
