import { HttpRequest } from '../../modules/HttpRequest.js'; 
import { Selects } from '../../modules/Selects.js'; 

const url = '../../../api/get/admission/infoAdmission'; 
let regionalCentersData = [];
let careersData = [];

/**
 * Esta funcion se encarga de dar la lista de carreras para las opciones de los select
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 6/11/24
 * 
 **/
export const loadSelectOptions = async (selectFirstCareer, selectSecondCareer, selectRegionalCenters) => {
  try {
    const data = await HttpRequest.get(url);
    careersData = data.data.careers;
    regionalCentersData = data.data.regionalCenters;

    if (careersData && regionalCentersData) {
      Selects.renderSelect(selectRegionalCenters, regionalCentersData, 'idRegionalCenter', 'description');
      Selects.renderSelect(selectFirstCareer, careersData, 'idCareer', 'description');
      Selects.renderSelect(selectSecondCareer, careersData, 'idCareer', 'description');

      // Desactiva los selects de carrera hasta que se seleccione un centro regional
      selectFirstCareer.disabled = true;
      selectSecondCareer.disabled = true;
    } else {
      console.error('No se pudieron cargar las opciones.');
    }
  } catch (error) {
    console.error('Error al cargar las opciones:', error);
  }
};
/**
 * Esta funcion se encarga de habilitar los select una vez se halla elegido el centro regional
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 6/11/24
 * 
 **/
export const enableCareerSelects = (selectFirstCareer, selectSecondCareer, selectRegionalCenters) => {
  const selectedRegionalCenterId = parseInt(selectRegionalCenters.value);

  const isRegionalCenterSelected = !isNaN(selectedRegionalCenterId);
  selectFirstCareer.disabled = !isRegionalCenterSelected;
  selectSecondCareer.disabled = !isRegionalCenterSelected;

  if (isRegionalCenterSelected) {
    const selectedCenter = regionalCentersData.find(
      center => center.idRegionalCenter === selectedRegionalCenterId
    );

    if (selectedCenter) {
      // Filtra las carreras usando `classifyCareers` y actualiza las opciones
      const filteredCareers = classifyCareers(selectedCenter, careersData);
      
      // Limpia las opciones actuales de los selects de carrera
      selectFirstCareer.innerHTML = '';
      selectSecondCareer.innerHTML = '';

      // Agrega la opción por defecto al inicio de los selects de carrera
      const defaultOption = document.createElement('option');
      defaultOption.text = 'Seleccione la carrera';
      defaultOption.value = '';
      selectFirstCareer.appendChild(defaultOption.cloneNode(true));
      selectSecondCareer.appendChild(defaultOption.cloneNode(true));

      // Rellena los selects de carrera con las carreras filtradas
      Selects.renderSelect(selectFirstCareer, filteredCareers, 'idCareer', 'description');
      Selects.renderSelect(selectSecondCareer, filteredCareers, 'idCareer', 'description');
    }
  }
};

 /*
 * Esta función filtra las carreras que están disponibles en un centro regional específico
 *
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 6/11/24
 * 
 **/
 function classifyCareers(centerData, careersList) {
    return careersList.filter(career => centerData.careers.includes(career.idCareer));
}


