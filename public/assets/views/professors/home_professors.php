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
        header("Location: /assets/views/professors/home_professors.php?id=".$userId);
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

        <section class="col ms-4">
            <div class="my-4">
                <div class="d-flex align-items-center">
                    <h1 class="display3 me-3">Tus clases</h1>
                    <div class="status-card" style="background-color: #00C500;" id="periodName"></div>
                </div>
                <p>Las siguiente sección  muestra las clases a las que fuiste asignado este periodo.</p>
            </div>

            <section id="alertSection" style="width: 90%;"></section>

            <section id="processSection" class="mb-4"></section>

            <section class="d-flex gap-5" style="flex-wrap: wrap;" id="sectionsContainer">
            </section>
            
        </section>
    </main>
    
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/professors/home-professors/main.js" type="module"></script>
    <script src="../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>