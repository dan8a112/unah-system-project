import { HttpRequest } from "../../modules/HttpRequest.js";
import { Modal } from "../../modules/Modal.js";
import { Popup } from "../../modules/Popup.js";
import { createTable } from "../../modules/table.js";

class Action {
    /**
     * Renderiza información del proceso de admisión en la página.
     * author: afcastillof@unah.hn, dochoa@unah.hn
     * version: 0.1.0
     * date: 24/11/24
     * @param {Object} data - Datos del proceso de admisión actual.
     */
    static renderActiveProcess(data) {
        const { infoProcess, amountInscription, lastestInscriptions, reviewers } = data;

        this.updateTextContent("h1#processName", infoProcess.processState);
        this.updateTextContent("p#startDate", infoProcess.start);
        this.updateTextContent("p#finishDate", infoProcess.end);
        this.updateTextContent("h1#admissionState", infoProcess.processState);
        this.updateTextContent("h1#amountInscriptions", amountInscription.amountInscriptions);

        switch (infoProcess.idProcessState) {
            case 4:
                this.renderRevisionProcess(reviewers, amountInscription.amountInscriptions, amountInscription.approvedInscriptions, amountInscription.missingReviewInscriptions);
                break;
            case 5:
                this.renderUploadCSVSection(infoProcess.idProcessState);
                break;
            case 6:
                break;
        }

    }

    /**
     * Renderiza la tarjeta para subir o gestionar archivos CSV.
     * author: afcastillof@unah.hn
     * version: 0.1.0
     * date: 24/11/24
     * @param {number} processState - Estado actual del proceso de admisión.
     */
    static renderUploadCSVSection(processState) {
        const uploadCsvSection = document.querySelector("section#upload_csv");
        const cardContent = this.getCardContent(processState);
        const card = this.createCard(cardContent, processState);

        uploadCsvSection.appendChild(card);
    }

    /**
     * Genera el contenido de la tabla con la informacion de los revisores
     * author: afcastillof@unah.hn
     * version: 0.1.0
     * date: 24/11/24
     * @param {row} processState - Filas para la tabla de revisiones.
     * @param {inscripcionesPorRevisar} inscripcionesPorRevisar 
     * @param {inscripcionesRevisadas} inscripcionesRevisadas 
     * @param {totalInscripciones} totalInscripciones 
     * @returns {Object} Contenido dinámico de la tarjeta.
     */
    static renderRevisionProcess(rows, totalInscripciones, inscripcionesRevisadas, inscripcionesPorRevisar) {
        // Crear elemento con clases específicas
        const createElementWithClasses = (tag, ...classes) => {
            const element = document.createElement(tag);
            element.classList.add(...classes);
            return element;
        };
    
        // Crear estructura general
        const containerGeneral = createElementWithClasses('div', 'row', 'gap-5');
        containerGeneral.id = 'containerGeneral';
        const container = document.getElementById('container');
    
        if (!container) {
            console.error("El contenedor con id 'container' no se encuentra en el DOM.");
            return;
        }
    
        // Contenedor dinámico para la tabla
        const containerDinamic = createElementWithClasses('div', 'col-8');
        const headers = ["#", "Nombre", "Inscripciones revisadas"];
        this.createTableWithData("Revisores", headers, rows, containerDinamic, "reviewersTable");
    
        // Sección de progreso de revisiones
        const containerInfo = createElementWithClasses('div', 'card-container', 'col');
    
        const iconRevision = createElementWithClasses('img', 'me-2');
        iconRevision.src = '../../img/icons/graduation-icon.svg';
    
        const title = document.createElement('span');
        title.classList.add("fw-bold")
        title.textContent = "Progreso de revisiones";
    
        // Composición de la sección de título
        const titleContainer = createElementWithClasses('div', 'd-flex', 'align-items-center');
        titleContainer.append(iconRevision, title);
    
        // Información adicional
        const infoDetails = createElementWithClasses('div', 'mt-3');
        const createInfoItem = (label, value) => {
            const item = createElementWithClasses('div', 'd-flex', 'justify-content-between', 'mb-2');
            const labelElement = document.createElement('span');
            labelElement.textContent = label;
    
            const valueElement = document.createElement('span');
            valueElement.classList.add("fw-bold")
            valueElement.textContent = value;
            valueElement.style.color = "#FFAA34";
    
            item.append(labelElement, valueElement);
            return item;
        };
    
        infoDetails.appendChild(createInfoItem("Total de inscripciones:", totalInscripciones, true));
        infoDetails.appendChild(createInfoItem("Inscripciones aprobadas:", inscripcionesRevisadas, true));
        infoDetails.appendChild(createInfoItem("Inscripciones por revisar:", inscripcionesPorRevisar, true));
    
        containerInfo.appendChild(titleContainer);
        containerInfo.appendChild(infoDetails);
    
        // Ensamblar y agregar al DOM
        containerGeneral.append(containerInfo, containerDinamic);
        container.appendChild(containerGeneral);
    }
    
    
    

    /**
     * Genera el contenido dinámico para la tarjeta según el estado del proceso.
     * @param {number} processState - Estado actual del proceso.
     * @returns {Object} Contenido dinámico de la tarjeta.
     */
    static getCardContent(processState) {
        const contentMap = {
            5: {
                title: "Subida de calificaciones",
                description:
                    "El proceso de admisión está en publicación de resultados. Puedes subir el archivo de calificaciones aquí.",
                button: { id: "uploadCSVBtn", text: "Subir CSV", icon: "upload.svg", action: "openUploadModal" },
            },
            6: {
                title: "Enviar resultados",
                description:
                    "Informa a los participantes sobre su dictamen en las pruebas por correo.",
                button: { id: "sendMail", text: "Enviar resultados CSV", icon: "mail.svg", action: "openMailModal" },
            },
            7: {
                title: "Generar CSV",
                description:
                    "Genera un archivo CSV con todos los estudiantes aprobados de este proceso.",
                button: { id: "downloadCsvBtn", text: "Descargar CSV", icon: "download.svg", action: "downloadCSV" },
            },
        };

        return contentMap[processState] || {};
    }

    /**
     * Crea una tarjeta con el contenido especificado.
     * @param {Object} content - Contenido de la tarjeta.
     * @param {number} processState - Estado actual del proceso.
     * @returns {HTMLElement} Elemento HTML de la tarjeta.
     */
    static createCard(content, processState) {
        const card = document.createElement("div");
        card.classList.add("card-container", "d-flex", "justify-content-between");

        card.innerHTML = `
            <div>
                <p class="font-medium">${content.title}</p>
                <p>${content.description}</p>
            </div>
        `;

        const button = document.createElement("button");
        button.classList.add("button-upload", "btn");
        button.id = content.button.id;
        button.innerHTML = `
            <img src="../../img/icons/${content.button.icon}" alt="" class="me-2">
            <span>${content.button.text}</span>
        `;
        button.addEventListener("click", () => this[content.button.action]?.());

        card.appendChild(button);
        return card;
    }

    /**
     * Actualiza el texto de un elemento.
     * @param {string} selector - Selector del elemento.
     * @param {string} text - Texto a asignar.
     */
    static updateTextContent(selector, text) {
        const element = document.querySelector(selector);
        if (element) element.innerText = text;
    }

    /**
     * Llama a la API para obtener información del proceso de admisión activo.
     */
    static fetchActiveData = async () => {
        try {
            const response = await HttpRequest.get(`../../../api/get/admission/infoCurrentAdmission`);
            if (response.status) {
                this.renderActiveProcess(response.data);
            } else {
                this.handleError(response.message);
            }
        } catch (error) {
            console.error("Error al obtener datos del proceso activo:", error);
        }
    };

    /**
     * Maneja errores mostrando un popup.
     * @param {string} message - Mensaje de error.
     */
    static handleError(message) {
        const popupError = document.querySelector("#popupError");
        const messageError = popupError.querySelector("#message");
        const buttonClose = popupError.querySelector("#buttonClose");

        messageError.innerText = message;

        buttonClose.addEventListener("click", () => {
            Popup.close(popupError);
            window.location.href = "../administrative_home.html";
        });

        Popup.open(popupError);
    }

    /**
     * Descarga automáticamente un archivo CSV generado por la API.
     */
    static downloadCSV() {
        const url = "../../../api/get/admission/generateCSV";

        fetch(url)
            .then((response) => {
                if (!response.ok) throw new Error("No se pudo generar el CSV");
                return response.blob();
            })
            .then((blob) => {
                const blobUrl = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.href = blobUrl;
                link.download = "estudiantes_admitidos.csv";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(blobUrl);
            })
            .catch((error) => console.error("Error al descargar el archivo CSV:", error));
    }

    static openUploadModal() {
        const uploadCSVModal = document.querySelector("div#uploadCSVModal");
        Modal.openModal(uploadCSVModal);
    }

    /**
     * Crea una tabla con los datos especificados.
     * @param {string} title - Título de la tabla.
     * @param {Array} headers - Encabezados de la tabla.
     * @param {Array} rows - Filas de datos.
     * @param {HTMLElement} container - Contenedor de la tabla.
     * @param {string} tableId - ID único para la tabla.
     */
    static createTableWithData(title, headers, rows, container, tableId) {
        const section = createTable(title, headers, rows, tableId);
        container.appendChild(section);
    }
}

export { Action };
