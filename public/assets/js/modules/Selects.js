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
     * @param {String} defaultSelect El texto de la opcion por defecto que se muestra en el select
     * e.g. [{productId: 1, name: "box"}] el valueKey es "productId" y el labelKey es "name"
     */
    static renderSelect(selectDom,data,valueKey,labelKey, first, defaultSelect){

        //Si no es primera renderizacion (actualizacion de select)
        if (!first) {
            //Se limpia el select con el option por defecto
            selectDom.innerHTML = `<option selected>${defaultSelect!=null ? defaultSelect : "Seleccione una opcion"}</option>`;
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


    /**
     * @author dochoao@unah.hn
     * @date 6/11/24
     * Este método se encarga de agregarles un dataset a cada option del select, excepto al que tiene el parámetro default.
     * @param {Element} selectDom El nodo "select" del DOM.
     * @param {Array} data El array de objetos con los datos a asociar.
     * @param {String} valueKey La llave correspondiente al value del option.
     * @param {String} datasetName El nombre del dataset.
     */
    static addDataset(selectDom, data, matchingKey, valueKey, datasetName) {

        if (!selectDom || !data || !valueKey || !datasetName || !matchingKey) {
            console.error("No se envian todos los parametros para ejecutar el método.");
            return;
        }

        // Iterar sobre las opciones del select
        Array.from(selectDom.options).forEach(option => {
            const value = option.value;

            // Buscar en la data el objeto correspondiente al value del option
            const matchingItem = data.find(item => String(item[matchingKey]) === value);

            if (matchingItem) {
                // Agregar el dataset correspondiente
                option.dataset[datasetName] = matchingItem[valueKey];
            } else {
                // Eliminar el dataset si no hay match
                delete option.dataset[datasetName];
            }
        });
    }

}

export{Selects}