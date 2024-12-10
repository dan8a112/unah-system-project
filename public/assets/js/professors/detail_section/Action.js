import { createTable } from "../../modules/table.js";
import { Modal } from "../../modules/Modal.js";

class Action{

    static renderStudents(data, urlPaginacion){

        const { stateProces, students } = data;

        switch (stateProces) {
            case 1:
                this.renderUploadCSVSection(stateProces);
                break;
            case 2:
                this.renderUploadCSVSection(stateProces);
                break;
        }

        const headers = ["Cuenta", "Nombre del estudiante", "Carrera", "Fecha de matricula"];

        const dataFormated = data.students.stundentsList.map(row=>this.formatRows(row));

        const container = document.querySelector("#section-table");

        const section = createTable(
            "Estudiantes matriculados", 
            headers, 
            dataFormated, 
            "table-body",
            true,
            10, 
            students.amountStudents,
            urlPaginacion, 
            false, 
            true,
            this.formatRows
        );

        section.style.marginTop = '0px';
        container.appendChild(section);

    }

    /**
     * Le el formato necesario a la data antes de crear la tabla.
     * author: afcastillof@unah.hn
     * version: 0.1.0
     * date: 09/12/24
     * @param {Object} rows 
     */
    static formatRows(row){

        const formatedData = Object.values(row);

        const anchor = `<a style="text-decoration: none; color: inherit; cursor: pointer;">${row.account}<a>`
        formatedData.shift()
        formatedData[0] = anchor;

        return formatedData;
    }

    /**
     * Renderiza la tarjeta para subir o gestionar archivos.
     * author: afcastillof@unah.hn
     * version: 0.1.0
     * date: 09/12/24
     * @param {number} processState - Estado actual del proceso de admisión.
     */
    static renderUploadCSVSection(processState, sendedEmail) {
        const uploadCsvSection = document.querySelector("section#upload_csv");
        const cardContent = this.getCardContent(processState);
        const card = this.createCard(cardContent, sendedEmail);

        uploadCsvSection.appendChild(card);
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

    static createCard(content, sendedEmail) {
        const card = document.createElement("div");
        card.classList.add("card-container", "d-flex", "justify-content-between");

        card.innerHTML = `
            <div>
                <p class="font-medium">${content.title}</p>
                <p >${content.description}</p>
            </div>
        `;

        const button = document.createElement("button");
        button.classList.add("button-upload", "btn");
        button.id = content.button.id;
        button.style.backgroundColor = content.button.color;
        button.innerHTML = `
            <img src="../../img/icons/${content.button.icon}" alt="" class="me-2">
            <span style="color: ${content.button.spanColor}">${content.button.text}</span>
        `;
        button.addEventListener("click", () => this[content.button.action]?.());
        if(sendedEmail==1){
            button.disabled = true;
            button.style.backgroundColor = '#878787';
            card.innerHTML = `
            <div>
                <p class="font-medium">${content.title}</p>
                <p style="color: '#3472f8'";>${content.description}</p>
            </div>`;
        }

        card.appendChild(button);
        return card;
    }


    /**
     * Genera el contenido dinámico para la tarjeta según el estado del proceso.
     * @param {number} processState - Estado actual del proceso.
     * @returns {Object} Contenido dinámico de la tarjeta.
     */
    static getCardContent(processState, sendedEmail) {
        const contentMap = {
            1: {
                title: "Subir calificaciones de la clase",
                description:
                    "Llegó el momento de subir las calificaciones de los alumnos, puedes hacerlo desde este espacio.",
                button: { id: "uploadRatingsBtn", text: "Subir Calificaciones", icon: "upload.svg", action: "openUploadModal" },
            },
            2: {
                title: "Subir video de presentación",
                description: "Puedes agregar un video descriptivo para esta clase para mostrarla a tus alumnos.",
                    button: { id: "uploadCSVBtn", text: "Subir Video", icon: "upload.svg", action: "openUploadModal" },
            }
        };

        return contentMap[processState] || {};
    }

}

export {Action}