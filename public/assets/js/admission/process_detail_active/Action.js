class Action{

    /**
     * Este metodo se encarga de renderizar en la pagina, la data recibida del servidor.
     * @param {*} data un objeto que contiene estadisticas sobre el proceso de admision actual
     */
    static renderActiveProcess(data){
        
        //Se destructura la data
        const {dates, processState, amountInscriptions, lastestInscriptions, csvStatus} = data;

        //Se renderizan las fechas
        const startDate = document.querySelector("p#startDate");
        const finishDate = document.querySelector("p#finishDate");
        
        startDate.innerText = dates.start;
        finishDate.innerText = dates.end;

        //Se renderiza estado del proceso de admision

        const admissionState = document.querySelector("h1#admissionState");

        admissionState.innerText = processState.name;

        //Se renderiza cantidad actual de inscripciones
        
        const amountProcessInscription = document.querySelector("h1#amountInscriptions");

        amountProcessInscription.innerText = amountInscriptions;

        //Se renderizan las ultimas cinco inscripciones

        const lastInscriptionsBody = document.querySelector("tbody#lastInscriptionsTbl");
        
        //Se crean las filas y columnas de la tabla
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

        //Si el proceso no es subida de notas
        if (processState.id!==2) {
            //Se oculta la seccion de subir csv
            const uploadCsvSection = document.querySelector("section#upload_csv");
            uploadCsvSection.setAttribute("hidden", "true");
        }else{
            //Se verifica si se subio el csv
            if (csvStatus===true) {
                const uploadCsvBtn = document.querySelector("button#uploadCsvBtn");
                //Se desactiva el boton de subir csv
                uploadCsvBtn.setAttribute("disabled", "true");
            }
        }

    }

    

}

export {Action}