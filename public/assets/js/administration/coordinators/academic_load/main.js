import { Action } from "./Action.js";
import { HttpRequest } from "../../../modules/HttpRequest.js";


const selectPeriod = document.getElementById("period");
const currentPeriod = document.getElementById("periodName");
const careertName = document.getElementById("careertName")
const professorTypeSelectEdit = document.getElementById("professorTypeSelectEdit");
const userId = new URLSearchParams(window.location.search).get("id");
const url = `../../../../api/get/pagination/currentAcademicLoad/index.php?coordinatorId=${userId}&&offset=0`;
const container = document.querySelector("#section-table");

 // Estado para currentPeriodd
 let state = {
    currentPeriodd: 0,
  };
  
  // Función para actualizar el estado
  function setState(key, value) {
    state[key] = value;
  }



const dataa = {
    "periods" : [
        {
            "id": 3,
            "name": "1 PAC, 2023"
        },
        {
            "id": 2,
            "name": "2 PAC, 2023"
        },
        {
            "id": 4,
            "name": "3 PAC, 2023"
        }
    ],
    "sections" : { 
        "amountSections": 25,
        "sectionList" : [
            {
                code: "1100",
                class: "Ingenieria de Software",
                section: "1100",
                professor: "Angel Fernando Castilo Flores",
                idProfessor: "001",
                enrolled: 12,
                places: 20,
                building: "B2",
                classroom: "201"
            },
            {
                code: "1100",
                class: "Ingenieria de Software",
                section: "1100",
                professor: "Angel Fernando Castilo Flores",
                idProfessor: "001",
                enrolled: 12,
                places: 20,
                building: "B2",
                classroom: "201"
            },
        ]
    },
    "currentPeriod": {
        "id": 1,
        "description": "2 PAC, 2024"
    },
    "career" : "Ingenieria en sistemas"
}

async function loadData() {
    // Realizar la solicitud GET usando HttpRequest
    const respose = await HttpRequest.get(url);
    const data = respose;
    const paginationUrl = `../../../../api/get/pagination/currentAcademicLoad/index.php?coordinatorId=${userId}&&`;
  
    if (data) {
      Action.renderSections(data.sections.sectionList, data.sections.amountSections, paginationUrl, container);
      Action.renderSelects(data.periods, selectPeriod);
      currentPeriod.innerText = `${data.currentPeriod.name}`;
      setState("currentPeriodd", data.currentPeriod.id);
      careertName.innerText = `${data.career}`
    } else {
      console.error("No se pudo cargar la información desde la API.");
    }
  }
  
  // Llama a la función para cargar los datos al iniciar el módulo
  loadData();

const table = document.getElementById('section-table');

// Agrega un event listener al contenedor
table.addEventListener('click', function(event) {
if (event.target.matches('.btn')) {
    window.location.href = `/assets/views/administration/bosses/section_grades.php?id=${userId}&section=${event.target.id}`;
    const buttonId = parseInt(event.target.dataset.professorId, 10);
    Action.openEditiForm(buttonId);
}
});
const response = {
    "status": true,
    "message": "Array obtenido.",
    "data": [
        {
            "id": 102,
            "denomination": "0600",
            "class": "MATEMATICA I",
            "places": 40,
            "hour": "600:00"
        },
        {
            "id": 103,
            "denomination": "0700",
            "class": "GEOMETRIA Y TRIGONOMETRIA",
            "places": 40,
            "hour": "700:00"
        },
        {
            "id": 104,
            "denomination": "0700",
            "class": "CALCULO I",
            "places": 40,
            "hour": "700:00"
        },
        {
            "id": 105,
            "denomination": "0600",
            "class": "CALCULO II",
            "places": 40,
            "hour": "600:00"
        },
        {
            "id": 106,
            "denomination": "0700",
            "class": "VECTORES Y MATRICES",
            "places": 40,
            "hour": "700:00"
        },
        {
            "id": 107,
            "denomination": "0800",
            "class": "ECUACIONES DIFERENCIALES",
            "places": 40,
            "hour": "800:00"
        },
        {
            "id": 108,
            "denomination": "0900",
            "class": "MATEMATICA DISCRETA",
            "places": 40,
            "hour": "900:00"
        }
    ],
    "amountSections": 7
}
selectPeriod.addEventListener('change', async (event) => {
    try {
        const url2 = `/api/get/pagination/historicAcademicLoad/index.php?coordinatorId=${userId}&&periodId=${event.target.value}&&offset=0`;
        const selectedOption = event.target.options[event.target.selectedIndex];
        const selectedText = selectedOption.innerText;
        const response = await HttpRequest.get(url2); 
        const data = response.data;
        const paginationUrl = `../../../../api/get/pagination/historicAcademicLoad/index.php?coordinatorId=${userId}&&periodId=${event.target.value}&&`;
        setState("currentPeriodd", response.currentPeriod.id);

        if (data) {
            container.innerHTML = "";
            Action.renderSections(data, response.sections.amountSections, paginationUrl, container);
            currentPeriod.innerText = `${selectedText}`;
        } else {
            console.error("No se pudo cargar la información desde la API.");
        }
    } catch (error) {
        console.error("Error en la solicitud:", error);
    }
});

  const downloadStudents = document.getElementById("downloadLoad");
  downloadStudents.addEventListener("click", () => {
    const urlload = `../../../../api/get/coordinator/generateCsvAcademicLoad/?idCoordinator=${userId}&idPeriod=${state.currentPeriodd}`;
    // Código para descargar la plantilla
    const link = document.createElement("a");
    link.href = urlload;
    link.click();
});
