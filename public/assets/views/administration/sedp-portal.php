<?php 
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  if (!SessionValidation::isValid($_SESSION, "sedp")){
    header("Location: /assets/views/logins/login_sedp.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="dochoao@unah.hn">
    <meta name="date" content="04/11/2024">
    <meta name="version" content="0.1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/sedp/sedp-portal.css">
    <title>Portal SEDP</title>
</head>
<body>
  <?php 
      $title = "Portal SEDP";
      $description = "Administración del personal docente de la UNAH";
      $portal = "sedp";
      $path = "../";
      include_once($path . "templates/headerAdmission.php");
    ?>

      <div class="mt-5 d-flex-col" style="margin: 0 auto; width: 90vw; border: #A1A1A1 solid 1px; border-radius: 20px; padding: 20px;">
        <div class="d-flex justify-content-between">
            <div class="ms-2">
                <span class="fs-4 me-2 fw-bold">Cantidad de docentes</span>
                <span class="fs-5" id="amountProfessors"></span>
            </div>
            <div class="d-flex align-items-center" style="width: 30%;">
                <img class="me-2" src="../../img/icons/search.svg" alt="">
                <input class="form-control me-3" placeholder="Buscar docente" type="search" >
            </div>
            <div class="d-flex me-2">
                <button class="btn d-flex align-items-center" style="background-color: #FFAA34; color: #F4F7FB;" id="createBtn">
                    <img src="../../img/icons/add-circle.svg" alt="" class="me-2">
                    Crear
                </button>
            </div>    
        </div>
        <hr>
        <div id="table">
        </div>
      </div>

      
      <div class="modal fade" tabindex="-1" id="formModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Crear un nuevo docente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="row g-3" id="createProfessorForm">
              <div class="row my-2">
                  <div class="col">
                  <label class="form-label">Numero de identidad</label>
                    <input type="text" class="form-control" placeholder="e.g. 0601-2003-02426" aria-label="Numero de identidad" pattern="(1|0)\d{3}-(19|20)\d{2}-\d{5}" name="identityNumber" required>
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                  <label class="form-label">Nombres</label>
                    <input type="text" class="form-control uppercase" placeholder="e.g. Carlos" aria-label="Primer Nombre" name="names" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" required>
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                  <label class="form-label">Apellidos</label>
                    <input type="text" class="form-control" placeholder="e.g. Martinez" aria-label="Primer Apellido" name="lastNames" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" required>
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                    <label class="form-label">Numero de telefono</label>
                    <input type="text" class="form-control" placeholder="e.g. 98475241" aria-label="Numero de telefono" name="phoneNumber" pattern="^(\(\+504\))?\s*[23789]\d{3}-?\d{4}$" required>
                  </div>
                  <div class="col">
                    <label class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" aria-label="Fecha de naciminento" name="birthDate" id="birthDateInput" required>
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                    <label class="form-label">Direccion</label>
                    <textarea class="form-control" placeholder="e.g. Tegucigalpa, Francisco Mora..." aria-label="Direccion"  minlength="15" maxlength="60" name="address"></textarea>
                    </div>
                </div>
                <div>
                  <label class="form-label">Tipo de profesor</label>
                  <select class="form-select" aria-label="Default select example" name="professorTypeId" id="professorTypeSelect" required>
                    <option selected>Seleccione una opcion</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Departamento</label>
                  <select class="form-select" aria-label="Default select example" name="departmentId" id="departmentSelect" required>
                    <option selected>Seleccione una opcion</option>
                  </select>
                </div>
                <div class="col-6">
                  <button type="submit" class="btn btn-success">Agregar</button>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" tabindex="-1" id="editModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Editar Informacion del Docente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="row g-3" id="editProfessorForm" data-id-professor>
              <div class="row my-2">
                  <div class="col">
                  <label class="form-label">Numero de identidad</label>
                    <input type="text" class="form-control" placeholder="e.g. 0601-2003-02426" aria-label="Numero de identidad" name="identityNumber" pattern="(1|0)\d{3}-(19|20)\d{2}-\d{5}" required>
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                  <label class="form-label">Nombres</label>
                    <input type="text" class="form-control" placeholder="e.g. Carlos" aria-label="Primer Nombre" name="names" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" required>
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                  <label class="form-label">Apellidos</label>
                    <input type="text" class="form-control" placeholder="e.g. Martinez" aria-label="Primer Apellido" name="lastNames" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?: [A-ZÁÉÍÓÚÑa-záéíóúñ]+)*" required>
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                    <label class="form-label">Numero de telefono</label>
                    <input type="text" class="form-control" placeholder="e.g. 98475241" aria-label="Numero de telefono" name="phoneNumber" pattern="^(\(\+504\))?\s*[23789]\d{3}-?\d{4}$" required>
                  </div>
                  <div class="col">
                    <label class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" aria-label="Numero de telefono" name="birthDate" id="bdInput" required>
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                    <label class="form-label">Direccion</label>
                      <textarea class="form-control" placeholder="e.g. Tegucigalpa, Francisco Mora..." aria-label="Direccion" minlength="15" maxlength="60" name="address"></textarea>
                    </div>
                </div>
                <div>
                  <label class="form-label">Tipo de profesor</label>
                  <select class="form-select" aria-label="Default select example" name="professorTypeId" id="professorTypeSelectEdit" required>
                    <option selected>Seleccione una opcion</option>
                </select>
                </div>
                <div>
                  <label class="form-label">Departamento</label>
                  <select class="form-select" aria-label="Default select example" name="departmentId" id="departmentSelectEdit" required>
                    <option selected>Seleccione una opcion</option>
                  </select>
                </div>
                <div>
                  <label class="form-label">Estatus laboral</label>
                  <select class="form-select" aria-label="Default select example" name="active" required >
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                  </select>
                </div>
                <div class="col-6">
                  <button type="submit" class="btn btn-success">Editar</button>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" tabindex="-1" id="messageModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="btnClose">Close</button>
            </div>
          </div>
        </div>
      </div>


  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script type="module" src="../../js/administration/main.js"></script>
</body>
</html>