/**
 * @description Comportamiento de sidebar para seleccionar un item en especifico
 * @author dochoao@unah.hn
 * @version 0.1.0
 * @date 26/11/24
 */

//Se selecciona el item que se debe seleccionar
const selectedIndex = sideBar.dataset.selectedIndex;

//Si el index existe en el dataset se agrega clase que marca el elemento como seleccionado
if (selectedIndex) {
    const selectedItem = document.querySelectorAll(".menu-item")[ selectedIndex - 1 ]    
    selectedItem.classList.add("selected-item");
}else{
    console.error("Error: No se establecio el indice seleccionado")
}
