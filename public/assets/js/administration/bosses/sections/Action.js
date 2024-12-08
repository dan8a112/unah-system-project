import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";
import { Selects } from "../../../modules/Selects.js";
import {HttpRequest} from "../../../modules/HttpRequest.js" 

class Action{

    static renderAllPage = async()=>{

        const userId = new URLSearchParams(window.location.search).get("id");

        const response = await HttpRequest.get(`/api/get/departmentBoss/sectionsAdministration/?id=${userId}`);

        const data = response.data;

        const periodSection = document.querySelector("#periodName");
        periodSection.innerText = data.period.description;

        const departmentSection = document.querySelector("#departmentName");
        departmentSection.innerText = data.department;

        this.renderSections(data.sections, data.period.id, userId, data.amountSections);

        //Accion al presionar un boton de la tabla (Acciones)
        const tableBody = document.querySelector("tbody#table-body");
        tableBody.addEventListener("click", (e)=>{this.openSectionActions(e)});
    }

    /**
     * Se encarga de renderizar la tabla con las secciones en la pagina.
     * @param {Array<Object>} rows
     * @param {int} periodId 
     * @param {int} userId 
     * @param {int} amountSections 
     */
    static renderSections(rows, periodId, userId, amountSections){


        const headers = ["#", "Codigo","Clase", "Cupos","Hora", "Acciones"];

        const dataFormated = this.formatRows(rows)

        const container = document.querySelector("#section-table");

        const apiPagination =  `/api/get/pagination/sections/?idProcess=${periodId}&idBoss=${userId}&`

        const section = createTable(
            "", 
            headers, 
            dataFormated,
            "table-body",
            false,
            10,
            amountSections,
            apiPagination,
            false,
            true,
            this.formatRows
        );

        section.style.marginTop = '0px';
        container.appendChild(section);

    }


    /**
     * Funcion que se encarga de formatear cada fila de la tabla, este retorna un arreglo con los resultados.
     * @param {Array<Object>} row 
     * @returns {Array<Array<any>>} retorna un array con los elementos de la fila formateados
     */
    static formatRows(rows){

        const formatedTable = []

        rows.forEach(row=>{
            //Se obtienen todos los valores del objeto como array
            const formatedRow = Object.values(row);

            //Se crea el elemento button con el dataset del id de la seccion
            const button = `<button data-id-section=${row.id} class="btn btn-outline-warning btn-sm actionsBtn">Acciones</button>`

            //Se agrega el boton al array (fila de la tabla)
            formatedRow.push(button);

            formatedTable.push(formatedRow)
        })
        
        return formatedTable;
    }

    /**
     * Abre una modal en donde se pueden realizar acciones sobre cada sección, como editar y eliminar
     * @param {Event} event recibe el evento que fue ejecutado (Click) 
     */
    static openSectionActions(event){

        const data = {
            code: "1500",
            days: "LuMaMiJuVi",
            className: "Intro. a la ingenieria en sistemas",
            uv: 3,
            startHour: '07:00',
            professor: {
                id: 2,
                name: "Jose Manuel Inestroza"
            },
            places: 34,
            classroom: {
                id: 1,
                name: "403 B2"
            },
            amountWaitingStudents: 24,
            waitingStudentList: [
                {
                    account: "20191003421",
                    name: "Angel Fernando Castillo",
                    date: "12/12/2024"
                },
                {
                    account: "20201003421",
                    name: "Daniel Alexander Ochoa",
                    date: "12/12/2024"
                }
            ],
            amountEnrolledStudents: 24,
            enrolledStudentList: [
                {
                    account: "20191003421",
                    name: "Angel Fernando Castillo",
                    date: "12/12/2024"
                },
                {
                    account: "20201003421",
                    name: "Daniel Alexander Ochoa",
                    date: "12/12/2024"
                },
                {
                    account: "20201003421",
                    name: "Marcos Alexander Ochoa",
                    date: "12/12/2024"
                }
            ]
        }

        //Obtiene el target (se espera un boton)
        const button = event.target;

        //Si es un boton de la tabla se abre la modal
        if (button.matches('.actionsBtn')) {

            const actionsModal = document.querySelector("#actionsModal");

            document.querySelector("#sectionCode").innerText = data.code;
            document.querySelector("#sectionUV").innerText = data.uv;
            document.querySelector("#sectionDays").innerText = data.days;
            document.querySelector("#sectionHour").innerText = data.startHour;

            const inputValue = document.querySelector("input#increaseInput");
            inputValue.value = data.places;

            //Se crea tabla de estudiantes matriculados
            const enrolledSectionTbl = document.querySelector("#enrolledStudentsTable");
            enrolledSectionTbl.innerHTML = ""

            const enrolledPaginationUrl =  ``

            const enrolledHeadersTbl = ['Cuenta', 'Nombre', 'Fecha de matricula']

            this.generatePaginationTable(
                enrolledSectionTbl, 
                enrolledHeadersTbl,
                data.enrolledStudentList,
                'enrolled-body',
                data.amountEnrolledStudents,
                enrolledPaginationUrl,
                "",
                false);

            //Se genera la tabla de estudiantes en espera
            const waitingSectionTbl = document.querySelector("#studentsWaitingTable");
            waitingSectionTbl.innerHTML = ""

            const  waitingPaginationUrl =  ``

            const  waitingHeadersTbl = ['Cuenta', 'Nombre', 'Fecha de matricula']

            this.generatePaginationTable(
                waitingSectionTbl, 
                waitingHeadersTbl,
                data.waitingStudentList,
                'waiting-body',
                data.amountWaitingStudents,
                waitingPaginationUrl,
                "",
                false);

            //formato para nombre de la clase
            const className = `Clase: ${data.className}`

            //Se modifican los valores de la modal del resultado de la peticion
            Modal.openModal(actionsModal,"", className)
        }

    }

    static generatePaginationTable(section, headers, rows, id, amountRows, url, title, border){

        const table = createTable(
            title, 
            headers, 
            rows,
            id,
            border,
            10,
            amountRows,
            url,
            false,
            true,
            null
        );

        section.style.marginTop = '0px';
        section.appendChild(table);
    }

    /**
     * Se abre una modal con un formulario en donde el jefe de departamento puede crear secciones
     */
    static openCreateSection(){

        const data = {
            classes : [
                {
                    id: 1,
                    name: "Ingenieria de software"
                },
                {
                    id: 2,
                    name: "Programacion II"
                },
                {
                    id: 3,
                    name: "Inteligencia Artificial"
                }
            ],
            professors: [
                {
                    id: 34,
                    name: "Jose Manuel Inestroza"
                },
                {
                    id: 35,
                    name: "Harold Roberto Coello"
                },
                {
                    id: 36,
                    name: "Erick Vladimir Marin"
                }
            ],
            classrooms: [
                {
                    id: 53,
                    name: "401 B2"
                },
                {
                    id: 52,
                    name: "Laboratorio 2, B2"
                },
                {
                    id: 54,
                    name: "403 B2"
                }
            ],
            days: [
                {
                    id: 1,
                    name: "LuMaMiJuVi"
                },
                {
                    id: 2,
                    name: "LuMaMiJu"
                },
                {
                    id: 3,
                    name: "LuMaMi"
                }
            ]
        }

        const classSelect = document.querySelector("#classesSelect");
        const startHourSelect = document.querySelector("#startHourSelect");
        const endHourSelect = document.querySelector("#endHourSelect");
        const daysSelect = document.querySelector("#daysSelect");
        const professorSelect = document.querySelector("#professorsSelect");
        const classroomSelect = document.querySelector("#classroomSelect");

        Selects.renderSelect(classSelect,data.classes,"id","name");
        Selects.renderSelect(professorSelect,data.professors,"id","name");
        Selects.renderSelect(classroomSelect,data.classrooms,"id","name");
        Selects.renderSelect(daysSelect,data.days,"id","name");
        
        //Generamos una lista de horas desde las 6am hasta las 10pm
        const hours = this.generateHours();
        //Se renderiza el select de la hora inicial
        Selects.renderSelect(startHourSelect,hours,"id","name");

        //Se renderizan las horas finales en funcion de la hora inicial
        startHourSelect.addEventListener("change",(e)=>{
            const value = parseInt(e.target.value);
            Selects.renderSelect(endHourSelect,hours.slice(value-5),"id","name")
        })

        //Se abre la modal
        const modal = document.querySelector("#addSectionModal");
        Modal.openModal(modal,"", "Crea una Sección");

    }

    static generateHours(){
        const hours = [];

        for (let index = 6; index < 22; index++) {
            const hour = {}
            hour['id'] = index;

            let label = `${index}:00`

            if (index<10) {
                label = `0${index}:00` 
            }

            hour['name'] = label;
            hours.push(hour);
        }
        return hours;
    }


}

export {Action}