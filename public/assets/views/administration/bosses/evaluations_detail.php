<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluaciones de docentes</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/temas/cards.css">
    <link rel="stylesheet" href="../../../css/templates/professor.css">
    <link rel="stylesheet" href="../../../css/templates/breadCrumb.css">
</head>

<body>
    <?php
    $title = "Portal Jefes de departamentos";
    $description = "Jefes de departamento, administra los procesos de matricula y mas";
    $path = "../../";
    include_once($path . "templates/headerAdmission.php");
    ?>

    <main class="row">

        <?php
        $path = "../../";
        $selected = 2;
        include_once($path . "templates/professors/bossSidebar.php");
        ?>
        <section class="col mx-4">
            <?php
            $path = "../../";
            $links = [
                ['title' => 'Evaluaciones de docentes', 'url' => '/assets/views/administration/bosses/professor_evaluations.php'],
                ['title' => 'Docente', 'url' => '/evaluaciones']
            ];

            include_once($path . "templates/breadCrumb.php");
            ?>

            <section>
                <div class="mb-4">
                    <span class="fs-4" id="professorName">Docente: Jose Manuel Inestroza</span><br>
                    <span>Estas son las secciones que tiene asignadas el docente. <b>Selecciona</b> una para ver sus calificaciones</span>
                </div>
                <section id="sectionsContainer" class="d-flex gap-5 mb-4"></section>
            </section>
            <hr>
            <section class="mb-4 mx-3" id="evaluationsContainer"></section>
        </section>

    </main>

    <div class="modal fade" tabindex="-1" id="evaluationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="btnClose">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/administration/bosses/evaluations_detail/main.js" type="module"></script>
    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>