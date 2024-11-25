/**
 * Logica de cierre de sesión. Se debe importar en cada vista que contenga el botón de cerrar sesión.
 * Se debe asegurar que el botón tenga el id "logoutButton"
 * @author dochoao@unah.hn
 * @version 0.1.0
 * @date 2024-11-24
 */

import {Auth} from "../../js/modules/Auth.js"

const logoutBtn = document.querySelector("button#logoutButton");

logoutBtn.addEventListener("click", Auth.logout);
