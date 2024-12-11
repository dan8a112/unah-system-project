import { Action } from "./Action.js";
import { HttpRequest } from "../../modules/HttpRequest.js";
import { Modal } from "../../modules/Modal.js";


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
const headerMissingData = ["Cuenta", "Nombre"]



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
   document.getElementById('fromVideo').addEventListener('submit', async (event) => {
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
        }
        Action.createTableWithData("Registros invalidos", headersincorrectTable, result.incorrectData, container, 'incorrectDataTable', 10, result.incorrectData.length, '', true)
        Action.createTableWithData("Registros que no estaban en el csv", headerMissingData,result.missingData, container, 'MissingInscriptionTable', 10, result.missingData.length, '', true)
        Modal.closeModal();
        
    } catch (error) {
        console.error("Error al cargar el CSV:", error);
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
  