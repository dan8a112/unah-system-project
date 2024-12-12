import {Modal} from "../../../js/modules/Modal.js" 
import {HttpRequest} from "../../../js/modules/HttpRequest.js" 
import {createTable} from "../../../js/modules/table.js" 

/**
 * Clase principal para gestionar acciones relacionadas con el portal CRI
 * @author: dochoa@unah.hn
 * @version: 0.1.0
 * date: 7/12/24
 */
class Action {

    //Estado de los id de inscripciones sin revisar. Necesario para hacer revision secuencial
    static unreviewedInscriptionsId = [];

    //Estado que determina la inscripcion en revision actual
    static currentReviewInscription = null;

    //Estado que determina si se han revisado inscripciones
    static hasReviewedInscription = false;

    /**
     * ID del revisor que tiene una sesion iniciada.
     */
    static userId = new URLSearchParams(window.location.search).get("id");

    /**
     * Renderiza toda la pagina a partir de la data retornada de una peticion con la informacion
     * de las inscripciones pendientes a revisar. 
     * @param {int} first 1 si es la primera carga de la pagina 0 si no es la primera vez.
     * Este parametro nos ayuda a ejecutar acciones solo la primera vez que se renderiza la pagina
     */
    static renderAllPage = async(first)=>{

        //Se obtiene el id del usuario en los parametros de la url

        //Se hace la peticion al backend
        const response = await HttpRequest.get(`../../../../api/get/criUser/home/?id=${this.userId}`);
        
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

        //Guardamos los ids de las inscripciones revisadas
        this.unreviewedInscriptionsId = unreviewedList.map(inscription=>inscription.id);

        document.querySelector("#amountUnreviewed").innerText = amountUnreviewed;

        const dataFormated = this.formatUnreviewedRows(unreviewedList);

        const headers = ['#', 'Nombre', 'Carrera Principal', 'Fecha de inscripcion', 'Acciones']

        const tableSection = document.querySelector("#unreviewedTbl");

        const table = createTable(
            "", 
            headers, 
            dataFormated,
            "unreviewed-table-body",
            false,
            11,
            amountUnreviewed,
            null,
            false,
            true,
            this.formatUnreviewedRows
        );

        tableSection.appendChild(table)

        //Se agrega acción a los botones de la tabla de revisar
        const unreviewedBody = document.querySelector("#unreviewed-table-body");
        unreviewedBody.addEventListener("click", (e)=>{Action.openReviewModal(null,e)})
    }

    /**
     * Función que recarga la pagina si la modal se ha cerrado por el usuario
     * Para saber si se cerró por el usuario basta con verificar si el valor revisando actualmente 
     * está en la lista de no revisados, lo que indica que la modal no se cerró porque se revisó una inscripción.
     */
    static reloadAfterDismiss(){
        if (this.unreviewedInscriptionsId.includes(this.currentReviewInscription) && this.hasReviewedInscription) {
            window.location.reload();
        }
    }

    /**
    * Funcion que se encarga de formatear cada fila de la tabla, este retorna un arreglo con los resultados.
    * @param {Array<Object>} unreviewedList 
    * @returns {Array<Array<any>>} retorna un array con los elementos de la fila formateados
    */
    static formatUnreviewedRows(unreviewedList){

        const formatedTable = []

        unreviewedList.forEach(inscription=>{
            //Se obtienen todos los valores del objeto como array
            const formatedRow = Object.values(inscription);

            //Se crea el elemento button con el dataset del id de la seccion
            const button = `<button data-inscription-id=${inscription.id} class="btn btn-outline-primary btn-sm actionsBtn">Revisar</button>`

            //Se agrega el boton al array (fila de la tabla)
            formatedRow.push(button);

            formatedTable.push(formatedRow)
        })
        
        return formatedTable;
    }


    /**
     * Renderiza la tabla de inscripciones revisadas
     * @param {*} data 
     */
    static renderReviewedData(data){
        
        const {amountReviewed, reviewedList} = data; 

        document.querySelector("#amountReviewed").innerText = amountReviewed;

        const dataFormated = this.formatReviewedRows(reviewedList);

        const headers = ['#', 'Nombre', 'Carrera Principal', 'Fecha de inscripcion', 'Dictamen']

        const tableSection = document.querySelector("#reviewedTbl");

        const urlPagination = `/api/get/pagination/reviewedInscriptions/?idReviewer=${this.userId}&`

        const table = createTable(
            "", 
            headers, 
            dataFormated,
            "reviewed-table-body",
            false,
            10,
            amountReviewed,
            urlPagination,
            false,
            true,
            this.formatReviewedRows
        );

        tableSection.appendChild(table)
    }
    
    /**
    * Funcion que se encarga de formatear cada fila de la tabla, este retorna un arreglo con los resultados.
    * @param {Array<Object>} reviewedList 
    * @returns {Array<Array<any>>} retorna un array con los elementos de la fila formateados
    */
    static formatReviewedRows(reviewedList){

        const formatedTable = []

        reviewedList.forEach(inscription=>{

            //Se crea el elemento dictamen con el color dependiendo si es aprobado o no
            const dictum = inscription.dictum == true ? `<span style="color: #00C500; font-weight: 500;">Aprobada</span>`: `<span style="color: #C51A00; font-weight: 500;">Rechazada</span>`;
            
            //Eliminamos el atributo dictum
            delete inscription.dictum;

            //Se obtienen todos los valores del objeto como array, excepto dictum
            const formatedRow = Object.values(inscription);
            
            //Se agrega el dictamen formateado al array (fila de la tabla)
            formatedRow.push(dictum);

            formatedTable.push(formatedRow)
        })

        return formatedTable;
    }

    /**
     * Abre la modal de revision de una inscripcion
     * @param {int} inscriptionId valor opcional, en caso que se llame la funcion desde otra funcion
     * @param {Event} event evento click sobre el boton de una inscripcion
     */
    static openReviewModal = async (inscriptionId = null, event = null) => {

        // Inicializa el id a buscar con el inscriptionId proporcionado
        let idToFetch = inscriptionId;

        // Si se proporciona un evento, se obtiene el target y el dataset
        if (event) {
            const button = event.target;
        
            // Comprueba si el evento proviene de un boton con la clase esperada
            if (button.matches('.actionsBtn')) {
                // Se cambia el id con el dataset del boton
                idToFetch = button.dataset.inscriptionId; 
            }
        }

        // Si tenemos un id para buscar, continuamos
        if (idToFetch) {
            try {
                const response = await HttpRequest.get(`/api/get/admission/inscription/?id=${idToFetch}&idAdmissionProcess=0`);

                if (response.status) {
                    // Se establecen los datos de la inscripcion
                    this.setInscriptionData(response.data, idToFetch);

                    // Se abre la modal con los datos de revision
                    const reviewModal = document.querySelector("div#reviewModal");
                    Modal.openModal(reviewModal);
                    
                    //Se establece el id de la inscripcion en revision actual
                    setTimeout(() => {
                        this.currentReviewInscription = parseInt(idToFetch); 
                    }, 200);
                } else {
                    console.error(response.message);
                }
            } catch (error) {
                console.error("Error al realizar la peticion:", error);
            }
        }
    };

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

        // Clonamos los elementos para limpiar eventos
        const newDenyButton = denyInscriptionButton.cloneNode(true);
        const newApproveButton = approveInscriptionButton.cloneNode(true);

        // Reemplazamos los botones por los elementos clonados(sin eventos)
        denyInscriptionButton.parentNode.replaceChild(newDenyButton, denyInscriptionButton);
        approveInscriptionButton.parentNode.replaceChild(newApproveButton, approveInscriptionButton);

        // Agregar eventos nuevamente
        newDenyButton.addEventListener("click", () => {
            this.finishReviewInscription(0, inscriptionId, applicant.name, applicant.email, newDenyButton, newApproveButton);
        });

        newApproveButton.addEventListener("click", () => {
            this.finishReviewInscription(1, inscriptionId, applicant.name, applicant.email, newDenyButton, newApproveButton);
        });
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

        const body = {
            idApplication: inscriptionId,
            idReviewer: this.userId,
            approved: dictum,
            name: name,
            mail: email
        }
        
        const response = await HttpRequest.post("../../../api/update/verifyApplication/", body);
        
        if (response.status === true) {

            //se elimina la inscripcion revisada de la lista
            this.unreviewedInscriptionsId.shift();
            this.hasReviewedInscription = true;

            Modal.closeModal();

            if (this.unreviewedInscriptionsId.length > 0) {
                this.openReviewModal(this.unreviewedInscriptionsId[0])
            }else{
                window.location.reload();
            }

            //Se reactivan ambos botones (Rechazar y Aprobar)
            DenyBtn.removeAttribute("disabled");
            approveBtn.removeAttribute("disabled");
        }

    }
}

export {Action}