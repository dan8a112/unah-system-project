import {Selects} from "../modules/Selects.js"
import {Modal} from "../modules/Modal.js"
import {HttpRequest} from "../modules/HttpRequest.js"

class Action{

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

            //Se crean elementos acciones de eliminar y editar
            const actionsCol = document.createElement("td");
            actionsCol.innerHTML = `
                <td>
                    <img class="me-3" src="../../img/icons/delete.svg" alt="">
                    <img src="../../img/icons/edit.svg" alt="">
                </td>`

            row.appendChild(actionsCol);

            tableBody.appendChild(row);
        }

    }

    /**
     * Genera los las opciones de los selects del formulario para crear maestros (tipos de maestros y departamentos).
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 05/11/24
     * @param {*} data informacion que contiene las opciones de los selects a renderizar
     */
    static generateSelectForm(data){

        const professorTypesSelect = document.querySelector("select#professorTypeSelect");
        const departmentSelect = document.querySelector("select#departmentSelect");

        //destructuracion de la data
        const {professorTypes, departments} = data;

        //Se renderizan las opciones del select de tipos de maestros
        Selects.renderSelect(professorTypesSelect,professorTypes,"professorTypeId","name");
        
        //Se renderizan las opciones del select de departamentos de maestros
        Selects.renderSelect(departmentSelect,departments,"departmentId","name");

        const formModal = document.querySelector("#formModal");
        Modal.openModal(formModal);
    }

    /**
     * Envia el formulario de creacion de nuevo maestro
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 05/11/24
     * @param {*} event evento submit de envio de formulario
     */
    static submitFormProfessor(event){

        const form = this;

        event.preventDefault();
        
        const formData = new FormData(form);

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
        const responseTypes = await HttpRequest.get("http://localhost:3000/api/get/professorTypes");
        
        //Se agregan a data
        data.professorTypes = responseTypes.professorTypes;

        const responseDeparments = await HttpRequest.get("http://localhost:3000/api/get/departments");

        data.departments = responseDeparments.departments;

        this.generateSelectForm(data);  
        
    }

    /**
     * Realiza una peticion get para obtener la data de los maestros que estan registrados en la base de datos.
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 05/11/24
     */
    static fetchProfessors(){
        fetch('http://localhost:3000/api/get/infoHomeSEDP')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                console.log(data.data)
                this.generateProfessors(data.data);    
            }
        });
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