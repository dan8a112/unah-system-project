import {BarChart} from './chart.js';
import { makeCurrentProcesCard, makeTimeLine, separateData } from './Action.js';
import { HttpRequest } from '../../modules/HttpRequest.js';

const data = {
    currentProces: {
        id: 1,
        name: "II Proceso 2024"
    },
    previousProcessesSummary: {
        applicantsAmount: [5000, 4500, 3000, 5200, 5500, 4830, 4500],
        processes: ["1 2021", "2 2021", "1 2022", "2 2022", "1 2023", "2 2023", "1 2024"]
    },
    previousProcesses: [
    {
        year: "2024",
        processes: [
            {
                id: 4,
                title: "I Proceso 2024"
            }
        ]
    },
    {
        year: "2023",
        processes: [
            {
                id: 3,
                title: "II Proceso 2023"
            },
            {
                id: 2,
                title: "I Proceso 2023"
            }
        ]
    },
    {
        year: "2022",
        processes: [
            {
                id: 1,
                title: "II Proceso 2022"
            },
            {
                id: 6,
                title: "I Proceso 2022"
            }
        ]
    }
    ]
}

const logoutButton = document.querySelector("button#logoutButton");

logoutButton.addEventListener("click",async ()=>{
    const response = await HttpRequest.get("../../../api/get/logout");
    if (response.status) {
        window.location.href = "/"
    }
})


const url = '../../../api/get/homeAPA';

async function loadData() {
  // Realizar la solicitud GET usando HttpRequest
  const respose = await HttpRequest.get(url);
  const data = respose.data;
  const previousProcessesSummary = separateData(data.processSummary)
  console.log(data)

  if (data) {
    if (data.currentProces && data.currentProces.name) {
      makeCurrentProcesCard(data.currentProces.id, data.currentProces.name);
    }

    if (previousProcessesSummary) {
      const barChart = new BarChart("admissionChart", previousProcessesSummary.applicantsAmount, previousProcessesSummary.processes);
      barChart.draw();
    }

    // Generar la línea de tiempo
    if (data.previousProcesses) {
      makeTimeLine(data.previousProcesses);
    }
  } else {
    console.error("No se pudo cargar la información desde la API.");
  }
}

// Llamar a la función para cargar los datos al iniciar el módulo
loadData();




