import {BarChart} from './chart.js';
import { makeCurrentProcesCard, makeTimeLine, separateData } from './Action.js';
import { HttpRequest } from '../../modules/HttpRequest.js';

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




