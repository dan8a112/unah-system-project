/**
 * Este metodo hace una tarjeta en la pantalla referente al proceso de admision actual.
 * author: afcastillof@unah.hn
 * version: 0.1.1
 * date: 12/11/24
 * 
 **/
export const makeCurrentProcesCard = (id, name) => {
  const cardContainer = document.createElement('div');
  cardContainer.className = 'currentProcesCard';
  cardContainer.style.cursor = 'pointer';
  
  // Redirigir a vista de proceso actual
  cardContainer.addEventListener('click', () => {
      window.location.href = `../../../assets/views/admission/process_detail_active.php`; 
  });

  const capIcon = document.createElement('img');
  capIcon.src = '../../img/icons/cap.svg';

  const title = document.createElement('h2');
  title.innerHTML = name;

  const subtitle = document.createElement('h5');
  subtitle.innerHTML = 'Gestiona los detalles del proceso actual de admisión';

  // Añadir los elementos a la tarjeta
  cardContainer.appendChild(capIcon);
  cardContainer.appendChild(title);
  cardContainer.appendChild(subtitle);

  // Insertar la tarjeta en el contenedor
  const container = document.getElementById('containerFirst');
  container.prepend(cardContainer);
};


/**
 * Esta funcion se encarga de crear una linea de tiempo en funcion de la informacion pasada por parametro
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 11/11/24
 **/
export const makeTimeLine = (processes) => {
  const timeline = document.getElementById('timeline');
  const containerSection = document.getElementById('containerSection')

  //Se crear los circulos con los anios
  for (let i = 0; i < processes.length; i++) {
    const dataItem = processes[i]; 
    const timelineItem = document.createElement("div");
    timelineItem.classList.add("timeline-item");

    const circle = document.createElement("div");
    circle.classList.add("circle");
    circle.textContent = dataItem.year;

    const contentGroup = document.createElement("div");
    contentGroup.classList.add("content-group");

    //Se crean los procesos por cada anio
    for (let j = 0; j < dataItem.processes.length; j++) {
      const process = dataItem.processes[j]; 

      const content = document.createElement("div");
      content.classList.add("content");
    
      const professorId = new URLSearchParams(window.location.search).get("id");

      const link = document.createElement("a");
      link.href = `/assets/views/professors/previous_periods_classes.php?id=${professorId}&periodId=${process.id}&periodName=${process.title}`;
      link.classList.add("more-link");
      link.textContent = "Ver más";

      const heading = document.createElement("h3");
      heading.textContent = process.title;

      const paragraph = document.createElement("p");
      paragraph.textContent = 'Ve los detalles del proceso de admisión ';

      content.appendChild(link);
      content.appendChild(heading);
      content.appendChild(paragraph);

      contentGroup.appendChild(content);
    }

    timelineItem.appendChild(circle);
    timelineItem.appendChild(contentGroup);

    timeline.appendChild(timelineItem);
  }

  containerSection.appendChild(timeline);
}

/**
 * Esta funcion se encarga de recibir un objeto y crear otro con dos arreglos para dibujar el grafico
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 12/11/24
 **/
export const separateData = (arr) => {
  const result = {
      applicantsAmount: [],
      processes: []
  };

  arr.forEach(item => {
      result.applicantsAmount.push(item.applications);
      result.processes.push(item.name);
  });

  return result;
}