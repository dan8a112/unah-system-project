/**
 * Este metodo hace una tarjeta en la pantalla referente al proceso de admision actual.
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 11/11/24
 * 
 **/
export const makeCurrentProcesCard = (id, name) => {
    const cardContainer = document.createElement('div');
    cardContainer.className = 'currentProcesCard';
    const capIcon = document.createElement('img');
    capIcon.src = '../../img/icons/cap.svg'
    const title = document.createElement('h2');
    const container = document.getElementById('containerFirst');
    title.innerHTML = name;
    const subtitle = document.createElement('h5');
    subtitle.innerHTML = 'Gestiona los detalles del proceso actual de admisión';
    cardContainer.appendChild(capIcon);
    cardContainer.appendChild(title);
    cardContainer.appendChild(subtitle);
    container.prepend(cardContainer);
}

/**
 * Esta funcion se encarga de crear una linea de tiempo en funcion de la informacion pasada por parametro
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 11/11/24
 **/
export const makeTimeLine = (processes) => {
  const timeline = document.getElementById('timeline');

  for (let i = 0; i < processes.length; i++) {
    const dataItem = processes[i]; 
    const timelineItem = document.createElement("div");
    timelineItem.classList.add("timeline-item");

    const circle = document.createElement("div");
    circle.classList.add("circle");
    circle.textContent = dataItem.year;

    const contentGroup = document.createElement("div");
    contentGroup.classList.add("content-group");

    for (let j = 0; j < dataItem.processes.length; j++) {
      const process = dataItem.processes[j]; 

      const content = document.createElement("div");
      content.classList.add("content");

      const link = document.createElement("a");
      link.href = "#";
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

  document.body.appendChild(timeline);
}