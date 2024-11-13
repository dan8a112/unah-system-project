import { HttpRequest } from "../modules/HttpRequest.js";

class Action {

    static async submitLoginForm(event, url, redirect){

        event.preventDefault();

        //Se envia el formulario con correo y contraseña
        const data = await HttpRequest.submitForm(event,url);

        //Se evalua la respuesta
        if (data.status==1 || data.status==0) {
            //redirecciona a pagina principal
            window.location.href = redirect
        
        }else{
            const errorSection = document.querySelector("#errorSection");

            const errorText = document.createElement("p");
            //Se genera un texto de error
            errorText.innerText =  "El correo o la contraseña es incorrecto, vuelva a intentarlo."
            errorText.style.color = "red";
            errorSection.appendChild(errorText);
        }
    }

}

export {Action}