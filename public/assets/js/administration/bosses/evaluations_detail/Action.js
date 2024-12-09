import {createSectionCard} from '../../../modules/Cards.js'
import { createTable } from "../../../modules/table.js";
import {Modal} from "../../../modules/Modal.js"

class Action{

    static renderSections(){

        const professorId = new URLSearchParams(window.location.search).get("professorId");

        //Se hace fetch usando el professorId
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
                },
                {
                    id: 3,
                    code: "1600",
                    class: "Algoritmos y estructuras de datos",
                    classCode: "IS-803"
                }
            ]
        }

        const professorName = document.querySelector("#professorName");
        professorName.innerText = `Docente: ${data.professorName}`;

        const cardsFormated = data.sections.map((section, index) => createSectionCard(section, index)).join("");

        const sectionsContainer = document.querySelector("#sectionsContainer");

        sectionsContainer.innerHTML = cardsFormated;

    }


    static renderEvaluationList(event){

        //Si hay una seleccionada se deselecciona
        const selectedCard = document.querySelector("#sectionsContainer .selected-card");
        selectedCard && selectedCard.classList.remove("selected-card");

        //Obtiene el padre mas cercano que tenga la clase class-card
        const card = event.target.closest('.class-card');

        if (card) {

            card.classList.add("selected-card")

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

            //HTML con información de la sección selecionada y tabla de evaluaciones
            const content = `
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
                `

            const evaluationsContainer = document.querySelector("#evaluationsContainer");
            evaluationsContainer.innerHTML = "";

            evaluationsContainer.innerHTML = content;

            const dataFormated = data.evaluations.map(row => this.formatRows(row, "evaluation-id", "Detalle"));

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
                (rows) => { rows.map(row => this.formatRows(row, "evaluation-id", "Detalle")) }
            );

            section.style.marginTop = '0px';
            container.appendChild(section);

            //Accion al presionar un boton de la tabla (Acciones)
            const tableBody = document.querySelector("tbody#evaluation-table-body");
            tableBody.addEventListener("click", (e)=>{this.openEvaluationsDetail(e)});

        }

    }

    static openEvaluationsDetail(event){
                //Obtiene el target (se espera un boton)
        const button = event.target;

        //Si es un boton de la tabla se abre la modal
        if (button.matches('.actionsBtn')) {

            const evaluationId = button.dataset.evaluationId;

            const data = {
                score: 100,
                responsability: "Bueno",
            }

            const content = `
            <div>
                <p>Puntuacion: ${data.score}%</p>
                <p>Responsabilidad: ${data.responsability}</p>
            </div>
            `

            const modal = document.querySelector("#evaluationModal");
            Modal.openModal(modal,content, "Evaluacion")

        }
    }

    
    /**
     * Funcion que se encarga de formatear cada fila de la tabla, este retorna un arreglo con los resultados.
     * @param {Object} row 
     * @param {String} dataset 
     * @param {String} textButton 
     * @returns {Array} retorna un array con los elementos de la fila formateados
     */
    static formatRows(row, dataset, textButton) {

        //Se obtienen todos los valores del objeto como array
        const formatedData = Object.values(row);

        //Se crea el elemento button con el dataset del id de la seccion
        const button = `<button data-${dataset}=${row.id} class="btn btn-outline-primary btn-sm actionsBtn">${textButton}</button>`

        //Se agrega el boton al array (fila de la tabla)
        formatedData.push(button);

        return formatedData;
    }

}

export {Action}