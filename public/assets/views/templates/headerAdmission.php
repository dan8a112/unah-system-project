<nav class="navbar navbar-expand-lg" style="background-color: #F4F7FB;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
        <img src="/assets/img/landing/unah-logo.png" alt="Bootstrap" width="100px" class="ms-5">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="ms-4 mt-3">
        <h1 class="mb-0"><?php echo isset($title) ? $title : "Portal" ?></h1>
        <p><?php echo isset($description) ? $description : "Portal de administración de la UNAH" ?></p>
        </div>
        <div class="collapse navbar-collapse d-flex flex-row-reverse me-5" id="navbarNavDropdown">
        <ul class="navbar-nav gap-3">
            <li class="nav-item">
            <button 
            class="btn d-flex align-items-center" 
            style="background-color: #3472F8; color: #F4F7FB;" 
            id="logoutButton" 
            data-portal="<?php echo $portal?>">
                <img src="/assets/img/icons/logout-icon.svg" alt="" class="me-2">
                Cerrar Sesión
            </button>
            </li>
        </ul>
        </div>
    </div>
</nav>
<div style="height: 3px; background-color: #FFAA34; width: 100%;"></div>
<script src="/assets/js/logout/logout.js" type="module"></script>
