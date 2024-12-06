import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";
import { Selects } from "../../../modules/Selects.js";

class Action{

    static renderAllPage(){

        const data = {
            period: "2 PAC 2024",
            department: "Departamento de Ingenieria en sistemas",
            amountSections: 34,
            sections: [
            {
                id: 1,
                class: "Ingenieria de Software",
                hour: "11:00",
                denomination: "1100",
                places: 12
            },
            {
                id: 2,
                class: "Algoritmos y Estructuras de datos",
                hour: "13:00",
                denomination: "1301",
                places: 24
            }]
        }

        const periodSection = document.querySelector("#periodName");
        periodSection.innerText = data.period;

        const departmentSection = document.querySelector("#departmentName");
        departmentSection.innerText = data.department;

        this.renderSections(data.sections)
    }

    /**
     * Se encarga de renderizar la tabla con las secciones en la pagina.
     * @param {*} data 
     */
    static renderSections(data){


        const headers = ["#", "Clase", "Hora", "Denominación", "Cupos", "Acciones"];

        const dataFormated = data.map(row=>this.formatRows(row));

        const container = document.querySelector("#section-table");

        const section = createTable(
            "", 
            headers, 
            dataFormated, 
            "table-body",
            false,
            10, 
            dataFormated.length, 
            "", 
            false, 
            true,
            ""
        );

        section.style.marginTop = '0px';
        container.appendChild(section);

    }


    /**
     * Funcion que se encarga de formatear cada fila de la tabla, este retorna un arreglo con los resultados.
     * @param {Object} row 
     * @returns {Array} retorna un array con los elementos de la fila formateados
     */
    static formatRows(row){

        //Se obtienen todos los valores del objeto como array
        const formatedData = Object.values(row);

        //Se crea el elemento button con el dataset del id de la seccion
        const button = `<button data-id-section=${row.id} class="btn btn-outline-warning btn-sm actionsBtn">Acciones</button>`

        //Se agrega el boton al array (fila de la tabla)
        formatedData.push(button);

        return formatedData;
    }

    /**
     * Abre una modal en donde se pueden realizar acciones sobre cada sección, como editar y eliminar
     * @param {Event} event recibe el evento que fue ejecutado (Click) 
     */
    static openSectionActions(event){

        const data = {
            code: "1100",
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
            ]
        }

        //Obtiene el target (se espera un boton)
        const button = event.target;

        //Si es un boton de la tabla se abre la modal
        if (button.matches('.actionsBtn')) {

            const actionsModal = document.querySelector("#actionsModal");
            //Se modifican los valores de la modal del resultado de la peticion
            Modal.openModal(actionsModal,"", "Ingenieria de software")
        }

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