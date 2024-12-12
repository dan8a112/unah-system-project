import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";

/**
 * Clase Action que gestiona el renderizado y las acciones en la tabla de estudiantes.
 * @author: afcastillof@unah.hn
 * @version: 0.1.0
 * date: 7/12/24
 */
class Action {

    /**
     * Renderiza la tabla de estudiantes con sus respectivas calificaciones.
     * @param {Array} data - Datos de los estudiantes.
     * @param {number} amountStudents - Cantidad total de estudiantes.
     * @param {string} urlPaginacion - URL para manejar la paginación.
     */
    static renderStudents(data, amountStudents, urlPaginacion) {
        const headers = ["#Cuenta", "Nombre del estudiante", "Calificacion", "Observacion"];
        const dataFormated = data.map(row => this.formatRows(row));
        const container = document.querySelector("#section-table");

        const section = createTable(
            "Calificaciones de seccion", 
            headers, 
            dataFormated, 
            "table-body",
            false,
            10, 
            amountStudents,
            urlPaginacion, 
            false, 
            true,
            this.formatRows
        );

        section.style.marginTop = '0px';
        container.appendChild(section);
    }

    /**
     * Formatea una fila de datos de un estudiante para mostrarla en la tabla.
     * @param {Object} row - Datos de un estudiante.
     * @returns {Array} - Fila de datos formateada.
     */
    static formatRows(row) {
        const formatedData = Object.values(row);
        const anchor = `<a style="text-decoration: none; color: inherit; cursor: pointer;">${row.account}<a>`;
        formatedData[0] = anchor;
        return formatedData;
    }

    /**
     * Abre la modal de acciones para una sección específica.
     * @param {Event} event - Evento de clic en el botón de acciones.
     */
    static openSectionActions(event) {
        const button = event.target;

        if (button.matches('.actionsBtn')) {
            const actionsModal = document.querySelector("#actionsModal");
            // Se modifican los valores de la modal según el resultado de la petición
            Modal.openModal(actionsModal, "", "Ingenieria de software");
        }
    }
}

export { Action };
