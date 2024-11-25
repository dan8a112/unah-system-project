<?php
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  if (SessionValidation::isValid($_SESSION, "apa")){
    header("Location: /assets/views/admission/administrative_home.php");
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/logins/login.css">
    <title>Login APA</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #F4F7FB;">
        <div class="container-fluid">
          <a class="navbar-brand" href="../../../index.html">
            <img src="../../img/landing/unah-logo.png" alt="Bootstrap" width="100px" class="ms-5">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse d-flex flex-row-reverse me-5" id="navbarNavDropdown">
            <ul class="navbar-nav gap-3">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../admission/inscription_view.html">Admisiones</a>
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
      
    <div class="container-fluid login-background d-flex align-items-center justify-content-center" style="background-image: url('../../img/login/admissions_login.png');">
        <div class="row login-card-wrapper">

            <div class="col-lg-6 left-section d-flex flex-column align-items-center justify-content-center text-center">
                <img src="../../img/login/logo-unah-white.png" alt="Imagen" class="img">
                <h2 class="title">Administracion APA</h2>
                <p class="subtitle">Para acceder a este portal debes autenticarte</p>
            </div>
            
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="card login-card p-4">
                    <h4 class="card-title mb-2">Iniciar Sesión - APA</h4>
                    <p class="card-subtitle mb-3 text-muted">Administracion de procesos de admision</p>
                    <form id="loginForm">
                        <div class="mb-4">
                            <input type="email" class="form-control" id="email" placeholder="Correo" name="mail" required>
                        </div>
                        <div class="mb-4">
                            <input type="password" class="form-control" id="password" placeholder="Contraseña" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">Iniciar Sesión</button>
                        <a href="#" class="text-decoration-none text-primary d-block text-end">¿Olvidaste tu contraseña?</a>
                        <section id="errorSection"></section>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/login/loginAPA/main.js" type="module"></script>
</body>
</html>
