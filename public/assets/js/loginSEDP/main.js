import { Action } from "./Action.js"

const loginForm = document.querySelector("#loginForm");

loginForm.addEventListener("submit", (e)=>{Action.submitLoginForm(e)} );