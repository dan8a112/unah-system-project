/**
 * Esta clase contiene logica relacionada con selects con el objetivo de reutilizar funcionalidades que tienen un alto
 * nivel de repitencia en el desarrollo del proyecto
* author: dochoao@unah.hn
* version: 0.1.0
* date: 6/11/24
 * 
 */
class Selects {
    
    /**
     * author: dochoao@unah.hn
     * date: 6/11/24
     * Este metodo se encarga de renderizar las opciones de un select de forma dinamica
     * @param {Element} selectDom El nodo "select" del dom
     * @param {Array} data Una lista de elementos que contienen un value y un label o nombre
     * @param {String} valueKey la llave correspondiente al value 
     * @param {String} labelKey la llave correspondiente al label
     * @param {Boolean} firstTime valor que indica si es primera vez que se renderiza o es una actualizacion.
     * e.g. [{productId: 1, name: "box"}] el valueKey es "productId" y el labelKey es "name"
     */
    static renderSelect(selectDom,data,valueKey,labelKey, first){

        //Si no es primera renderizacion (actualizacion de select)
        if (!first) {
            //Se limpia el select con el option por defecto
            selectDom.innerHTML = "<option selected>Seleccione una opcion</option>";
        }

        data.forEach(element => {
            //Crea elemento option
            const option = document.createElement("option");

            //Le agrega el atributo value
            option.setAttribute("value",element[valueKey]);

            //Le agrega el label
            option.innerText = element[labelKey];

            //Agrega la opcion al select
            selectDom.appendChild(option);
        })

    }

}

export{Selects}