import { Auth } from "../../modules/Auth.js"

const loginForm = document.querySelector("#loginForm");

//Se envia el formulario de login con la ruta de la api y la ruta a redireccionar
loginForm.addEventListener("submit", (e)=>{
    Auth.submitLoginForm(e,"../../../api/post/login/loginCRI/", "../admission/cri_portal.php")
} );