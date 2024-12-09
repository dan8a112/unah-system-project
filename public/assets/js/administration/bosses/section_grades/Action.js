import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";

class Action{

    static renderStudents(data, amountStudents, urlPaginacion){

        const headers = ["#Cuenta", "Nombre del estudiante", "Calificacion", "Observacion"];

        const dataFormated = data.map(row=>this.formatRows(row));

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
     * 
     * @param {Object} rows 
     */
    static formatRows(row){

        const formatedData = Object.values(row);

        const anchor = `<a style="text-decoration: none; color: inherit; cursor: pointer;">${row.account}<a>`

        formatedData[0] = anchor;

        return formatedData;
    }

    static openSectionActions(event){

        const button = event.target;

        if (button.matches('.actionsBtn')) {
            console.log(button);
            const actionsModal = document.querySelector("#actionsModal");
            //Se modifican los valores de la modal del resultado de la peticion
            Modal.openModal(actionsModal,"", "Ingenieria de software")
        }

    }

}

export {Action}