import { createTable } from "../../modules/table.js";

class Action{

    static renderSections(data, amountSections, paginationUrl, container){

        const headers = ["Codigo", "Clase", "UV", "Seccion", "Año", "Periodo", "Calificacion", "Obs"];

        const dataFormated = this.formatRows(data);


        const section = createTable(
            "", 
            headers, 
            dataFormated, 
            "table-body",
            true,
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
            formatedData.shift();

            return formatedData;
        })

    }


}

export {Action}