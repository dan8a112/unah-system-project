import { redirectPageToInscription, closeModal } from "./Action.js";

const admissionButton = document.getElementById('admissions');
const closeModalButton = document.getElementById('closeModal');
const Buttonadmission = document.getElementById('admissionButton');

admissionButton.addEventListener("click", redirectPageToInscription);
Buttonadmission.addEventListener("click", redirectPageToInscription);
closeModalButton.addEventListener("click", closeModal);
