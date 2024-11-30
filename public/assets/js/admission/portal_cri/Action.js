import {Modal} from "../../../js/modules/Modal.js" 
import {HttpRequest} from "../../../js/modules/HttpRequest.js" 
import {createPagination} from "../../../js/modules/table.js" 

class Action {

    /**
     * Estado de los id de inscripciones sin revisar. Necesario para hacer revision secuencial
     */
    static unreviewedInscriptionsId = [];

    /**
     * Renderiza toda la pagina a partir de la data retornada de una peticion con la informacion
     * de las inscripciones pendientes a revisar. 
     * @param {int} first 1 si es la primera carga de la pagina 0 si no es la primera vez.
     * Este parametro nos ayuda a ejecutar acciones solo la primera vez que se renderiza la pagina
     */
    static renderAllPage = async(first)=>{

        //Se obtiene el id del usuario en los parametros de la url
        const userId = new URLSearchParams(window.location.search).get("id");

        //Se hace la peticion al backend
        const response = await HttpRequest.get(`../../../../api/get/criUser/home/?id=${userId}`);
        
        if(response.status==true){

            const data = response.data;

            //Se muestra la fecha del proceso de admisiones
            document.querySelector("div#periodName").innerText = data.period;

            //Renderiza la data
            this.renderStats(data.stats);
            this.renderReviewedData(data.reviewedInscriptions)
            this.renderUnreviewed(data.unreviewedInscriptions,first)

        }else{
            console.error(response.message);
        }
    }

    /**
     * Renderiza las estadisticas de la pagina: Meta del dia y Total revisadas
     * @param {Object} stats 
     */
    static renderStats(stats){

        const {dailyGoal, amountReviewed} =  stats;

        const dailyGoalText = document.querySelector("h1#dailyGoal");
        const totalReviewedText = document.querySelector("h1#totalReviewed");

        dailyGoalText.innerText = dailyGoal;
        totalReviewedText.innerText = amountReviewed;
    }

    
    /**
     * Renderiza la tabla de inscripciones sin revisar
     * @param {Object} data 
     * @param {int} first 1 si es la primera carga de la pagina 0 si no es la primera vez 
     */
    static renderUnreviewed(data, first){
        
        const {amountUnreviewed, unreviewedList} = data; 

        document.querySelector("#amountUnreviewed").innerText = amountUnreviewed;

        const tableBody = document.querySelector("tbody#unreviewedTbl");
        tableBody.innerHTML = "";

        unreviewedList.forEach(inscription => {

            const row = document.createElement("tr");

            //Se recorre el objeto y se crea una columna por cada valor
            Object.keys(inscription).forEach(key => {
                const td = document.createElement("td");
                td.innerText = inscription[key];
                row.appendChild(td);
            });

            //Almacenamos la data de inscripciones sin revisar en el estado, 
            //solo si es la primera carga para mantener estado inicial
            if (first===1) {
                this.unreviewedInscriptionsId.push(inscription.id);                
            }

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

    /**
     * Renderiza la tabla de inscripciones revisadas
     * @param {*} data 
     */
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

        const reviewedSection = document.querySelector("div#reviewedSection");

        //Se obtiene el id del usuario en los parametros de la url
        const userId = new URLSearchParams(window.location.search).get("id");
        const urlPagination = `../../../../api/get/pagination/reviewedInscriptions/?idReviewer=${userId}`

        createPagination(reviewedSection,tableBody,2 ,amountReviewed,urlPagination,false);

    }

    /**
     * Abre la modal de revision de inscripciones
     * @param {*} inscriptionId id de la inscripcion a revisar
     */
    static openReviewModal = async (inscriptionId)=>{

        const response = await HttpRequest.get(`../../../../api/get/admission/inscription/?id=${inscriptionId}&idAdmissionProcess=0`)

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

    /**
     * Establece los datos de la inscripcion en la ventana modal
     * @param {*} data datos de la inscripcion
     * @param {*} inscriptionId id de la inscripcion
     */
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

        //Se muestra certificado de admisión
        this.openCertificateFile(certificate)
        
        //Botones de aprobar o rechazar inscripcion
        const denyInscriptionButton = document.querySelector("#denyInscriptionBtn");
        const approveInscriptionButton = document.querySelector("#approveInscriptionBtn");

        denyInscriptionButton.addEventListener("click", 
            ()=>{
                this.finishReviewInscription(0, inscriptionId, applicant.name, applicant.email, denyInscriptionButton, approveInscriptionButton)
            });

        approveInscriptionButton.addEventListener("click", 
            ()=>{
                this.finishReviewInscription(1, inscriptionId, applicant.name, applicant.email, denyInscriptionButton, approveInscriptionButton)
            })
    }

    /**
     * Crea un nuevo elemento embed que deserializa el archivo y lo muestra en seccion de la modal
     * @param {*} certificate objeto con tipo de archivo y contenido
     */
    static openCertificateFile(certificate){

        // Obtener contenedor donde mostrar el archivo
        const fileSection = document.querySelector("section#fileSection");

        fileSection.innerHTML = "";

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
            fileSection.appendChild(embed);
        } else {
            fileSection.textContent = "No hay archivo disponible.";
        }
    }

    /**
     * Accion al finalizar una inscripcion puede ser aprobar o desaprobar
     * @param {int} dictum valor 1 para aprobada y 0 desaprobada
     * @param {int} inscriptionId id de la inscripcion
     * @param {String} name nombre del aplicante que hizo la inscripcion
     * @param {String} email correo del aplicante que hizo la inscripcion
     * @param {Element} DenyBtn Boton de rechazar solicitud
     * @param {Element} approveBtn Boton de aprobar solicitud
     */
    static finishReviewInscription = async (dictum, inscriptionId, name, email, DenyBtn, approveBtn) =>{

        //Se desactivan ambos botones (Rechazar y Aprobar)
        DenyBtn.setAttribute("disabled","true");
        approveBtn.setAttribute("disabled","true");

        //Se obtiene el id del usuario revisor en los parametros de la url
        const userId = new URLSearchParams(window.location.search).get("id");

        const body = {
            idApplication: inscriptionId,
            idReviewer: userId,
            approved: dictum,
            name: name,
            mail: email
        }
        
        const response = await HttpRequest.post("../../../api/update/verifyApplication/", body);
        
        if(response.status===true){

           Modal.closeModal();

           console.log("antes de eliminar:",this.unreviewedInscriptionsId)
           this.unreviewedInscriptionsId.shift();
           console.log("despues de eliminar:",this.unreviewedInscriptionsId)

           if (this.unreviewedInscriptionsId.length>0) {
            this.openReviewModal(this.unreviewedInscriptionsId[0])
           }

           this.renderAllPage(0);

           //Se reactivan ambos botones (Rechazar y Aprobar)
           DenyBtn.removeAttribute("disabled");
           approveBtn.removeAttribute("disabled");
        }

    }
}

export {Action}