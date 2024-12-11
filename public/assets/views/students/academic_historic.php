<?php
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  $portal = "students";

  if (!SessionValidation::isValid($_SESSION, $portal)){
    header("Location: /assets/views/logins/login_students.php");
  }else{

    $userId = $_SESSION['portals'][$portal]['user'];

    //Si los parametros no coinciden con los de la sesion se corrigen
    if (!SessionValidation::validateParam("student", $userId)) {
        header("Location: /assets/views/students/academic_historic.php?student=".$userId."&offset=10");
        exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial academico</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/templates/professor.css">
    <link rel="stylesheet" href="../../css/temas/cards.css">
    <link rel="stylesheet" href="../../css/students/academic_history.css">
    <link rel="stylesheet" href="../../css/templates/breadCrumb.css">
    <link rel="stylesheet" href="../../css/temas/popup.css">
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
                    <div style="right: 30px; top: 215px; position: absolute;" class="btn" id="edit">
                        <span class="fw-bolder" style="color:#A1A1A1;">Editar perfil</span>
                        <img src="../../img/icons/editprofile.svg" alt="">
                    </div>
                    
                </div>
            </div>

            <div id="section-table" style="margin-bottom: 200px;">
            </div>
            

        </section>
    </main>

    <!-- Modal HTML -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Acontinuacion podras editar la informacion de tu perfil</p>
                <form id="editProfileForm">
                    <div class="mb-3">
                        <label for="profileImage" class="form-label">Foto de Perfil</label>
                        <input class="form-control" name="pathProfilePhoto" type="file" id="profileImage" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="profileDescription" class="form-label">Descripción</label>
                        <textarea name="description" class="form-control" id="profileDescription" rows="4" placeholder="Ingrese una descripción..."></textarea>
                    </div>
                    <button type="submit" class="btn" style="background-color: #FFAA34;">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="popup" id="popupError" style="border: solid 1px #EC0000;">
      <img src="../../img/icons/error.svg" alt="">
      <h2>Error!</h2>
      <p id="message"></p>
      <button type="button" id="buttonOk2">OK</button>
    </div>


    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/students/academic_historic/main.js" type="module"></script>
    <script src="../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>

</html>