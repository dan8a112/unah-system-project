import {Modal} from "../modules/Modal.js"
import {Selects} from "../modules/Selects.js"
import { Action } from "./Action.js";

const formModal = document.querySelector("#formModal");
const createButton = document.querySelector("#createBtn");

createButton.addEventListener('click', Modal.openModal.bind(this,formModal));

const professorTypesSelect = document.querySelector("select#professorTypeSelect");

const prueba = [
    {
        "id":1,
        "name":"Opcion1"
    },
    {
        "id":2,
        "name": "Opcion2"
    }
]

Selects.renderSelect(professorTypesSelect,prueba,"id","name");