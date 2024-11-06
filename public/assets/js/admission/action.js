export const fetchData = async (url) => {
  try {
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error('Network response was not ok ' + response.statusText);
    }

    const data = await response.json();

    if (data && data.data && data.data.careers) {
      return data.data.careers; 
    }

    throw new Error('Datos no encontrados');
  } catch (error) {
    console.error('Error fetching data:', error);
    return null;
  }
};

export const populateSelect = (selectElement, careers) => {
  selectElement.innerHTML = '';

  const defaultOption = document.createElement('option');
  defaultOption.textContent = 'Seleccione una carrera';
  defaultOption.disabled = true;
  defaultOption.selected = true;
  selectElement.appendChild(defaultOption);

  careers.forEach(career => {
    const option = document.createElement('option');
    option.value = career.idCareer; 
    option.textContent = career.description;
    selectElement.appendChild(option);
  });
};
