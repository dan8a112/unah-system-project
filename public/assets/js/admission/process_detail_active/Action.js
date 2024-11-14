import { HttpRequest } from "../../modules/HttpRequest.js";
import { Modal } from "../../modules/Modal.js"
import {Popup} from "../../modules/Popup.js"

class Action{

    /**
     * Este metodo se encarga de renderizar en la pagina, la data recibida del servidor.
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 11/11/24
     * @param {*} data un objeto que contiene estadisticas sobre el proceso de admision actual
     */
    static renderActiveProcess(data){
        
        //Se destructura la data
        const {infoProcess, amountInscription, lastestInscriptions, csvStatus} = data;

        //Se renderiza el nombre del proceso de admision
        const processName = document.querySelector("h1#processName");
        processName.innerText = infoProcess.name;

        //Se renderizan las fechas
        const startDate = document.querySelector("p#startDate");
        const finishDate = document.querySelector("p#finishDate");
        
        startDate.innerText = infoProcess.start;
        finishDate.innerText = infoProcess.end;

        //Se renderiza estado del proceso de admision

        const admissionState = document.querySelector("h1#admissionState");

        admissionState.innerText = infoProcess.processState;

        //Se renderiza cantidad actual de inscripciones
        
        const amountProcessInscription = document.querySelector("h1#amountInscriptions");

        amountProcessInscription.innerText = amountInscription;

        //Se renderizan las ultimas cinco inscripciones

        const lastInscriptionsBody = document.querySelector("tbody#lastInscriptionsTbl");
        
        //Se crean las filas y columnas de la tabla
        if (lastestInscriptions!==null) {
            lastestInscriptions.forEach(inscription=>{
            
                const row = document.createElement("tr");
                
                //Se crea la columna de id
                const idCol = document.createElement("th");
                idCol.setAttribute("scope","row");
                idCol.innerText = inscription.id;
    
                row.appendChild(idCol);
    
                //Se crean las columnas
                const colName = document.createElement("td");
                const colCareer = document.createElement("td");
                const colDate = document.createElement("td");
                
                //Se agrega columna de nombre del aplicante
                colName.innerText = inscription.name;
                row.appendChild(colName);
    
                //Se agrega la columna de la carrera 
                colCareer.innerText = inscription.career;
                row.appendChild(colCareer);
    
                //Se agrega la columna de la fecha de inscripcion
                colDate.innerText = inscription.inscriptionDate;
                row.appendChild(colDate);
    
                //Se agrega la fila al cuerpo de la tabla
                lastInscriptionsBody.appendChild(row)
            })
        }

        //Si el proceso no es subida de notas
        if (infoProcess.idProcessState===3) {
            //Se renderiza la seccion de subida de csv
            this.renderUploadCSVSection();
        }

    }

    /**
     * Renderiza la tarjeta que permite subir el csv de calificaciones al portal
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 11/11/24
     * @param {*} id el id del proceso de admision solicitado
     */
    static renderUploadCSVSection(){

        //Se selecciona la sección de subida del CSV
        const uploadCsvSection = document.querySelector("section#upload_csv");

        //Se crea card contenedora
        const card = document.createElement("div");
        card.classList.add("card-container", "d-flex", "justify-content-between");

        //Se agrega texto informativo a card
        card.innerHTML = `
            <div>
                <p class="font-medium">Subida de calificaciones</p>
                <p>El proceso de admisión está en publicacion de resultados puedes subir el archivo de calificaciones aqui.</p>
            </div>`;

        //Se crea el boton de subida de csv
        const button = document.createElement("button");
        button.setAttribute("id", "uploadCSVBtn")
        button.classList.add("button-upload", "btn");

        //Se agrega accion de abrir modal de subir archivo
        button.addEventListener("click", ()=>{
            const uploadCSVModal = document.querySelector("div#uploadCSVModal");
            Modal.openModal(uploadCSVModal);
        })

        //Se agrega imagen y texto dentro del boton
        button.innerHTML = `
                <img src="../../img/icons/upload.svg" alt="" class="me-2">
                <span>Subir CSV</span>`;

        //Se agrega el boton a la card
        card.appendChild(button);

        //Se agrega la card la seccion
        uploadCsvSection.appendChild(card);
    }

    /**
     * Este metodo manda a llamar a la api para obtener la informacion de un proceso de admision activo
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 11/11/24
     * @param {*} id el id del proceso de admision solicitado
     */
    static fetchActiveData = async ()=>{
        const response = await HttpRequest.get(`../../../api/get/infoCurrentAdmission`);
        if (response.status) {
            this.renderActiveProcess(response.data)
        }else{

            const popupError = document.querySelector("#popupError");
            const messageError = popupError.querySelector("#message");
            const buttonClose = popupError.querySelector("#buttonClose");

            messageError.innerText = response.message;

            buttonClose.addEventListener('click',()=>{
                Popup.close(popupError);
                window.location.href = "../administrative_home.html"
            })

            Popup.open(popupError);

        }
    }

    
    /**
     * Accion para el boton de descargar CSV que obteniene un archivo y lo descarga automaticamente.
     * @author afcastillof@unah.hn
     * @version 0.1.0
     * @date 12/11/24
     */
    static downloadCSV(){
        const url = '../../../api/get/generateCSV';
    
        // Hacer la solicitud para obtener el CSV
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('No se pudo generar el CSV');
                }
                return response.blob();
            })
            .then(blob => {
                const blobUrl = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = blobUrl;
                link.download = 'estudiantes_admitidos.csv';
                document.body.appendChild(link);
                link.click();
    
                document.body.removeChild(link);
                window.URL.revokeObjectURL(blobUrl);
            })
            .catch(error => {
                console.error('Error al descargar el archivo CSV:', error);
            });
    }

}

export {Action}