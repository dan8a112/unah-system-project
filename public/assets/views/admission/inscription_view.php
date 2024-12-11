<?php
  $path = "../../../../";

  include_once $path."src/DbConnection/DbConnection.php";
  include_once $path."src/Application/Application.php";

  //Se verifica si existe un proceso de inscripcion activo
  $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
  $result = $dao->isActiveInscriptionProcess();

  //Se evalua si el resultado es true o false
  if (!$result) {
    header("Location: /index.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="afcastillof@unah.hn">
    <meta name="date" content="09/11/2024">
    <meta name="version" content="0.1.2">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/admission/inscription.css">
    <link rel="stylesheet" href="../../css/temas/popup.css">
    <title>Document</title>
</head>
<body>

  <?php 
      $path = "../";
      include_once($path . "templates/headerPublic.php");
  ?>
    <section class="section">
        <section class="title">
            <h1>Inscripción de admisión</h1>
            <h6>A continuación solicitaremos tus datos personales, para inscribirte en el examen de admisión. Por favor, asegurate que todos tus datos sean correctos.</h6>
        </section>
        <form id="form-inscription">
          <section class="form">
              <h4>Datos Generales</h4>
              <div class="line"></div>
              <p>En esta seccion debes ingresar tus datos generales.</p>
              <section class="input-container">
                  <input type="text" class="form-control uppercase" id="names" name="names" placeholder="Nombres" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" title="No cumple con el formato admitido" required>
                  <input type="text" class="form-control uppercase" id="lastNames" name="lastNames" placeholder="Apellidos" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" title="No cumple con el formato admitido" required>
                  <input type="text" class="form-control" id="identityNumber" name="identityNumber" placeholder="Numero de identidad"  pattern="\d{4}-?(19|20)\d{2}-?\d{5}" title="El numero de identidad debe tener el siguiente formato: 0801-2000-00000" required>
                  <input type="email" class="form-control" id="personalEmail" name="personalEmail" placeholder="Correo electronico" required>
                  <input type="text" class="form-control" id="telephoneNumber" name="telephoneNumber" placeholder="Telefono" required pattern="(?!.*(\d)\1{2})[9283]\d{3}-?\d{4}" title="El numero de telefono no es valido">
              </section>
          </section>
          <section class="form">
              <h4>Datos de carrera</h4>
              <div class="line" style="margin-bottom: 25px;"></div>
              <div class="select-control" style="width: 40%;">
                <label for="exampleFormControlInput1" class="form-label">Campus</label>
                <select class="form-select" aria-label="Default select example" id="regionalCenters" name="idRegionalCenterChoice">
                  <option selected>Seleccione una opcion</option>
                </select>
              </div>
              <section class="input-container">
                  <div class="select-control">
                      <label for="exampleFormControlInput1" class="form-label">Carrera principal</label>
                      <select class="form-select" aria-label="Default select example" id="firstCareer" name="idFirstDegreeProgramChoice">
                          <option selected>Seleccione una opcion</option>
                      </select>
                  </div>
                  <div class="select-control">
                      <label for="exampleFormControlInput1" class="form-label">Carrera secundaria</label>
                      <select class="form-select" aria-label="Default select example" id="secondCareer" name="idSecondDegreeProgramChoice">
                        <option selected>Seleccione una opcion</option>
                      </select>
                  </div>
              </section>
          </section>
          <section class="form">
              <h4>Estudios previos</h4>
              <div class="line"></div>
              <p>En esta seccion debes subir tu certificado de estudios de educacion secundaria. Toma en cuenta que solo podras adjuntar archivos pdf o en formato de imagen. Este archivo debera pesar minimo 100 kb y maximo 2 mb.</p>
              <section class="input-container">
                  <div class="select-control">
                      <label for="formFile" class="form-label">Subir certificacion de secundaria</label>
                      <input class="form-control" type="file" id="formFile" name="pathSchoolCertificate" accept=".pdf,image/*" required title="Solo se permiten archivos PDF o imágenes (JPEG, PNG, GIF).">
                  </div>
              </section>
          </section>
          <div class="d-flex justify-content-center">
            <div class="d-grid gap-2" style="width: 40%;">
              <button class="btn btn-primary mt-5" type="submit">Inscribirse</button>
            </div>
          </div>          
        </form>
    </section>
    <div class="popup" id="popup">
      <img src="../../img/icons/check.svg" alt="">
      <h2>Felicidades!</h2>
      <p id="exitMessage"></p>
      <button type="button" id="buttonOk1">OK</button>
    </div>
    <div class="popup" id="popupError" style="border: solid 1px #EC0000;">
      <img src="../../img/icons/error.svg" alt="">
      <h2>Error!</h2>
      <p id="message"></p>
      <button type="button" id="buttonOk2">OK</button>
    </div>
    
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/admission/inscription/main.js" type="module"></script>
</body>
</html>
