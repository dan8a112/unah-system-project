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

        <section class="col mx-4">
            <div class="my-4">
                <div class="d-flex align-items-center">
                    <h1 class="display3 me-3" id="processName">Secciones</h1>
                    <div class="status-card" style="background-color: #00C500;">2 PAC 2024</div>
                </div>
                <p>Administra las secciones de este periodo para tu departamento</p>
            </div>

            <div class="mt-5 d-flex-col card-container">
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
                            <select class="form-select" aria-label="Default select example" name="class" id="professorTypeSelectEdit" required>
                                <option selected>Clases</option>
                            </select>
                        </div>
                        <div class="row my-2">
                            <div class="col">
                                <label class="form-label">Selecciona la hora</label>
                                <select class="form-select" aria-label="Default select example" name="hour" id="departmentSelectEdit" required>
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
                            <select class="form-select" aria-label="Default select example" name="professor" id="professorTypeSelectEdit" required>
                                <option selected>Docentes</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Elije una aula</label>
                            <select class="form-select" aria-label="Default select example" name="classroom" id="professorTypeSelectEdit" required>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-outline-danger btn-sm" style="position: absolute; top:20px; right:20px;">Eliminar sección</button>
                    <form class="row g-3" id="addSectionForm" data-id-professor>
                        <div class="row my-2">
                            <span class="me-2">Sección</span>
                            <span class="fs-4">1100</span>
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
                                    <div class="btn" style="position: absolute; right: 0; top:0; background-color: #FFAA34;" id="increaseBtn" ><img src="/assets/img/icons/add-circle.svg" alt=""></div>
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
                    <section id="studentsWaitingTable"></section>
                    <div class="mt-4 col-6 text-center w-100">
                        <button type="submit" class="btn" style="background-color: #FFAA34;">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/bootstrap.bundle.min.js"></script>
    <script src="../../../js/administration/bosses/sections/main.js" type="module"></script>
    <script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>