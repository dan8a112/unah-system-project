/**
 * author: afcastillof@unah.hn
 * version: 0.1.2
 * date: 9/11/24
 */
import { loadSelectOptions, enableCareerSelects } from './Action.js';
import { HttpRequest } from '../../modules/HttpRequest.js';
import { Popup } from '../../modules/Popup.js';

const selectFirstCareer = document.getElementById('firstCareer');
const selectSecondCareer = document.getElementById('secondCareer');
const selectRegionalCenters = document.getElementById('regionalCenters');
const popup = document.getElementById('popup');
const popupError = document.getElementById('popupError');
const message = document.getElementById('message');
const buttonOk1 = document.getElementById('buttonOk1');
const buttonOk2 = document.getElementById('buttonOk2');
const exitMessage = document.getElementById('exitMessage');

// Elementos relacionados con la validación de archivo
const fileInput = document.getElementById('formFile');
const maxSizeInBytes = 2 * 1024 * 1024; // 2 MB
const formErrorMessage = document.createElement('span');
formErrorMessage.style.color = 'red';
formErrorMessage.style.display = 'none';
fileInput.parentNode.appendChild(formErrorMessage);

// Validación al cargar un archivo
fileInput.addEventListener('change', () => {
  const file = fileInput.files[0];
  if (file) {
    if (file.size > maxSizeInBytes) {
      formErrorMessage.textContent = 'El archivo es demasiado grande. Máximo permitido: 2 MB.';
      formErrorMessage.style.display = 'block';
      fileInput.value = ''; // Limpiar el input
    } else {
      formErrorMessage.style.display = 'none';
    }
  }
});

// Llamamos a la función para cargar las opciones cuando la página esté lista
document.addEventListener('DOMContentLoaded', () => {
  loadSelectOptions(selectFirstCareer, selectSecondCareer, selectRegionalCenters);
});

// Evento para habilitar los selectores de carrera cuando se elige un centro regional
selectRegionalCenters.addEventListener('change', () => {
  enableCareerSelects(selectFirstCareer, selectSecondCareer, selectRegionalCenters);
});

// Validación y envío del formulario
document.getElementById('form-inscription').addEventListener('submit', (event) => {
  const file = fileInput.files[0];

  if (file && file.size > maxSizeInBytes) {
    event.preventDefault(); // Evitar el envío del formulario
    formErrorMessage.textContent = 'El archivo es demasiado grande. Máximo permitido: 2 MB.';
    formErrorMessage.style.display = 'block';
    return;
  }

  HttpRequest.submitForm(event, '../../../api/post/application')
    .then(result => {
      if (result.status) {
        Popup.open(popup);
        exitMessage.innerHTML = `Tu inscripción fue realizada exitosamente, tendrás que realizar los exámenes: ${result.exams}`;
      } else {
        Popup.open(popupError);
        message.innerHTML = result.message;
        buttonOk2.style.background = '#EC0000';
      }
    });
});

buttonOk1.addEventListener('click', () => Popup.close1(popup));
buttonOk2.addEventListener('click', () => Popup.close(popupError));
