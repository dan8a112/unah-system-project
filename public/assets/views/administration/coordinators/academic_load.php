<?php
include_once("../../../../../src/SessionValidation/SessionValidation.php");

session_start();

$portal = "coordinators";

if (!SessionValidation::isValid($_SESSION, $portal)) {
    header("Location: /assets/views/logins/login_coordinators.php");
} else {

    $userId = $_SESSION['portals'][$portal]['user'];

    //Si los parametros no coinciden con los de la sesion se corrigen
    if (!SessionValidation::validateParam("id", $userId)) {
        header("Location: /assets/views/administration/coordinators/academic_load.php?id=" . $userId);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secciones</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/temas/cards.css">
    <link rel="stylesheet" href="../../../css/templates/professor.css">
</head>

<body>
    <?php
    $portal = "coordinators";
    $title = "Portal Coordinadores de carrera";
    $description = "Coordinadores de carrera, administra los procesos estudiantiles.";
    $path = "../../";
    include_once($path . "templates/headerAdmission.php");
    ?>

    <main class="row">

        <?php
        $path = "../../";
        $selected = 1;
        include_once($path . "templates/professors/coordinatorsSidebar.php");
        ?>

        <section class="col mx-5">

            <div class="row align-items-center">

                <div class="my-4 col-7">
                    <div class="d-flex align-items-center ">
                        <h1 class="display3 me-3" id="processName">Carga Academica</h1>
                        <div class="status-card" style="background-color: #00C500;" id="periodName"></div>
                    </div>
                    <span>Visualiza y obtiene una copia de la carga academica para este periodo</span>
                </div>

                <div class="card-container d-flex align-items-center" style="width:fit-content; height: fit-content;">
                    <img src="/assets/img/icons/department.svg" alt="" class="me-3">
                    <span id="careertName" class="fs-6" style="font-weight: 500;"></span>
                </div>
            </div>
            <div class="btn" style="background-color: #304987;" id="downloadLoad">
                <img src="/assets/img/icons/downloadWhite.svg" alt="" class="me-2">
                <span style="color: #fff">Descargar carga</span>
            </div>
            

            <div class="mt-2 d-flex-col card-container">
                <div class="d-flex justify-content-between">
                    <div class="ms-2">
                        <span class="fs-4 me-2 fw-bold">Secciones de este periodo</span>
                    </div>
                    <div class="d-flex me-2 align-items-sm-center gap-2">
                        <h6>Periodo</h6>
                        <select class="form-select" aria-label="Default select example" id="period" name="period">
                            <option selected>Periodo Actual</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div id="section-table">
                </div>
            </div>

        </section>
    </main>

    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script src="../../../js/administration/coordinators/academic_load/main.js" type="module"></script>
    <script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>