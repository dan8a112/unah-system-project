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
    
            const dataFormated = data.map(row=>this.formatRows(row,"section-id", "Ver Secciones"));
    
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
                (rows)=>{rows.map(row=>this.formatRows(row,"evaluation-id", "Detalle"))}
            );
    
            section.style.marginTop = '0px';
            container.appendChild(section);
    
        }
    
    
        /**
         * Funcion que se encarga de formatear cada fila de la tabla, este retorna un arreglo con los resultados.
         * @param {Object} row 
         * @param {String} dataset 
         * @param {String} textButton 
         * @returns {Array} retorna un array con los elementos de la fila formateados
         */
        static formatRows(row, dataset, textButton){
    
            //Se obtienen todos los valores del objeto como array
            const formatedData = Object.values(row);
    
            //Se crea el elemento button con el dataset del id de la seccion
            const button = `<button data-${dataset}=${row.id} class="btn btn-outline-primary btn-sm actionsBtn">${textButton}</button>`
    
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
                evaluationModal.querySelector('.modal-dialog').classList.remove('modal-lg');

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
                <section class="d-flex gap-3 flex-column px-5 mb-4" id="professorClasses">
                ${data.sections.map(
                    (section, index)=>this.createSectionCard(section,colors[index%3])
                ).join('')}
                </section>`

                Modal.openModal(evaluationModal,content, "Selecciona la sección")
                
                //Se abre la modal
                const classesSection = document.querySelector("section#professorClasses");
                classesSection.addEventListener("click", (e)=>{this.openSectionEvaluations(e)})
            }
    
        }

        static openSectionEvaluations(event){

            const card = event.target.closest('.class-card');

            if (card) {

                Modal.closeModal();

                const sectionId = card.dataset.sectionId;
                //Con el ID se llama a la API

                const data = {
                    class: "Ingeniería de Software",
                    period: "2 PAC 2024",
                    code: "1100",
                    classCode: "IS-804",
                    professorName: "Juan Alberto Martinez",
                    email: "juan.martinez@unah.edu.hn",
                    amountEvaluations: 25,
                    evaluations: [
                        {
                            id: 1,
                            date: '12/12/2024'
                        },
                        {
                            id: 2,
                            date: '14/12/2024'
                        },
                        {
                            id: 3,
                            date: '15/12/2024'
                        }
                    ]
                }
                const evaluationModal = document.querySelector("#evaluationModal");
                //Se hace la modal mas grande
                evaluationModal.querySelector('.modal-dialog').classList.add('modal-lg')
                

                const content = `<div class="mb-4 mx-3">
                <div class="d-flex align-items-center">
                    <h1 class="display-6 me-3">${data.class}</h1>
                    <div class="status-card" style="background-color: #00C500;">${data.period}</div>
                </div>
                <p class="fs-5">${data.code} | ${data.classCode}</p>
                <div class="mb-4">
                    <span class="fs-4">Docente: ${data.professorName}</span><br>
                    <span>${data.email}</span>
                </div>
                <section id="evaluation-table"></section>
                </div>
                `

                Modal.openModal(evaluationModal, content, "Selecciona la Evaluacion");
                
                const dataFormated = data.evaluations.map(row=>this.formatRows(row,"evaluation-id", "Detalle"));

                const headers = ["#", "Fecha de evaluacion", "Evaluacion"]

                const container = document.querySelector("section#evaluation-table");

                const section = createTable(
                    "Evaluaciones de la clase", 
                    headers, 
                    dataFormated, 
                    "evaluation-table-body",
                    true, 
                    10, 
                    dataFormated.length, 
                    "", 
                    false, 
                    true,
                    (rows)=>{rows.map(row=>this.formatRows(row,"evaluation-id", "Detalle"))}
                );

                section.style.marginTop = '0px';
                container.appendChild(section);

            }

        }

        static createSectionCard(section, color){
            
            return `<div class="class-card" data-section-id=${section.id}>
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