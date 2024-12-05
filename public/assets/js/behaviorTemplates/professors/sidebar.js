/**
 * Cada numero representa el id del tipo de maestro 
 * y los elementos que se renderizan solo para ese usuario en el sidebar
 */
const sideBarElements = {
    1:[],
    2:[],
    3:[],
    4:[
        {
            text: "Secciones",
            img: "/assets/img/icons/Classes.svg",
            href: "#"
        },
        {
            text: "Evaluaciones",
            img: "/assets/img/icons/evaluation-yellow.svg",
            href: "#"
        },
        {
            text: "Calificaciones",
            img: "/assets/img/icons/percent.svg",
            href: "#"
        }
    ]
}

//Elemento contenedor del sidebar
const sideBar = document.querySelector("#sideBar");

//Parametros de la url
const params = new URLSearchParams(window.location.search);

//Parametro de tipo de profesor
const professorType = params.get("type");


if (professorType!=null) {
    //Recorre el array y genera los elementos
    sideBarElements[professorType].forEach(element=>{

        const menuItem = document.createElement("a");
        menuItem.classList.add("menu-item");
        menuItem.setAttribute("href", element.href);

        const image = document.createElement("img");
        image.classList.add("icon");
        image.setAttribute("src", element.img);

        const text = document.createElement("span");
        text.classList.add("menu-item-text");
        text.innerText = element.text;

        menuItem.appendChild(image);
        menuItem.appendChild(text);
        sideBar.appendChild(menuItem);
    })
}

//Se selecciona el item que se debe seleccionar
const selectedIndex = sideBar.dataset.selectedIndex;

//Si el index existe en el dataset se agrega clase que marca el elemento como seleccionado
if (selectedIndex) {
    const selectedItem = document.querySelectorAll(".menu-item")[ selectedIndex - 1 ]    
    selectedItem.classList.add("selected-item");
}else{
    console.error("Error: No se establecio el indice seleccionado")
}
