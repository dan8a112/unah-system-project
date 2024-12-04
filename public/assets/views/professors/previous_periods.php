<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" contentet="afcastillof@unah.hn">
    <meta name="version" contentet="0.1.0">
    <meta name="date" contentet="04/12/2024">
    <title>Home Docentes</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/templates/professor.css">
    <link rel="stylesheet" href="../../css/temas/cards.css">
    <link rel="stylesheet" href="../../css/admission/timeline.css">
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
        $selected = 2;
        include_once($path . "templates/professors/standardProfessor.php");
        ?>

        <section class="col ms-4">
            <div class="my-4">
                <div class="d-flex align-items-center">
                    <h1 class="display3 me-3" id="processName">Peiodos anteriores</h1>
                </div>
                <p>Revisa tus clases en periodos anteriores.</p>
            </div>

            <section class="d-flex gap-5" style="flex-wrap: wrap; margin-right: 5.5rem;" id="containerSection">
                <div class="timeline" id="timeline">            
                </div>
            </section>
            
        </section>
    </main>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/professors/previous_periods/main.js" type="module"></script>
</body>

</html>