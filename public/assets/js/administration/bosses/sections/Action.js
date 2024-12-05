import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";

class Action{

    /**
     * Se encarga de renderizar la tabla con las secciones en la pagina.
     * @param {*} data 
     */
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
     * Funcion que se encarga de formatear cada fila de la tabla, este retorna un arreglo con los resultados.
     * @param {Object} row 
     * @returns {Array} retorna un array con los elementos de la fila formateados
     */
    static formatRows(row){

        //Se obtienen todos los valores del objeto como array
        const formatedData = Object.values(row);

        //Se crea el elemento button con el dataset del id de la seccion
        const button = `<button data-id-section=${row.id} class="btn btn-outline-warning btn-sm actionsBtn">Acciones</button>`

        //Se agrega el boton al array (fila de la tabla)
        formatedData.push(button);

        return formatedData;
    }

    /**
     * Abre una modal en donde se pueden realizar acciones sobre cada sección, como editar y eliminar
     * @param {Event} event recibe el evento que fue ejecutado (Click) 
     */
    static openSectionActions(event){

        //Obtiene el target (se espera un boton)
        const button = event.target;

        //Si es un boton de la tabla se abre la modal
        if (button.matches('.actionsBtn')) {

            const actionsModal = document.querySelector("#actionsModal");
            //Se modifican los valores de la modal del resultado de la peticion
            Modal.openModal(actionsModal,"", "Ingenieria de software")
        }

    }

    /**
     * Se abre una modal con un formulario en donde el jefe de departamento puede crear secciones
     */
    static openCreateSection(){

        const modal = document.querySelector("#addSectionModal");

        Modal.openModal(modal,"", "Crea una Sección");

    }


}

export {Action}