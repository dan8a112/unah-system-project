/**
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 15/11/24
 */

import { Modal } from "../modules/Modal.js";
import { HttpRequest } from "../modules/HttpRequest.js";

// Selección del modal para mostrar mensajes
const modal = document.querySelector("#modalDom");

/**
 * Función que redirige al usuario a la página de inscripción si hay un proceso de admisión activo.
 * Si no hay un proceso activo, muestra un mensaje en el modal.
 */
export async function redirectPageToInscription() {
    const url = '../../../api/get/admission/activeAdmissionProcess/';

    try {
        // Realizamos la solicitud a la API para verificar el estado del proceso de admisión
        const response = await HttpRequest.get(url);
        const { status } = response;

        // Si el proceso de admisión está activo, redirigimos a la página de inscripción
        if (status) {
            window.location.href = '/assets/views/admission/inscription_view.php';
        } else {
            // Si no hay proceso activo, mostramos un mensaje informativo
            const content = "No hay un proceso de admisión activo por el momento. Revisa nuestro calendario académico y mantente pendiente del próximo proceso de admisiones.";
            Modal.openModal(modal, content, "Ups!");
        }
    } catch (error) {
        // En caso de error con la solicitud, mostramos un mensaje en consola
        console.error("Error al realizar la solicitud a la API:", error);
    }
}

/**
 * Función para cerrar el modal.
 * Esta función puede ser llamada cuando el usuario quiera cerrar el modal de error o información.
 */
export const closeModal = () => {
    Modal.closeModal(); // Cierra el modal utilizando la función definida en el módulo Modal
};
