import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";
import { Selects } from "../../../modules/Selects.js";

class Action{

    static renderSections(data){

        const headers = ["#", "Clase", "Hora", "Denominación", "Cupos", "Acciones"];

        const dataFormated = data.map(row=>this.formatRows(row));

        const container = document.querySelector("#section-table");

        const section = createTable(
            "", 
            headers, 
            dataFormated, 
            "table-body",
            false,
            10, 
            dataFormated.length, 
            "", 
            false, 
            true,
            ""
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

        const button = `<button data-id-section=${row.id} class="btn btn-outline-success btn-sm actionsBtn">Ver</button>`

        formatedData.push(button);

        return formatedData;
    }

    static renderSelects(data, select) {
        Selects.renderSelect(select,data,'id','name');
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

    static openCreateSection(){

        const modal = document.querySelector("#addSectionModal");

        Modal.openModal(modal,"", "Crea una Sección");

    }

}

export {Action}