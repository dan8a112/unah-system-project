/**
 * author: afcastillof@unah.hn
 * version: 0.2.0
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
const maxSizeInBytes = 5 * 1024 * 1024; // 5 MB
const maxImageDimensions = { width: 1920, height: 1080 }; // Dimensiones máximas para imágenes
const minImageDimensions = { width: 800, height: 600 }; // Dimensiones mínimas para imágenes
const formErrorMessage = document.createElement('span');
formErrorMessage.style.color = 'red';
formErrorMessage.style.display = 'none';
fileInput.parentNode.appendChild(formErrorMessage);

// Función para validar dimensiones de imágenes
const validateImageDimensions = (file) => {
  return new Promise((resolve, reject) => {
    const img = new Image();
    const url = URL.createObjectURL(file);

    img.onload = () => {
      if (img.width > maxImageDimensions.width || img.height > maxImageDimensions.height) {
        reject(`La imagen excede las dimensiones máximas permitidas (${maxImageDimensions.width}x${maxImageDimensions.height}).`);
      } else if (img.width < minImageDimensions.width || img.height < minImageDimensions.height) {
        reject(`La imagen no cumple con las dimensiones mínimas requeridas (${minImageDimensions.width}x${minImageDimensions.height}).`);
      } else {
        resolve();
      }
      URL.revokeObjectURL(url);
    };

    img.onerror = () => {
      reject('Error al cargar la imagen.');
      URL.revokeObjectURL(url);
    };

    img.src = url;
  });
};

// Función para validar PDFs (por ejemplo, número de páginas o dimensiones)
const validatePdfDimensions = async (file) => {
  const pdfjsLib = await import('pdfjs-dist');
  const loadingTask = pdfjsLib.getDocument(URL.createObjectURL(file));

  return loadingTask.promise.then(pdf => {
    return pdf.getPage(1).then(page => {
      const viewport = page.getViewport({ scale: 1 });
      if (viewport.width > maxImageDimensions.width || viewport.height > maxImageDimensions.height) {
        throw new Error(`El PDF excede las dimensiones máximas permitidas (${maxImageDimensions.width}x${maxImageDimensions.height}).`);
      } else if (viewport.width < minImageDimensions.width || viewport.height < minImageDimensions.height) {
        throw new Error(`El PDF no cumple con las dimensiones mínimas requeridas (${minImageDimensions.width}x${minImageDimensions.height}).`);
      }
    });
  });
};

// Validación al cargar un archivo
fileInput.addEventListener('change', async () => {
  const file = fileInput.files[0];

  if (file) {
    try {
      if (file.size > maxSizeInBytes) {
        throw new Error('El archivo es demasiado grande. Máximo permitido: 5 MB.');
      }

      const fileType = file.type;

      if (fileType.startsWith('image/')) {
        await validateImageDimensions(file);
      } else if (fileType === 'application/pdf') {
        await validatePdfDimensions(file);
      } else {
        throw new Error('Solo se permiten imágenes y PDFs.');
      }

      formErrorMessage.style.display = 'none';
    } catch (error) {
      formErrorMessage.textContent = error.message || error;
      formErrorMessage.style.display = 'block';
      fileInput.value = ''; // Limpiar el input
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
document.getElementById('form-inscription').addEventListener('submit', async (event) => {
  event.preventDefault();
  const form = event.target; 
  const formData = new FormData(form);
  for (const [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`);
  }

  // Opcional: Imprimir solo los valores de los datos
  console.log("Datos del formulario:", Object.fromEntries(formData.entries()));

    HttpRequest.submitForm(event, '../../../api/post/application')
      .then(result => {
        if (result.status) {
          Popup.open(popup);
          exitMessage.innerHTML = `Tu inscripción fue realizada exitosamente, tendrás que realizar los exámenes: ${result.exams}`;
                  } else {
          Popup.open(popupError);
          if(result.code == 4){
            message.innerHTML = result.message;
            buttonOk2.style.background = '#EC0000';
            buttonOk2.addEventListener('click', () => Popup.close2(popupError));
          } else {
            message.innerHTML = result.message;
            buttonOk2.style.background = '#EC0000';
          }
          
        }
      });
});

buttonOk1.addEventListener('click', () => Popup.close1(popup));
buttonOk2.addEventListener('click', () => Popup.close(popupError));
