<?php
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  $portal = "professors";

  if (!SessionValidation::isValid($_SESSION, $portal)){
    header("Location: /assets/views/logins/login_professors.php");
  }else{

    $userId = $_SESSION['portals'][$portal]['user'];

    //Si los parametros no coinciden con los de la sesion se corrigen
    if (!SessionValidation::validateParam("id", $userId)) {
        header("Location: /assets/views/professors/class_detail.php?id=".$userId);
        exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Docentes</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/templates/professor.css">
    <link rel="stylesheet" href="../../css/temas/cards.css">
    <link rel="stylesheet" href="../../css/admission/process_detail.css">
    <link rel="stylesheet" href="../../css/templates/breadCrumb.css">
    <link rel="stylesheet" href="../../css/temas/popup.css">
</head>

<body style="background-color: #FBF9F4;">
    <?php
        $title = "Portal Docentes";
        $description = "Administra tus clases y otros procesos del periodo academico";
        $path = "../";
        include_once($path . "templates/headerAdmission.php");
    ?>

    <main class="row">

        <?php
            $path = "../";
            $selected = 1;
            include_once($path . "templates/professors/professorSidebar.php");
        ?>

        <section class="col ms-4" style="margin-right: 1.7rem">
            <?php 
                $path = "../";
                $links = [
                    ['title' => 'Tus clases', 'url' => '/assets/views/professors/home_professors.php'],
                    ['title' => 'Detalle de clase', 'url' => '/calificaciones']
                ];

                include_once($path . "templates/breadCrumb.php");
            ?>
            <section class="my-4">
                <div class="d-flex align-items-center">
                    <h1 class="display3 me-3" id="className"></h1>
                    <div class="status-card" style="background-color: #00C500;" id="currentPeriod"></div>
                </div>
                <p id="denomination"></p>
            </section>
          
            <section class="row mb-4 gap-5">
                <div class="card-container col">
                    <div class="d-flex align-items-center mb-2">
                        <img src="../../img/icons/Clock.svg" alt="" class="me-2">
                        <span style="font-weight: 600;">Horarios</span>
                    </div>
                    <div class="dates-container">
                        <div class="mb-2">
                            <span class="fw-bolder">Inicio</span>
                            <p class="font-medium" id="startHour"></p>
                        </div>
                        <div>
                            <span class="fw-bolder">Fin</span>
                            <p class="font-medium" id="finishHour"></p>
                        </div>
                    </div>
                </div>
                <div class="card-container col">
                    <div class="d-flex align-items-center">
                        <img src="../../img/icons/people.svg" alt="" class="me-2">
                        <span >Cantidad de alumnos</span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center" style="height: 80%;">
                        <h1 style="font-size: 1.7rem; font-weight: 400;" id="amountStudents"></h1>
                    </div>
                </div>
                <div class="card-container col">
                    <div class="d-flex align-items-center">
                        <img src="../../img/icons/inscription-icon.svg" alt="" class="me-2">
                        <span id="amountBox">Unidades valorativas</span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 80%;">
                        <h1 class="display-6" style="font-weight: 400;" id="valueUnits"></h1>
                        <h1 class="display-6" style="font-weight: 600; font-size:1.0rem" id="days"></h1>
                    </div>
                </div>
            </section>
            <a class="btn" style="background-color: #304987; margin-bottom: 20px;" id="downloadStudents">
                <img src="/assets/img/icons/downloadWhite.svg" alt="" class="me-2">
                <span style="color: #fff">Descargar Lista de estudiantes</span>
            </a>
            <section id="upload_csv" class="mb-4 row">
            </section>
            <div id="contentt"></div>

            <div id="section-table"></div>
            
        </section>
    </main>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="formModal">Subir archivo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCsv">
                <div class="modal-body">
                    <div class="container">
                        <div class="mb-3">
                            <p class="fs-5">Subir calificaciones de estudiantes</p>
                            <p>A continuacion puedes subir las calificaciones que obtuvieron los estudiantes en el periodo</p>
                        </div>
                        <input class="form-control mb-3" type="file" name="pathCsvGrades" required>
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal">Close</button>
                    <button class="button-upload btn me-3" id="uploadCsv" style="height: 40px;" type="submit">
                            <img src="../../img/icons/upload.svg" alt="" class="me-2">
                            <span>Subir</span>
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="uploadVideoModal" tabindex="-1" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="formModal">Subir video</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formVideo">
                <div class="modal-body">
                    <div class="container">
                        <div class="mb-3">
                            <p class="fs-5">Subir Video de presentacion</p>
                            <p>A continuacion puedes subir un video de presentacion para tus estudiantes.</p>
                        </div>
                        <input class="form-control mb-3" type="file" name="video" required>
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal">Close</button>
                    <button class="button-upload btn me-3" id="uploadVideo" style="height: 40px;" type="submit">
                            <img src="../../img/icons/upload.svg" alt="" class="me-2">
                            <span>Subir</span>
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="popup" id="popupError" style="border: solid 1px #EC0000;">
      <img src="../../img/icons/error.svg" alt="">
      <h2>Error!</h2>
      <p id="message"></p>
      <button type="button" id="buttonOk2">OK</button>
    </div>
    <div class="popup" id="popup">
      <img src="../../img/icons/check.svg" alt="">
      <h2>Felicidades!</h2>
      <p id="exitMessage"></p>
      <button type="button" id="buttonOk1">OK</button>
    </div>

    <!-- Loader Overlay -->
<!-- Loader Overlay -->
<div id="loadingOverlay" style="
    display: none; 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background: rgba(0,0,0,0.5); 
    z-index: 9999; 
    justify-content: center; 
    align-items: center; 
    flex-direction: column;">
    
    <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Cargando...</span>
    </div>
    <p style="margin-top: 1rem; color: white; font-size: 1.5rem;">Subiendo...</p>
</div>


    
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/professors/detail_section/main.js" type="module"></script>
    <script src="../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>