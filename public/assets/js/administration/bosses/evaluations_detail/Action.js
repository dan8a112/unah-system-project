import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";
import { Selects } from "../../../modules/Selects.js";

/**
 * Clase que gestiona las acciones relacionadas con secciones.
 * @author: afcastillof@unah.hn
 * @version: 0.1.0
 * @date: 9/12/24
 */
class Action {

    /**
     * Renderiza una tabla con las secciones.
     * @param {Object[]} data - Datos de las secciones.
     * @param {number} amountSections - Cantidad total de secciones.
     * @param {string} paginationUrl - URL para la paginación.
     * @param {HTMLElement} container - Contenedor donde se insertará la tabla.
     */
    static renderSections(data, amountSections, paginationUrl, container) {
        const headers = ["id", "Sección", "Clase", "Cupos", "Hora", "Acciones"];
        const dataFormatted = this.formatRows(data);

        const section = createTable(
            "",
            headers,
            dataFormatted,
            "table-body",
            false,
            10,
            amountSections,
            paginationUrl,
            false,
            true,
            this.formatRows
        );

        section.style.marginTop = '0px';
        container.appendChild(section);
    }

    /**
     * Formatea las filas para la tabla.
     * @param {Object[]} rows - Filas de datos.
     * @returns {string[][]} - Filas formateadas.
     */
    static formatRows(rows) {
        return rows.map(row => {
            const formattedData = Object.values(row);
            const actionButton = `<a id="${row.id}" class="btn btn-outline-success btn-sm actionsBtn">Ver</a>`;
            formattedData.push(actionButton);
            return formattedData;
        });
    }

    /**
     * Renderiza un select con los datos proporcionados.
     * @param {Object[]} data - Datos para el select.
     * @param {HTMLSelectElement} select - Elemento select donde se renderizarán los datos.
     */
    static renderSelects(data, select) {
        Selects.renderSelect(select, data, 'id', 'name');
    }

    /**
     * Maneja la apertura de la modal de acciones para una sección.
     * @param {Event} event - Evento de clic.
     */
    static openSectionActions(event) {
        const button = event.target;
        if (button.matches('.actionsBtn')) {
            const actionsModal = document.querySelector("#actionsModal");
            Modal.openModal(actionsModal, "", "Ingeniería de Software");
        }
    }

    /**
     * Abre la modal para crear una nueva sección.
     */
    static openCreateSection() {
        const modal = document.querySelector("#addSectionModal");
        Modal.openModal(modal, "", "Crea una Sección");
    }
}

export { Action };
