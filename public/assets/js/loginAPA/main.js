import { Action } from "../loginSEDP/Action.js"

const loginForm = document.querySelector("#loginForm");

//Se envia el formulario de login con la ruta de la api y la ruta a redireccionar
loginForm.addEventListener("submit", (e)=>{
    Action.submitLoginForm(e,"../../../api/post/loginAdmission", "../admission/administrative_home.php")
} );