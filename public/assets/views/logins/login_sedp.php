<?php
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  if (SessionValidation::isValid($_SESSION, "sedp")){
    header("Location: /assets/views/administration/sedp-portal.php");
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/logins/login.css">
    <title>Login</title>
</head>
<body>
    <?php 
      $path = "../";
      include_once($path . "templates/headerPublic.php");
    ?>

    <div class="container-fluid login-background d-flex align-items-center justify-content-center">
        <div class="row login-card-wrapper">

            <div class="col-lg-6 left-section d-flex flex-column align-items-center justify-content-center text-center">
                <img src="../../img/login/logo-unah-white.png" alt="Imagen" class="img">
                <h2 class="title">Administracion SEDP</h2>
                <p class="subtitle">Para acceder a este portal debes autenticarte</p>
            </div>
            
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="card login-card p-4">
                    <h4 class="card-title mb-2">Iniciar Sesión - SEDP</h4>
                    <p class="card-subtitle mb-3 text-muted">Servicios de administracion de docentes</p>
                    <form id="loginForm" data-login-key="SEDP">
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
    <script src="../../js/login/login.js" type="module"></script>
</body>
</html>
