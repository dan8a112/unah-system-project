import { redirectPageToInscription, closeModal, Action } from "./Action.js";

const admissionButton = document.getElementById('admissions');
const closeModalButton = document.getElementById('closeModal');

admissionButton.addEventListener("click", redirectPageToInscription);
closeModalButton.addEventListener("click", closeModal);
