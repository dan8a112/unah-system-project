<?php
include_once("../../../../../src/SessionValidation/SessionValidation.php");

session_start();

$portal = "bosses";

if (!SessionValidation::isValid($_SESSION, $portal)) {
    header("Location: /assets/views/logins/login_professors.php");
} else {

    $userId = $_SESSION['portals'][$portal]['user'];

    //Si los parametros no coinciden con los de la sesion se corrigen
    if (!SessionValidation::validateParam("id", $userId)) {
        header("Location: /assets/views/administration/bosses/administrate_sections.php?id=" . $userId);
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
    $title = "Portal Jefes de departamentos";
    $description = "Jefes de departamento, administra los procesos de matricula y mas";
    $path = "../../";
    include_once($path . "templates/headerAdmission.php");
    ?>

    <main class="row">

        <?php
        $path = "../../";
        $selected = 1;
        include_once($path . "templates/professors/bossSidebar.php");
        ?>

        <section class="col mx-5">

            <div class="row align-items-center">

                <div class="my-4 col-8">
                    <div class="d-flex align-items-center ">
                        <h1 class="display3 me-3" id="processName">Secciones</h1>
                        <div class="status-card" style="background-color: #00C500;" id="periodName"></div>
                    </div>
                    <span>Administra las secciones de este periodo para tu departamento</span>
                </div>

                <div class="card-container d-flex align-items-center col" style="width:fit-content; height: fit-content;">
                    <img src="/assets/img/icons/department.svg" alt="" class="me-3">
                    <span id="departmentName" class="fs-6" style="font-weight: 500;"></span>
                </div>
            </div>

            <div class="mt-2 d-flex-col card-container">
                <div class="d-flex justify-content-between">
                    <div class="ms-2">
                        <span class="fs-4 me-2 fw-bold">Secciones de este periodo</span>
                    </div>
                    <div class="d-flex me-2">
                        <button class="btn d-flex align-items-center" style="background-color: #FFAA34; color: #F4F7FB;" id="createBtn">
                            <img src="/assets/img/icons/add-circle.svg" alt="" class="me-2">
                            Crear
                        </button>
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
                        <div>
                            <div>
                                <label class="form-label">Dias</label>
                                <select class="form-select" aria-label="Default select example" name="days" id="daysSelect" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label class="form-label">Hora de inicio</label>
                                <select class="form-select" aria-label="Default select example" name="startHour" id="startHourSelect" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Hora final</label>
                                <select class="form-select" aria-label="Default select example" name="finishHour" id="endHourSelect" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Cupos</label>
                            <input type="text" class="form-control" placeholder="e.g. 20" name="places" pattern="\d{2}" required>
                        </div>
                        <div>
                            <label class="form-label">Asigna un Docente</label>
                            <select class="form-select" aria-label="Default select example" name="professor" id="professorsSelect" required>
                                <option selected>Docentes</option>
                            </select>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label class="form-label">Elije un edificio</label>
                                <select class="form-select" aria-label="Default select example" name="building" id="buildingSelect" required>
                                    <option selected>Edificios disponibles</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Elije una aula</label>
                                <select class="form-select" aria-label="Default select example" name="classroom" id="classroomSelect" required>
                                    <option selected>Aulas disponibles</option>
                                </select>
                            </div>
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
                    <button class="btn btn-outline-danger btn-sm" style="position: absolute; top:20px; right:20px;" id="deleteSectionBtn">Eliminar sección</button>
                    <form class="row g-3" id="editSectionForm" data-id-professor>
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
                            <input type="text" name="id" id="sectionIdInput" hidden>
                            <input type="text" name="class" id="classIdInput" hidden>
                            <div class="col">
                                <label class="form-label">Dias</label>
                                <select class="form-select" aria-label="Default select example" name="days" id="daysAsigned" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Hora de inicio</label>
                                <select class="form-select" aria-label="Default select example" name="startHour" id="startHourAsigned" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Hora final</label>
                                <select class="form-select" aria-label="Default select example" name="finishHour" id="finishHourAsigned" required>
                                    <option selected>Seleccione una opcion</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col">
                                <label class="form-label">Edificio asignado</label>
                                <select class="form-select" aria-label="Default select example" name="building" id="buildingAsigned" required>
                                    <option selected>Edificios disponibles</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Aula asignada</label>
                                <select class="form-select" aria-label="Default select example" name="classroom" id="classroomAsigned" required>
                                    <option selected>Aulas disponibles</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Docente Asignado</label>
                                <select class="form-select" aria-label="Default select example" name="professor" id="professorAsigned" required>
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
                                <span class="fs-5 me-2">Estudiantes En lista de espera</span>
                            </div>
                            <hr>
                            <section id="studentsWaitingTable" class="col"></section>
                        </div>
                    </div>
                    <div class="mt-4 col-6 text-center w-100">
                        <button class="btn" style="background-color: #FFAA34;" id="updateButton">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="messageModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="btnClose">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script src="../../../js/administration/bosses/sections/main.js" type="module"></script>
    <script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>