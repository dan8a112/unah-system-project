import { HttpRequest } from '../../modules/HttpRequest.js';


const logoutButton = document.querySelector("button#logoutButton");

logoutButton.addEventListener("click",async ()=>{
    const response = await HttpRequest.get("../../../api/get/logout/");
    if (response.status) {
        window.location.href = "/"
    }
})