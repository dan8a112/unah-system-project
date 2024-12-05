import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";

class Action{

    static renderSections(rows){

        const data = [
            {
                id: 1,
                class: "Ingenieria de Software",
                hour: "11:00 am",
                denomination: "1100",
                places: 12
            },
            {
                id: 2,
                class: "Algoritmos y Estructuras de datos",
                hour: "01:00 pm",
                denomination: "1301",
                places: 24
            }
        ]

        const headers = ["#", "Clase", "Hora", "Denominación", "Cupos", "Acciones"];

        const dataFormated = data.map(row=>this.formatRows(row));

        const container = document.querySelector("#section-table");

        const section = createTable(
            "", 
            headers, 
            dataFormated, 
            "table-body", 
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

        const button = `<button data-id-section=${row.id} class="btn btn-outline-warning btn-sm actionsBtn">Acciones</button>`

        formatedData.push(button);

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

    static openCreateSection(){

        const modal = document.querySelector("#addSectionModal");

        Modal.openModal(modal,"", "Crea una Sección");

    }

}

export {Action}