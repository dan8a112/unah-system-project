/**
 * Esta clase contiene logica relacionada con 
 * funcionalidades reutilizables de formularios.
* @author dochoao@unah.hn
* @version 0.1.0
* @date 18/11/24
 * 
 */

class Forms{

    /**
     * Se encarga de llenar la informacion de un formulario que tiene el objetivo de ofrecer la funcionalidad de editar.
     * @param {Object} data objeto que contiene los datos que seran insertados en el formulario.
     * @param {Element} form elemento form(nodo del dom) que se desea llenar.
     * Es importante que las llaves del objeto coincidan con el name de los inputs del formulario.
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 18-11-24
    */
    static fillFieldsEdit(data, form){

        // Iterar sobre las claves del objeto y asignar los valores a los inputs correspondientes
        for (const key in data) {
            //Se verifica si las propiedades son propias
            if (data.hasOwnProperty(key)) {
                //Se obtiene el input con el name 
                const input = form.querySelector(`[name="${key}"]`);
                
                if (input) {
                    // Si el input es un select o input normal, asignar el valor
                    if (input.tagName === "SELECT" || input.tagName === "INPUT") {
                        input.value = data[key];
                    }
                }
            }
        }
    }

    static clearFields(form){

        const fields = form.querySelectorAll("input");

        fields.forEach(field => {
            field.value = "";
        });

    }
}

export {Forms}