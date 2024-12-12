/**
 * @module HomeDataLoader
 * @description Carga y muestra datos del módulo HomeAPA desde una API.
 * @author: afcastillof@unah.hn
 * @version: 0.1.0
 * @date: 12/11/24
 */

import { BarChart } from './chart.js';
import { makeCurrentProcesCard, makeTimeLine, separateData } from './Action.js';
import { HttpRequest } from '../../modules/HttpRequest.js';

const url = '../../../api/get/homeAPA/';

/**
 * Carga datos desde la API y actualiza la interfaz de usuario.
 */
async function loadData() {
  try {
    // Realizar la solicitud GET usando HttpRequest
    const response = await HttpRequest.get(url);
    const data = response.data;

    if (!data) {
      console.error("No se pudo cargar la información desde la API.");
      return;
    }

    // Mostrar el proceso actual
    if (data.currentProces?.name) {
      makeCurrentProcesCard(data.currentProces.id, data.currentProces.name);
    }

    // Crear el gráfico de barra con datos de procesos anteriores
    const previousProcessesSummary = separateData(data.processSummary);
    if (previousProcessesSummary) {
      const barChart = new BarChart(
        "admissionChart",
        previousProcessesSummary.applicantsAmount,
        previousProcessesSummary.processes
      );
      barChart.draw();
    }

    // Generar la línea de tiempo
    if (data.previousProcesses) {
      makeTimeLine(data.previousProcesses);
    }
  } catch (error) {
    console.error("Error al cargar los datos:", error);
  }
}

// Llamar a la función para cargar los datos al iniciar el módulo
loadData();
