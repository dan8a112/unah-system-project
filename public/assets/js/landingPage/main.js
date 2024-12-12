/**
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 15/11/24
 */

import { redirectPageToInscription, closeModal } from "./Action.js";

// Selección de los botones del DOM
const admissionButton = document.getElementById('admissions');
const closeModalButton = document.getElementById('closeModal');

/**
 * Añade los event listeners a los botones para realizar las acciones correspondientes.
 * - El botón de admisión redirige a la página de inscripción si hay un proceso activo.
 * - El botón de cerrar modal cierra el modal cuando se hace clic.
 */
admissionButton.addEventListener("click", redirectPageToInscription);
closeModalButton.addEventListener("click", closeModal);
