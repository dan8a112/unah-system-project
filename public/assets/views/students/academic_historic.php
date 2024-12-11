
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secciones</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/templates/professor.css">
    <link rel="stylesheet" href="../../css/temas/cards.css">
    <link rel="stylesheet" href="../../css/students/academic_history.css">
    <link rel="stylesheet" href="../../css/templates/breadCrumb.css">
</head>

<body>
<?php
    $portal = "students";
    $title = "Portal Coordinadores de carrera";
    $description = "Coordinadores de carrera, administra los procesos estudiantiles.";
    $path = "../";
    include_once($path . "templates/headerAdmission.php");
    ?>

    <main class="row">

        <?php
        $path = "../";
        $selected = 1;
        include_once($path . "templates/studentSidebar.php");
        ?>

        <section class="col mx-4 big-container">
            <div class="my-4">
                <div class="d-flex align-items-center">
                    <h1 class="display3 me-3" id="processName">Historial Academico</h1>
                </div>
                <p>Registro oficial de materias cursadas y calificaciones obtenidas.</p>
            </div>

            <div class="mt-5 d-flex-col card-container">
                <div class="backgroundCard"></div>
                <p class="generalInfo">Informacion General</p>
                <div class="profile">
                    <img id="profileImg" class="profileImg" src="https://i.scdn.co/image/ab67616d0000b273ca964f2c3c069b3fb9ec11be" alt="">
                    <div class="profile-info">
                        <h3 id="studentName"></h3>
                        <div class="d-flex gap-2">
                            <p id="studentCareer"> </p>
                            <p>-</p>
                            <p id="studentAcount"></p>
                        </div>
                    </div>
                    <p id="studentDescription"></p>
                    <div class="d-flex align-items-start gap-4">
                        <div class="stat">
                            <span id="studentGlobalIndex"></span>
                            <label>Indice global</label>
                        </div>
                        <div class="stat">
                            <span id="studentPeriodIndex"></span>
                            <label>Indice de periodo</label>
                        </div>
                        <div class="stat">
                            <span id="studentCenter"></span>
                            <label>Centro</label>
                        </div>
                    </div>
                    <div>
                        <img src="../../img/icons/editprofile.svg" alt="">
                    </div>
                    
                </div>
            </div>

            <div id="section-table" style="margin-bottom: 200px;">
            </div>
            

        </section>
    </main>


    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/students/academic_historic/main.js" type="module"></script>
    <script src="../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>