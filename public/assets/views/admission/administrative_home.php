<?php
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  if (!SessionValidation::isValid($_SESSION, "apa")){
    header("Location: /assets/views/logins/login_apa.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="afcastillof@unah.hn">
    <meta name="date" content="11/11/2024">
    <meta name="version" content="0.1.1">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/admission/admision_home.css">
    <link rel="stylesheet" href="../../css/admission/timeline.css">


    <title>Document</title>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg" style="background-color: #F4F7FB;">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">
            <img src="../../img/landing/unah-logo.png" alt="Bootstrap" width="100px" class="ms-5">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="ms-4 mt-3">
            <h1 class="mb-0">Portal Admisiones</h1>
            <p>Administración del proceso de admision de la unah</p>
          </div>
          <div class="collapse navbar-collapse d-flex flex-row-reverse me-5" id="navbarNavDropdown">
            <ul class="navbar-nav gap-3">
              <li class="nav-item">
                <button class="btn d-flex align-items-center" style="background-color: #3472F8; color: #F4F7FB;" id="logoutButton">
                    <img src="../../img/icons/logout-icon.svg" alt="" class="me-2">
                    Cerrar Sesión
                </button>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div style="height: 3px; background-color: #FFAA34; width: 100%;"></div>



    <section class="section" id="containerSection">
        <section class="title">
            <h1>Benvenido al portal de admisiones</h1>
        </section>
        <section id="containerFirst" class="responsive-container">

          <canvas id="admissionChart" width="400" height="250" style="background-color: #fff; border-radius: 15px;"></canvas>
        </section>
        
        <section class="title">
          <h1>Revisa los procesos de admision</h1>
        </section>


        <section>
          <div class="timeline" id="timeline">            
          </div>
          
        </section>


    </section>
    

    <script src="../../js/admission/home_administration/main.js" type="module"></script>
    

</body>
</html>
