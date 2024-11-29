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
    <nav class="navbar navbar-expand-lg" style="background-color: #F4F7FB;">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">
            <img src="../../img/landing/unah-logo.png" alt="Bootstrap" width="100px" class="ms-5">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="ms-4 mt-3">
            <h1 class="mb-0">Portal SEDP</h1>
            <p>Administración del personal docente de la UNAH</p>
          </div>
          <div class="collapse navbar-collapse d-flex flex-row-reverse me-5" id="navbarNavDropdown">
            <ul class="navbar-nav gap-3">
              <li class="nav-item">
                <button class="btn d-flex align-items-center" style="background-color: #3472F8; color: #F4F7FB;" id="logoutBtn">
                    <img src="../../img/icons/logout-icon.svg" alt="" class="me-2">
                    Cerrar Sesión
                </button>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <div style="height: 3px; background-color: #FFAA34; width: 100%;"></div>

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
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Usuario</th>
                <th scope="col">Roles</th>
                <th scope="col">DNI</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody id="table-body">
              
            </tbody>
          </table>
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
                  <label class="form-label">Primer Nombre</label>
                    <input type="text" class="form-control uppercase" placeholder="e.g. Carlos" aria-label="Primer Nombre" name="firstName" pattern="^\w+$" required>
                  </div>
                  <div class="col">
                    <label class="form-label">Segundo Nombre</label>
                    <input type="text" class="form-control uppercase" placeholder="e.g. Alberto" aria-label="Segundo Nombre" name="secondName" pattern="^\w+(\s\w+)?$">
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                  <label class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" placeholder="e.g. Martinez" aria-label="Primer Apellido" name="firstLastName" pattern="^\w+$" required>
                  </div>
                  <div class="col">
                    <label class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" placeholder="e.g. Flores" aria-label="Segundo Apellido"  name="secondLastName" pattern="^\w+$">
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
                  <label class="form-label">Primer Nombre</label>
                    <input type="text" class="form-control" placeholder="e.g. Carlos" aria-label="Primer Nombre" name="firstName" pattern="^\w+$" required>
                  </div>
                  <div class="col">
                    <label class="form-label">Segundo Nombre</label>
                    <input type="text" class="form-control" placeholder="e.g. Alberto" aria-label="Segundo Nombre" name="secondName" pattern="^\w+(\s\w+)?$">
                  </div>
                </div>
                <div class="row my-2">
                  <div class="col">
                  <label class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" placeholder="e.g. Martinez" aria-label="Primer Apellido" name="firstLastName" pattern="^\w+$" required>
                  </div>
                  <div class="col">
                    <label class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" placeholder="e.g. Flores" aria-label="Segundo Apellido"  name="secondLastName" pattern="^\w+$">
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