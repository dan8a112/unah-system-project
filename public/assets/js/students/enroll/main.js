//import {Action} from "./Action.js"

document.addEventListener("DOMContentLoaded", () => {
    const departmentSelect = document.getElementById("departmentSelect");
    const classSelect = document.getElementById("classSelect");
    const sectionSelect = document.getElementById("sectionSelect");
    const enrollButton = document.getElementById("enrollButton");
  
    const resetSelect = (select) => {
      select.innerHTML = '<option selected value="">Seleccione una opción</option>'; // Restablece las opciones
      select.disabled = true; // Deshabilita el select
    };
  
    const fetchDataAndPopulateSelect = async (url, targetSelect) => {
      try {
        const response = await fetch(url);
        if (!response.ok) throw new Error("Error en la respuesta del servidor");
  
        const data = await response.json();
        if (data && data.length > 0) {
          data.forEach(item => {
            const option = document.createElement("option");
            option.value = item.id; // Ajusta según la estructura de los datos
            option.textContent = item.name; // Ajusta según la estructura de los datos
            targetSelect.appendChild(option);
          });
          targetSelect.disabled = false;
        }
      } catch (error) {
        console.error("Error al cargar datos:", error);
      }
    };
  
    departmentSelect.addEventListener("change", async (event) => {
      resetSelect(classSelect);
      resetSelect(sectionSelect);
      enrollButton.disabled = true;
  
      if (event.target.value) {
        const url = `http://localhost:3000/api/get/classes/?departmentId=${event.target.value}`;
        await fetchDataAndPopulateSelect(url, classSelect);
      }
    });
  
    classSelect.addEventListener("change", async (event) => {
      resetSelect(sectionSelect);
      enrollButton.disabled = true;
  
      if (event.target.value) {
        const url = `http://localhost:3000/api/get/sections/?classId=${event.target.value}`;
        await fetchDataAndPopulateSelect(url, sectionSelect);
      }
    });
  
    sectionSelect.addEventListener("change", () => {
      enrollButton.disabled = !sectionSelect.value; // Habilita el botón solo si se selecciona una sección
    });
  });
  