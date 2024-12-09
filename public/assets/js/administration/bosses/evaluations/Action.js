import { createTable } from "../../../modules/table.js";
import { Selects } from "../../../modules/Selects.js";
import {HttpRequest} from "../../../modules/HttpRequest.js"

class Action {

    /**
     * Se encarga de renderizar la tabla con los docentes del periodo seleccionado.
     * @param {*} periodId
     */
    static renderProfessorEvaluations(periodId) {

        //Se hace fetch con el periodID
        const data = {
            amountProfessors: 12,
            period: {
                id: 3,
                name: "II PAC 2024"
            },
            professors: [
                {
                    id: 1,
                    name: "Juan Alberto Martinez",
                    email: "juan.alberto@unah.hn",
                    amountSections: 2
                },
                {
                    id: 2,
                    name: "Maria Alejandra Galvez",
                    email: "maria.alejandrag@unah.hn",
                    amountSections: 2
                }
            ]
        }

        const periodSelect = document.querySelector("select#periodSelect");
        periodSelect.value = data.period.id;

        const headers = ["#", "Docente", "Correo", "Secciones", "Acciones"];

        const dataFormated = data.professors.map(row => this.formatRows(row, "professor-id", "Ver Secciones"));

        const container = document.querySelector("#section-table");
        container.innerHTML = "";

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
            (rows) => { rows.map(row => this.formatRows(row, "evaluation-id", "Detalle")) }
        );

        section.style.marginTop = '0px';
        container.appendChild(section);

    }

    static renderPeriodSelect() {

        //Se hace fetch a la API de traer selects de periodos
        const data = {
            "periods": [
                {
                    "id": 3,
                    "name": "1 PAC, 2023"
                },
                {
                    "id": 2,
                    "name": "2 PAC, 2023"
                },
                {
                    "id": 4,
                    "name": "3 PAC, 2023"
                }
            ]
        }

        const periodSelect = document.querySelector("select#periodSelect");

        Selects.renderSelect(periodSelect,data.periods,"id","name",false, "Seleccione un periodo")

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

            const professorId = button.dataset.professorId

            window.location.href = `/assets/views/administration/bosses/evaluations_detail.php?professorId=${professorId}`;
        }

    }


}

export { Action }