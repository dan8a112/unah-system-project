import {HttpRequest} from '../../modules/HttpRequest.js'

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
        const {infoProcess, amountApproved, amountInscriptions, higherScores, amountCentersInscriptions} = data;

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
        approbed.innerText = amountApproved;

        //Se renderiza cantidad actual de inscripciones
        
        const amountProcessInscription = document.querySelector("h1#amountInscriptions");
        amountProcessInscription.innerText = amountInscriptions;

        //Se renderizan las cinco notas mas altas del proceso de admision

        const higherScoreBody = document.querySelector("tbody#higherScoreTbl");
        
        //Se crean las filas y columnas de la tabla
        higherScores.forEach(inscription=>{
            
            const row = document.createElement("tr");
            
            //Se crea la columna de id
            const idCol = document.createElement("th");
            idCol.setAttribute("scope","row");
            idCol.innerText = inscription.id;

            row.appendChild(idCol);

            //Se crea un elemento columna
            const colName = document.createElement("td");
            const colCareer = document.createElement("td");
            const colScore = document.createElement("td");
            
            //Se agrega columna de nombre del aplicante
            colName.innerText = inscription.name;
            row.appendChild(colName);

            //Se agrega la columna de la carrera 
            colCareer.innerText = inscription.career;
            row.appendChild(colCareer);

            //Se agrega la columna del puntaje del aplicante
            colScore.innerText = inscription.score;
            row.appendChild(colScore);

            //Se agrega la fila al cuerpo de la tabla
            higherScoreBody.appendChild(row)
        })

        const amountCentersContainer = document.querySelector("div#amountCentersContainer");

        amountCentersInscriptions.forEach(center=>{

            //Se crea un item de centro regional
            const centerItem = document.createElement("div");
            centerItem.classList.add("regional-center-item");

            //Se crea texto de nombre de centro
            const centerName = document.createElement("span");
            centerName.classList.add("font-medium");
            centerName.innerText = center.name;

            //Se crea texto de cantidad de inscripciones
            const amountInscripted = document.createElement("span");
            amountInscripted.innerText = center.amount;

            centerItem.appendChild(centerName);
            centerItem.appendChild(amountInscripted);

            amountCentersContainer.appendChild(centerItem);
        })
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
    
}

export {Action}