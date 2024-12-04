<section class="side-bar" class="col-3">
    <a class="menu-item">
        <img src="<?php echo $pathImg.'img/icons/Classes.svg'?>" alt="" class="icon">
        <span class="menu-item-text">Tus Clases</span>
    </a>
    <a class="menu-item">
        <img src="<?php echo $pathImg.'img/icons/cap-yellow.svg'?>" alt="" class="icon">
        <span class="menu-item-text">Periodos anteriores</span>
    </a>
</section>
<script>
    //Se selecciona el item que se debe seleccionar
    const selectedItem = document.querySelectorAll(".menu-item")[ <?php echo $selected;?> - 1 ]
    selectedItem.classList.add("selected-item");
</script>