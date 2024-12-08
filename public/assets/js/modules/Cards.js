/**
 * Funcion que recibe un objeto sección y retorna una card con el formato de una sección/clase en HTML
 * @param {Object} section objeto sección de una lista de secciones 
 * @param {int} index indice producto de la iteración de la lista de secciones (se utiliza para darle el color a la card)
 * @returns Un String con contenido HTML con el formato de una card
 * @author dochoao@unah.hn
 * @version 0.1.0
 * @date 08/12/24
 */
export const createSectionCard = (section, index)=>{
    
    //Colores de las cards los cuales se van repitiendo si se excede la cantidad
    const colors = {
        0: "#FFAA34",
        1: "#304987",
        2: "#AF595C"
    }

    //Se obtienen la cantidad de colores
    const amountColors = Object.keys(colors).length;

    //Se obtienen las llaves de la section
    const sectionKeys = Object.keys(section);
    
    //Se retorna una card de clase/sección
    return `<div class="class-card" data-section-id=${section[sectionKeys[0]]}>
            <div class="class-card-header" style="background-color: ${colors[index%amountColors]};">
                <span>Seccion ${section[sectionKeys[1]]}</span>
            </div>
            <div class="ps-3 pe-5 pb-3 pt-2">
                <span class="fs-5" style="display:block" >${section[sectionKeys[2]]}</span>
                <span style="color: #A1A1A1">${section[sectionKeys[3]]}</span>
            </div>
            </div>`
}