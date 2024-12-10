<?php
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  $portal = "professors";

  if (!SessionValidation::isValid($_SESSION, $portal)){
    header("Location: /assets/views/logins/login_professors.php");
  }else{

    $userId = $_SESSION['portals'][$portal]['user'];

    //Si los parametros no coinciden con los de la sesion se corrigen
    if (!SessionValidation::validateParam("id", $userId)) {
        header("Location: /assets/views/professors/class_detail.php?id=".$userId);
        exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Docentes</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/templates/professor.css">
    <link rel="stylesheet" href="../../css/temas/cards.css">
    <link rel="stylesheet" href="../../css/admission/process_detail.css">
    <link rel="stylesheet" href="../../css/templates/breadCrumb.css">
</head>

<body style="background-color: #FBF9F4;">
    <?php
        $title = "Portal Docentes";
        $description = "Administra tus clases y otros procesos del periodo academico";
        $path = "../";
        include_once($path . "templates/headerAdmission.php");
    ?>

    <main class="row">

        <?php
            $path = "../";
            $selected = 1;
            include_once($path . "templates/professors/professorSidebar.php");
        ?>

        <section class="col ms-4" style="margin-right: 1.7rem">
            <?php 
                $path = "../";
                $links = [
                    ['title' => 'Tus clases', 'url' => '/assets/views/professors/home_professors.php'],
                    ['title' => 'Detalle de clase', 'url' => '/calificaciones']
                ];

                include_once($path . "templates/breadCrumb.php");
            ?>
            <section class="my-4">
                <div class="d-flex align-items-center">
                    <h1 class="display3 me-3" id="className"></h1>
                    <div class="status-card" style="background-color: #00C500;" id="currentPeriod"></div>
                </div>
                <p id="denomination"></p>
            </section>
          
            <section class="row mb-4 gap-5">
                <div class="card-container col">
                    <div class="d-flex align-items-center mb-2">
                        <img src="../../img/icons/Clock.svg" alt="" class="me-2">
                        <span style="font-weight: 600;">Horarios</span>
                    </div>
                    <div class="dates-container">
                        <div class="mb-2">
                            <span class="fw-bolder">Inicio</span>
                            <p class="font-medium" id="startHour"></p>
                        </div>
                        <div>
                            <span class="fw-bolder">Fin</span>
                            <p class="font-medium" id="finishHour"></p>
                        </div>
                    </div>
                </div>
                <div class="card-container col">
                    <div class="d-flex align-items-center">
                        <img src="../../img/icons/people.svg" alt="" class="me-2">
                        <span >Cantidad de alumnos</span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center" style="height: 80%;">
                        <h1 style="font-size: 1.7rem; font-weight: 400;" id="amountStudents"></h1>
                    </div>
                </div>
                <div class="card-container col">
                    <div class="d-flex align-items-center">
                        <img src="../../img/icons/inscription-icon.svg" alt="" class="me-2">
                        <span id="amountBox">Unidades valorativas</span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 80%;">
                        <h1 class="display-6" style="font-weight: 400;" id="valueUnits"></h1>
                        <h1 class="display-6" style="font-weight: 600; font-size:1.0rem" id="days"></h1>
                    </div>
                </div>
            </section>
            <section id="upload_csv" class="mb-4 row">
            </section>

            <div id="section-table"></div>
            
        </section>
    </main>
    
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/professors/detail_section/main.js" type="module"></script>
    <script src="../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>