import { HttpRequest } from "../../modules/HttpRequest.js";
import {Popup} from "../../modules/Popup.js"

class Action{

    /**
     * Este metodo se encarga de renderizar en la pagina, la data recibida del servidor.
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
        if (infoProcess.idProcessState!==2) {
            //Se oculta la seccion de subir csv
            const uploadCsvSection = document.querySelector("section#upload_csv");
            uploadCsvSection.setAttribute("hidden", "true");
        }else{
            //Se verifica si se subio el csv
            if (csvStatus!=null & csvStatus===true) {
                const uploadCsvBtn = document.querySelector("button#uploadCsvBtn");
                //Se desactiva el boton de subir csv
                uploadCsvBtn.setAttribute("disabled", "true");
            }
        }

    }

        /**
     * Este metodo manda a llamar a la api para obtener la informacion de un proceso de admision activo
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

}

export {Action}