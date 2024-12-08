import { Action } from "./Action.js";
import { HttpRequest } from "../../../modules/HttpRequest.js";


const selectPeriod = document.getElementById("period");
const currentPeriod = document.getElementById("currentPeriod");
const professorTypeSelectEdit = document.getElementById("professorTypeSelectEdit");
const url = "";


const data = {
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
                id: 1,
                class: "Ingenieria de Software",
                hour: "11:00 am",
                denomination: "1100",
                places: 12
            },
            {
                id: 2,
                class: "Algoritmos y Estructuras de datos",
                hour: "01:00 pm",
                denomination: "1301",
                places: 24
            }
        ]
    },
    "currentPeriod": {
        "id": 1,
        "name": "2 PAC, 2024"
    },
}

async function loadData() {
    // Realizar la solicitud GET usando HttpRequest
    //const respose = await HttpRequest.get(url);
    //const dataa = respose.data;
    console.log(data)
  
    if (data) {
      Action.renderSections(data.sections.sectionList, data.sections.amountSections);
      Action.renderSelects(data.periods, professorTypeSelectEdit);
      currentPeriod.innerText = `${data.currentPeriod.name}`
    } else {
      console.error("No se pudo cargar la información desde la API.");
    }
  }
  
  // Llamar a la función para cargar los datos al iniciar el módulo
  loadData();

  const table = document.getElementById('section-table');

    // Agregar un event listener al contenedor
    table.addEventListener('click', function(event) {
    // Verificar si el elemento que se hizo clic es un botón (o un elemento específico)
    if (event.target.matches('.editBtn')) {
        // Aquí va la lógica que quieres ejecutar cuando el botón es clickeado
        console.log(event.target.dataset.professorId)
        const buttonId = parseInt(event.target.dataset.professorId, 10);
        Action.openEditiForm(buttonId);
    }
    });