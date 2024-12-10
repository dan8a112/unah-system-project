import { Action } from "./Action.js";
import { HttpRequest } from "../../modules/HttpRequest.js";


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
     * Se manda el video para posteriormente guandarlo en la base de datos
     * 
     */
    document.getElementById('formCsv').addEventListener('submit', async (event) => {
      event.preventDefault(); 
  
      try {
          const result = await HttpRequest.submitForm(event, `../../../api/update/readCalifations?idSection=${sectionId}/`);
          console.log(result.message); 
          console.log(result); 
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