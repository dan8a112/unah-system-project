# Documentación de Vistas


# **Login**

## **Descripción General**
El sistema de login permite la autenticación de múltiples roles de usuario mediante formularios específicos. Integra diversas tecnologías como HTML, CSS, PHP y JavaScript para ofrecer una experiencia segura y eficiente. Las credenciales se validan a través de APIs dedicadas, y el sistema asegura la gestión de sesiones y la protección de datos sensibles.

---

## **Estructura de Archivos del Login**
### Archivos principales involucrados:
1. **HTML y PHP:** Formularios de login diferenciados por roles en `public/assets/views/logins/`.
2. **JavaScript:** Manejo de interacciones y solicitudes HTTP en `public/assets/js/login/`.
3. **CSS:** Estilos personalizados en `public/assets/css/logins/login.css`.
4. **PHP:** Validaciones backend en `src/login/login.php`.
5. **Index.php:** Página de inicio que conecta múltiples elementos del sistema.

---

## **1. Página de Inicio: `Index.php`**
La página `Index.php` actúa como la puerta de entrada principal del sistema, ofreciendo una vista inicial para los usuarios.

### **Estructura y Componentes Principales:**
1. **Cabecera dinámica:**
   - Usa `include_once` para cargar la plantilla de cabecera (`headerPublic.php`) ubicada en `assets/views/templates/`.
   - Mejora la modularidad al permitir cambios centralizados en el diseño de la cabecera.

   ```php
   $path = "./assets/views/";
   include_once($path . "templates/headerPublic.php");
   ```

2. **Sección principal:**
   - Contiene una bienvenida y una descripción sobre la universidad.
   - Incluye un botón destacado con un enlace a `InformativeAdmission.php` que lleva a los usuarios a detalles sobre el proceso de admisión.

   ```html
   <div class="row align-items-center justify-content-center mt-5 gap-4 mx-5">
       <div class="slide-up col">
           <h1 class="display-4 mb-4">Emprende tu carrera universitaria aquí</h1>
           <p class="fs-5">UNAH es una institución autónoma, laica y estatal...</p>
           <a class="btn" style="background-color: #FFAA34;" id="admissionButton" href="assets/views/informative/InformativeAdmission.php">Ingresa ahora</a>
       </div>
       <img class="col primary-img" src="assets/img/landing/student-image.png" alt="Student Image">
   </div>
   ```

3. **Carreras destacadas:**
   - Presenta una lista de tarjetas con información sobre carreras importantes.
   - Cada tarjeta incluye una imagen, título y descripción breve.

   ```html
   <div class="card" style="width: 18rem;">
       <img src="assets/img/landing/is-image.jpg" class="card-img-top" alt="...">
       <div class="card-body">
           <h5 class="card-title">Ingeniería en Sistemas</h5>
           <p class="card-text">Es un campo interdisciplinario de la ingeniería...</p>
       </div>
   </div>
   ```

4. **Pie de página dinámico:**
   - Similar a la cabecera, usa `include_once` para cargar la plantilla de pie de página (`footer.php`).

   ```php
   include_once($path . "templates/footer.php");
   ```

5. **Modal interactivo:**
   - Proporciona una ventana modal para mensajes específicos, como información sobre el estado del proceso de admisión.

   ```html
   <div class="modal" tabindex="-1" id="modalDom">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Procesos de admisión</h5>
               </div>
               <div class="modal-footer">
                   <button class="btn btn-primary" id="closeModal">Ok.</button>
               </div>
           </div>
       </div>
   </div>
   ```

6. **Archivos JavaScript:**
   - `main.js`: Maneja eventos como el clic en el botón de admisión.
   - `bootstrap.bundle.min.js`: Asegura la compatibilidad y funcionalidad de Bootstrap.

   ```html
   <script src="assets/js/bootstrap.bundle.min.js"></script>
   <script src="assets/js/landingPage/main.js" type="module"></script>
   ```

### **Relación con otros Elementos:**
- **Recursos estáticos:**
  - CSS y JavaScript están organizados en carpetas (`assets/css`, `assets/js`).
  - Imágenes específicas para la página (`assets/img/landing/`).

- **Plantillas PHP:**
  - `headerPublic.php` y `footer.php` encapsulan la estructura común de la página.

### **Propósito:**
- Actuar como un punto de inicio intuitivo y atractivo para los usuarios.
- Conectar de manera eficiente las vistas y los recursos estáticos.

---

## **2. Formularios de Login**
Los formularios están organizados por roles (APA, CRI, Profesores, Coordinadores, Jefes de Departamento y SEDP), cada uno con su propia funcionalidad y diseño. 

### **Ejemplo: login_apa.php**
Este archivo maneja el inicio de sesión de administradores APA.

#### **Características:**
- Verificación de sesiones activas con `SessionValidation`.
- Diseño responsivo con Bootstrap.
- Integración de un formulario que incluye:
  - Campos obligatorios para correo y contraseña.
  - Botón para recuperación de contraseñas.

#### **Fragmento de Código:**
```php
<?php
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  session_start();

  if (SessionValidation::isValid($_SESSION, "apa")){
    header("Location: /assets/views/admission/administrative_home.php");
  }
?>
```

#### **Diseño del Formulario:**
```html
<form id="loginForm" data-login-key="APA">
    <input type="email" class="form-control" placeholder="Correo" name="mail" required>
    <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
</form>
```

### **Mención de Otros Formularios:**
- **`login_bosses.php`:** Para Jefes de Departamento, con redirección a la administración de secciones.
- **`login_coordinators.php`:** Para Coordinadores de Carrera, con acceso a la carga académica.
- **`login_cri.php`:** Diseñado para Revisores CRI, incluye validación de procesos activos.
- **`login_professors.php`:** Para Profesores, con funcionalidad de gestión académica.
- **`login_sedp.php`:** Para la administración SEDP, enfocado en la gestión docente.

Cada formulario sigue un esquema similar con adaptaciones específicas a las funciones del rol correspondiente. Esto incluye rutas de API, validaciones de sesión y estilos personalizados.
Los formularios están organizados por roles (APA, CRI, Profesores, etc.), cada uno con su propia funcionalidad y diseño. 

### **Ejemplo: login_apa.php**
Este archivo maneja el inicio de sesión de administradores APA.

#### **Características:**
- Verificación de sesiones activas con `SessionValidation`.
- Diseño responsivo con Bootstrap.
- Integración de un formulario que incluye:
  - Campos obligatorios para correo y contraseña.
  - Botón para recuperación de contraseñas.

#### **Fragmento de Código:**
```php
<?php
  include_once("../../../../src/SessionValidation/SessionValidation.php");
  session_start();

  if (SessionValidation::isValid($_SESSION, "apa")){
    header("Location: /assets/views/admission/administrative_home.php");
  }
?>
```

#### **Diseño del Formulario:**
```html
<form id="loginForm" data-login-key="APA">
    <input type="email" class="form-control" placeholder="Correo" name="mail" required>
    <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
</form>
```

---



## **Portal para SEDP (`sedp-portal.php`):**

**Propósito:**
- Proveer un portal de administración para gestionar el personal docente de la Universidad Nacional Autónoma de Honduras (UNAH).

### **Validación de Sesión:**
- **Verificación de Sesión:**
  - Se utiliza `SessionValidation::isValid` para verificar si la sesión es válida para el portal SEDP.
  - Si la sesión no es válida, el usuario es redirigido a la página de inicio de sesión correspondiente.

### **Estructura HTML:**
- **Encabezado:**
  ```php
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="date" content="04/11/2024">
      <meta name="version" content="0.1.0">
      <link rel="stylesheet" href="../../css/bootstrap.min.css">
      <link rel="stylesheet" href="../../css/sedp/sedp-portal.css">
      <title>Portal SEDP</title>
  </head>
  ```

- **Encabezado y barra lateral del portal:**
  - Se incluye el encabezado común y la barra lateral específica para el portal SEDP mediante `headerAdmission.php`.

### **Interfaz de Usuario:**
- **Información del docente:**
  - Se muestra la cantidad de docentes y un campo de búsqueda para buscar docentes por nombre.
  - **Botón de creación:**
    - Permite abrir un modal para agregar un nuevo docente.
  - **Tabla de docentes:**
    - Los docentes se muestran en una tabla que se actualiza dinámicamente.
  
### **Modal para Crear Docente (`#formModal`):**
- **Formulario de creación:**
  - Campos para capturar la información básica de un docente: número de identidad, nombres, apellidos, teléfono, fecha de nacimiento, dirección, tipo de profesor, y departamento.
  - Se valida el formato de los datos ingresados para asegurarse de que sean correctos.
  - Botón para enviar el formulario que agrega un nuevo docente a la base de datos.

### **Modal para Editar Docente (`#editModal`):**
- **Formulario de edición:**
  - Permite editar la información de un docente existente.
  - Similar al formulario de creación, pero con campos ya prellenados con la información existente del docente.
  - Incluye un campo para cambiar el estatus laboral (`activo/inactivo`).

### **Modal para mensajes (`#messageModal`):**
- **Comunicación de mensajes:**
  - Muestra mensajes de confirmación o error relacionados con la creación y edición de docentes.
  - Botón para cerrar el modal.

### **Interactividad:**
- **`main.js`:**
  - Gestiona las interacciones con los modales de creación y edición de docentes.
  - Maneja las acciones de búsqueda y actualización de la tabla de docentes.
  - Interactúa con el servidor para manejar los datos del docente.
  
---
# Documentación de Vistas: Portal Jefes de Departamento

## **Descripción General**
Las vistas del portal de Jefes de Departamento están diseñadas para facilitar la administración de procesos relacionados con secciones académicas, historial académico de los estudiantes, evaluaciones de docentes y calificaciones por período. Estas vistas aseguran que solo usuarios autenticados accedan al contenido mediante validaciones de sesión.

---

## **Vistas Incluidas**
1. `academic_history.php`
2. `administrate_sections.php`
3. `evaluations_detail.php`
4. `period_grades.php`
5. `professor_evaluations.php`
6. `section_grades.php`
7. `students.php`

Cada una de estas vistas utiliza componentes comunes como encabezados, barras laterales y scripts personalizados.

---

## **1. Historial Académico: `academic_history.php`**

### **Propósito:**
Permite a los jefes de departamento consultar el historial académico de los estudiantes, incluyendo información general y métricas clave como índice global y de período.

### **Características Principales:**
- **Validación de Sesión:**
  Verifica que el usuario tenga una sesión activa y coincida con los parámetros de la URL.
  ```php
  if (!SessionValidation::isValid($_SESSION, $portal)){
      header("Location: /assets/views/logins/login_bosses.php");
  } else {
      if (!SessionValidation::validateParam("id", $userId)) {
          header("Location: /assets/views/administration/bosses/academic_history.php?id=".$userId);
          exit;
      }
  }
  ```

- **Estructura del Contenido:**
  - **Encabezado y barra lateral:**
    Utiliza plantillas reutilizables como `headerAdmission.php` y `bossSidebar.php`.
  - **Información General del Estudiante:**
    Incluye detalles como nombre, carrera, cuenta, índices académicos y centro asociado.
  ```html
  <div class="profile">
      <img id="profileImg" class="profileImg" src="https://i.scdn.co/image/ab67616d0000b273ca964f2c3c069b3fb9ec11be" alt="">
      <div class="profile-info">
          <h3 id="studentName"></h3>
          <div class="d-flex gap-2">
              <p id="studentCareer"></p>
              <p>-</p>
              <p id="studentAcount"></p>
          </div>
      </div>
      <p id="studentDescription"></p>
  </div>
  ```

- **Scripts y Estilos:**
  - CSS: Utiliza estilos específicos de historial académico y plantillas generales.
  - JS: Scripts modulares para manejar eventos y obtener información dinámica.
  ```html
  <script src="../../../js/students/academic_historic/main.js" type="module"></script>
  ```

---

## **2. Administración de Secciones: `administrate_sections.php`**

### **Propósito:**
Facilita la gestión de secciones académicas, permitiendo crear, editar y eliminar secciones, así como asignar docentes, aulas y horarios.

### **Características Principales:**
- **Validación de Sesión:**
  Similar a `academic_history.php`, verifica que el usuario esté autenticado y que los parámetros sean válidos.
  ```php
  if (!SessionValidation::isValid($_SESSION, $portal)) {
      header("Location: /assets/views/logins/login_professors.php");
  } else {
      if (!SessionValidation::validateParam("id", $userId)) {
          header("Location: /assets/views/administration/bosses/administrate_sections.php?id=" . $userId);
          exit;
      }
  }
  ```

- **Secciones del Contenido:**
  - **Encabezado y barra lateral:**
    Incluye elementos como `headerAdmission.php` y `bossSidebar.php`.
  - **Gestión de Secciones:**
    Proporciona una lista de secciones existentes y un botón para crear nuevas secciones.
  ```html
  <div class="d-flex me-2">
      <button class="btn d-flex align-items-center" style="background-color: #FFAA34; color: #F4F7FB;" id="createBtn">
          <img src="/assets/img/icons/add-circle.svg" alt="" class="me-2">
          Crear
      </button>
  </div>
  ```

- **Modal de Creación de Sección:**
  Permite seleccionar clases, días, horarios, profesores y aulas para configurar una nueva sección.
  ```html
  <div class="modal fade" tabindex="-1" id="addSectionModal">
      <form id="addSectionForm">
          <label class="form-label">Selecciona una clase</label>
          <select class="form-select" name="class" id="classesSelect" required></select>
          <label class="form-label">Dias</label>
          <select class="form-select" name="days" id="daysSelect" required></select>
          <label class="form-label">Hora de inicio</label>
          <select class="form-select" name="startHour" id="startHourSelect" required></select>
      </form>
  </div>
  ```

- **Scripts y Estilos:**
  - CSS: Incluye plantillas de estilo general y específicas para secciones.
  - JS: Maneja eventos relacionados con la creación y edición de secciones.
  ```html
  <script src="../../../js/administration/bosses/sections/main.js" type="module"></script>
  ```

---

## **3. Detalle de Evaluaciones: `evaluations_detail.php`**

### **Propósito:**
Proporciona una vista detallada de las evaluaciones de los docentes, incluyendo secciones asignadas y calificaciones.

### **Características Principales:**
- **Breadcrumbs y Navegación Contextual:**
  Ayuda a navegar entre evaluaciones y docentes de forma estructurada.
  ```php
  $links = [
      ['title' => 'Evaluaciones de docentes', 'url' => '/assets/views/administration/bosses/professor_evaluations.php'],
      ['title' => 'Docente', 'url' => '/evaluaciones']
  ];
  include_once($path . "templates/breadCrumb.php");
  ```

- **Secciones y Evaluaciones:**
  Muestra las secciones del docente seleccionado y permite seleccionar una para ver sus calificaciones detalladas.
  ```html
  <section id="sectionsContainer" class="d-flex gap-5 mb-4"></section>
  <section class="mb-4 mx-3" id="evaluationsContainer"></section>
  ```

- **Modal de Evaluación:**
  Permite ver detalles específicos de las evaluaciones en un modal interactivo.
  ```html
  <div class="modal fade" tabindex="-1" id="evaluationModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-body"></div>
          </div>
      </div>
  </div>
  ```

---

## **4. Calificaciones por Período: `period_grades.php`**

### **Propósito:**
Permite evaluar el rendimiento de los estudiantes por período, mostrando las calificaciones organizadas por secciones y períodos académicos.

### **Características Principales:**
- **Cambio de Período:**
  Selección dinámica de períodos académicos para filtrar las secciones y calificaciones correspondientes.
  ```html
  <select class="form-select" aria-label="Default select example" id="period" name="period">
      <option selected>Seleccione una opción</option>
  </select>
  ```

- **Gestión de Calificaciones:**
  Permite modificar o revisar calificaciones existentes mediante formularios específicos.
  ```html
  <div id="section-table"></div>
  ```

- **Modal de Edición:**
  Ofrece la funcionalidad de modificar parámetros como cupos, aulas y docentes asignados.
  ```html
  <div class="modal fade" tabindex="-1" id="actionsModal">
      <form id="addSectionForm">
          <select name="professor" id="departmentSelectEdit" required></select>
      </form>
  </div>
  ```

---
## **5. Evaluaciones de Docentes: `professor_evaluations.php`**

**Propósito:**

Proporciona una vista para evaluar el rendimiento de los docentes según los estudiantes.

**Características Principales:**

- **Encabezado y barra lateral:** Utiliza `headerAdmission.php` y `bossSidebar.php` para la estructura común del portal.
```php
include_once($path . "templates/headerAdmission.php");
include_once($path . "templates/professors/bossSidebar.php");
```
- **Lista de Docentes:** Muestra una lista de docentes y permite seleccionar uno para ver sus evaluaciones.

```html
<div class="d-flex justify-content-between my-2 mx-4">
    <select id="professorSelect" class="form-select" aria-label="Default select example">
        <option selected>Seleccione un profesor</option>
        <!-- Opciones dinámicas aquí -->
    </select>
</div>
<section id="professorsContainer" class="d-flex gap-5 mb-4"></section>
```

- **Detalles de Evaluación:** Proporciona un detalle de las evaluaciones y permite ver los comentarios de los estudiantes.

```html
<section id="evaluationsContainer" class="mb-4 mx-3"></section>
```

- **Modal de Evaluación:** Permite ver y editar las evaluaciones de forma interactiva.

    <div class="modal fade" tabindex="-1" id="evaluationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

**Scripts y Estilos:**

- **JS:**
    - Manejo de eventos y lógica de interacción de datos.
    - Validación y manejo de formularios.

```html
<script src="../../../js/administration/bosses/evaluations/main.js" type="module"></script>
```
- **CSS:**

    - Estilos específicos para evaluar docentes.
    - Inclusión de plantillas generales.

```html
<link rel="stylesheet" href="../../../styles/evaluation.css">
```
---


## **6. Periodo de Calificaciones: section_grades.php**

**Propósito:**

- Valida la sesión de los jefes de departamento y proporciona una vista para gestionar las calificaciones del periodo.

**Código PHP:**

```php
<?php
  include_once("../../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  $portal = "bosses";

  if (!SessionValidation::isValid($_SESSION, $portal)){
    header("Location: /assets/views/logins/login_professors.php");
  }else{

    $userId = $_SESSION['portals'][$portal]['user'];

    //Si los parametros no coinciden con los de la sesion se corrigen
    if (!SessionValidation::validateParam("id", $userId)) {
        header("Location: /assets/views/administration/bosses/period_grades.php?id=".$userId);
        exit;
    }
  }
?>
```

**HTML:**

- **Encabezado y barra lateral:** Incluye los archivos necesarios para la estructura común.
```php
<?php
include_once($path . "templates/headerAdmission.php");
?>
```
```php
<?php
include_once($path . "templates/professors/bossSidebar.php");
?>
```

- **Interfaz Principal:**
  - Título y descripción del portal.
  - Selección de periodos.
  - Tabla de secciones del periodo.

```html
<main class="row">
    <section class="col mx-4">
        <div class="my-4">
            <div class="d-flex align-items-center">
                <h1 class="display3 me-3" id="processName">Calificaciones del periodo</h1>
                <div class="status-card" style="background-color: #00C500;" id="currentPeriod"></div>
            </div>
            <p>Evalua el rendimiento de los estudiantes este periodo, revisando sus calificaciones.</p>
        </div>

        <div class="mt-5 d-flex-col card-container">
            <div class="d-flex justify-content-between">
                <div class="ms-2">
                    <span class="fs-4 me-2 fw-bold">Secciones de este periodo</span>
                </div>
                <div class="d-flex me-2 align-items-sm-center gap-2">
                    <h6>Periodo</h6>
                    <select class="form-select" aria-label="Default select example" id="period" name="period">
                        <option selected>Seleccione una opcion</option>
                    </select>
                </div>
            </div>
            <hr>
            <div id="section-table"></div>
        </div>
    </section>
</main>
```

- **Modal de Acción:**
  - Permite la edición de secciones, aumento de cupos y asignación de aula.

```html
<div class="modal fade" tabindex="-1" id="addSectionModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="addSectionForm" data-id-professor>
                    <div>
                        <label class="form-label">Selecciona una clase</label>
                        <select class="form-select" aria-label="Default select example" name="class" id="professorTypeSelectEdit" required>
                            <option selected>Clases</option>
                        </select>
                    </div>
                    <div class="row my-2">
                        <div class="col">
                            <label class="form-label">Selecciona la hora</label>
                            <select class="form-select" aria-label="Default select example" name="hour" id="departmentSelectEdit" required>
                                <option selected>Seleccione una opcion</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Cupos</label>
                            <input type="text" class="form-control" placeholder="e.g. 20" name="places" pattern="\d{2}" required>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Asigna un Docente</label>
                        <select class="form-select" aria-label="Default select example" name="professor" id="professorTypeSelectEdit" required>
                            <option selected>Docentes</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Elije una aula</label>
                        <select class="form-select" aria-label="Default select example" name="classroom" id="professorTypeSelectEdit" required>
                            <option selected>Aulas disponibles</option>
                        </select>
                    </div>
                    <div class="mt-4 col-6 text-center w-100">
                        <button type="submit" class="btn" style="background-color: #FFAA34;">Crear Sección</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="actionsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="addSectionForm" data-id-professor>
                    <div class="row my-2">
                        <span class="me-2">Sección</span>
                        <span class="fs-4">1100</span>
                    </div>
                    <div class="row my-2">
                        <div class="col-8">
                            <label class="form-label">Docente Asignado</label>
                            <select class="form-select" aria-label="Default select example" name="professor" id="departmentSelectEdit" required>
                                <option selected>Seleccione una opcion</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Aumentar Cupos</label>
                            <div style="position: relative;">
                                <input type="text" class="form-control" placeholder="e.g. 20" name="places" pattern="\d{2}" required>
                                <div class="btn" style="position: absolute; right: 0; top:0; background-color: #FFAA34;"><img src="/assets/img/icons/add-circle.svg" alt=""></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Aula asignada</label>
                        <select class="form-select" aria-label="Default select example" name="classroom" id="professorTypeSelectEdit" required>
                            <option selected>Aulas disponibles</option>
                        </select>
                    </div>
                </form>
                <section id="studentsWaitingTable"></section>
                <div class="mt-4 col-6 text-center w-100">
                    <button type="submit" class="btn" style="background-color: #FFAA34;">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>
```

**Scripts y Estilos:**

- **JS:**
  - Manejo de eventos y lógica de interacción de datos.
  - Validación y manejo de formularios.

```html
<script src="../../../js/bootstrap.bundle.min.js"></script>
<script src="../../../js/administration/bosses/period_grades/main.js" type="module"></script>
<script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
```

## **9. Estudiantes: `Students.php`**

**Propósito:**

- Proporciona una interfaz para los jefes de departamento para buscar estudiantes matriculados en la universidad.

**PHP:**

- **Validación de Sesión:**
  - Verifica si el usuario ha iniciado sesión correctamente y si tiene el portal adecuado.
```php
<?php
  include_once("../../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  $portal = "bosses";

  if (!SessionValidation::isValid($_SESSION, $portal)){
    header("Location: /assets/views/logins/login_professors.php");
  }else{

    $userId = $_SESSION['portals'][$portal]['user'];

    //Si los parametros no coinciden con los de la sesion se corrigen
    if (!SessionValidation::validateParam("id", $userId)) {
        header("Location: /assets/views/administration/bosses/students.php?id=".$userId);
        exit;
    }
  }
?>
```

- **Encabezado:**
  - Incluye el título y los estilos necesarios para la página.
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secciones</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/temas/cards.css">
    <link rel="stylesheet" href="../../../css/templates/professor.css">
</head>
<body>
<?php
    $title = "Portal Jefes de departamentos";
    $description = "Jefes de departamento, administra los procesos de matricula y mas";
    $path = "../../";
    include_once($path . "templates/headerAdmission.php");
?>
```

- **Encabezado y barra lateral:**
  - Incluye el encabezado del portal y la barra lateral para jefes de departamento.
```php
<?php
    $path = "../../";
    $selected = 4;
    include_once($path . "templates/professors/bossSidebar.php");
?>
```

- **Interfaz Principal:**
  - Búsqueda de estudiantes por número de cuenta.
  - Muestra los resultados de la búsqueda o un mensaje si no hay resultados.
```php
<div class="row align-items-center">
    <div class="my-4 col-7">
        <div class="d-flex align-items-center ">
            <h1 class="display3 me-3" id="processName">Estudiantes</h1>
            <div class="status-card" style="background-color: #00C500;" id="periodName"></div>
        </div>
        <span>En esta pantalla podras buscar a caulquier estudiante matriculado en la Universidad</span>
    </div>
</div>

<div id="content" class="mt-2 d-flex-row">
    <div class="mt-2 d-flex align-items-center justify-content-end">
        <span class="me-3">Busca a un estudiante por su número de cuenta:</span>
        <form id="search-form" class="input-group w-50">
            <input type="text" name="searchIndex" class="form-control" id="search-input" placeholder="Buscar por número de cuenta">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>
    <hr class="w-20 mt-5">
    <span style="font-weight: bold;" >Resultados:</span>
    <div id="section-table"></div>
</div>
<div id="no-search-message" class="alert alert-info mt-3 w-100 text-center">
    Aún no ha realizado una búsqueda.
</div>
```

- **Scripts:**
  - Scripts necesarios para el funcionamiento de las funcionalidades, como Bootstrap y el script `main.js` para la lógica específica de esta página.
```html
<script src="../../../js/bootstrap.bundle.min.js"></script>
<script src="../../../js/administration/coordinators/academic_historic/main.js" type="module" data-user="1"></script>
<script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>
</html>
```

---

## **Componentes Reutilizables**
Todas las vistas utilizan componentes comunes:
1. **Encabezado:**
   ```php
   include_once($path . "templates/headerAdmission.php");
   ```
2. **Barra Lateral:**
   ```php
   include_once($path . "templates/professors/bossSidebar.php");
   ```
3. **Breadcrumbs:**
   Proporcionan navegación contextual.
   ```php
   include_once($path . "templates/breadCrumb.php");
   ```

---



## **Documentación de Vistas: Portal Coordinadores de Carrera**

### **Descripción General:**
Las vistas del portal de Coordinadores de Carrera están diseñadas para facilitar la administración de procesos estudiantiles, incluyendo el historial académico de los estudiantes y la carga académica. Estas vistas aseguran que solo usuarios autenticados accedan al contenido mediante validaciones de sesión.

### **Vistas Incluidas:**
- **academic_historic.php**
- **academic_load.php**
- **students.php**

Cada vista utiliza componentes comunes como encabezados, barras laterales y scripts personalizados.

---

### **1. academic_historic.php:**
**Propósito:**
- Permite a los coordinadores ver el historial académico de los estudiantes, incluyendo las materias cursadas y las calificaciones obtenidas.

**PHP:**
- **Validación de Sesión:**
  - Verifica si el usuario ha iniciado sesión correctamente y si tiene el portal adecuado.
```php
<?php
  include_once("../../../../../src/SessionValidation/SessionValidation.php");
  
  session_start();

  $portal = "coordinators";

  if (!SessionValidation::isValid($_SESSION, $portal)){
    header("Location: /assets/views/logins/login_coordinators.php");
  }else{

    $userId = $_SESSION['portals'][$portal]['user'];

    //Si los parametros no coinciden con los de la sesion se corrigen
    if (!SessionValidation::validateParam("id", $userId)) {
        header("Location: /assets/views/administration/coordinators/academic_historic.php?id=".$userId);
        exit;
    }
  }
?>
```

- **Encabezado:**
  - Incluye el título y los estilos necesarios para la página.
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secciones</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../css/templates/professor.css">
    <link rel="stylesheet" href="../../../css/temas/cards.css">
    <link rel="stylesheet" href="../../../css/students/academic_history.css">
    <link rel="stylesheet" href="../../../css/templates/breadCrumb.css">
</head>
<body>
<?php
    $portal = "coordinators";
    $title = "Portal Coordinadores de carrera";
    $description = "Coordinadores de carrera, administra los procesos estudiantiles.";
    $path = "../../";
    include_once($path . "templates/headerAdmission.php");
    ?>
```

- **Encabezado y barra lateral:**
  - Incluye el encabezado del portal y la barra lateral para coordinadores de carrera.
```php
<?php
    $path = "../../";
    $selected = 3;
    include_once($path . "templates/professors/coordinatorsSidebar.php");
?>
```

- **Interfaz Principal:**
  - Incluye navegación de breadcrumb para facilitar la navegación en la página.
```php
<section class="col mx-4 big-container">
<?php 
    $path = "../../";
    $links = [
        ['title' => 'Estudiantes', 'url' => '/assets/views/administration/coordinators/students.php'],
        ['title' => 'historial', 'url' => '/calificaciones']
      ];

    include_once($path . "templates/breadCrumb.php");
?>
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
        </div>
    </div>

    <div id="section-table" style="margin-bottom: 200px;">
    </div>
</section>
```

- **Scripts:**
  - Scripts necesarios para el funcionamiento de las funcionalidades, como Bootstrap y el script `main.js` para la lógica específica de esta página.
```html
<script src="../../../js/bootstrap.bundle.min.js"></script>
<script src="../../../js/students/academic_historic/main.js" type="module"></script>
<script src="../../../js/behaviorTemplates/professors/sidebar.js"></script>
</body>
</html>
```

---

## **2. academic_load.php:**

**Propósito:**
- Esta vista asegura que los coordinadores puedan gestionar y obtener informes de la carga académica de manera eficiente y en tiempo real, mejorando así la administración de recursos educativos.


### **Requisitos de Sesión:**
- **Validación de Sesión:** 
  - Se usa la función `SessionValidation::isValid` para verificar que el usuario tenga una sesión válida en el portal de coordinadores.
  - Si la sesión no es válida, se redirige al usuario a la página de inicio de sesión correspondiente.

### **Estructura HTML:**
- **Encabezado:**
  ```php
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Secciones</title>
      <link rel="stylesheet" href="../../../css/bootstrap.min.css">
      <link rel="stylesheet" href="../../../css/temas/cards.css">
      <link rel="stylesheet" href="../../../css/templates/professor.css">
  </head>
  ```

- **Barra lateral y encabezado personalizados:**
  - `coordinatorsSidebar.php` se incluye para mostrar la barra lateral específica del portal de coordinadores.
  - `headerAdmission.php` es el encabezado común para todas las vistas del portal.

### **Carga Académica:**
- **Secciones y Período:**
  - Se visualizan las secciones del periodo académico seleccionado.
  - Un selector de período permite a los coordinadores cambiar entre diferentes periodos académicos.

- **Interactividad y Descarga:**
  - Botón para descargar la carga académica.
  - Contenedor dinámico (`section-table`) donde se presentan las secciones del periodo seleccionado.

### **Scripts:**
- **`main.js`**:
  - Este script maneja la carga dinámica de datos para las secciones, la gestión de la interfaz de usuario y la interacción con el servidor para descargar la carga académica.

---

---

## **3. students.php:**

**Propósito:**
- Permite a los coordinadores buscar y gestionar información de los estudiantes matriculados en la universidad.

### **Requisitos de Sesión:**
- **Validación de Sesión:**
  - Se utiliza `SessionValidation::isValid` para asegurarse de que el usuario esté autenticado en el portal de coordinadores.
  - Si la sesión no es válida, se redirige al usuario a la página de inicio de sesión correspondiente.

### **Estructura HTML:**
- **Encabezado:**
  ```php
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Estudiantes</title>
      <link rel="stylesheet" href="../../../css/bootstrap.min.css">
      <link rel="stylesheet" href="../../../css/temas/cards.css">
      <link rel="stylesheet" href="../../../css/templates/professor.css">
  </head>
  ```

- **Barra lateral y encabezado personalizados:**
  - Se incluye `coordinatorsSidebar.php` para mostrar la barra lateral del portal de coordinadores.
  - `headerAdmission.php` es el encabezado común para todas las vistas del portal.

### **Funcionalidad de Búsqueda:**
- **Formulario de Búsqueda:**
  - Permite a los coordinadores buscar estudiantes por su nombre o número de cuenta.
  - Se incluye un campo de entrada y un botón de búsqueda.

- **Resultados de la Búsqueda:**
  - Los resultados de la búsqueda se muestran dinámicamente en `section-table`.
  - Se proporciona un mensaje informativo (`no-search-message`) cuando no se ha realizado una búsqueda.

### **Interactividad:**
- **`main.js`**:
  - Gestiona la búsqueda de estudiantes.
  - Muestra y actualiza los resultados en tiempo real según los criterios de búsqueda.
  - Interactúa con el servidor para recuperar los datos de los estudiantes.

---



## **Documentación de Vistas: Portal APA (Admisión)**

### **Descripción General**
Las vistas del portal de Admisión están diseñadas para facilitar la administración de procesos relacionados con la inscripción de estudiantes, seguimiento de históricos académicos, evaluaciones de docentes y calificaciones por período. Estas vistas aseguran que solo usuarios autenticados accedan al contenido mediante validaciones de sesión.

### **Vistas Incluidas:**
- **administrative_home.php**
- **cri_portal.php**
- **inscription_view.php**
- **process_detail_active.php**
- **process_detail_historic.php**

Cada una de estas vistas utiliza componentes comunes como encabezados, barras laterales y scripts personalizados.

---

### **1. `administrative_home.php`:**

**Propósito:**
- Proveer un portal para la administración de sistemas de admisiones en la UNAH.

**Validación de Sesión:**
- **Verificación de Sesión:**
  - Se utiliza `SessionValidation::isValid` para verificar si la sesión es válida para el portal APA.
  - Si la sesión no es válida, el usuario es redirigido a la página de inicio de sesión correspondiente.

**Estructura HTML:**
- **Encabezado:**
  ```php
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="date" content="11/11/2024">
      <meta name="version" content="0.1.1">
      <link rel="stylesheet" href="../../css/bootstrap.min.css">
      <link rel="stylesheet" href="../../css/admission/admision_home.css">
      <link rel="stylesheet" href="../../css/admission/timeline.css">
      <title>Portal APA</title>
  </head>
  ```

- **Encabezado y barra lateral del portal:**
  - Se incluye el encabezado común y la barra lateral específica para el portal APA mediante `headerAdmission.php`.

### **Interfaz de Usuario:**
- **Bienvenida y Descripción:**
  - Se proporciona un mensaje de bienvenida y descripción del portal.
  - Herramientas y recursos para la gestión de procesos de admisión de la universidad.

- **Gráfica de Administración de Admisiones:**
  - Se presenta un gráfico de barras que muestra el estado de los procesos de admisión.
  - Facilita la visualización rápida de datos estadísticos relacionados con la cantidad de aplicaciones recibidas y procesos completados.

- **Timeline de Procesos de Admisión:**
  - Una línea de tiempo interactiva que muestra los eventos y hitos importantes en el proceso de admisión.
  - Permite al usuario hacer un seguimiento de las etapas del proceso y su progreso.

- **Interactividad:**
  - **`main.js`:**
    - Gestiona las interacciones con los componentes del portal, como la actualización dinámica de la gráfica y la línea de tiempo.
    - Maneja la comunicación con el servidor para obtener los datos mostrados en el gráfico y la línea de tiempo.
  - **Eventos:**
    - El usuario puede hacer clic en elementos específicos del gráfico para obtener detalles adicionales sobre los datos representados.
    - Los eventos en la línea de tiempo proporcionan información detallada sobre cada etapa del proceso de admisión.

---


### **2. `cri_portal.php`:**

**Propósito:**
- Proveer una interfaz para el Comité de Revisión de Inscripciones para revisar y gestionar las inscripciones de los estudiantes.

**Validación de Sesión:**
- **Verificación de Sesión:**
  - Se utiliza `SessionValidation::isValid` para verificar si la sesión es válida para el portal CRI.
  - Si la sesión no es válida, el usuario es redirigido a la página de inicio de sesión correspondiente.
  - Si el ID de usuario en la sesión no coincide con el parámetro 'id' de la URL, el usuario es redirigido a su propia página del portal.

**Estructura HTML:**
- **Encabezado:**
  ```php
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Portal CRI</title>
      <link rel="stylesheet" href="../../css/temas/cards.css">
      <link rel="stylesheet" href="../../css/admission/cri_portal.css">
      <link rel="stylesheet" href="../../css/bootstrap.min.css">
  </head>
  ```

- **Encabezado y barra lateral del portal:**
  - Se incluye el encabezado común y la barra lateral específica para el portal CRI mediante `headerAdmission.php`.

### **Interfaz de Usuario:**
- **Revisión de Inscripciones:**
  - Se proporciona un mensaje de bienvenida y una descripción del portal.
  - Información y estadísticas sobre el proceso de admisión.
- **Información de Meta de Hoy y Revisadas:**
  - Tarjetas que muestran la meta diaria de revisiones y la cantidad total de inscripciones revisadas.
  - Cada tarjeta incluye información estadística y gráfica relevante.

- **Inscripciones Por Revisar:**
  - Sección que muestra las inscripciones pendientes de revisión.
  - Tabla interactiva que permite al usuario ver y revisar cada inscripción.
  - Cada fila de la tabla muestra detalles de la inscripción, incluyendo nombre, carrera principal, y fecha de inscripción.

- **Inscripciones Revisadas:**
  - Sección que muestra las inscripciones que ya han sido revisadas por el usuario.
  - Se visualizan los detalles de cada inscripción con un dictamen (aprobada o rechazada).

- **Modal para Datos de Inscripción:**
  - Modal que muestra los detalles completos de una inscripción cuando el usuario hace clic en una fila de la tabla.
  - Contiene información personal del estudiante, datos de inscripción y documentos adjuntos.
  - Botones para aprobar o rechazar la inscripción directamente desde el modal.

**Interactividad:**
- **`main.js`:**
  - Gestiona las interacciones con los componentes del portal, como la actualización dinámica de estadísticas y la gestión de inscripciones revisadas.
  - Maneja la comunicación con el servidor para obtener los datos mostrados en las tablas y el modal.
- **Eventos:**
  - Los usuarios pueden aprobar o rechazar inscripciones directamente desde el modal.
  - Actualiza automáticamente las tablas de inscripciones revisadas y por revisar después de cada acción.

---

### **3. `inscription_view.php`**

La vista `inscription_view.php` es la página utilizada para realizar el proceso de inscripción en un examen de admisión. A continuación se explica cada sección y los fragmentos de código más relevantes de la vista:

### Encabezado
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
```
- **Encabezado HTML**: Define los metadatos esenciales como charset, viewport, y la autoría de la vista.
- **Llamado al encabezado público**: Incluye el archivo `headerPublic.php` que probablemente contiene el menú superior y la navegación pública común en el portal.

### Formulario de Inscripción
```php
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
                  <input class="form-control" type="file" id="formFile" name="pathSchoolCertificate" accept=".pdf,image/" required title="Solo se permiten archivos PDF o imágenes (JPEG, PNG, GIF).">
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
```
- **Datos Generales**: Se solicitan información personal como nombres, apellidos, número de identidad, correo electrónico y número de teléfono. Estos campos incluyen patrones de validación para garantizar que los datos introducidos sean correctos.
- **Datos de carrera**: Permite seleccionar el campus y las carreras principales y secundarias a las que el usuario desea aplicar.
- **Estudios previos**: Permite la carga de un certificado de estudios de secundaria, verificando que el archivo sea un PDF o una imagen, y que tenga un tamaño dentro de los límites especificados.

### Popups
- **Popup de éxito**:
  ```html
  <div class="popup" id="popup">
      <img src="../../img/icons/check.svg" alt="">
      <h2>Felicidades!</h2>
      <p id="exitMessage"></p>
      <button type="button" id="buttonOk1">OK</button>
  </div>
  ```
  - Utilizado para mostrar un mensaje de éxito cuando la inscripción se ha realizado correctamente.
- **Popup de error**:
  ```html
  <div class="popup" id="popupError" style="border: solid 1px #EC0000;">
      <img src="../../img/icons/error.svg" alt="">
      <h2>Error!</h2>
      <p id="message"></p>
      <button type="button" id="buttonOk2">OK</button>
  </div>
  ```
  - Muestra un mensaje de error en caso de que algo salga mal durante el proceso de inscripción.

### Scripts
```html
<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="../../js/admission/inscription/main.js" type="module"></script>
```
- **scripts.js**: Contiene lógica JavaScript para manejar la interacción con el usuario, como la validación de campos, la carga de datos de las carreras y la gestión de los archivos subidos.
  
---

### **4. `process_detail_active.php`:**

- Este archivo `process_detail_active.php` es una vista principal dentro del portal APA que proporciona información clave sobre el proceso de admisión y permite la gestión de los datos a través de la interfaz administrativa.

1. **Validación de sesión**:
   - `SessionValidation::isValid($_SESSION, "apa")` verifica si la sesión es válida para el usuario con rol "apa". Si la validación falla, redirige al usuario a la página de inicio de sesión `login_apa.php`.

2. **Encabezado y navegación**:
   - Se incluyen los archivos CSS y JS necesarios para el diseño y funcionalidad de la página.
   - `headerAdmission.php` se incluye para mostrar la barra de navegación específica del portal APA.

3. **Información del proceso**:
   - Se muestra el nombre del proceso, su estado y las fechas de inicio y fin.
   - Se visualizan las estadísticas como la cantidad de inscripciones realizadas.
   - Se utiliza `id` para agregar dinámicamente datos específicos mediante JavaScript.

4. **Carga de CSV**:
   - Se proporciona una sección para subir un archivo CSV con las calificaciones de los estudiantes.
   - El modal `uploadCSVModal` permite subir este archivo y luego procesar las calificaciones una vez que se confirme la subida.

5. **Modal de enviar correos**:
   - `sendEmails` es un modal que ofrece la opción de enviar correos electrónicos a los estudiantes con los resultados de sus pruebas.
   - Contiene un botón para cerrar el modal y otro para enviar los correos electrónicos.

6. **Scripts**:
   - `main.js` maneja la lógica del procesamiento de los datos en esta página, incluyendo la subida de archivos CSV y el envío de correos electrónicos.

---
### **5. `process_detail_historic.php`:**

El código `process_detail_historic.php` es una página para mostrar los detalles históricos de un proceso de admisión. Incluye metadatos para la descripción y autoría, y usa estilos y scripts de Bootstrap para su diseño y funcionalidad. Aquí tienes el análisis y algunas recomendaciones para mejorar el código:

### Análisis del Código

1. **Validación de sesión**:
   - La validación de sesión se realiza correctamente al llamar a `SessionValidation::isValid($_SESSION, "apa")`. Si la sesión no es válida, se redirige al login.
   
2. **Encabezado**:
   - Se incluye un encabezado común mediante `include_once` que proporciona navegación y descripción del portal. Esto mantiene el código modular y reutilizable.
   
3. **Información del proceso**:
   - Se muestran los nombres del proceso, las fechas de inicio y fin, el estado y las estadísticas como la cantidad de inscripciones y aprobados.
   - Hay una sección dedicada para mostrar estadísticas adicionales, como la cantidad de inscripciones por centro de estudio.

4. **Modals**:
   - Se utilizan dos modales: uno para mostrar detalles adicionales sobre el proceso de admisión y otro para confirmar la acción con un botón.
   - Los modales están bien definidos pero podrían mejorarse visualmente para una mejor usabilidad.
   
5. **Carga de archivos y envíos de correos**:
   - Los modales para cargar archivos CSV y enviar correos electrónicos son similares a `process_detail_active.php`, proporcionando funcionalidades para subir datos y enviar notificaciones a los estudiantes.

---



##  `Informative_admissions.php` 

`Informative_admissions.php` es una vista diseñada para proporcionar información general sobre el sistema de admisiones de la UNAH. Esta página se centra en educar al usuario sobre el proceso de admisión y las funciones del sistema de admisiones en la universidad.

### Análisis y Descripción del Código

1. **Encabezado**:
   - El archivo incluye las metadatas necesarias como el charset y la vista del meta para la responsividad (`viewport`).
   - Se enlazan las hojas de estilo (`CSS`) necesarias:
     - `bootstrap.min.css` para el diseño básico y componentes de la interfaz de usuario.
     - `animations/slides.css` para posibles animaciones.
     - `informative/informativePage.css` para estilos específicos de la página informativa.
   - Se establece el título de la página.

2. **Encabezado de la Página**:
   - Se incluye el encabezado del portal mediante `include_once` con el archivo `headerPublic.php`. Esto ayuda a mantener el encabezado consistente en todas las vistas del sitio web.

3. **Contenido Principal**:
   - Una imagen de fondo que describe el sistema de admisiones de la UNAH.
   - Un encabezado principal `<h1>` que destaca el tema de la página.
   - Un breve párrafo que explica cómo funciona el sistema de admisiones de la UNAH, especificando su propósito y las funciones que cumple para los aspirantes y los estudiantes.
   - Un botón de llamada a la acción que redirige al usuario a la página de inscripción.

4. **Pie de Página**:
   - Se incluye el pie de página común para todo el sitio mediante `include_once` con el archivo `footer.php`.

5. **Script Principal**:
   - Se incluye `bootstrap.bundle.min.js` para las funcionalidades interactivas de Bootstrap.

---
















### **1. `class_detail.php` para Profesores**

`class_detail.php` es una vista dentro del portal para profesores, diseñada para proporcionar una visión detallada de una clase específica, incluyendo horarios, cantidad de estudiantes, unidades valorativas, y otras estadísticas relacionadas. Esta vista es parte de las vistas del portal de Jefes de Departamento y está protegida por validaciones de sesión para asegurar que solo los profesores autenticados puedan acceder.



1. **Validación de Sesión**:
   - Se incluye el archivo `SessionValidation.php` para manejar la validación de sesión.
   - `session_start()` inicia la sesión para el usuario.
   - Se establece la variable `$portal` con el valor `"professors"` para identificar el contexto de la sesión.
   - Se valida que la sesión del usuario sea válida para el portal de profesores.
   - Si la validación falla, redirige al usuario a la página de inicio de sesión específica para profesores.

2. **Encabezado**:
   - El documento utiliza un `<!DOCTYPE>` y la declaración `<html>` para definir el idioma y el conjunto de caracteres.
   - Se definen los metadatos de la página incluyendo la compatibilidad con dispositivos móviles (`viewport`).
   - Se enlazan las hojas de estilo (`CSS`) necesarias:
     - `bootstrap.min.css` para el diseño base.
     - `professor.css`, `cards.css` y `process_detail.css` para estilos específicos de la página y de componentes.
     - `breadCrumb.css` para la navegación de las migas de pan.

3. **Encabezado del Portal**:
   - Se definen variables `$title` y `$description` que proporcionan información sobre la página.
   - Se incluye el encabezado del portal usando `include_once()` con `headerAdmission.php` para mantener la coherencia en la interfaz de usuario.

4. **Barra Lateral del Profesor**:
   - Se incluye `professorSidebar.php` que contiene la navegación específica para el portal de profesores.
   - La variable `$selected` indica qué opción está activa actualmente en la barra lateral.

5. **Breadcrumb**:
   - Se incluyen las migas de pan (`breadCrumb.php`) que muestran la navegación de la página actual dentro del portal.
   - Se pasa un array `$links` con los enlaces anteriores y actuales para mejorar la navegación.

6. **Contenido Principal**:
   - Se muestra información detallada sobre la clase a través de diversas tarjetas.
   - **Nombre de la Clase** y **Periodo Actual** se obtienen dinámicamente y se muestran.
   - **Horarios**: Muestra el inicio y fin de las clases.
   - **Cantidad de Alumnos** y **Unidades Valorativas** proporcionan estadísticas importantes sobre la clase.
   - Se incluye un área para subir archivos CSV que puede usarse para importar datos relacionados con la clase.
   - Se muestra una tabla (`section-table`) que probablemente contendrá detalles adicionales de la clase.

7. **Scripts**:
   - Se incluyen los scripts JavaScript necesarios para el funcionamiento de la página.
     - `bootstrap.bundle.min.js` para las funcionalidades de interacción de Bootstrap.
     - `main.js` para la lógica específica de la vista.
     - `sidebar.js` para la funcionalidad de la barra lateral para profesores.

---

### **2. `home_professors.php`**

`home_professors.php` es una vista que permite a los profesores gestionar y visualizar las clases a las que están asignados durante un periodo académico específico. Esta vista forma parte del portal para profesores y está protegida por validaciones de sesión para asegurar que solo los usuarios correctos tengan acceso.


1. **Validación de Sesión**:
   - Se incluye el archivo `SessionValidation.php` para manejar la validación de sesión.
   - `session_start()` inicia la sesión.
   - Se define la variable `$portal` con el valor `"professors"` para identificar el contexto de la sesión.
   - Se verifica que la sesión del usuario sea válida para el portal de profesores. Si la validación falla, se redirige al usuario a la página de inicio de sesión para profesores.

2. **Encabezado**:
   - Se definen los metadatos de la página, incluyendo el charset y el `viewport` para dispositivos móviles.
   - Se enlazan las hojas de estilo necesarias:
     - `bootstrap.min.css` para el diseño base.
     - `professor.css` y `cards.css` para estilos específicos de la vista.

3. **Encabezado del Portal**:
   - Se definen las variables `$title` y `$description` para proporcionar información sobre la página.
   - Se incluye el encabezado del portal usando `include_once()` con `headerAdmission.php` para mantener la coherencia en la interfaz de usuario.

4. **Barra Lateral del Profesor**:
   - Se incluye `professorSidebar.php` que proporciona la navegación específica para el portal de profesores.
   - La variable `$selected` indica qué opción está activa actualmente en la barra lateral.

5. **Contenido Principal**:
   - Se muestra un título y una breve descripción de la sección.
   - **Alert Section**: Un área para mostrar alertas o mensajes importantes relacionados con las clases.
   - **Process Section**: Probablemente usada para mostrar procesos o acciones relacionados con las clases.
   - **Sections Container**: Un contenedor que lista las clases a las que el profesor está asignado. Los elementos dentro de este contenedor se organizan en una cuadrícula flexible para acomodar múltiples clases.
   - El contenido se genera dinámicamente a través de JavaScript.

6. **Scripts**:
   - Se incluyen los scripts JavaScript necesarios para el funcionamiento de la vista:
     - `bootstrap.bundle.min.js` para las funcionalidades de interacción de Bootstrap.
     - `main.js` para la lógica específica de la vista `home_professors.php`.
     - `sidebar.js` para la funcionalidad de la barra lateral para profesores.

---

### **3. `previous_periods.php`** 

`previous_periods.php` es una vista dentro del portal de profesores que permite a los profesores revisar las clases y actividades en periodos académicos anteriores. Esta página está protegida por validaciones de sesión para asegurar que solo los profesores autenticados puedan acceder.


1. **Validación de Sesión**:
   - Se incluye el archivo `SessionValidation.php` para manejar la validación de sesión.
   - `session_start()` inicia la sesión.
   - Se define la variable `$portal` con el valor `"professors"` para identificar el contexto de la sesión.
   - Se verifica que la sesión del usuario sea válida para el portal de profesores. Si la validación falla, se redirige al usuario a la página de inicio de sesión para profesores.

2. **Encabezado**:
   - Se definen los metadatos de la página, incluyendo el charset y el `viewport` para dispositivos móviles.
   - Se incluyen los elementos `meta` para la información de autor, versión y fecha.
   - Se enlazan las hojas de estilo necesarias:
     - `bootstrap.min.css` para el diseño base.
     - `professor.css` y `cards.css` para estilos específicos de la vista.
     - `timeline.css` para estilos de la línea de tiempo utilizada en la página.

3. **Encabezado del Portal**:
   - Se definen las variables `$title` y `$description` para proporcionar información sobre la página.
   - Se incluye el encabezado del portal usando `include_once()` con `headerAdmission.php` para mantener la coherencia en la interfaz de usuario.

4. **Barra Lateral del Profesor**:
   - Se incluye `professorSidebar.php` que proporciona la navegación específica para el portal de profesores.
   - La variable `$selected` indica qué opción está activa actualmente en la barra lateral.
   - `$pathImg` es usado para manejar las rutas de las imágenes.

5. **Contenido Principal**:
   - Se muestra un título y una breve descripción de la sección.
   - **Container Section**: Un contenedor para la línea de tiempo (`timeline`) que muestra las actividades y clases de periodos anteriores.
   - El contenido de la línea de tiempo es generado dinámicamente a través de JavaScript, cargando información de periodos anteriores.

6. **Scripts**:
   - Se incluyen los scripts JavaScript necesarios para el funcionamiento de la vista:
     - `bootstrap.bundle.min.js` para las funcionalidades de interacción de Bootstrap.
     - `main.js` para la lógica específica de la vista `previous_periods.php`.

---
