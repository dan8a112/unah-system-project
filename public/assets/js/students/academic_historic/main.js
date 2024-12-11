import { Action } from "./Action.js";
import { HttpRequest } from "../../modules/HttpRequest.js";
import { Modal } from "../../modules/Modal.js";
import { Popup } from "../../modules/Popup.js";

const studentName = document.getElementById("studentName");
const studentCareer = document.getElementById("studentCareer");
const studentAcount = document.getElementById("studentAcount");
const studentDescription = document.getElementById("studentDescription");
const studentGlobalIndex = document.getElementById("studentGlobalIndex");
const studentPeriodIndex = document.getElementById("studentPeriodIndex");
const studentCenter = document.getElementById("studentCenter");

//popup
const message = document.getElementById('message');
const popupError = document.getElementById('popupError');
const buttonOk2 = document.getElementById('buttonOk2');

//Descripcion de modal
const description = document.getElementById("profileDescription")

const userId = new URLSearchParams(window.location.search).get("id");
const acountStudent = new URLSearchParams(window.location.search).get("student");
const url = `../../../../api/get/pagination/studentHistory/index.php?id=${acountStudent}&offset=0/`;
const container = document.querySelector("#section-table");

const dataa = {
    "studentInfo" : {
        name : "Dorian Samantha Velasquez",
        career: "Ingenieria en sistemas",
        acount: "20191006515",
        description: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.",
        globalIndex: "90%",
        periodIndex: "90%",
        center: "CU",
        imgStudent: "no se como lo mandan xd"
        
    },
    "classes" : { 
        "amountClasses": 25,
        "classesList" : [
            {
                id: 1,
                code: "IS-803",
                class: "Ingenieria de Software",
                uv: 4,
                section: "1100",
                year: 2019,
                period: 3,
                calification: 90,
                obs: "APB"
            },
            {
                id: 1,
                code: "IS-803",
                class: "Ingenieria de Software",
                uv: 4,
                section: "1100",
                year: 2019,
                period: 3,
                calification: 90,
                obs: "APB"
            }
        ]
    }
}

// Función para verificar nulos y devolver un guion
function checkNull(value) {
    return value ?? "-";
}

async function loadData() {
    try {
        // Realizar la solicitud GET usando HttpRequest
        const response = await HttpRequest.get(url);
        const data = response;
        const paginationUrl = `../../../../api/get/pagination/studentHistory/index.php?id=${acountStudent}&`;
        
        if (data) {
            Action.renderSections(data.data, data.amountClasses, paginationUrl, container);

            studentName.innerText = checkNull(data.studentInfo.studentName);
            studentCareer.innerText = checkNull(data.studentInfo.studentCareer);
            studentAcount.innerText = checkNull(data.studentInfo.studentAccount);
            studentDescription.innerText = checkNull(data.studentInfo.studentDescription);
            studentGlobalIndex.innerText = checkNull(data.studentInfo.studentGlobalIndex);
            studentPeriodIndex.innerText = checkNull(data.studentInfo.studentPeriodIndex);
            studentCenter.innerText = checkNull(Action.getInitials(data.studentInfo.studentCenter));
            description.value = data.studentInfo.studentDescription;

        } else {
            console.error("No se pudo cargar la información desde la API.");
        }
    } catch (error) {
        console.error("Error al cargar los datos:", error);
    }
}

// Llama a la función para cargar los datos al iniciar el módulo
loadData();

const edit = document.getElementById("edit");
edit.addEventListener("click", ()=>Action.openUploadEditModal());


   /**
     * Se manda el formulario para actualizar los campos
     * author: afcastillof@unah.hn
     * version: 0.1.0
     * date: 10/12/24
     */
   document.getElementById('editProfileForm').addEventListener('submit', async (event) => {
    event.preventDefault(); 

    try {
        const result = await HttpRequest.submitForm(event, `../../../api/update/studentProfile/index.php?studentId=${acountStudent}&&offset=10/`);
        console.log(result.message); 
        console.log(result); 

        if(result.status == false) {
            Popup.open(popupError);
            message.innerHTML = result.message;
            buttonOk2.style.background = '#EC0000';
            buttonOk2.addEventListener('click', () => Popup.close(popupError));
        }
        Modal.closeModal();
        
    } catch (error) {
        console.error("Error al cargar el CSV:", error);
    }
});

