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
        header("Location: /assets/views/administration/coordinators/students.php?id=" . $userId);
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
        $selected = 3;
        include_once($path . "templates/professors/coordinatorsSidebar.php");
        ?>

        <section class="col mx-5">

            <div class="row align-items-center">

                <div class="my-4 col-7">
                    <div class="d-flex align-items-center ">
                        <h1 class="display3 me-3" id="processName">Estudiantes</h1>
                        <div class="status-card" style="background-color: #00C500;" id="periodName"></div>
                    </div>
                    <span>En esta pantalla podras buscar a caulquier estudiante matriculado en la Universidad</span>
                </div>
            </div>

            <div id="content" class="mt-2 d-flex-row">
            <div class="mt-2 d-flex align-items-center justify-content-end">
                <span class="me-3">Busca a un estudiante por su número de cuenta:</span>
                <form id="search-form" class="input-group w-50">
                    <input type="text" name="acount" class="form-control" id="search-input" placeholder="Buscar por nombre o número de cuenta">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
            <hr class="w-20 mt-5">
            <span style="font-weight: bold;" >Resultados:</span>
                <div id="section-table">
                </div>
            </div>
            <div id="no-search-message" class="alert alert-info mt-3 w-100 text-center">
                Aún no ha realizado una búsqueda.
            </div>

        </section>
    </main>


    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script src="../../../js/administration/coordinators/academic_historic/main.js" type="module"></script>
    <script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>