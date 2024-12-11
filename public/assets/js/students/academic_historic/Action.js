import { createTable } from "../../modules/table.js";
import { Modal } from "../../modules/Modal.js";

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

    static getInitials(phrase) {
        return phrase
            .split(" ")            
            .map(word => word[0])  
            .join("")              
            .toUpperCase();    
    }

    /**
     * Esta funcion se se encarga de abrir una modal para subir un archivo
     */
    static openUploadEditModal() {
        const uploadCSVModal = document.querySelector("div#editProfileModal");
        Modal.openModal(uploadCSVModal);
    }


}

export {Action}