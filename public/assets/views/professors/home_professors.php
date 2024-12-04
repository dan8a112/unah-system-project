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
    $portal = "professors";
    $path = "../";
    include_once($path . "templates/headerAdmission.php");
    ?>

    <main class="row">

        <?php
        $path = "../";
        $pathImg = "../../";
        $selected = 1;
        include_once($path . "templates/professors/standardProfessor.php");
        ?>

        <section class="col ms-4">
            <div class="my-4">
                <div class="d-flex align-items-center">
                    <h1 class="display3 me-3" id="processName">Tus clases</h1>
                    <div class="status-card" style="background-color: #00C500;">2 PAC 2024</div>
                </div>
                <p>Las siguiente sección  muestra las clases a las que fuiste asignado este periodo.</p>
            </div>

            <section class="d-flex gap-5" style="flex-wrap: wrap;">
                <div class="class-card">
                    <div class="class-card-header">
                        <span>Seccion 1100</span>
                    </div>
                    <div class="ps-3 pe-5 pb-3 pt-2">
                        <span class="fs-4" style="display:block" >Ingenieria de Software</span>
                        <span style="color: #A1A1A1">IS-802</span>
                    </div>
                </div>
                <div class="class-card">
                    <div class="class-card-header">
                        <span>Seccion 1100</span>
                    </div>
                    <div class="ps-3 pe-5 pb-3 pt-2">
                        <span class="fs-4" style="display:block" >Ingenieria de Software</span>
                        <span style="color: #A1A1A1">IS-802</span>
                    </div>
                </div>
                <div class="class-card">
                    <div class="class-card-header">
                        <span>Seccion 1100</span>
                    </div>
                    <div class="ps-3 pe-5 pb-3 pt-2">
                        <span class="fs-4" style="display:block" >Ingenieria de Software</span>
                        <span style="color: #A1A1A1">IS-802</span>
                    </div>
                </div>
            </section>
            
        </section>
    </main>
    <script src="../../js/bootstrap.bundle.min.js"></script>
</body>

</html>