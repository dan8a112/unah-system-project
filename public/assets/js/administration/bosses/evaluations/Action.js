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
                    name: "Juan Alberto Martinez",
                    email: "juan.alberto@unah.hn",
                    amountSections: 2
                },
                {
                    id: 2,
                    name: "Maria Alejandra Galvez",
                    email: "maria.alejandrag@unah.hn",
                    amountSections: 2
                }
            ]
    
            const headers = ["#", "Docente", "Correo", "Secciones", "Acciones"];
    
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
            const button = `<button data-id-section=${row.id} class="btn btn-outline-primary btn-sm actionsBtn">Ver</button>`
    
            //Se agrega el boton al array (fila de la tabla)
            formatedData.push(button);
    
            return formatedData;
        }
    
        /**
         * Abre una modal en donde se pueden ver las evaluaciones de cada docente
         * @param {Event} event recibe el evento que fue ejecutado (Click) 
         */
        static openEvaluation(event){

            const data = {
                professorName: "Juan Alberto Martinez",
                sections: [
                    {
                        id: 1,
                        code: "1100",
                        class: "Programacion II",
                        classCode: "IS-210"
                    },
                    {
                        id: 2,
                        code: "1500",
                        class: "Inteligencia Artificial",
                        classCode: "IS-803"
                    }
                ]
            }
    
            //Obtiene el target (se espera un boton)
            const button = event.target;
    
            //Si es un boton de la tabla se abre la modal
            if (button.matches('.actionsBtn')) {
                const evaluationModal = document.querySelector("#evaluationModal");

                //Se modifican los valores de la modal del resultado de la peticion
                const colors = {
                    0: "#FFAA34",
                    1: "#304987",
                    2: "#AF595C"
                }

                const content = `
                <div class="mb-4">
                    <span class="fs-4">Docente: ${data.professorName}</span><br>
                    <span>Estas son las secciones que tiene asignadas el docente.</span>
                </div>
                <section class="d-flex gap-3 flex-column px-5 mb-4">
                ${data.sections.map(
                    (section, index)=>this.createSectionCard(section,colors[index%3])
                ).join('')}
                </section>`

                console.log(content)

                //Se abre la modal
                Modal.openModal(evaluationModal,content, "Selecciona la sección")
            }
    
        }

        static createSectionCard(section, color){
            
            return `<div class="class-card">
                    <div class="class-card-header" style="background-color: ${color};">
                        <span>Seccion ${section.code}</span>
                    </div>
                    <div class="ps-3 pe-5 pb-3 pt-2">
                        <span class="fs-4" style="display:block" >${section.class}</span>
                        <span style="color: #A1A1A1">${section.classCode}</span>
                    </div>
                    </div>`
        }
}

export {Action}