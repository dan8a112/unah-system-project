// Importación de módulos
import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";
import { Selects } from "../../../modules/Selects.js";
import { HttpRequest } from "../../../modules/HttpRequest.js"; 

/**
 * Clase principal para gestionar acciones relacionadas con secciones
 * @author: dochoa@unah.hn
 * @version: 0.1.0
 * date: 7/12/24
 */
class Action {

    static userId = new URLSearchParams(window.location.search).get("id");
    static isActive = true;

    /**
     * Renderiza toda la página cargando los datos iniciales
     */
    static renderAllPage = async () => {
        const response = await HttpRequest.get(`/api/get/departmentBoss/sectionsAdministration/?id=${this.userId}`);
        const data = response.data;

        document.querySelector("#periodName").innerText = data.period.description;
        document.querySelector("#departmentName").innerText = data.department;

        if (!data.isActive) {
            document.querySelector("#createBtn").setAttribute("disabled", true);
            this.isActive = data.isActive;
        }

        this.renderSections(data.sections, data.period.id, data.amountSections);

        document.querySelector("tbody#table-body").addEventListener("click", (e) => {
            this.openSectionActions(e);
        });
    };

    /**
     * Renderiza la tabla con las secciones
     * @param {Array<Object>} rows - Filas de la tabla
     * @param {number} periodId - ID del periodo actual
     * @param {number} amountSections - Número total de secciones
     */
    static renderSections(rows, periodId, amountSections) {
        const headers = ["#", "Código", "Clase", "Cupos", "Hora", "Acciones"];
        const dataFormated = this.formatRows(rows, this.isActive);
        const container = document.querySelector("#section-table");
        const apiPagination = `/api/get/pagination/sections/?idProcess=${periodId}&idBoss=${this.userId}&`;

        const section = createTable(
            "", headers, dataFormated, "table-body",
            false, 10, amountSections, apiPagination, false, true,
            (rows) => this.formatRows(rows, this.isActive)
        );

        section.style.marginTop = '0px';
        container.appendChild(section);
    }

    /**
     * Formatea las filas para la tabla
     * @param {Array<Object>} rows - Datos de las filas
     * @param {boolean} isActive - Estado activo de la tabla
     * @returns {Array<Array<any>>} Filas formateadas
     */
    static formatRows(rows, isActive) {
        return rows.map(row => {
            const formatedRow = Object.values(row);
            const button = `<button data-id-section=${row.id} class="btn btn-outline-warning btn-sm actionsBtn" ${isActive ? '' : 'disabled'}>Acciones</button>`;
            formatedRow.push(button);
            return formatedRow;
        });
    }

    /**
     * Abre la modal para crear una nueva sección
     */
    static openCreateSection = async () => {
        const selects = ["#classesSelect", "#startHourSelect", "#endHourSelect", "#daysSelect", "#professorsSelect", "#classroomSelect", "#buildingSelect"].map(id => document.querySelector(id));
        this.renderSelects(...selects);
        Modal.openModal(document.querySelector("#addSectionModal"), "", "Crea una Sección");
    };

    /**
     * Envía el formulario para crear una nueva sección
     * @param {Event} event - Evento de envío
     */
    static submitCreateSection = async (event) => {
        event.preventDefault();
        const response = await HttpRequest.submitForm(event, `/api/post/section/`);
        const modal = document.querySelector("#messageModal");
        Modal.openModal(modal, response.message, response.status ? "Se creó la sección exitosamente" : "Ocurrió un error");
    };

    /**
     * Abre una modal con acciones para la sección seleccionada
     * @param {Event} event - Evento de clic
     */
    static openSectionActions = async (event) => {
        const button = event.target;
        if (button.matches('.actionsBtn')) {
            const sectionId = button.dataset.idSection;
            const response = await HttpRequest.get(`/api/get/departmentBoss/sectionStudents/?id=${sectionId}`);
            if (response.status) {
                this.populateSectionModal(response.data, sectionId);
                Modal.openModal(document.querySelector("#actionsModal"), "", `Clase: ${response.data.class.name}`);
            }
        }
    };

    /**
     * Llena la modal con información de la sección seleccionada
     * @param {Object} data - Datos de la sección
     * @param {string} sectionId - ID de la sección
     */
    static populateSectionModal(data, sectionId) {
        document.querySelector("#sectionCode").innerText = data.code;
        document.querySelector("#sectionUV").innerText = data.uv;
        document.querySelector("#sectionDays").innerText = data.days.name;
        document.querySelector("#sectionHour").innerText = `${data.startHour}:00`;
        document.querySelector("#increaseInput").value = data.places;
        document.querySelector("#sectionIdInput").value = sectionId;
        document.querySelector("#classIdInput").value = data.class.id;
    }

    /**
     * Envía el formulario para editar una sección
     * @param {Event} event - Evento de envío
     */
    static submitEditSection = async (event) => {
        event.preventDefault();
        const response = await HttpRequest.submitForm(event, `/api/update/section/`);
        const modal = document.querySelector("#messageModal");
        Modal.openModal(modal, response.message, response.status ? "Se actualizó la sección exitosamente" : "Ocurrió un error al actualizar");
    };

    /**
     * Envía la solicitud para eliminar una sección
     */
    static submitDeleteSection = async () => {
        const sectionId = document.querySelector("#sectionIdInput").value;
        const response = await HttpRequest.get(`/api/update/canceledSection/?id=${sectionId}`);
        const modal = document.querySelector("#messageModal");
        Modal.openModal(modal, response.message, response.status ? "Se eliminó la sección correctamente" : "Ocurrió un error al eliminar la sección");
    };
}

export { Action };