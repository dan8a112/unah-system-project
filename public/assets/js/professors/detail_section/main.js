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
      currentPeriod.innerText = `${data.infoSection.period}`;
      startHour.innerText = `${data.infoSection.start}:00`;
      finishHour.innerText = `${data.infoSection.end}:00`;
      denomination.innerText = `${data.infoSection.denomination} | ${data.infoSection.code}`;
      className.innerText = `${data.infoSection.name}`;
      breadCrumbTitle.innerText = `${data.infoSection.name}`;
      amountStudents.innerText = `${data.students.amountStudents}`;
      valueUnits.innerText = `${data.infoSection.valueUnits} UV`;
      days.innerText = `${data.infoSection.days}`
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