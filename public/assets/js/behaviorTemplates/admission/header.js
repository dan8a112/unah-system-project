import { HttpRequest } from '../../modules/HttpRequest.js';

/**
 * @description Comportamiento para cerrar sesion (Boton en header) 
 * @author dochoao@unah.hn
 * @version 0.1.0
 * @date 25/11/24
 */
const logoutButton = document.querySelector("button#logoutButton");

logoutButton.addEventListener("click",async ()=>{
    const response = await HttpRequest.get("../../../api/get/logout/");
    if (response.status) {
        window.location.href = "/"
    }
})