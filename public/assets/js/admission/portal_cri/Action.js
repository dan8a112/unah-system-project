import {Modal} from "../../../js/modules/Modal.js" 
import {HttpRequest} from "../../../js/modules/HttpRequest.js" 

class Action {

    static renderAllPage = async()=>{

        //Se obtiene el id del usuario en los parametros de la url
        const userId = new URLSearchParams(window.location.search).get("id");

        //Se hace la peticion al backend
        const response = await HttpRequest.get(`../../../../api/get/criUser/home/?id=${userId}`);
        console.log(response)
        
        if(response.status==true){

            const data = response.data;

            //Se muestra la fecha del proceso de admisiones
            document.querySelector("div#periodName").innerText = data.period;

            this.renderStats(data.stats);
            this.renderReviewedData(data.reviewedInscriptions)
            this.renderUnreviewed(data.unreviewedInscriptions)

        }else{
            console.error(response.message);
        }
    }

    static renderStats(stats){

        const {dailyGoal, amountReviewed} =  stats;

        const dailyGoalText = document.querySelector("h1#dailyGoal");
        const totalReviewedText = document.querySelector("h1#totalReviewed");

        dailyGoalText.innerText = dailyGoal;
        totalReviewedText.innerText = amountReviewed;
    }

    static renderUnreviewed(data){
        
        const {amountUnreviewed, unreviewedList} = data; 

        document.querySelector("#amountUnreviewed").innerText = amountUnreviewed;

        const tableBody = document.querySelector("tbody#unreviewedTbl");
        tableBody.innerHTML = "";

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
            reviewButton.addEventListener("click", ()=>{this.openReviewModal(inscription.id)});

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
        tableBody.innerHTML = ""; 

        reviewedList.forEach(inscription => {

            const row = document.createElement("tr");

            //Se recorre el objeto y se crea una columna por cada valor
            Object.keys(inscription).forEach(key => {
                const td = document.createElement("td");

                if(key=="dictum"){
                    //Si esta aprobada se pinta en verde sino en rojo
                    td.style.color = inscription[key] == 1 ? "#00C500" : "#C51A00";
                    td.innerText = inscription[key] == 1 ? "Aprobada" : "Rechazada";
                }else{
                    td.innerText = inscription[key];
                }
                
                row.appendChild(td);

            });

            //Se agrega la fila al cuerpo de la tabla
            tableBody.appendChild(row)
        })

    }

    static openReviewModal = async (inscriptionId)=>{

        const response = await HttpRequest.get(`../../../../api/get/criUser/inscription/?id=${inscriptionId}`)

        if (response.status) {
            //Se establecen los datos de la inscripcion
            this.setInscriptionData(response.data, inscriptionId);

            //Se abre la modal con los datos de revision
            const reviewModal = document.querySelector("div#reviewModal")
            Modal.openModal(reviewModal)
        }else{
            console.error(response.message);
        }
    }

    static setInscriptionData(data, inscriptionId){
        const {applicant, inscription, certificate} = data;

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

        //Boton de mostrar certificado
        const showCertificateButton = document.querySelector("#showCertificateBtn");
        //Se agrega funcion de abrir modal con certificado
        showCertificateButton.addEventListener("click", ()=>{this.openCertificateFile(certificate)});
        
        //Botones de aprobar o rechazar inscripcion
        const denyInscriptionButton = document.querySelector("#denyInscriptionBtn");
        const approveInscriptionButton = document.querySelector("#approveInscriptionBtn");

        denyInscriptionButton.addEventListener("click", 
            ()=>{this.finishReviewInscription(0, inscriptionId, applicant.name, applicant.email)});

        approveInscriptionButton.addEventListener("click", 
            ()=>{this.finishReviewInscription(1, inscriptionId, applicant.name, applicant.email)})
    }

    static openCertificateFile(certificate){

        // Obtener contenedor donde mostrar el archivo
        const modal = document.querySelector("div#fileModal");

        //Obtener cuerpo de modal
        const modalBody = modal.querySelector("div.modal-body");
        modalBody.innerHTML = "";

        // Extraer datos del archivo
        const { type, content } = certificate;

        if (type && content) {
            // Crear URL en Base64 compatible con <embed>
            const fileURL = `data:${type};base64,${content}`;

            // Crear la etiqueta <embed>
            const embed = document.createElement("embed");
            embed.src = fileURL;
            embed.type = type;
            embed.style.width = "100%";
            embed.style.height = "500px";

            // Insertar el <embed> en el contenedor
            modalBody.appendChild(embed);

            //Abrimos la modal
            Modal.openModal(modal);
        } else {
            modalBody.textContent = "No hay archivo disponible.";
        }
    }

    static finishReviewInscription = async (dictum, inscriptionId, name, email) =>{

        //Se obtiene el id del usuario revisor en los parametros de la url
        const userId = new URLSearchParams(window.location.search).get("id");

        const body = {
            idApplication: inscriptionId,
            idReviewer: userId,
            approved: dictum,
            name: name,
            mail: email
        }
        
        const response = await HttpRequest.post("../../../api/update/verifyApplication", body);
        
        if(response.status===true){
           this.renderAllPage();
           Modal.closeModal();
        }

    }
}

export {Action}