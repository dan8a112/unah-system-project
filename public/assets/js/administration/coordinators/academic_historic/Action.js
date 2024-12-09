import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";
import { Selects} from "../../../modules/Selects.js";

class Action{

    static renderSections(data, amountSections, container){

        const headers = ["Cuenta", "Nombre", "Carrera", "Centro", "Acciones"];

        const dataFormated = this.formatRows(data);


        const section = createTable(
            "", 
            headers, 
            dataFormated, 
            "table-body",
            false,
            10, 
            amountSections,
            "",
            true, 
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
            const button = `<a id=${row.id} class="btn btn-outline-success btn-sm actionsBtn">Ver Historial</a>`
            formatedData.push(button);
            formatedData.shift();
            return formatedData;
        })

    }

    static renderSelects(data, select) {
        Selects.renderSelect(select,data,'id','name');
    }


}

export {Action}