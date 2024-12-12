import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";
import { Selects } from "../../../modules/Selects.js";

/**
 * Clase que gestiona las acciones relacionadas con la administración de secciones.
 * @author: afcastillof@unah.hn 
 * @version: 0.1.0
 * date: 6/12/24
 */
class Action {

    /**
     * Renderiza la tabla de secciones.
     * @param {Array} data - Lista de secciones.
     * @param {number} amountSections - Número total de secciones.
     * @param {string} paginationUrl - URL para la paginación.
     * @param {HTMLElement} container - Contenedor donde se agrega la tabla.
     */
    static renderSections(data, amountSections, paginationUrl, container) {
        const headers = ["id", "Seccion", "Clase", "Cupos", "Hora", "Acciones"];
        const dataFormated = this.formatRows(data);

        const section = createTable(
            "", 
            headers, 
            dataFormated, 
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
     * Da formato a las filas de la tabla de secciones.
     * @param {Array} rows - Lista de objetos de secciones.
     * @returns {Array} Filas formateadas.
     */
    static formatRows(rows) {
        return rows.map((row) => {
            const formatedData = Object.values(row);
            const button = `<a id=${row.id} class="btn btn-outline-success btn-sm actionsBtn">Ver</a>`;
            formatedData.push(button);
            return formatedData;
        });
    }

    /**
     * Renderiza un elemento select con los datos proporcionados.
     * @param {Array} data - Lista de elementos para el select.
     * @param {HTMLElement} select - Elemento select a llenar.
     */
    static renderSelects(data, select) {
        Selects.renderSelect(select, data, 'id', 'name');
    }

    /**
     * Abre la modal de acciones para una sección específica.
     * @param {Event} event - Evento de clic del botón de acción.
     */
    static openSectionActions(event) {
        const button = event.target;

        if (button.matches('.actionsBtn')) {
            const actionsModal = document.querySelector("#actionsModal");
            Modal.openModal(actionsModal, "", "Ingenieria de software");
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