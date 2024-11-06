import {Selects} from "../modules/Selects.js"

class Action{

    static generateProfessors(professors){

        const tableBody = document.querySelector("#table-body");

        for (const professor of professors) {

            const row = document.createElement("tr");
            row.style.verticalAlign = "middle";
            
            //Se crea columna de id de maestro
            const idCol = document.createElement("th");
            idCol.setAttribute("scope","row");

            //Se agrega el id del maestro
            idCol.innerHTML = professor.id;

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
                colorTypeCard = "#3472F8";
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

    static generateSelectForm(data){

        const professorTypesSelect = document.querySelector("select#professorTypeSelect");
        const departmentSelect = document.querySelector("select#departmentSelect");

        const {professorTypes, departments} = data;

        professorTypes.forEach(type=>{
            const option = document.createElement("option");
            option.setAttribute("value",type.professorTypeId);
            option.innerText = type.name;
            professorTypesSelect.appendChild(option);
        })

        Selects.renderSelect

        departments.forEach(department => {
            const option = document.createElement("option");
            option.setAttribute("value",department.departmentId);
            option.innerText = department.name;
            departmentSelect.appendChild(option);
        })


    }


    static fetchProfessors(){
        fetch('http://localhost:3000/api/get/infoAdmission')
        .then(response => response.json())
        .then(data => console.log(data));
    }

    static fetchFormProfessors(){
        fetch('http://localhost:3000/api/get/infoAdmission')
        .then(response => response.json())
        .then(data => console.log(data));
    }

}

export {Action}