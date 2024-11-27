import { HttpRequest } from "./HttpRequest.js";

/**
 * Logica de autenticación genérica, donde se llaman a las apis de inicio y cierre de sesión.
 * @author dochoao@unah.hn
 * @version 0.1.0
 * @date 2024-11-24 
 */
class Auth {

    /**
     * Envia el formulario de inicio de sesión y llama a la api que se pasa como parametro para validar las credenciales.
     * @param {*} event evento "submit" del formulario
     * @param {*} url url de la api que hace el inicio de sesion
     * @param {*} redirect url de la pagina a la que se redirecciona si las credenciales son validas
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 2024-11-24 
     */
    static async submitLoginForm(event, url, redirect){

        event.preventDefault();

        //Se envia el formulario con correo y contraseña
        const data = await HttpRequest.submitForm(event,url);

        //Se evalua la respuesta
        if (data.status==1) {
            //redirecciona a pagina principal
            window.location.href = redirect
        
        }else{
            const errorSection = document.querySelector("#errorSection");

            errorSection.innerHTML = "";
            const errorText = document.createElement("p");
            
            //Se genera un texto de error
            errorText.innerText =  data.message;
            errorText.style.color = "red";
            errorSection.appendChild(errorText);
        }
    }

    /**
    * Llama a la api que cierra la sesion y redirecciona al home
    * @author dochoao@unah.hn
    * @version 0.1.0
    * @date 2024-11-24 
    */
    static async logout() {
        const response = await HttpRequest.get("../../../api/get/logout");
        if (response.status) {
            window.location.href = "/"
        }
    }

}

export {Auth}