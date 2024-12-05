<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/animations/slides.css">
    <link rel="stylesheet" href="../../css/informative/informativePage.css">
    <title>UNAH Inicio</title>
</head>
<body>
    <?php 
      $path = "../";
      include_once($path . "templates/headerPublic.php");
    ?>

    <div class="containerr">
    <img src="../../img/login/admissions_login.png" alt="Descripción de la imagen">
    <h1>Admisiones UNAH</h1>
    </div>

    <div class="slide-up col mx-5 p-2">
        <h1 class="display-4 mb-4">¿Como funciona el sistema de admisiones en la UNAH?</h1>
        <p class="fs-5">Es una unidad académica perteneciente a la Vicerrectoría Académica, con funciones propias y especializadas para garantizar una admisión transparente, eficiente, de calidad, con equidad y participación democrática, para todos los aspirantes de primer ingreso a la UNAH, para estudiantes que teniendo un título de grado de esta u otras universidades desean cursa otra carrera de grado y los estudiantes de reingreso que desean cambio de carrera.</p>
        <a class="btn" style="background-color: #FFAA34;" id="admissionButton" href="/assets/views/admission/inscription_view.php">Ingresa ahora</a>
    </div>
        

    <?php 
        $path = "../";
        include_once($path . "templates/footer.php");
    ?>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>