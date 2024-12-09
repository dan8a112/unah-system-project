import { Action } from "./Action.js";
import { HttpRequest } from "../../../modules/HttpRequest.js";


const selectPeriod = document.getElementById("period");
const userId = new URLSearchParams(window.location.search).get("id");
const url = `../../../../api/get/departmentBoss/ratingsInfo/?id=${userId}`;
const container = document.querySelector("#section-table");
const alert = document.getElementById("no-search-message");


const data = {
    "students" : { 
        "amountResult": 1,
        "studentList" : [
            {
                id: 27,
                account: "20191006515",
                name: "Angel Fernando Castilo Flores",
                career: "Ingenieria de Software",
                center: "CU"
            }
        ]
    }
}


document.getElementById('search-form').addEventListener('submit', async (event) => {
event.preventDefault();

    HttpRequest.submitForm(event, url)
    .then(result => {
        if (result.status) {
            alert.hidden = true;
            Action.renderSections(data.students.studentList, data.students.amountResult, container);
            Action.renderSelects(data.periods, selectPeriod);
        } else {
            alert.innerText = 'No se encontraron resultados.'
        }
    });
});
  

const table = document.getElementById('section-table');

// Agrega un event listener al contenedor
table.addEventListener('click', function(event) {
if (event.target.matches('.btn')) {
    console.log(event.target.id);
    window.location.href = `/assets/views/administration/coordinators/academic_historic.php?id=${userId}&section=${event.target.id}`;
    const buttonId = parseInt(event.target.dataset.professorId, 10);
    Action.openEditiForm(buttonId);
}
});