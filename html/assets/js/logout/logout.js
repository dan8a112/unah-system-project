/**
 * Logica de cierre de sesión. Se debe importar en cada vista que contenga el botón de cerrar sesión.
 * Se debe asegurar que el botón tenga el id "logoutButton"
 * @author dochoao@unah.hn
 * @version 0.1.0
 * @date 2024-11-24
 */

import {Auth} from "../../js/modules/Auth.js"

//Se selecciona el boton de cerrar sesión
const logoutBtn = document.querySelector("button#logoutButton");

//Se obtiene el portal del dataset del boton logout de cada portal
//Cabe destacar que debe colocarse este valor para que el boton de cierre de sesion funcione correctamente
const portal = logoutBtn.dataset.portal;

logoutBtn.addEventListener("click", ()=>{Auth.logout(portal)});
