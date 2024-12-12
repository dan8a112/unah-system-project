import { makeTimeLine } from './Action.js';
import { HttpRequest } from '../../modules/HttpRequest.js';

const sectionId = new URLSearchParams(window.location.search).get("id");
const url = `../../../api/get/professor/timeLinePeriods/?idProfessor=${sectionId}`;
/**
 * Funcion para cargar informacion al cargar la pagina
 * @author: afcastillof@unah.hn
 * @version: 0.1.1
 * date:8/12/24
 */
async function loadData() {
  // Realizar la solicitud GET usando HttpRequest
  const respose = await HttpRequest.get(url);
  const data = respose.data;

  if (data) {
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




