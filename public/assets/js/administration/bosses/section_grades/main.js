/**
 * Archivo de gestión de datos de la sección y calificaciones de estudiantes.
 * Carga datos desde la API y maneja eventos relacionados.
 * 
 * @author: afcastillof@unah.hn
 * @version: 0.1.0
 * @date: 7/12/24
 */

import { Action } from "./Action.js";
import { HttpRequest } from "../../../modules/HttpRequest.js";

// Referencias a elementos del DOM
const currentPeriod = document.getElementById("currentPeriod");
const professor = document.getElementById("professor");
const denomination = document.getElementById("denomination");
const className = document.getElementById("className");
const section = new URLSearchParams(window.location.search).get("section");
const url = `../../../../api/get/section/sectionGrades/?id=${section}`;

/**
 * Carga datos de la API y los renderiza en la interfaz.
 * Muestra información de la sección y estudiantes asociados.
 */
async function loadData() {
    try {
        const response = await HttpRequest.get(url);
        const data = response.data;
        const breadCrumbTitle = document.querySelector(".active");
        const urlPaginacion = `../../../../api/get/pagination/studentsSection/?id=${section}&`;

        if (data) {
            Action.renderStudents(data.students.studentsList, data.students.amountStudents, urlPaginacion);
            currentPeriod.innerText = `${data.period.name}`;
            professor.innerText = `${data.sectionInfo.professor}`;
            denomination.innerText = `${data.sectionInfo.denomination}`;
            className.innerHTML = `${data.sectionInfo.name}`;
            breadCrumbTitle.innerText = `${data.sectionInfo.name}`;
        } else {
            console.error("No se pudo cargar la información desde la API.");
        }
    } catch (error) {
        console.error("Error en la solicitud de datos:", error);
    }
}

// Llama a la función para cargar los datos al iniciar el módulo
loadData();

/**
 * Maneja eventos de clic en la tabla de estudiantes.
 * Abre el formulario de edición si se hace clic en un botón de edición.
 */
const table = document.getElementById('section-table');

table.addEventListener('click', function(event) {
    if (event.target.matches('.editBtn')) {
        const buttonId = parseInt(event.target.dataset.professorId, 10);
        Action.openEditiForm(buttonId);
    }
});
