/**
 * Módulo para cargar y gestionar datos de secciones.
 * @module SectionsLoader
 * @version 0.1.0
 * @date 9/12/24
 * @autor afcastillof@unah.hn
 */

import { Action } from "./Action.js";
import { HttpRequest } from "../../../modules/HttpRequest.js";

// Elementos del DOM
const selectPeriod = document.getElementById("period");
const currentPeriod = document.getElementById("currentPeriod");
const userId = new URLSearchParams(window.location.search).get("id");
const url = `../../../../api/get/departmentBoss/ratingsInfo/?id=${userId}`;
const container = document.querySelector("#section-table");

/**
 * Carga y renderiza los datos desde la API.
 */
async function loadData() {
  try {
    const response = await HttpRequest.get(url);
    const data = response;
    
    if (!data) {
      throw new Error("No se pudo cargar la información desde la API.");
    }

    const paginationUrl = `../../../../api/get/pagination/sections/?idProcess=${data.currentPeriod.id}&idBoss=${userId}&`;
    Action.renderSections(data.sections.sectionList, data.sections.amountSections, paginationUrl, container);
    Action.renderSelects(data.periods, selectPeriod);
    currentPeriod.innerText = data.currentPeriod.description;

  } catch (error) {
    console.error(error.message);
  }
}

// Inicializa la carga de datos
loadData();

// Event listener para manejar clicks en la tabla de secciones
const table = document.getElementById('section-table');
table.addEventListener('click', handleTableClick);

/**
 * Maneja los clics en los botones de la tabla.
 * @param {Event} event - Evento de clic en la tabla.
 */
function handleTableClick(event) {
  if (event.target.matches('.btn')) {
    const sectionId = event.target.id;
    window.location.href = `/assets/views/administration/bosses/section_grades.php?id=${userId}&section=${sectionId}`;
    const professorId = parseInt(event.target.dataset.professorId, 10);
    Action.openEditiForm(professorId);
  }
}

// Event listener para cambios en el período seleccionado
selectPeriod.addEventListener('change', handlePeriodChange);

/**
 * Maneja el cambio de período y actualiza la tabla.
 * @param {Event} event - Evento de cambio en el select de período.
 */
async function handlePeriodChange(event) {
  try {
    const periodId = event.target.value;
    const selectedOption = event.target.options[event.target.selectedIndex];
    const selectedText = selectedOption.innerText;

    const paginationUrl = `../../../../api/get/pagination/sections/?idProcess=${periodId}&idBoss=${userId}&`;
    const requestUrl = `http://localhost:3000/api/get/pagination/sections/?idProcess=${periodId}&offset=0&idBoss=${userId}`;

    const response = await HttpRequest.get(requestUrl);
    const data = response.data;

    if (!data) {
      throw new Error("No se pudo cargar la información desde la API.");
    }

    container.innerHTML = "";
    Action.renderSections(data, response.amountSections, paginationUrl, container);
    currentPeriod.innerText = selectedText;
  } catch (error) {
    console.error("Error en la solicitud:", error);
  }
}
