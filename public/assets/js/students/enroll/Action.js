import {Selects} from '../../modules/Selects.js'
import {Modal} from '../../modules/Modal.js'
import {HttpRequest} from '../../modules/HttpRequest.js'

class Action{
    
    static account = new URLSearchParams(window.location.search).get("id")

    static loadPage = async () => {
        const departmentSelect = document.getElementById("departmentSelect");
        const classSelect = document.getElementById("classSelect");
        const sectionSelect = document.getElementById("sectionSelect");
        const enrollButton = document.getElementById("enrollButton");

        const departmentsResponse = await HttpRequest.get(`/api/get/enroll/departmentsByStudent/?account=${this.account}`);

        if (departmentsResponse.status) {
            Selects.renderSelect(departmentSelect,departmentsResponse.data,"id","name");
        }

        departmentSelect.addEventListener("change", async (event) => {
            this.resetSelect(classSelect);
            this.resetSelect(sectionSelect);
            enrollButton.disabled = true;
        
            if (event.target.value) {
              const url = `/api/get/enroll/classesByDepartment/?departmentId=${event.target.value}&account=${this.account}`;
              await this.fetchDataAndPopulateSelect(url, classSelect);
            }

          });

        classSelect.addEventListener("change", async (event) => {
            this.resetSelect(sectionSelect);
            enrollButton.disabled = true;
        
            if (event.target.value) {
              const url = `/api/get/enroll/sectionsByClass/?classId=${event.target.value}&account=${this.account}`;
              await this.fetchDataAndPopulateSelect(url, sectionSelect);
            }
        });

        sectionSelect.addEventListener("change", () => {
            enrollButton.disabled = !sectionSelect.value; // Habilita el botón solo si se selecciona una sección
          });
    }

    static resetSelect = (select) => {
        select.innerHTML = '<option selected value="">Seleccione una opción</option>'; // Restablece las opciones
        select.disabled = true; // Deshabilita el select
    };

    static fetchDataAndPopulateSelect = async (url, targetSelect) => {
        try {
            const response = await HttpRequest.get(url);

            if (response.status) {
                targetSelect.disabled = false;
                Selects.renderSelect(targetSelect,response.data,"id","name");
            }else{
                const modal = document.querySelector("#messageModal");
                Modal.openModal(modal,response.message,"Error")
            }
        } catch (error) {
            console.error("Error al cargar datos:", error);
        }
    };

}

export {Action}