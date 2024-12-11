import { createTable } from "../../modules/table.js";
import { Modal } from "../../modules/Modal.js";

class Action{

    static renderStudents(data, urlPaginacion){

        const { stateProcess, infoSection } = data;

        const testData = [
            { id: 1, name: "Asistencia", points: 10 },
            { id: 2, name: "Proyecto Final", points: 40 },
            { id: 3, name: "Examen Parcial", points: 25 },
            { id: 4, name: "Tareas", points: 15 },
            { id: 5, name: "Examen Final", points: 30 },
        ];

        switch (true) {
            case stateProcess === 17:
                this.renderUploadCSVSection(stateProcess);
                this.provideUploadInfo(testData);
                break;
            case stateProcess >= 12 && stateProcess <= 16:
                this.renderUploadCSVSection(stateProcess);
                break;
        }
        

        const headers = ["Cuenta", "Nombre del estudiante", "Carrera", "Fecha de matricula"];

        const student = infoSection.students.studentsList;
        const dataFormated = student.map(row=>this.formatRows(row));

        const container = document.querySelector("#section-table");

        const section = createTable(
            "Estudiantes matriculados", 
            headers, 
            dataFormated, 
            "table-body",
            true,
            10, 
            infoSection.students.amountStudents,
            urlPaginacion, 
            false, 
            true,
            this.formatRows
        );

        section.style.marginTop = '0px';
        container.appendChild(section);

    }

    /**
     * Esta funcion se se encarga de abrir una modal para subir un archivo
     */
    static openUploadModal() {
        const uploadCSVModal = document.querySelector("div#uploadModal");
        Modal.openModal(uploadCSVModal);
    }

    /**
     * Esta funcion se se encarga de abrir una modal para subir un archivo
     */
    static openUploadVideoModal() {
        const uploadCSVModal = document.querySelector("div#uploadVideoModal");
        Modal.openModal(uploadCSVModal);
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
    static renderUploadCSVSection(processState) {
        const uploadCsvSection = document.querySelector("section#upload_csv");
        const cardContent = this.getCardContent(processState);
        const card = this.createCard(cardContent);

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

    static createCard(content) {
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
        card.appendChild(button);
        return card;
    }


    /**
     * Genera el contenido dinámico para la tarjeta según el estado del proceso.
     * @param {number} processState - Estado actual del proceso.
     * @returns {Object} Contenido dinámico de la tarjeta.
     */
    static getCardContent(processState) {
        const contentMap = {
            17: {
                title: "Subir calificaciones de la clase",
                description:
                    "Llegó el momento de subir las calificaciones de los alumnos, puedes hacerlo desde este espacio.",
                button: { id: "uploadRatingsBtn", text: "Subir Calificaciones", icon: "upload.svg", action: "openUploadVideoModal" },
            },
        };
    
        // Verifica si está en el rango 12-16
        if (processState >= 12 && processState <= 16) {
            return {
                title: "Subir video de presentación",
                description: "Puedes agregar un video descriptivo para esta clase para mostrarlo a tus alumnos.",
                button: { id: "uploadVideoBtn", text: "Subir Video", icon: "upload.svg", action: "openUploadModal" },
            };
        }
    
        return contentMap[processState] || {};
    }


    /**
     * Metodo que sirve para proveer informacion de subida de notas los docentes
     * @param {Array<String>} tests 
     * @returns Contendio html con informacion para subir video
     */
    static provideUploadInfo(tests) {
        // Obtener el contenedor donde se mostrará la información
        const contentContainer = document.getElementById("contentt");
    
        if (!contentContainer) {
            console.error("El contenedor con id 'contentt' no existe.");
            return;
        }
    
        // Limpiar contenido previo (si es necesario)
        contentContainer.innerHTML = "";
    
        const title = document.createElement("h3");
        title.textContent = "Información sobre el formato del archivo";
        title.classList.add("info-title");
    
        const description = document.createElement("p");
        description.textContent = "En este proceso se subirán las calificaciones obtenidas por los estudiantes en la seccion. Asegúrate de seguir las indicaciones para evitar errores durante la carga.";
    
        // Crear una lista con las instrucciones para el formato del archivo
        const formatInstructions = document.createElement("ul");
        formatInstructions.classList.add("info-list"); 
    
        let testString = ''; 
        tests.forEach((test) => {
            testString += `${test.id} (${test.name} se aprueba con ${test.points} puntos).\n`;
        });

        const instructions = [
            "El archivo debe estar en formato Excel (.xlsx o .xls).",
            "Las columnas obligatorias son: 'Numero de cuenta', 'Calificacion', 'Obsservacion'.",
            "No debe haber filas vacías entre los datos.",
            "La calificación debe ser un número entre 0 y 100.",
            `Toma en cuenta que los idObservacion permitidos son:\n ${testString}`,
        ];
    
        instructions.forEach((instruction) => {
            const listItem = document.createElement("li");
            listItem.textContent = instruction;
            formatInstructions.appendChild(listItem);
        });
    
        // Crear un botón para descargar la plantilla
        const downloadButton = document.createElement("button");
        downloadButton.classList.add("btn", "btn-template-download"); 
        downloadButton.style.backgroundColor = '#FFAA34';
        downloadButton.style.marginBottom = '10px';
        downloadButton.textContent = "Descargar plantilla";
        downloadButton.addEventListener("click", () => {
            // Código para descargar la plantilla
            const link = document.createElement("a");
            link.href = "../../../api/get/professor/templateCalificationsCSV";
            link.download = "Plantilla_Calificaciones.xlsx";
            link.click();
        });
    
        // Insertar los elementos en el contenedor
        contentContainer.appendChild(title);
        contentContainer.appendChild(description);
        contentContainer.appendChild(formatInstructions);
        contentContainer.appendChild(downloadButton);
    }
    

    /**
     * Crea una tabla con los datos especificados.
     * @param {string} title - Título de la tabla.
     * @param {Array} headers - Encabezados de la tabla.
     * @param {Array} rows - Filas de datos.
     * @param {HTMLElement} container - Contenedor de la tabla.
     * @param {string} tableId - ID único para la tabla.
     */
    static createTableWithData(title, headers, rows, container, tableId, limit, totalRecords, apiUrl, isFetchPagination) {
        const section = createTable(title, headers, rows, tableId, true, limit, totalRecords, apiUrl, isFetchPagination);
        section.style.marginTop = '0px'
        container.appendChild(section);
    }

}

export {Action}