//Se selecciona el item que se debe seleccionar
const selectedIndex = sideBar.dataset.selectedIndex;

//Si el index existe en el dataset se agrega clase que marca el elemento como seleccionado
if (selectedIndex) {
    const selectedItem = document.querySelectorAll(".menu-item")[ selectedIndex - 1 ]    
    selectedItem.classList.add("selected-item");
}else{
    console.error("Error: No se establecio el indice seleccionado")
}
