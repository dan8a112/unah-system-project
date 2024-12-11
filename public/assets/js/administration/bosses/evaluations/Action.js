import { createTable } from "../../../modules/table.js";
import { Selects } from "../../../modules/Selects.js";
import {HttpRequest} from "../../../modules/HttpRequest.js"

class Action {

    /**
     * Se encarga de renderizar la tabla con los docentes del periodo seleccionado.
     * @param {*} periodId
     */
    static renderProfessorEvaluations = async (periodId) => {

        //Se hace fetch con el periodID
        const response = await HttpRequest.get(`/api/get/departmentBoss/professorsAmountSections/?idPeriod=${periodId}`);

        if (response.status) {
            const data = response.data;
            const periodSelect = document.querySelector("select#periodSelect");
            periodSelect.value = data.period.id;

            const headers = ["#", "Docente", "Correo", "Secciones", "Acciones"];

            const dataFormated = data.professors.map(row => this.formatRows(row, "professor-id", "Ver Secciones"));

            const urlPagination = `/api/get/pagination/professorsAmountSections/?idPeriod=${data.period.id}&`

            const container = document.querySelector("#section-table");
            container.innerHTML = "";

            const section = createTable(
                "",
                headers,
                dataFormated,
                "table-body",
                false,
                10,
                data.amountProfessors,
                urlPagination,
                false,
                true,
                (rows) => rows.map(row => this.formatRows(row, "professor-id", "Ver Secciones"))
            );

            section.style.marginTop = '0px';
            container.appendChild(section);

            //Accion al presionar un boton de la tabla (Acciones)
            const tableBody = document.querySelector("tbody#table-body");
            tableBody.addEventListener("click", (e)=>{Action.openEvaluationsSections(e)});
        }

    }

    static renderPeriodSelect = async () => {

        //Se hace fetch a la API de traer selects de periodos
        const response = await HttpRequest.get("/api/get/periods/");

        const data = response.periods;

        const periodSelect = document.querySelector("select#periodSelect");

        Selects.renderSelect(periodSelect,data,"id","name",false, "Seleccione un periodo")

    }


    /**
     * Funcion que se encarga de formatear cada fila de la tabla, este retorna un arreglo con los resultados.
     * @param {Object} row 
     * @param {String} dataset 
     * @param {String} textButton 
     * @returns {Array} retorna un array con los elementos de la fila formateados
     */
    static formatRows(row, dataset, textButton) {

        //Se obtienen todos los valores del objeto como array
        const formatedData = Object.values(row);

        //Se crea el elemento button con el dataset del id de la seccion
        const button = `<button data-${dataset}=${row.id} class="btn btn-outline-primary btn-sm actionsBtn">${textButton}</button>`

        //Se agrega el boton al array (fila de la tabla)
        formatedData.push(button);

        return formatedData;
    }

    static openEvaluationsSections(event) {

        //Obtiene el target (se espera un boton)
        const button = event.target;

        //Si es un boton de la tabla se abre la modal
        if (button.matches('.actionsBtn')) {

            const professorId = button.dataset.professorId;
            const periodId = document.querySelector("#periodSelect").value;

            window.location.href = `/assets/views/administration/bosses/evaluations_detail.php?professorId=${professorId}&periodId=${periodId}`;
        }

    }


}

export { Action }