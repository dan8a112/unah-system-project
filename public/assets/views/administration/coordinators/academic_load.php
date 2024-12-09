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
    $portal = "bosses";
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
            <div class="btn" style="background-color: #304987;">
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

    <div class="modal fade" tabindex="-1" id="addSectionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="addSectionForm" data-id-professor>
                        <div>
                            <label class="form-label">Selecciona una clase</label>
                            <select class="form-select" aria-label="Default select example" name="class" id="classesSelect" required>
                                <option selected>Clases</option>
                            </select>
                        </div>
                        <div class="row my-2">
                            <div class="col">
                                <label class="form-label">Hora de inicio</label>
                                <select class="form-select" aria-label="Default select example" name="hour" id="startHourSelect" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Hora final</label>
                                <select class="form-select" aria-label="Default select example" name="hour" id="endHourSelect" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col">
                                <label class="form-label">Dias</label>
                                <select class="form-select" aria-label="Default select example" name="hour" id="daysSelect" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Cupos</label>
                                <input type="text" class="form-control" placeholder="e.g. 20" name="places" pattern="\d{2}" required>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Asigna un Docente</label>
                            <select class="form-select" aria-label="Default select example" name="professor" id="professorsSelect" required>
                                <option selected>Docentes</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Elije una aula</label>
                            <select class="form-select" aria-label="Default select example" name="classroom" id="classroomSelect" required>
                                <option selected>Aulas disponibles</option>
                            </select>
                        </div>
                        <div class="mt-4 col-6 text-center w-100">
                            <button type="submit" class="btn" style="background-color: #FFAA34;">Crear Sección</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="actionsModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-outline-danger btn-sm" style="position: absolute; top:20px; right:20px;">Eliminar sección</button>
                    <form class="row g-3" id="addSectionForm" data-id-professor>
                        <div class="row my-2">
                            <div class="col-2 row">
                                <span class="me-2">Sección</span>
                                <span class="fs-4" id="sectionCode"></span>
                            </div>
                            <div class="col-2 row">
                                <span class="me-2">UV</span>
                                <span class="fs-4" id="sectionUV"></span>
                            </div>
                            <div class="col-3 row">
                                <span class="me-2">Días</span>
                                <span class="fs-4" id="sectionDays"></span>
                            </div>
                            <div class="col-2 row">
                                <span class="me-2">Hora de inicio</span>
                                <span class="fs-4" id="sectionHour"></span>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-8">
                                <label class="form-label">Docente Asignado</label>
                                <select class="form-select" aria-label="Default select example" name="professor" id="departmentSelectEdit" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Aumentar Cupos</label>
                                <div style="position: relative;">
                                    <input type="text" value="1" class="form-control" placeholder="e.g. 20" name="places" pattern="\d{2}" id="increaseInput" required>
                                    <div class="btn" style="position: absolute; right: 0; top:0; background-color: #FFAA34;" id="increaseBtn"><img src="/assets/img/icons/add-circle.svg" alt=""></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Aula asignada</label>
                            <select class="form-select" aria-label="Default select example" name="classroom" id="professorTypeSelectEdit" required>
                                <option selected>Aulas disponibles</option>
                            </select>
                        </div>
                    </form>

                    <div class="row gap-3 mx-2 my-4">

                        <div class="mt-2 d-flex-col card-container col">
                            <div class="ms-2">
                                <span class="fs-5 me-2">Estudiantes matriculados</span>
                            </div>
                            <hr>
                            <section id="enrolledStudentsTable" class="col"></section>
                        </div>

                        <div class="mt-2 d-flex-col card-container col">
                            <div class="ms-2">
                                <span class="fs-5 me-2">Estudiantes matriculados</span>
                            </div>
                            <hr>
                            <section id="studentsWaitingTable" class="col"></section>
                        </div>
                    </div>
                    <div class="mt-4 col-6 text-center w-100">
                        <button type="submit" class="btn" style="background-color: #FFAA34;">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script src="../../../js/administration/coordinators/academic_load/main.js" type="module"></script>
    <script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>