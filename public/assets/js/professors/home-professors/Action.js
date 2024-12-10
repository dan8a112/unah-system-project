import {createSectionCard} from '../../modules/Cards.js'
import {HttpRequest} from "../../../js/modules/HttpRequest.js" 

class Action {

    //Se obtiene el id del docente en los parametros de la url
    static userId = new URLSearchParams(window.location.search).get("id");

    static renderPage = async () => {

        //Petición asíncrona que obtiene la información del home
        const response = await HttpRequest.get(`/api/get/professor/homeProfessor/?id=${this.userId}`);

        //Response temporal
        const response1 = {
            "status": true,
            "message": "Petición realizada con éxito.",
            "data": {
              "processInfo": {
                "processId": 13,
                "period": "III PAC 2024",
                "subprocessId": 12,
                "description": "Prematrícula",
                "startDate": "2024-10-10",
                "finalDate": "2024-10-20"
              },
              "classes": [
                {
                  "idSection": 2,
                  "section": 1600,
                  "description": "ALGORITMOS Y ESTRUCTURA DE DATOS",
                  "idSubject": "IS310"
                },
                {
                  "idSection": 5,
                  "section": 700,
                  "description": "BASE DE DATOS I",
                  "idSubject": "IS501"
                }
              ]
            }
          }

        //destructuración de la respuesta
        const {status, message, data} = response1;

        //Si la respuesta fue exitosa
        if (status===true) {
            //Si data existe => existe un periodo academico activo
            if (data) {

                //destructuración de la información del periodo y proceso académico
                const {period, description, startDate, finalDate} = data.processInfo;

                const periodName = document.querySelector("#periodName");
                periodName.innerText = period;

                const processSection = document.querySelector("#processSection");

                processSection.innerHTML = `<div class="card-container col-5">
                <div class="d-flex align-items-center mb-2">
                    <img src="../../img/icons/calendar-clock.svg" alt="" class="me-2">
                    <span class="fs-5" style="font-weight: 600;" id="processName">Proceso: ${description}</span>
                </div>
                <div>
                    <div class="mb-2">
                        <span>Inicio</span>
                        <p class="fs-5" id="startDate">${startDate}</p>
                    </div>
                    <div >
                        <span>Fin</span>
                        <p class="fs-5" id="finishDate">${finalDate}</p>
                    </div>
                </div>
                </div>`
    
                //Si classes existe significa que se le han asignado clases al maestro
                if (data.classes) {
                    
                    //Se crea el HTML de las cards 
                    const sectionFormated = data.classes.map(
                        (section,index) => createSectionCard(section,index)
                    ).join("");
    
                    const sectionsContainer = document.querySelector("section#sectionsContainer");
    
                    //Se insertan las cards en el contenedor
                    sectionsContainer.innerHTML = sectionFormated;
                }
            }else{
                //Se muestra una alerta de la respuesta del servidor
                const alertSection = document.querySelector("#alertSection");
    
                alertSection.innerHTML = `<div class="alert alert-warning" role="alert" >${message}</div>`
            }
        }
        
    }


    static redirectSectionDetail(event){
      try {
        const card = event.target.closest('.class-card');
        if (card) {
          const sectionId = card.dataset.sectionId;
          window.location.href = `/assets/views/professors/class_detail.php?id=${this.userId}&sectionId=${sectionId}`
        }
      } catch (error) {
        console.error(error);
      }
    }
}

export {Action}