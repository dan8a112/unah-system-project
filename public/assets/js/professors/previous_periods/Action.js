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