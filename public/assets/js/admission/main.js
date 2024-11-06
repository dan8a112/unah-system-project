/**
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 6/11/24
 */
import { loadSelectOptions, enableCareerSelects } from './action.js';

const selectFirstCareer = document.getElementById('firstCareer');
const selectSecondCareer = document.getElementById('secondCareer');
const selectRegionalCenters = document.getElementById('regionalCenters');

// Llamamos a la función para cargar las opciones cuando la página esté lista
document.addEventListener('DOMContentLoaded', () => {
  loadSelectOptions(selectFirstCareer, selectSecondCareer, selectRegionalCenters);
});

// Evento para habilitar los selectores de carrera cuando se elige un centro regional
selectRegionalCenters.addEventListener('change', () => {
  enableCareerSelects(selectFirstCareer, selectSecondCareer, selectRegionalCenters);
});
