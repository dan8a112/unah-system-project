import {Selects} from "../modules/Selects.js";
import {Modal} from "../modules/Modal.js";
import {Forms} from "../modules/Forms.js";
import {HttpRequest} from "../modules/HttpRequest.js";
import { createTable } from "../modules/table.js";

class Action{

    /**
     * Realiza una peticion get para obtener la data de los maestros que estan registrados en la base de datos.
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 05/11/24
     */
    static fetchProfessors(){
        fetch('../../../api/get/infoHomeSEDP/')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                console.log(data.data)
                this.generateProfessorsWithTable(data.data);    
            }
        });
    }   

    /**
     * Abre modal para crear docente
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 18/11/24
     */
    static generateProfessorsWithTable(data) {
        const { professors, professorsAmount } = data;
    
        // Nodo donde se insertará la cantidad de maestros registrados
        const amountProfessors = document.querySelector("span#amountProfessors");
        amountProfessors.innerText = professorsAmount;
    
        // Encabezados de la tabla
        const headers = ["#", "Usuario", "Roles", "DNI", "Estado", "Acciones"];
    
        // Filas iniciales para la tabla
        const rows = professors.map((professor, index) => {
            const idCell = professor.professorId;
    
            const userCell = `
                <div class="d-flex align-items-center">
                    <img src="../../img/icons/user.png" alt="" class="me-3" style="width: 50px;">
                    <div>
                        <p class="mb-0 fw-bold">${professor.name}</p>
                        <p class="mb-0">${professor.email}</p>
                    </div>
                </div>
            `;
    
            const rolesCell = (() => {
                const colorMap = {
                    'Jefe de departamento': "#3472F8",
                    'Coordinador': "#00C500",
                    'default': "#FFAA34",
                };
                const colorTypeCard = colorMap[professor.professorType] || colorMap.default;
                return `
                    <div class="d-flex gap-3">
                        <div style="border-radius: 5px; border: solid 1px ${colorTypeCard}; color: ${colorTypeCard}; padding: 0 5px;">
                            ${professor.professorType}
                        </div>
                    </div>
                `;
            })();
    
            const dniCell = professor.dni;
    
            const stateCell = `
                <span style="color: ${professor.active !== 1 ? '#ff5651' : 'inherit'};">
                    ${professor.active === 1 ? "Activo" : "Inactivo"}
                </span>
            `;
    
            const actionsCell = `
                <img src="../../img/icons/edit.svg" class="editBtn" alt="Editar" data-professor-id=${idCell}">
            `;
    
            return [index + 1, userCell, rolesCell, dniCell, stateCell, actionsCell];
        });
    
        const container = document.getElementById('table');
    
        // Crear la tabla con el componente `createTable`
        this.createTableWithData(
            "",
            headers,
            rows,
            container,
            "table-body",
            10, // Límite de filas por página
            professorsAmount, // Total de registros
            "../../../api/get/pagination/professors/?", // URL del API (debe ser reemplazada con la real)
            false,
            true,
            rows // Activar renderización como HTML en las celdas
        );
    }
    
    // Modifica la función `createTableWithData` para procesar contenido HTML.
    

    /**
     * Abre la modal para editar un docente
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 17/11/24
     * @param {*} idProfessor id del docente que se necesita editar
     */
    static async openEditiForm(idProfessor){

        //Se obtiene la data de los selects y se generan opciones
        const selectData = await this.fetchFormProfessors();
        this.generateSelectForm(selectData, true);
        //Se obtiene la informacion del profesor
        const professorResponse = await HttpRequest.get(`../../../api/get/professor/professor/?id=${idProfessor}`);
        //Formulario de maestros
        const professorForm = document.querySelector("#editProfessorForm");
        //Se guarda el id del maestro en el dataset del formulario
        professorForm.dataset.idProfessor = professorResponse.data.id;
        //Se establece un rango de edad entre 18 y 90 años para validar fecha de nacimiento
        const dateInput = professorForm.querySelector("input#bdInput");
        Forms.setRangeDate(dateInput,18,90);
        //Llena los campos del formulario
        Forms.fillFieldsEdit(professorResponse.data, professorForm);
        //Se abre la modal
        const formModal = document.querySelector("#editModal");
        Modal.openModal(formModal);
    }

    /**
     * Abre modal para crear docente
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 18/11/24
     */
    static async openCreateForm(){

        //Se obtiene la data de los selects
        const data = await this.fetchFormProfessors();
        this.generateSelectForm(data);
        
        const formModal = document.querySelector("#formModal");
        
        //Se establece un rango de edad entre 18 y 90 años para validar fecha de nacimiento
        const dateInput = formModal.querySelector("input#birthDateInput");
        Forms.setRangeDate(dateInput,18,90);
        
        //Se abre una modal
        Modal.openModal(formModal);
    }

    /**
     * Envia el formulario de creacion de nuevo maestro
     * @author dochoao@unah.hn
     * @version 0.1.1
     * @date 18/11/24
     * @since 05/11/24
     * @param {*} event evento submit de envio de formulario
     */
    static submitFormProfessor = async (form, event)=>{

        console.log(form)

        event.preventDefault();
        
        const response = await HttpRequest.submitForm(event, "../../../api/post/professor/");
        console.log(response);

        Modal.closeModal();

        if (response.status) {
            //Abre una modal mostrando los datos del maestro creado
            const modal = document.querySelector("#messageModal");
            const message = `
                <p class="mb-3">${response.message}</p>
                <p class="mb-2"><strong>Nombre: </strong>${response.data.name}</p>
                <p class="mb-2"><strong>Contraseña: </strong>${response.data.password}</p>
                <p class="mb-2"><strong>Correo: </strong>${response.data.personalEmail}</p>
            `;
            Modal.openModal(modal,message,"Exito!");
            this.fetchProfessors();
            const containerTable = document.getElementById('table');
            containerTable.innerHTML = "";
            Forms.clearFields(document.querySelector("#createProfessorForm"))
        }else{
            //Muestra una modal de error
            const modal = document.querySelector("#messageModal");
            const modalBtn = modal.querySelector("button#btnClose");
            modalBtn.classList.remove("btn-success");
            modalBtn.classList.add("btn-danger");
            Modal.openModal(modal,response.message,"Error!")
        }
    }


    /**
     * Envia el formulario de edicion de un docente
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 18/11/24
     * @param {*} event evento submit de envio de formulario
     */
    static submitFormEditProfessor = async (event)=>{

        event.preventDefault();
        
        const form = event.target;
        
        //Se obtiene el id del profesor del dataset del formulario
        const idProfessor = form.dataset.idProfessor;
        
        //Se envia el formulario y se espera una respuesta
        const response = await HttpRequest.submitForm(event, `../../../api/update/professor?id=${idProfessor}`);

        Modal.closeModal();

        if (response.status) {
            //Muestra mensaje de exito en modal
            const modal = document.querySelector("#messageModal");
            Modal.openModal(modal,response.message,"Exito!")
            this.fetchProfessors();
        }else{
            //Muestra mensaje de error en modal
            const modal = document.querySelector("#messageModal");
            const modalBtn = modal.querySelector("button#btnClose");
            modalBtn.classList.remove("btn-success");
            modalBtn.classList.add("btn-danger");
            Modal.openModal(modal,response.message,"Error!")
        }

    }


    /**
     * Realiza peticiones asincronas para obtener la data que se utiliza para renderizar los selects
     * del formulario de crear maestro
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 05/11/24
     */
    static fetchFormProfessors  = async ()=>{
        
        let data = {}

        //Se hace la peticion de los tipos de profesores
        const responseTypes = await HttpRequest.get("../../../api/get/professor/professorTypes/");
        
        //Se agregan a data
        data.professorTypes = responseTypes.professorTypes;

        //Se hace la peticion de los departamentos
        const responseDeparments = await HttpRequest.get("../../../api/get/departments/");

        data.departments = responseDeparments.departments;

        return data;
    }

    /**
     * Genera los las opciones de los selects del formulario para crear maestros (tipos de maestros y departamentos).
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 05/11/24
     * @param {*} data informacion que contiene las opciones de los selects a renderizar
     */
    static generateSelectForm(data, edit=false){

        //destructuracion de la data
        const {professorTypes, departments} = data;

        let departmentSelect = document.querySelector("select#departmentSelect");
        let professorTypesSelect = document.querySelector("select#professorTypeSelect");

        if (edit) {
            departmentSelect = document.querySelector("select#departmentSelectEdit");
            professorTypesSelect = document.querySelector("select#professorTypeSelectEdit");
        }

        //Se renderizan las opciones del select de tipos de maestros
        Selects.renderSelect(professorTypesSelect,professorTypes,"professorTypeId","name");
        
        //Se renderizan las opciones del select de departamentos de maestros
        Selects.renderSelect(departmentSelect,departments,"departmentId","name");
    }

    /**
     * Cierra la sesion y redirecciona al home
     */
    static async logout(){
        const response = await HttpRequest.get("../../../api/get/logout/");
        if (response.status) {
            window.location.href = "/"
        }
    }
    

    /**
     * Crea una tabla con los datos especificados.
     * @param {string} title - Título de la tabla.
     * @param {Array} headers - Encabezados de la tabla.
     * @param {Array} rows - Filas de datos.
     * @param {HTMLElement} container - Contenedor de la tabla.
     * @param {string} tableId - ID único para la tabla.
     * @param {Function} transformFunc - Función de transformación de contenido de celdas.
     */
    static createTableWithData(title, headers, rows, container, tableId, limit, totalRecords, apiUrl, isFetchPagination, renderAsHtml, transformFunc) {
        const section = createTable(title, headers, rows, tableId, limit, totalRecords, apiUrl, isFetchPagination, renderAsHtml, transformFunc);
        section.style.marginTop = '0px';
        container.appendChild(section);
}

}

export {Action}