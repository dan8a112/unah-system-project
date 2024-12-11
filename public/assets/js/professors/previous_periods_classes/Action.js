import {createSectionCard} from '../../modules/Cards.js'
import { HttpRequest } from "../../modules/HttpRequest.js";

class Action{

    //Se obtiene el id del docente en los parametros de la url
    static userId = new URLSearchParams(window.location.search).get("id");

    //Se obtiene el id del periodo academico en los parametros de la url
    static periodName = new URLSearchParams(window.location.search).get("periodName");
    
    static loadPage = async()=>{

        const breadCrumb = document.querySelector(".breadcrumb-item.active");
        breadCrumb.innerText = this.periodName;

        const periodNameCard = document.querySelector("#periodName");
        periodNameCard.innerText = this.periodName;

        const professorId = new URLSearchParams(window.location.search).get("id");

        const periodId = new URLSearchParams(window.location.search).get("periodId");

        const urlAPI = `/api/get/professor/assignedSections/?idProfessor=${professorId}&idProcess=${periodId}`;

        const response = await HttpRequest.get(urlAPI);

        this.renderClasses(response.data);
    }

    static renderClasses(classes) {
        //Se crea el HTML de las cards 
        const sectionFormated = classes.map(
            (section, index) => createSectionCard(section, index)
        ).join("");

        const sectionsContainer = document.querySelector("section#sectionsContainer");

        //Se insertan las cards en el contenedor
        sectionsContainer.innerHTML = sectionFormated;
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

export {Action};