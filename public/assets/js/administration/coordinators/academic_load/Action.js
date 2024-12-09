import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";
import { Selects} from "../../../modules/Selects.js";

class Action{

    static renderSections(data, amountSections, paginationUrl, container){

        const headers = ["Codigo", "Clase", "Seccion", "Docente", "id Docente", "Matricula", "Cupos", "Edificio", "Aula"];

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
     * 
     * @param {Object} rows 
     */
    static formatRows(rows){
        return rows.map((row)=>{
            const formatedData = Object.values(row);
            return formatedData;
        })

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