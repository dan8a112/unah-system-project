import {HttpRequest} from '../../modules/HttpRequest.js'
import { createTable } from "../../modules/table.js";

class Action{

    /**
     * Este metodo se encarga de renderizar en la pagina,
     * la data recibida del servidor sobre el proceso historico seleccionado
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 11/11/24
     * @param {*} data un objeto que contiene estadisticas sobre el proceso de admision actual
     */
    static renderHistoricProcess(data){
        
        //Se destructura la data
        const {infoProcess, amountApproved, amountInscriptions, higherScores, inscriptionInfo, regionalCenters, approvedStudents} = data;

        //Se renderiza el nombre del proceso
        const processName = document.querySelector("h1#processName");
        processName.innerText = infoProcess.name;

        //Se renderizan las fechas
        const startDate = document.querySelector("p#startDate");
        const finishDate = document.querySelector("p#finishDate");
        
        startDate.innerText = infoProcess.start;
        finishDate.innerText = infoProcess.end;

        //Se renderiza cantidad de aprobados

        const approbed = document.querySelector("h1#amountApprobed");
        approbed.innerText = approvedStudents;

        //Se renderiza cantidad actual de inscripciones
        
        const amountProcessInscription = document.querySelector("h1#amountInscriptions");
        amountProcessInscription.innerText = inscriptionInfo.approvedInscriptions;

        //Se renderizan las cinco notas mas altas del proceso de admision

        const higherScoreBody = document.querySelector("tbody#higherScoreTbl");

        const container = document.getElementById('container');
        const headers = ["#", "Nombre", "Carrera", "Puntaje en PAA"];
        const limit = 10;
        const apiUrl = `../../../api/get/pagination/allInscriptions/?idProcess=${infoProcess.id}`
        this.createTableWithData("Todos los aplicantes", headers, data.applications, container, "allAprovedInscriptions", limit, inscriptionInfo.approvedInscriptions, apiUrl)
    

        const summaryApplications = document.getElementById("summaryApplicationsTbl")
        
        


        regionalCenters.forEach(center=>{
            
            const row = document.createElement("tr");
            
            //Se crea la columna de id
            const centerCol = document.createElement("th");
            centerCol.setAttribute("scope","row");
            centerCol.innerText = center.acronym;

            row.appendChild(centerCol);

            //Se crea un elemento columna
            const Ins = document.createElement("td");
            const Apvs = document.createElement("td");
            
            //Se agrega columna de nombre del aplicante
            Ins.innerText = center.approvedReview;
            row.appendChild(Ins);

            //Se agrega la columna de la carrera 
            Apvs.innerText = center.approvedApplicants;
            row.appendChild(Apvs);

            //Se agrega la fila al cuerpo de la tabla
            summaryApplications.appendChild(row)
        })

        
    }

    static renderLastesInscriptions(data, limit, totalRecords, apiUrl) {
        const container = document.getElementById('container');
        const headers = ["id", "Nombre", "Carrera", "Fecha de inscripcion"];
        this.createTableWithData("Ultimos aplicantes", headers, data, container, "lastInscriptions", limit, totalRecords, apiUrl)
    }

    /**
     * Este metodo manda a llamar a la api para obtener la informacion de un proceso de admision historico
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 11/11/24
     * @param {*} id el id del proceso de admision solicitado
     */
    static fetchHistoricData = async (id)=>{
        const response = await HttpRequest.get(`../../../api/get/admission/admissionDetail/?id=${id}`);
        if (response.status) {
            console.log(response.data)
            this.renderHistoricProcess(response.data);
        }else{
            console.error(response.message);
        }
    }

    /**
     * Crea una tabla con los datos especificados.
     * @author afcastillof@unah.hn
     * @version 0.1.0
     * @date 30/11/24
     * @param {string} title - Título de la tabla.
     * @param {Array} headers - Encabezados de la tabla.
     * @param {Array} rows - Filas de datos.
     * @param {HTMLElement} container - Contenedor de la tabla.
     * @param {string} tableId - ID único para la tabla.
     */
    static createTableWithData(title, headers, rows, container, tableId, limit, totalRecords, apiUrl) {
        const section = createTable(title, headers, rows, tableId, limit, totalRecords, apiUrl);
        section.style.marginTop = '0px'
        container.appendChild(section);
    }
    
}

export {Action}