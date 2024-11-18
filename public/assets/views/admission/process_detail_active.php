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
    <meta name="author" content="dochoao@unah.hn">
    <meta name="date" content="11/11/2024">
    <meta name="version" content="0.1.0">
    <title>Proceso de admision actual</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/admission/process_detail.css">
    <link rel="stylesheet" href="../../css/temas/popup.css">
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
            <h1 class="mb-0">Portal ASA</h1>
            <p>Administracion de sistema de admisiones de la UNAH</p>
          </div>
          <div class="collapse navbar-collapse d-flex flex-row-reverse me-5" id="navbarNavDropdown">
            <ul class="navbar-nav gap-3">
              <li class="nav-item">
                <button class="btn d-flex align-items-center" style="background-color: #3472F8; color: #F4F7FB;">
                    <img src="../../img/icons/logout-icon.svg" alt="" class="me-2">
                    Cerrar Sesión
                </button>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <div style="height: 3px; background-color: #FFAA34; width: 100%;"></div>

    <div class="container mb-5">

        <section class="my-4">
            <div class="d-flex align-items-center">
                <h1 class="display3 me-3" id="processName"></h1>
                <div class="status-card" style="background-color: #00C500;">Activo</div>
            </div>
            <p>A continuación encontrará informacion y estadísticas sobre este proceso de admisión.</p>
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
                    <h1 class="display-6" style="font-weight: 400;" id="admissionState">Inscripciones</h1>
                </div>
            </div>
            <div class="card-container col">
                <div class="d-flex align-items-center">
                    <img src="../../img/icons/inscription-icon.svg" alt="" class="me-2">
                    <span>Cantidad de inscripciones</span>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="height: 80%;">
                    <h1 class="display-6" style="font-weight: 400;" id="amountInscriptions">80</h1>
                </div>
            </div>
        </section>

        
        <section id="upload_csv" class="mb-4 row">
            <div class="card-container d-flex justify-content-between">
                <div>
                    <p class="font-medium">Subida de calificaciones</p>
                    <p>El proceso de admisión está en publicacion de resultados puedes subir el archivo de calificaciones aqui.</p>
                </div>
                <button class="button-upload btn" id="uploadCsvBtn">
                    <img src="../../img/icons/upload.svg" alt="" class="me-2">
                    <span>Subir CSV</span>
                </button>
            </div>
        </section>


        <section id="unload_csv" class="mb-4 row">
            <div class="card-container d-flex justify-content-between">
                <div>
                    <p class="font-medium">Generar CSV</p>
                    <p>Genera un archivo csv con todos los estudiante aprobados de este proceso de admision.</p>
                </div>
                <button class="button-upload btn" id="downloadCsvBtn">
                    <img src="../../img/icons/download.svg" alt="" class="me-2">
                    <span>Descargar CSV</span>
                </button>
            </div>
        </section>


        <section class="row">
            <div class="card-container">
                <p class="fs-2">Ultimas inscripciones</p>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Carrera principal</th>
                        <th scope="col">Fecha de inscripcion</th>
                      </tr>
                    </thead>
                    <tbody id="lastInscriptionsTbl">    
                    </tbody>
                  </table>
            </div>
        </section>
    </div>

    <div class="popup" id="popupError" style="border: solid 1px #EC0000;">
        <img src="../../img/icons/error.svg" alt="">
        <h2>Error!</h2>
        <p id="message"></p>
        <button type="button" id="buttonClose">OK</button>
    </div>

    <script type="module" src="../../js/admission/process_detail_active/main.js"></script>
</body>
</html>