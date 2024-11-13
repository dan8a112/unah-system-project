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
    <title>X Proceso de admisión</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/admission/process_detail.css">
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

    <div class="container mb-5" id="processContent">

        <section class="my-4">
            <div class="d-flex align-items-center">
                <h1 class="display3 me-3" id="processName"></h1>
                <div class="status-card">Finalizado</div>
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
                    <span>Cantidad de aprobados</span>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="height: 80%;">
                    <h1 class="display-6" style="font-weight: 400;" id="amountApprobed">400</h1>
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

        <div class="row gap-5">

          <div class="card-container col-8">
                  <p class="fs-2">Calificaciones mas altas</p>
                  <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Carrera principal</th>
                          <th scope="col">Puntaje</th>
                        </tr>
                      </thead>
                      <tbody id="higherScoreTbl"></tbody>
                  </table>
          </div>

          <div class="card-container col" id="amountCentersContainer">
                  <div class="d-flex align-items-center">
                      <img src="../../img/icons/graduation-icon.svg" alt="" class="me-2">
                      <span>Inscripciones por centro</span>
                  </div>
          </div>
      </div>
    </div>

    <div class="modal" tabindex="-1" id="modalDom">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Procesos de admision</h5>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <a type="button" class="btn btn-primary" href="../admission/administrative_home.html">Regresar a Inicio</a>
          </div>
        </div>
      </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script type="module" src="../../js/admission/process_detail_historic/main.js"></script>
</body>
</html>