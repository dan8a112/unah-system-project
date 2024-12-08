import { Action } from "./Action.js";
import { HttpRequest } from "../../../modules/HttpRequest.js";


const currentPeriod = document.getElementById("currentPeriod");
const professor = document.getElementById("professor");
const denomination = document.getElementById("denomination");
const className = document.getElementById("className");
const section = new URLSearchParams(window.location.search).get("section");
const url = `../../../../api/get/section/sectionGrades/?id=${section}`;



const dataa = {
    "sectionInfo" : {
        "name" : "Ingenieria de Software",
        "professor": "Jose Manuel Inestroza",
        "denomination": "1100 | IS-803"
    },
    "students" : { 
        "amountStudents": 25,
        "studentsList" : [
            {
                "account": "20191006515", 
                "name": "Angel Fernando Castillo Flores", 
                "calification": "95", 
                "observation": "APB"
            },
            {
                "account": "20191006515", 
                "name": "Angel Fernando Castillo Flores", 
                "calification": "95", 
                "observation": "APB"
            },
        ]
    },
    "Period": {
        "id": 1,
        "name": "2 PAC, 2024"
    },
}

async function loadData() {
    // Realizar la solicitud GET usando HttpRequest;
    const respose = await HttpRequest.get(url);
    const data = respose.data;
    const breadCrumbTitle = document.querySelector(".active")

    if (data) {
      Action.renderStudents(data.students.studentsList, data.students.amountStudents);
      currentPeriod.innerText = `${data.period.name}`;
      professor.innerText = `${data.sectionInfo.professor}`;
      denomination.innerText = `${data.sectionInfo.denomination}`;
      className.innerHTML = `${data.sectionInfo.name}`;
      breadCrumbTitle.innerText = `${data.sectionInfo.name}`;
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