import {Selects} from "../modules/Selects.js"
import {Modal} from "../modules/Modal.js"
import {Forms} from "../modules/Forms.js"
import {HttpRequest} from "../modules/HttpRequest.js"

class Action{

    /**
     * Realiza una peticion get para obtener la data de los maestros que estan registrados en la base de datos.
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 05/11/24
     */
    static fetchProfessors(){
        fetch('../../../api/get/infoHomeSEDP')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                console.log(data.data)
                this.generateProfessors(data.data);    
            }
        });
    }

    /**
     * Este metodo genera la tabla con los profesores registrados en el sistema, su rol, y sus acciones correspondientes
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 05/11/24
     * @param {object} data Informacion que contiene una lista de profesores y cantidad de profesores registrados 
     */
    static generateProfessors(data){

        const {professors, professorsAmount } = data;

        //nodo donde se insertara la cantidad de maestros registrados 
        const amountProfessors = document.querySelector("span#amountProfessors");
        amountProfessors.innerText = professorsAmount;

        const tableBody = document.querySelector("#table-body");
        tableBody.innerHTML = "";

        for (const professor of professors) {

            const row = document.createElement("tr");
            row.style.verticalAlign = "middle";
            
            //Se crea columna de id de maestro
            const idCol = document.createElement("th");
            idCol.setAttribute("scope","row");

            //Se agrega el id del maestro
            idCol.innerHTML = professor.professorId;

            //Se agrega id a fila
            row.appendChild(idCol);

            //Se crea columna de nombre y correo (Usuario)
            const userCol = document.createElement("td");
            userCol.innerHTML = `
            <div class="d-flex align-items-center">
                        <img src="../../img/icons/user.png" alt="" class="me-3" style="width: 50px;">
                        <div>
                            <p class="mb-0 fw-bold">${professor.name}</p>
                            <p class="mb-0">${professor.email}</p>
                        </div>
            </div>
            `

            //Se agrega la columna usuario a la fila
            row.appendChild(userCol);

            //Columna de roles de maestro
            const roleCol = document.createElement("td");

            //Se crea un contenedor de roles
            const roleContainer = document.createElement("div");
            roleContainer.classList.add("d-flex", "gap-3");

            //Se crea la card con el rol de maestros
            const professorTypeCard = document.createElement("div");
            professorTypeCard.classList.add("px-1");
            professorTypeCard.style.borderRadius = "5px"

            //Por defecto el color es anaranjado
            let colorTypeCard = "#FFAA34";

            //El maestro es un jefe
            if (professor.professorType.match(/[jJ]efe(\s+)?(\w+)?/g)) {
                //Se cambia el color de la card a azul
                colorTypeCard = "#3472F8";
                //El maestro es un coordinador
            }else if(professor.professorType.match(/[Cc]oordinador(\s+)?(\w+)?/g)){
                //Se cambia el color de la card a verde
                colorTypeCard = "#00C500";
            }

            professorTypeCard.innerText = professor.professorType;
            professorTypeCard.style.color = colorTypeCard;
            professorTypeCard.style.border = `solid 1px ${colorTypeCard}`;

            //Se inserta la card dentro del contenedor
            roleContainer.appendChild(professorTypeCard);

            //Se inserta el contenedor en la columna de rol
            roleCol.appendChild(roleContainer)

            row.appendChild(roleCol);

            const dniCol = document.createElement("td");
            dniCol.innerText = professor.dni;
            
            row.appendChild(dniCol);

            const stateCol = document.createElement("td");
            //Determina si esta activo o inactivo
            stateCol.innerText = professor.active == 1 ? "Activo" : "Inactivo";
            //Coloca color rojo si es inactivo
            stateCol.style.color = professor.active != 1 && "#ff5651";

            row.appendChild(stateCol);

            //Se crean elementos acciones de editar
            const actionsCol = document.createElement("td");

            const editBtn = document.createElement("img");
            editBtn.src = "../../img/icons/edit.svg";
            editBtn.classList.add("editBtn");

            editBtn.addEventListener("click",()=>this.openEditForm(professor.professorId));
            
            actionsCol.appendChild(editBtn);

            row.appendChild(actionsCol);

            tableBody.appendChild(row);
        }

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
     * Abre la modal para editar un docente
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 17/11/24
     * @param {*} idProfessor id del docente que se necesita editar
     */
    static async openEditForm(idProfessor){

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
        
        const response = await HttpRequest.submitForm(event, "../../../api/post/professor");

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
        const responseTypes = await HttpRequest.get("../../../api/get/professor/professorTypes");
        
        //Se agregan a data
        data.professorTypes = responseTypes.professorTypes;

        //Se hace la peticion de los departamentos
        const responseDeparments = await HttpRequest.get("../../../api/get/departments");

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
        const response = await HttpRequest.get("../../../api/get/logout");
        if (response.status) {
            window.location.href = "/"
        }
    }

}

export {Action}