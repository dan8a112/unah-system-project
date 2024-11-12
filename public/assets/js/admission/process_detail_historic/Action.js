class Action{

    /**
     * Este metodo se encarga de renderizar en la pagina, la data recibida del servidor.
     * @param {*} data un objeto que contiene estadisticas sobre el proceso de admision actual
     */
    static renderActiveProcess(data){
        
        //Se destructura la data
        const {dates, amountApproved, amountInscriptions, higherScore, amountCentersInscriptions} = data;

        //Se renderizan las fechas
        const startDate = document.querySelector("p#startDate");
        const finishDate = document.querySelector("p#finishDate");
        
        startDate.innerText = dates.start;
        finishDate.innerText = dates.end;

        //Se renderiza cantidad de aprobados

        const approbed = document.querySelector("h1#amountApprobed");
        approbed.innerText = amountApproved;

        //Se renderiza cantidad actual de inscripciones
        
        const amountProcessInscription = document.querySelector("span#amountInscriptions");

        amountProcessInscription.innerText = amountInscriptions;

        //Se renderizan las cinco notas mas altas del proceso de admision

        const higherScoreBody = document.querySelector("tbody#higherScoreTbl");
        
        //Se crean las filas y columnas de la tabla
        higherScore.forEach(inscription=>{
            
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
            const centerItem = document.createElement("div")
            .classList.add("regional-center-item");

            //Se crea texto de nombre de centro
            const centerName = document.createElement("span").classList.add("font-medium");
            centerName.innerText = center.name;

            //Se crea texto de cantidad de inscripciones
            const amountInscripted = document.createElement("span");
            amountInscripted.innerText = center.amount;

            centerItem.appendChild(centerName);
            centerItem.appendChild(amountInscripted);

            amountCentersContainer.appendChild(centerItem);
        })
    }


    
}

export {Action}