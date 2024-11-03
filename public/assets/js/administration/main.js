import {Modal} from "../modules/Modal.js"

const formModal = document.querySelector("#formModal");
const createButton = document.querySelector("#createBtn");

createButton.addEventListener('click', Modal.openModal.bind(this,formModal));