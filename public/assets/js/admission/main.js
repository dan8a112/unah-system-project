import { fetchData, populateSelect } from './action.js';

const url = 'http://localhost:3000/api/get/infoAdmission'; 

// Seleccionamos los elementos select donde se llenarán las opciones
const selectFirstCareer = document.getElementById('firstCareer');
const selectSecondCareer = document.getElementById('secondCareer');
const selectCampus = document.getElementById('campus');

const loadSelectOptions = async () => {
  try {
    const careers = await fetchData(url);

    if (careers) {
      populateSelect(selectFirstCareer, careers);
      populateSelect(selectSecondCareer, careers);  
      populateSelect(selectCampus, careers);
    } else {
      console.error('No se pudieron cargar las opciones.');
    }
  } catch (error) {
    console.error('Error al cargar las opciones:', error);
  }
};

document.addEventListener('DOMContentLoaded', loadSelectOptions);
