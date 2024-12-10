import { Action } from "./Action.js";
import { HttpRequest } from "../../../modules/HttpRequest.js";


const selectPeriod = document.getElementById("period");
const userId = new URLSearchParams(window.location.search).get("id");
const url = `../../../../api/get/searchStudent`;
const container = document.querySelector("#section-table");
const alert = document.getElementById("no-search-message");
const scriptTag = document.querySelector('script[type="module"][src$="main.js"]');

// Asegurarse de que sea un número entero
const user = parseInt(scriptTag?.getAttribute("data-user"), 10);
const searchButton = document.getElementById("searchButton");
console.log(user)


const dataa = {
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
container.innerHTML = "";

    HttpRequest.submitForm(event, url)
    .then(result => {
        if (result.status) {
            alert.hidden = true;
            Action.renderSections(result.data, result.data.lenght, container);
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
    user === 1? 
    window.location.href = `/assets/views/administration/bosses/academic_history.php?id=${userId}&student=${event.target.id}`:
    window.location.href = `/assets/views/administration/coordinators/academic_historic.php?id=${userId}&student=${event.target.id}`;
    const buttonId = parseInt(event.target.dataset.professorId, 10);
    Action.openEditiForm(buttonId);
}
});