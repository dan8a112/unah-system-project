import {Modal} from "../../../js/modules/Modal.js" 

class Action {

    static renderStats(stats){

        const {dailyGoal, totalReviewed} =  stats;

        const dailyGoalText = document.querySelector("h1#dailyGoal");
        const totalReviewedText = document.querySelector("h1#totalReviewed");

        dailyGoalText.innerText = dailyGoal;
        totalReviewedText.innerText = totalReviewed;
    }

    static renderUnreviewed(data){
        
        const {amountUnreviewed, unreviewedList} = data; 

        document.querySelector("#amountUnreviewed").innerText = amountUnreviewed;

        const tableBody = document.querySelector("tbody#unreviewedTbl");

        unreviewedList.forEach(inscription => {

            const row = document.createElement("tr");

            //Se recorre el objeto y se crea una columna por cada valor
            Object.values(inscription).forEach(cellData => {
                const td = document.createElement("td");
                td.innerText = cellData;
                row.appendChild(td);
            });

            //Se crea columna de botón
            const colButton = document.createElement("td");
            
            //Se crea el boton con la accion de abrir modal
            const reviewButton = document.createElement("button");
            reviewButton.classList.add("btn", "btn-outline-primary", "btn-sm");
            reviewButton.innerText = "Revisar"
            reviewButton.addEventListener("click", this.openReviewModal);

            //Se agrega a la columna
            colButton.appendChild(reviewButton);
            row.appendChild(colButton);

            //Se agrega la fila al cuerpo de la tabla
            tableBody.appendChild(row)
        })

    }

    static renderReviewedData(data){
        
        const {amountReviewed, reviewedList} = data; 

        document.querySelector("#amountReviewed").innerText = amountReviewed;

        const tableBody = document.querySelector("tbody#reviewedTbl");

        reviewedList.forEach(inscription => {

            const row = document.createElement("tr");

            //Se recorre el objeto y se crea una columna por cada valor
            Object.keys(inscription).forEach(key => {
                const td = document.createElement("td");
                td.innerText = inscription[key];

                if(key=="dictum"){
                    //Si esta aprobada se pinta en verde sino en rojo
                    td.style.color = inscription[key] == "Aprobada" ? "#00C500" : "#C51A00";
                }
                
                row.appendChild(td);

            });

            //Se agrega la fila al cuerpo de la tabla
            tableBody.appendChild(row)
        })

    }

    static openReviewModal(){

        const reviewModal = document.querySelector("div#reviewModal")

        Modal.openModal(reviewModal)
    }

    static setInscriptionData(data){
        const {applicant, inscription} = data;

        //Espacios a rellenar, de la seccion de informacion personal.
        const personalFields = document.querySelectorAll("div#personalData span.text-information");

        //Se establecen los valores
        Object.keys(applicant).forEach((key, index)=>{
            personalFields[index].innerText = applicant[key];
        });
        
        //Seccion de informacion de inscripcion
        const inscriptionFields =  document.querySelectorAll("div#inscriptionData span.text-information");

        //Se establecen los valores
        Object.keys(inscription).forEach((key, index)=>{
            inscriptionFields[index].innerText = inscription[key];
        });
        
    }
}

export {Action}