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
    <meta name="author" content="dochoao@unah.hn, afcastillof@unah.hn">
    <meta name="date" content="24/11/2024">
    <meta name="version" content="0.1.3">
    <title>Proceso de admision actual</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/admission/process_detail.css">
    <link rel="stylesheet" href="../../css/temas/popup.css">
</head>
<body>
    <?php 
      $path = "../";
      include_once($path . "templates/headerAdmission.php");
    ?>

    <a class="btn btn-sm m-3" href="./administrative_home.php"><img src="../../img/icons/back-arrow.svg" alt=""></a>

    <div id="container" class="container mb-5">

        <section class="my-4">
            <div class="d-flex align-items-center">
                <h1 class="display3 me-3" id="processName"></h1>
                <div class="status-card" style="background-color: #00C500;">Activo</div>
            </div>
            <p>A continuación encontrará información y estadísticas sobre este proceso de admisión.</p>
        </section>
          
        <section class="row mb-4 gap-5">
            <div class="card-container col">
                <div class="d-flex align-items-center mb-2">
                    <img src="../../img/icons/date-icon.svg" alt="" class="me-2">
                    <span style="font-weight: 600;">Fechas</span>
                </div>
                <div class="dates-container">
                    <div class="mb-2">
                        <span class="font-mini">Inicio</span>
                        <p class="font-medium" id="startDate">18 de Marzo, 2024</p>
                    </div>
                    <div>
                        <span class="font-mini">Fin</span>
                        <p class="font-medium" id="finishDate">30 de mayo, 2024</p>
                    </div>
                </div>
            </div>
            <div class="card-container col">
                <div class="d-flex align-items-center">
                    <img src="../../img/icons/state-icon.svg" alt="" class="me-2">
                    <span >Estado de proceso</span>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="height: 80%;">
                    <h1 style="font-size: 1.7rem; font-weight: 400;" id="admissionState">Inscripciones</h1>
                </div>
            </div>
            <div class="card-container col">
                <div class="d-flex align-items-center">
                    <img src="../../img/icons/inscription-icon.svg" alt="" class="me-2">
                    <span id="amountBox">Cantidad de inscripciones</span>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="height: 80%;">
                    <h1 class="display-6" style="font-weight: 400;" id="amountInscriptions">80</h1>
                </div>
            </div>
        </section>

        
        <section id="upload_csv" class="mb-4 row">
        </section>


        <div id="contentt"></div>
    </div>

    <div class="popup" id="popupError" style="border: solid 1px #EC0000;">
        <img src="../../img/icons/error.svg" alt="">
        <h2>Error!</h2>
        <p id="message"></p>
        <button type="button" id="buttonClose">OK</button>
    </div>

    <div class="modal fade" id="uploadCSVModal" tabindex="-1" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="formModal">Subir calificaciones</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCsv">
                <div class="modal-body">
                    <div class="container">
                        <div class="mb-3">
                            <p class="fs-5">Subir archivo CSV</p>
                            <p>A continuacion se deben subir las calificaciones de los examenes de admisión</p>
                        </div>
                        <input class="form-control mb-3" type="file" name="pathCsvGrades" >
                       
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

    <div class="modal fade" id="sendEmails" tabindex="-1" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="formModal">Enviar resultados</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="mb-3">
                        <p class="fs-5">Mandar correos</p>
                        <p>Si presionas enviar se enviara un correo a todos los estudiantes con los resultados de sus pruebas.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal" id="closeModal">Close</button>
                <button class="button-upload btn me-3" id="sendEmailsButton" style="height: 40px; background-color:#3472F8">
                    <img src="../../img/icons/mail.svg" alt="" class="me-2" style="width: 24px;">
                    <span style="color:#fff">Enviar correos</span>
                </button>
            </div>

            </div>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script type="module" src="../../js/admission/process_detail_active/main.js"></script>
</body>
</html>