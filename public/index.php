<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animations/slides.css">
    <title>UNAH Inicio</title>
</head>
<body>
    <?php 
      $path = "./assets/views/";
      include_once($path . "templates/headerPublic.php");
    ?>

        <div class="row align-items-center justify-content-center mt-5 gap-4 mx-5">
          <div class="slide-up col">
              <h1 class="display-4 mb-4">Emprende tu carrera universitaria aqui</h1>
              <p class="fs-5">UNAH es una institución autónoma, laica y estatal de la República de Honduras. Considerada por muchos la mejor universidad del pais, destaca por sus aportes tecnológicos y de investigación a la sociedad hondureña y extranjera.</p>
              <a class="btn" style="background-color: #FFAA34;" id="admissionButton" href="assets/views/informative/InformativeAdmission.php">Ingresa ahora</a>
          </div>
          <img class="col primary-img" src="assets/img/landing/student-image.png" alt="Student Image">
        </div>
          
        <div class="d-flex-col mt-3" style="gap: 100px;">
            <h2 class="mb-5 text-center" >Las carreras del momento</h2>
            <div class="d-flex justify-content-evenly space-between mb-4 gap-4 flex-wrap">
                    <div class="card" style="width: 18rem;">
                        <img src="assets/img/landing/is-image.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Ingenieria en sistemas</h5>
                          <p class="card-text">es un campo interdisciplinario de la ingeniería que permite estudiar y comprender la realidad, con el enfoque de implementar u optimizar sistemas complejos.</p>
                        </div>
                      </div>
        
                      <div class="card" style="width: 18rem;">
                        <img src="assets/img/landing/le-image.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Lenguas extranjeras</h5>
                          <p class="card-text">Esta carrera está dirigida a formar docentes especializados en la enseñanza de lenguas extranjeras. Su primera función es la de preparar al estudiante en el manejo de dos o más lenguas extranjeras</p>
                        </div>
                      </div>
        
                      <div class="card" style="width: 18rem;">
                        <img src="assets/img/landing/ps-image.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Psicologia</h5>
                          <p class="card-text">La Carrera de Psicología, educa futuros psicólogos capacitados para desarrollar las siguientes actividades: Prevención en salud mental, consejería, evaluaciones...</p>
                        </div>
                      </div>
                </div>
        </div>

        <?php 
          $path = "./assets/views/";
          include_once($path . "templates/footer.php");
        ?>

        <div class="modal" tabindex="-1" id="modalDom">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Procesos de admision</h5>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary" href="#" id="closeModal">Ok.</button>
              </div>
            </div>
          </div>
        </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/landingPage/main.js" type="module"></script>
</body>
</html>