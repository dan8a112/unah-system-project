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
    
    <?php 
      $path = "../";
      include_once($path . "templates/headerAdmission.php");
    ?>



    <section class="section" id="containerSection">
        <section class="title">
            <h1>Benvenido al portal de admisiones</h1>
            <p>Este es el portal oficial del proceso de admisiones. Aquí encontrarás herramientas y recursos que facilitan la gestión y el seguimiento de todo lo relacionado con los porcesos de admicion de la universidad.</p>
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
