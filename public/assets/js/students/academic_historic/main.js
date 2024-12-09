import { Action } from "./Action.js";
import { HttpRequest } from "../../modules/HttpRequest.js"


const studentName = document.getElementById("studentName");
const studentCareer = document.getElementById("studentCareer");
const studentAcount = document.getElementById("studentAcount");
const studentDescription = document.getElementById("studentDescription");
const studentGlobalIndex = document.getElementById("studentGlobalIndex");
const studentPeriodIndex = document.getElementById("studentPeriodIndex");
const studentCenter = document.getElementById("studentCenter");

const userId = new URLSearchParams(window.location.search).get("id");
const url = `../../../../api/get/departmentBoss/ratingsInfo/?id=${userId}`;
const container = document.querySelector("#section-table");


const data = {
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

async function loadData() {
    // Realizar la solicitud GET usando HttpRequest
    //const respose = await HttpRequest.get(url);
    //const data = respose;
    const paginationUrl = `../../../../api/get/pagination/sections/?idProcess=${data}&idBoss=${userId}&`;
    console.log(data)
  
    if (data) {
      Action.renderSections(data.classes.classesList, data.classes.amountClasses, paginationUrl, container);
      studentName.innerText = `${data.studentInfo.name}`;
      studentCareer.innerText = `${data.studentInfo.career}`;
      studentAcount.innerText = `${data.studentInfo.acount}`;
      studentDescription.innerText = `${data.studentInfo.description}`;
      studentGlobalIndex.innerText = `${data.studentInfo.globalIndex}`;
      studentPeriodIndex.innerText = `${data.studentInfo.periodIndex}`;
      studentCenter.innerText = `${data.studentInfo.center}`;
    } else {
      console.error("No se pudo cargar la información desde la API.");
    }
  }
  
  // Llama a la función para cargar los datos al iniciar el módulo
  loadData();

const table = document.getElementById('section-table');

