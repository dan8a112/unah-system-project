import { Auth } from "../modules/Auth.js"
import { LOGIN_KEYS } from "./loginKeys.js"

const loginForm = document.querySelector("#loginForm");
const key = loginForm.dataset.loginKey;


loginForm.addEventListener("submit", 
    (e)=>{Auth.submitLoginForm(e,LOGIN_KEYS[key].apiUrl, LOGIN_KEYS[key].redirectUrl)} 
);