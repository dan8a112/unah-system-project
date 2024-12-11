import { createTable } from "../../../modules/table.js";
import { Modal } from "../../../modules/Modal.js";
import { Selects } from "../../../modules/Selects.js";
import {HttpRequest} from "../../../modules/HttpRequest.js" 

class Action{

    static userId = new URLSearchParams(window.location.search).get("id");
    static isActive = true;

    static renderAllPage = async()=>{

        const response = await HttpRequest.get(`/api/get/departmentBoss/sectionsAdministration/?id=${this.userId}`);

        const data = response.data;

        const periodSection = document.querySelector("#periodName");
        periodSection.innerText = data.period.description;

        const departmentSection = document.querySelector("#departmentName");
        departmentSection.innerText = data.department;

        if (!data.isActive) {
            const createSectionButton = document.querySelector("#createBtn");
            createSectionButton.setAttribute("disabled", true);
            this.isActive = data.isActive;
        }

        this.renderSections(data.sections, data.period.id, data.amountSections);

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
    static renderSections(rows, periodId, amountSections){

        const headers = ["#", "Codigo","Clase", "Cupos","Hora", "Acciones"];

        const dataFormated = this.formatRows(rows, this.isActive)

        const container = document.querySelector("#section-table");

        const apiPagination =  `/api/get/pagination/sections/?idProcess=${periodId}&idBoss=${this.userId}&`

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
            (rows)=>this.formatRows(rows,this.isActive)
        );

        section.style.marginTop = '0px';
        container.appendChild(section);

    }


    /**
     * Funcion que se encarga de formatear cada fila de la tabla, este retorna un arreglo con los resultados.
     * @param {Array<Object>} row 
     * @returns {Array<Array<any>>} retorna un array con los elementos de la fila formateados
     */
    static formatRows(rows,isActive){

        const formatedTable = []

        rows.forEach(row=>{
            //Se obtienen todos los valores del objeto como array
            const formatedRow = Object.values(row);

            //Se crea el elemento button con el dataset del id de la seccion
            const button = `<button data-id-section=${row.id} class="btn btn-outline-warning btn-sm actionsBtn" ${isActive==false && 'disabled'}>Acciones</button>`

            //Se agrega el boton al array (fila de la tabla)
            formatedRow.push(button);

            formatedTable.push(formatedRow)
        })
        console.log(formatedTable)
        return formatedTable;
    }

    /**
     * Se abre una modal con un formulario en donde el jefe de departamento puede crear secciones
     */
    static openCreateSection = async () => {

        const classSelect = document.querySelector("#classesSelect");
        const startHourSelect = document.querySelector("#startHourSelect");
        const finishHourSelect = document.querySelector("#endHourSelect");
        const daysSelect = document.querySelector("#daysSelect");
        const professorSelect = document.querySelector("#professorsSelect");
        const classroomSelect = document.querySelector("#classroomSelect");
        const buildingSelect = document.querySelector("#buildingSelect");

        //Se renderizan los selects condicionales
        this.renderSelects(
            classSelect,
            null,
            startHourSelect,
            finishHourSelect,
            daysSelect,
            professorSelect,
            classroomSelect,
            buildingSelect
        );

        //Se abre la modal
        const modal = document.querySelector("#addSectionModal");
        Modal.openModal(modal,"", "Crea una Sección");

    }

    static submitCreateSection = async (event) => {

        event.preventDefault();

        const response = await HttpRequest.submitForm(event,`/api/post/section/`);

        const modal = document.querySelector("#messageModal");
        if (response.status) {
            Modal.closeModal();
            Modal.openModal(modal,response.message, "Se creo la sección exitosamente");
        }else{
            Modal.openModal(modal,response.message, "Ocurrió un error");
        }
    }

    /**
     * Abre una modal en donde se pueden realizar acciones sobre cada sección, como editar y eliminar
     * @param {Event} event recibe el evento que fue ejecutado (Click) 
     */
    static openSectionActions = async (event)=>{

        //Obtiene el target (se espera un boton)
        const button = event.target;

        //Si es un boton de la tabla se abre la modal
        if (button.matches('.actionsBtn')) {

            const sectionId = button.dataset.idSection;

            //Se llama a la API que trae la info de la sección
            const response = await HttpRequest.get(`/api/get/departmentBoss/sectionStudents/?id=${sectionId}`);
            
            if (response.status) {

                const data = response.data;

                const actionsModal = document.querySelector("#actionsModal");

                document.querySelector("#sectionCode").innerText = data.code;
                document.querySelector("#sectionUV").innerText = data.uv;
                document.querySelector("#sectionDays").innerText = data.days.name;
                document.querySelector("#sectionHour").innerText = `${data.startHour}:00`;

                const inputValue = document.querySelector("input#increaseInput");
                inputValue.value = data.places;

                //Se llenan inputs necesarios para actualizacion > sectionId y classId
                document.querySelector("#sectionIdInput").value = sectionId;
                document.querySelector("#classIdInput").value = data.class.id;

                //Se seleccionan los selects del formulario
                const startHourSelect = document.querySelector("#startHourAsigned");
                const finishHourSelect = document.querySelector("#finishHourAsigned");
                const daysSelect = document.querySelector("#daysAsigned");
                const buildingSelect = document.querySelector("#buildingAsigned");
                const classroomSelect = document.querySelector("#classroomAsigned");
                const professorSelect = document.querySelector("#professorAsigned");

                //Data necesaria para renderizado de selects para editar seccion.
                const selectData = {
                    uv:data.uv, 
                    professor: data.professor, 
                    classroom: {
                        classroomId: data.classrom.id,
                        name: data.classrom.name,
                        idBuilding: data.classrom.idBuilding
                    }
                }

                //Se renderizan todas las opciones de los selects y se espera que termine
                await this.renderSelects(
                    null,
                    selectData,
                    startHourSelect,
                    finishHourSelect,
                    daysSelect,
                    professorSelect,
                    classroomSelect,
                    buildingSelect
                );
                
                //Se crea un evento que se va a ejecutar con cada cambio para generar selecciones condicionales
                const changeEvent = new Event('change');
                
                //Se seleccionan las opciones de la seccion obtenida
                daysSelect.value = data.days.id;
                daysSelect.dispatchEvent(changeEvent);

                startHourSelect.value = data.startHour;
                startHourSelect.dispatchEvent(changeEvent);

                finishHourSelect.value = data.finishHour;
                finishHourSelect.dispatchEvent(changeEvent);
                
                setTimeout(()=>{
                    buildingSelect.value = data.building.id;
                    buildingSelect.dispatchEvent(changeEvent);
                    //Estos dos ultimos no tienen condicionales
                    classroomSelect.value = data.classrom.id;
                    professorSelect.value = data.professor.id;
                },200)

                //Se crea tabla de estudiantes matriculados
                const enrolledSectionTbl = document.querySelector("#enrolledStudentsTable");
                enrolledSectionTbl.innerHTML = ""

                const enrolledPaginationUrl =  ``

                const enrolledHeadersTbl = ['Cuenta', 'Nombre', 'Correo Electronico']

                this.generatePaginationTable(
                    enrolledSectionTbl, 
                    enrolledHeadersTbl,
                    data.studentsList,
                    'enrolled-body',
                    data.amountStudents,
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
                const className = `Clase: ${data.class.name}`

                //Se modifican los valores de la modal del resultado de la peticion
                Modal.openModal(actionsModal,"", className)
            }
        }

    }

    static submitEditSection = async (event) => {

        event.preventDefault();

        const response = await HttpRequest.submitForm(event,`/api/update/section/`);

        const modal = document.querySelector("#messageModal");
        
        if (response.status) {
            Modal.closeModal();
            Modal.openModal(modal,response.message, "Se actualizó la sección exitosamente");
        }else{
            Modal.openModal(modal,response.message, "Ocurrió un error al actualizar");
        }
    }


    static submitDeleteSection = async () => {

        const sectionId = document.querySelector("#sectionIdInput").value;

        const response = await HttpRequest.get(`/api/update/canceledSection/?id=${sectionId}`);

        const modal = document.querySelector("#messageModal");
        
        if (response.status) {
            Modal.closeModal();
            Modal.openModal(modal,response.message, "Se eliminó la sección correctamente");
        }else{
            Modal.openModal(modal,response.message, "Ocurrió un error al eliminar la sección");
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

    static renderSelects = async (
        classSelect, data, startHourSelect, finishHourSelect,
        daysSelect, professorSelect, classroomSelect, buildingSelect)=>{

        //Se llama API para obtener dias y asignaturas
        const response = await HttpRequest.get(`/api/get/departmentBoss/subjectsAndDays/?id=${this.userId}`);

        const {classes, days} = response.data;

        if (classSelect) {

            Selects.renderSelect(classSelect,classes,"id","class");
            Selects.addDataset(classSelect,classes,'id',"uv","uv");

            classSelect.addEventListener("change", (e)=>{
                const option = e.target.selectedOptions[0];
                const uv = option.dataset.uv;
            
                const daysFiltered = days.filter(day=>day.amountDays<=uv && uv%day.amountDays==0);
    
                Selects.renderSelect(daysSelect,daysFiltered,"id","name");
                Selects.addDataset(daysSelect,days,'id','amountDays','amount')
            })

        }else{

            const daysFiltered = days.filter(day=>day.amountDays<=data.uv && data.uv%day.amountDays==0);
    
            Selects.renderSelect(daysSelect,daysFiltered,"id","name");
            Selects.addDataset(daysSelect,days,'id','amountDays','amount')
        }
        
        //Generamos una lista de horas desde las 6am hasta las 10pm
        const hours = this.generateHours();

        daysSelect.addEventListener("change", ()=>{
            Selects.renderSelect(startHourSelect,hours,"id","name");
        })
        
        //Se renderizan las horas finales en funcion de la hora inicial
        startHourSelect.addEventListener("change",(e)=>{

            //Hora inicial
            const value = parseInt(e.target.value);

            //Horas siguientes, e.g. selected = 11:00  -> [12:00, 13:00, ...]
            const nextHours = hours.slice(value-5);

            //Se obtienen el uv de la clase seleccionada y los dias seleccionados
            const uvSelected = classSelect ? classSelect.selectedOptions[0].dataset.uv : data.uv;
            const daysSelected = daysSelect.selectedOptions[0].dataset.amount;

            //Se obtienen solo la hora disponible dependiendo las uv de la clase y dias seleccionado
            const validHours = nextHours.slice(0,(uvSelected/daysSelected)).slice(-1)

            Selects.renderSelect(finishHourSelect,validHours,"id","name")
        })

        let classroomsData = [];

        finishHourSelect.addEventListener("change", async ()=>{

            const classValue = classSelect ? classSelect.value : data.uv;            
            //Si los selects tienen un valor
            if(classValue!=null && daysSelect.value && startHourSelect.value && finishHourSelect.value){
                
                const response = await HttpRequest.get(`/api/get/departmentBoss/professorsAndClassrooms/?idDays=${daysSelect.value}&startHour=${startHourSelect.value}&finishHour=${finishHourSelect.value}`);
                
                if (response.status==true) {
                    
                    const {buildings, classrooms, professors} = response.data;

                    if (!classSelect) {
                        //Se agregan maestros y aulas recibidas de backend
                        professors.push(data.professor);
                        classrooms.push(data.classroom);
                    }
                    
                    //Se guardan aulas traidas de backend en variable externa
                    classroomsData = classrooms;
                    
                    //Se renderizan opciones de select
                    Selects.renderSelect(professorSelect,professors,"id","name");
                    Selects.renderSelect(buildingSelect,buildings,"id","building");
                }
            }else{
                console.error("Debes seleccionar las opciones antes de continuar")
            }
        })

        buildingSelect.addEventListener("change", (e)=>{

            const buildingSelected = e.target.value;

            if (classroomsData.length>0) {
                const classroomFiltered = classroomsData.filter(classroom=>classroom.idBuilding==buildingSelected);

                Selects.renderSelect(classroomSelect,classroomFiltered,"classroomId","name");
            }

        })
    }
}

export {Action}