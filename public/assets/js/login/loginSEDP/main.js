import { Auth } from "../../modules/Auth.js"

const loginForm = document.querySelector("#loginForm");

loginForm.addEventListener("submit", 
    (e)=>{Auth.submitLoginForm(e,"../../../api/post/login/loginSEDP/", "../administration/sedp-portal.php")} 
);