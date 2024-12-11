import { Action } from "./Action.js";
import { HttpRequest } from "../../modules/HttpRequest.js";
import { Modal } from "../../modules/Modal.js";
import { Popup } from "../../modules/Popup.js";


const currentPeriod = document.getElementById("currentPeriod");
const denomination = document.getElementById("denomination");
const className = document.getElementById("className");
const startHour = document.getElementById("startHour");
const finishHour = document.getElementById("finishHour")
const sectionId = new URLSearchParams(window.location.search).get("sectionId");
const amountStudents = document.getElementById("amountStudents");
const valueUnits = document.getElementById("valueUnits");
const days = document.getElementById("days");
const url = `../../../api/get/professor/section/?id=${sectionId}`;
const container = document.getElementById("contentt");
const headersincorrectTable = ["id", "Cuenta", "Nota", "idObs", "Mensaje"];
const headerMissingData = ["Cuenta", "Nombre"];

//popup
const message = document.getElementById('message');
const popupError = document.getElementById('popupError');
const popup = document.getElementById('popup');
const buttonOk1 = document.getElementById('buttonOk1');
const buttonOk2 = document.getElementById('buttonOk2');
const exitMessage = document.getElementById('exitMessage');



const data = {
    stateProces : 2,
    infoSection: {
        id: 12,
        name: "Ingenieria de software",
        denomination: "1100",
        code: "IS-803",
        start: "11:00 am",
        end: "12:00 pm",
        amountStudents: 25,
        valueUnits: 4
    },
    students: {
      amountStudents : 25,
      stundentsList : [
        {
          id: 2,
          account: "20191006515",
          name: "Angel Fernando Castillo Flores",
          career: "Ingenieria en sistemas",
          registrationDate: "12/12/2012"
        },
        {
          id: 2,
          account: "20191006515",
          name: "Angel Fernando Castillo Flores",
          career: "Ingenieria en sistemas",
          registrationDate: "12/12/2012"
        }
      ]
    }
}

async function loadData() {
    // Realizar la solicitud GET usando HttpRequest;
    const respose = await HttpRequest.get(url);
    const data = respose.data;
    const breadCrumbTitle = document.querySelector(".active");
    const urlPaginacion = `../../../api/get/pagination/studentsSection/?id=${sectionId}&`;

    if (data) {
      Action.renderStudents(data, urlPaginacion);
      currentPeriod.innerText = `${data.infoSection.sectionDetails.period}`;
      startHour.innerText = `${data.infoSection.sectionDetails.start}:00`;
      finishHour.innerText = `${data.infoSection.sectionDetails.end}:00`;
      denomination.innerText = `${data.infoSection.sectionDetails.denomination} | ${data.infoSection.sectionDetails.code}`;
      className.innerText = `${data.infoSection.sectionDetails.name}`;
      breadCrumbTitle.innerText = `${data.infoSection.sectionDetails.name}`;
      amountStudents.innerText = `${data.infoSection.students.amountStudents}`;
      valueUnits.innerText = `${data.infoSection.sectionDetails.valueUnits} UV`;
      days.innerText = `${data.infoSection.sectionDetails.days}`
    } else {
      console.error("No se pudo cargar la información desde la API.");
    }
  }
  
  loadData();

  const table = document.getElementById('section-table');

    table.addEventListener('click', function(event) {
    if (event.target.matches('.editBtn')) {
        console.log(event.target.dataset.professorId)
        const buttonId = parseInt(event.target.dataset.professorId, 10);
        Action.openEditiForm(buttonId);
    }
    });

    /**
     * Se mandan las calicicaciones para registrarlas en la base de datos
     * author: afcastillof@unah.hn
     * version: 0.1.0
     * date: 10/12/24
     * 
     */
    document.getElementById('formCsv').addEventListener('submit', async (event) => {
      event.preventDefault(); 
   
      try {
          const result = await HttpRequest.submitForm(event, `../../../api/update/readCalifications?idSection=${sectionId}`);
          console.log(result.message); 
          console.log(result); 
          container.innerHTML = "";
          if(result.status == false) {
              let message = document.createElement('p');
              message.innerHTML = result.message;
              container.style.color = 'red';
              container.appendChild(message);
              Modal.closeModal();
          }
          Action.createTableWithData("Registros invalidos", headersincorrectTable, result.incorrectData, container, 'incorrectDataTable', 10, result.incorrectData.length, '', true)
          Action.createTableWithData("Registros que no estaban en el csv", headerMissingData,result.missingData, container, 'MissingInscriptionTable', 10, result.missingData.length, '', true)
          Modal.closeModal();
          
      } catch (error) {
          console.error("Error al cargar el CSV:", error);
      }
  });


   /**
     * Se manda el video para posteriormente almacenarlo en la base de datos
     * author: afcastillof@unah.hn
     * version: 0.1.0
     * date: 10/12/24
     */
   document.getElementById('formVideo').addEventListener('submit', async (event) => {
    event.preventDefault(); 

    // Mostrar rueda de carga
    const loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.style.display = 'flex';

    try {
        const result = await HttpRequest.submitForm(event, `../../../api/update/uploadVideo/?idSection=${sectionId}`);
        
        console.log(result.message); 
        console.log(result); 
        container.innerHTML = "";

        if(result.status == false) {
            Modal.closeModal();
            Popup.open(popupError);
            message.innerHTML = result.message;
            buttonOk2.style.background = '#EC0000';
            buttonOk2.addEventListener('click', () => Popup.close(popupError));
        } else{
          Modal.closeModal();
          Popup.open(popup);
          exitMessage.innerHTML = `Tu video fue cargado exitosamente`;
          buttonOk1.addEventListener('click', () => Popup.close(popup));
        }

    } catch (error) {
        console.error("Error al cargar el video:", error);

        // Mostrar mensaje de error
        container.innerHTML = '<p style="color: red;">Error al cargar el video. Intente nuevamente.</p>';

    } finally {
        // Ocultar rueda de carga
        loadingOverlay.style.display = 'none';
    }
});





  /**
   * Se consume el servicio para descargar el archivo csv con la informacion de los estudiantes 
   * matriculados en la seccion
   * author: afcastillof@unah.hn
   * version: 0.1.0
   * date: 10/12/24
   */
  const urlStudents = `../../../api/get/section/generateCsvStudentsSection/?id=${sectionId}`;
  const downloadStudents = document.getElementById("downloadStudents");
  downloadStudents.addEventListener("click", () => {
    // Código para descargar la plantilla
    const link = document.createElement("a");
    link.href = urlStudents;
    link.download = "Listado_estudiantes.xlsx";
    link.click();
});


const validateVideo = (file) => {
  const validVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];
  const maxSizeInMB = 20;
  const maxSizeInBytes = maxSizeInMB * 1024 * 1024;

  if (file.size > maxSizeInBytes) {
      throw new Error('El archivo debe pesar menos de 20 MB.');
  }

  if (!validVideoTypes.includes(file.type)) {
      throw new Error('Por favor, selecciona un archivo de video válido (mp4, webm, ogg).');
  }
};

const fileInput = document.querySelector('input[name="video"]');
const formErrorMessage = document.createElement('p');
formErrorMessage.style.color = 'red';
formErrorMessage.style.display = 'none';
fileInput.parentElement.appendChild(formErrorMessage);

fileInput.addEventListener('change', async () => {
  const file = fileInput.files[0];

  if (file) {
      try {
          validateVideo(file);
          formErrorMessage.style.display = 'none';
      } catch (error) {
          formErrorMessage.textContent = error.message || error;
          formErrorMessage.style.display = 'block';
          fileInput.value = ''; // Limpiar el input
      }
  }
});

  