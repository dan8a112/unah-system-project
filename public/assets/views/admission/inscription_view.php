<!-- <?php
// URL del servicio
//$service_url = '../../../api/get/admission/activeAdmissionProcess';

// Inicializar cURL para consumir el servicio
//$curl = curl_init();
//curl_setopt($curl, CURLOPT_URL, $service_url);
//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//$response = curl_exec($curl);
//curl_close($curl);

// Decodificar la respuesta JSON del servicio
//$service_response = json_decode($response, true);
//echo $service_response;// Validar el estado de la admisión
//if (!$service_response['status']) {
    // Si el servicio retorna false o hay un error
    // header('Location: /'); // Redirigir a una página de error
    // exit;
//}
?> -->

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
    <nav class="navbar navbar-expand-lg" style="background-color: #F4F7FB;">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">
            <img src="../../img/landing/unah-logo.png" alt="Bootstrap" width="100px" class="ms-5">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse d-flex flex-row-reverse me-5" id="navbarNavDropdown">
            <ul class="navbar-nav gap-3">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Admisiones</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Estudiantes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Docentes</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Administracion
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="../logins/login_sedp.php">SEDP Login</a></li>
                  <li><a class="dropdown-item" href="../logins/login_apa.php">APA Login</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    <section class="section">
        <section class="title">
            <h1>Inscripción de admisión</h1>
            <h6>A continuación solicitaremos tus datos personales, para inscribirte en el examen de admisión. Por favor, asegurate que todos tus datos sean correctos.</h6>
        </section>
        <form id="form-inscription">
          <section class="form">
              <h4>Datos Generales</h4>
              <div class="line"></div>
              <p>En esta seccion debes ingresar tus datos generales, toma en cuenta que en caso de tener solo un nombre, o caso contrario tienes mas de dos, podras ingresar tu unico nombre en el campo de primer nombre o tu tercer nombre en el campo de segundo nombre separado por un espacio.</p>
              <section class="input-container">
                  <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Primer nombre" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" title="No cumple con el formato admitido. Primera letra en mayúscula." required>
                  <input type="text" class="form-control" id="secondName" name="secondName" placeholder="Segundo nombre" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" title="No cumple con el formato admitido. Primera letra en mayúscula.">
                  <input type="text" class="form-control" id="firstLastName" name="firstLastName" placeholder="Primer apellido" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" title="No cumple con el formato admitido. Primera letra en mayúscula." required>
                  <input type="text" class="form-control" id="SecondLastName" name="SecondLastName" placeholder="Segundo apellido" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" title="No cumple con el formato admitido. Primera letra en mayúscula." required>
                  <input type="text" class="form-control" id="identity" name="identityNumber" placeholder="Numero de identidad"  pattern="\d{4}-?(19|20)\d{2}-?\d{5}" title="El numero de identidad debe tener el siguiente formato: 0000-0000-00000" required>
                  <input type="email" class="form-control" id="mail" name="personalEmail" placeholder="Correo electronico" required>
                  <input type="text" class="form-control" id="telephoneNumber" name="telephoneNumber" placeholder="Telefono" required pattern="[9283]\d{3}-?\d{4}" title="El número de telefono no es valido.">
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
