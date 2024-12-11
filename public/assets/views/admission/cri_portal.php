<?php
include_once("../../../../src/SessionValidation/SessionValidation.php");

session_start();

if (!SessionValidation::isValid($_SESSION, "cri")) {
    header("Location: /assets/views/logins/login_cri.php");
} else {

    $userId = $_SESSION['portals']['cri']['user'];

    if (!isset($_GET['id']) || empty($_GET['id']) || $_GET['id'] != $userId) {
        header("Location: /assets/views/admission/cri_portal.php?id=" . $userId);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal CRI</title>
    <link rel="stylesheet" href="../../css/temas/cards.css">
    <link rel="stylesheet" href="../../css/admission/cri_portal.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body style="background-color: #FBF9F4;">
    <?php
    $title = "Portal CRI";
    $description = "Comite de revision de Inscripciones de procesos de admision de la UNAH";
    $portal = "cri";
    $path = "../";
    include_once($path . "templates/headerAdmission.php");
    ?>

    <div class="container mb-5">

        <section class="my-4">
            <div class="d-flex align-items-center">
                <h1 class="me-3">Revision de inscripciones</h1>
                <div class="status-card" style="background-color: #00C500;" id="periodName"></div>
            </div>
            <p>A continuación encontrará información y estadísticas sobre este proceso de admisión.</p>
        </section>

        <section class="row mb-4 gap-5">
            <div class="card-container col-4">
                <div class="d-flex align-items-center">
                    <img src="../../img/icons/state-icon.svg" alt="" class="me-2">
                    <span>Meta de Hoy</span>
                </div>
                <div class="d-flex center align-items-center" style="height: 80%;">
                    <h1 class="display-6 ms-5" style="font-weight: 400;" id="dailyGoal"></h1>
                </div>
            </div>
            <div class="card-container col-4">
                <div class="d-flex align-items-center">
                    <img src="../../img/icons/inscription-icon.svg" alt="" class="me-2">
                    <span>Cantidad Total Revisadas</span>
                </div>
                <div class="d-flex align-items-center" style="height: 80%;">
                    <h1 class="display-6 ms-5" style="font-weight: 400;" id="totalReviewed"></h1>
                </div>
            </div>
        </section>

        <section class="my-4">
            <h3 class="me-3">Inscripciones Por revisar</h3>
            <p>En esta seccion se muestran las inscripciones que aun no has revisado, puedes empezar a revisar ahora y cumplir con la meta del día!</p>
        </section>

        <div class="mt-2 d-flex-col card-container">
            <div class="ms-2">
                <span class="fs-4 me-2">Inscripciones sin revisar</span>
                <span class="status-card" style="background-color: #c3c3c3;" id="amountUnreviewed"></span>
            </div>
            <hr>
            <div id="unreviewedTbl">
            </div>
        </div>

        <section class="my-4">
            <h3 class="me-3">Inscripciones Revisadas</h3>
            <p>En esta seccion se muestran las inscripciones que ya revisaste, toma en cuenta que las revisiones con un dictamen de rechazo se eliminaran y solo aparecen de manera temporal.</p>
        </section>

        <div class="mt-2 d-flex-col card-container">
            <div class="ms-2">
                <span class="fs-4 me-2">Inscripciones revisadas</span>
                <span class="status-card" style="background-color: #c3c3c3;" id="amountReviewed"></span>
            </div>
            <hr>
            <div id="reviewedTbl">
            </div>
        </div>

    </div>

    <div class="modal fade" tabindex="-1" id="reviewModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Datos de inscripcion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mx-3 row mb-4">
                        <section class="col">
                            <div class="mb-3">
                                <div class="fs-5">Datos Personales</div>
                                <div class="line-separator"></div>
                                <div id="personalData">
                                    <div class="row mb-2">
                                        <span class="text-description">Nombre Completo</span>
                                        <span class="text-information"></span>
                                    </div>
                                    <div class="row mb-2">
                                        <span class="text-description">Numero de identidad</span>
                                        <span class="text-information"></span>
                                    </div>
                                    <div class="row mb-2">
                                        <span class="text-description">Numero de telefono</span>
                                        <span class="text-information"></span>
                                    </div>
                                    <div class="row mb-2">
                                        <span class="text-description">Correo Electronico</span>
                                        <span class="text-information"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="fs-5">Datos de inscripcion</div>
                                <div class="line-separator"></div>
                                <div id="inscriptionData">
                                    <div class="row mb-2">
                                        <span class="text-description">Primera Opcion</span>
                                        <span class="text-information"></span>
                                    </div>
                                    <div class="row mb-2">
                                        <span class="text-description">Segunda Opcion</span>
                                        <span class="text-information"></span>
                                    </div>
                                    <div class="row mb-2">
                                        <span class="text-description">Campus</span>
                                        <span class="text-information"></span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section id="fileSection" class="col-8">

                        </section>
                    </div>

                    <section class="mb-4 mx-4">
                        <div class="mb-4">
                            <p style="font-size: 1.1rem; font-weight: 500;">¿Ya revisaste los datos de inscripcion?</p>
                            <p>Puedes decidir si aprobar o rechazar esta inscripcion</p>
                        </div>
                        <div class="row gap-3" id="approveButtons">
                            <button class="col btn btn-danger" id="denyInscriptionBtn">Rechazar</button>
                            <button class="col btn btn-success" id="approveInscriptionBtn">Aprobar</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/logout/logout.js" type="module"></script>
    <script src="../../js/admission/portal_cri/main.js" type="module"></script>
</body>

</html>