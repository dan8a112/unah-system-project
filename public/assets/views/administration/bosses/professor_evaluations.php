<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluaciones de docentes</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/temas/cards.css">
    <link rel="stylesheet" href="../../../css/templates/professor.css">
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
            <div class="my-4">
                <div class="d-flex align-items-center">
                    <h1 class="display3 me-3" id="processName">Evaluaciones de docentes</h1>
                </div>
                <p>En esta sección puedes evaluar el rendimiento de los docentes segun los estudiantes.</p>
            </div>

            <div class="mt-5 d-flex-col card-container">
                <div class="d-flex justify-content-between">
                    <div class="ms-2">
                        <span class="fs-4 me-2 fw-bold">Docentes</span>
                    </div>
                    <div class="d-flex me-2">
                        <select class="form-select" name="period" id="periodSelect">
                            <option value="#">3 PAC 2024</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div id="section-table">
                </div>
            </div>

        </section>
    </main>

    <div class="modal fade" tabindex="-1" id="evaluationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/administration/bosses/evaluations/main.js" type="module"></script>
    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>
</html>