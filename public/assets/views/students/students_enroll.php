<?php
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  $portal = "students";

  if (!SessionValidation::isValid($_SESSION, $portal)){
    header("Location: /assets/views/logins/login_students.php");
  }else{

    $userId = $_SESSION['portals'][$portal]['user'];

    //Si los parametros no coinciden con los de la sesion se corrigen
    if (!SessionValidation::validateParam("id", $userId)) {
        header("Location: /assets/views/students/students_enroll.php?id=".$userId);
        exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matricula</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/templates/professor.css">
    <link rel="stylesheet" href="../../css/temas/cards.css">
</head>

<body>
    <?php
    $portal = "students";
    $title = "Portal Estudiantes";
    $description = "Bienvenido al portal estudiantes de la unah.";
    $path = "../";
    include_once($path . "templates/headerAdmission.php");
    ?>

    <main class="row">

        <?php
        $path = "../";
        $selected = 2;
        include_once($path . "templates/studentSidebar.php");
        ?>

        <section class="col mx-4 big-container">
            <div class="my-4">
                <div class="d-flex align-items-center">
                    <h1 class="display3 me-3" id="processName">Matricula</h1>
                    <div class="status-card" style="background-color: #00C500;" id="periodName">II PAC 2024</div>
                </div>
                <p>En esta sección puedes realizar tu matricula y gestionar tu carga académica de este periodo</p>
            </div>

            <section class="row mb-4 gap-5">
                <div class="card-container col-5">
                    <div class="d-flex align-items-center">
                        <img src="../../img/icons/people.svg" alt="" class="me-2">
                        <span>Carrera cursada</span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center" style="height: 80%;">
                        <h1 style="font-size: 1.7rem; font-weight: 400;" id="amountStudents">Ingenieria en Sistemas</h1>
                    </div>
                </div>
                <div class="card-container col-4">
                    <div class="d-flex align-items-center">
                        <img src="../../img/icons/inscription-icon.svg" alt="" class="me-2">
                        <span id="amountBox">Unidades valorativas</span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 80%;">
                        <h1 class="display-6" style="font-weight: 400;" id="valueUnits">4 UV</h1>
                    </div>
                </div>
            </section>

            <section>
            <div class="mb-4">
                
            <label class="form-label">Departamento</label>
            <select class="form-select" name="department" id="departmentSelect">
                <option selected value="">Seleccione una opción</option>
                <option value="1">Departamento 1</option>
                <option value="2">Departamento 2</option>
            </select>
            </div>
            <div class="mb-4">
            <label class="form-label">Clase</label>
            <select class="form-select" name="class" id="classSelect" disabled>
                <option selected value="">Seleccione una opción</option>
                <option value="1">Departamento 1</option>
                <option value="2">Departamento 2</option>
            </select>
            </div>
            <form action="" class="mb-4">
            <div class="mb-5">
                <label class="form-label">Sección</label>
                <select class="form-select" name="section" id="sectionSelect" disabled required>
                <option selected value="">Seleccione una opción</option>
                <option value="1">Departamento 1</option>
                <option value="2">Departamento 2</option>
                </select>
            </div>
            <button class="btn btn-primary" disabled id="enrollButton">Matricular Clase</button>
            </form>

            </section>



        </section>
    </main>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/students/enroll/main.js" type="module"></script>
    <script src="../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>