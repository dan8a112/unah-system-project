# Documentación del Proyecto
## `Application.php`

### 1. **`__construct`**
Es el constructor de la clase `ApplicationDAO` y establece la conexión a la base de datos utilizando `mysqli`.

---

### 2. **`applicationInCurrentProcess`**
Esta función verifica si una aplicación está en el proceso actual. Utiliza el procedimiento almacenado **`ApplicationInCurrentEvent(?)`** que recibe el dni del aplicante, revisa si el dni coincide con el dni de una aplicación que esta en el evento académico activo.

### 3. **`getApplications (int $idProcess, int $offset`**
Recupera todas las primeras 10 aplicaciones de la base de datos de acuerdo al id del evento académico. ESta función sirve para paginar las aplicaciones.

### 4. **`getApprovedApplications (int $idProcess, int $offset)`**
Esta función obtiene las primeras 10 aplicaciones que han sido aprobadas por los revisores. Esta funcion sirve para paginar estas aplicaciones.

### 5. **`isActiveInscriptionProcess`**
Esta función verifica si hay un proceso de inscripción activo.

### Hay más funciones en este archivo estas son solo algunas de ellas. 

## `DepartmentBoss.php`

La clase `DepartmentBossDAO` está diseñada para gestionar operaciones relacionadas con los jefes de departamento en un sistema académico. Realiza interacciones con la base de datos para obtener, procesar y devolver información sobre secciones, períodos académicos, profesores, aulas, entre otros elementos. La clase utiliza `mysqli` para ejecutar consultas SQL.

---
## **Estructura y Métodos**

### 1. **getSections**
```php
public function getSections(int $idProcess, int $offset, int $idBoss)
```
- **Descripción**: Obtiene una lista de secciones asociadas a un proceso académico y al departamento del jefe de carrera, excluyendo secciones canceladas, y cuenta el total de secciones.
- **Parámetros**:
  - `int $idProcess`: ID del proceso académico.
  - `int $offset`: Desplazamiento para paginación.
  - `int $idBoss`: ID del jefe de departamento.
- **Retorno**:
  - Un arreglo con:
    - `sectionList`: Lista de secciones.
    - `amountSections`: Número total de secciones.
---

### 2. **ratingsDepartmentBoss**
```php
public function ratingsDepartmentBoss(int $id)
```
- **Descripción**: Obtiene información para la página principal del jefe de departamento, incluyendo períodos históricos, período actual y secciones asociadas.
- **Parámetros**:
  - `int $id`: ID del jefe de departamento.
- **Retorno**:
  - Un arreglo con información sobre:
    - Períodos históricos.
    - Período actual.
    - Secciones asociadas al período actual.
    - Estado de la operación (`status` y `message`).
---

### 3. **sectionAdministration**
```php
public function sectionAdministration(int $id)
```
- **Descripción**: Gestiona las secciones asociadas a un jefe de departamento, incluyendo departamento, período actual, y estado de las secciones.
- **Parámetros**:
  - `int $id`: ID del jefe de departamento.
- **Retorno**:
  - Un arreglo con información sobre el departamento, período actual, secciones y si el proceso está activo.
---

### 4. **getProfessorsClassroomsAvailable**
```php
public function getProfessorsClassroomsAvailable(int $idDays, int $startHour, int $finishHour)
```
- **Descripción**: Obtiene la disponibilidad de profesores y aulas en un horario específico.
- **Parámetros**:
  - `int $idDays`: ID del día o conjunto de días.
  - `int $startHour`: Hora de inicio.
  - `int $finishHour`: Hora de fin.
- **Retorno**:
  - Un arreglo con:
    - Profesores disponibles.
    - Aulas disponibles.
    - Edificios asociados.
---

### 6. **closeConnection**
```php
public function closeConnection()
```
- **Descripción**: Cierra la conexión con la base de datos.

#  `CSVExporter.php`


La clase `CSVExporter` está diseñada para exportar los resultados de una consulta SQL a un archivo CSV descargable. Utiliza la extensión `mysqli` para interactuar con la base de datos y está optimizada para exportaciones rápidas directamente desde la salida del servidor.

---

### 1. **Constructor**
```php
public function __construct(string $server, string $user, string $pass, string $dbName)
```
- **Descripción**: Establece una conexión con la base de datos mediante `mysqli`.
- **Parámetros**:
  - `string $server`: Dirección del servidor de base de datos.
  - `string $user`: Nombre de usuario para la conexión.
  - `string $pass`: Contraseña para la conexión.
  - `string $dbName`: Nombre de la base de datos.
- **Notas**:
  - No hay manejo explícito de errores si la conexión falla. Sería útil implementar una validación para confirmar la conexión exitosa.

---

### 2. **exportToCSV**
```php
public function exportToCSV(string $sql, $params=[], string $filename = "exported_data.csv")
```
- **Descripción**: Ejecuta una consulta SQL y exporta los resultados a un archivo CSV descargable.
- **Parámetros**:
  - `string $sql`: Consulta SQL que se ejecutará.
  - `array $params`: Parámetros opcionales para la consulta preparada.
  - `string $filename`: Nombre del archivo CSV que se generará (por defecto: `"exported_data.csv"`).
- **Funcionamiento**:
  1. Configura los encabezados HTTP para forzar la descarga de un archivo CSV.
  2. Ejecuta la consulta SQL con o sin parámetros.
  3. Si hay resultados:
     - Escribe los nombres de las columnas en el archivo CSV.
     - Escribe cada fila de datos en el archivo.
  4. Si no hay resultados:
     - Muestra un mensaje indicando que no hay datos para exportar.
---

# `GenericGet.php`


La clase `GenericGet` está diseñada para manejar diversas consultas SQL relacionadas con procesos académicos, departamentos, carreras, tipos de profesores, periodos académicos, entre otros. Es una implementación DAO (Data Access Object) que utiliza `mysqli` para interactuar con la base de datos.

---

## **Métodos Públicos**

### **Datos Académicos**

#### **`getDegrees`**
```php
public function getDegrees() : array
```
- **Descripción**: Recupera todas las carreras de la tabla `DegreeProgram`.
- **Retorno**: Array asociativo con los campos `idCareer` y `description`.

---

#### **`getProfessorTypes`**
```php
public function getProfessorTypes() : array
```
- **Descripción**: Obtiene los tipos de profesores de la tabla `ProfessorType`.
- **Retorno**: Array asociativo con los campos `professorTypeId` y `name`.

---

#### **`getCenters`**
```php
public function getCenters() : array
```
- **Descripción**: Recupera todos los centros regionales de la tabla `RegionalCenter`.
- **Retorno**: Array asociativo con los campos `idRegionalCenter` y `description`.

---

#### **`getDegreesInCenter`**
```php
public function getDegreesInCenter() : array
```
- **Descripción**: Obtiene las carreras asociadas a los distintos centros regionales mediante el procedimiento almacenado `GetDegreeProgramsByRegionalCenter`.
- **Funcionamiento**:
  - Itera sobre los centros regionales y recupera las carreras asociadas a cada uno.
- **Retorno**: Array asociativo donde cada centro contiene sus carreras.

---

#### **`getDepartments`**
```php
public function getDepartments() : array
```
- **Descripción**: Recupera todos los departamentos académicos de la tabla `Department`.
- **Retorno**: Array asociativo con los campos `departmentId` y `name`.

---

### **Eventos Académicos**

#### **`getAllProcess`**
```php
public function getAllProcess(int $typeProcess) : array
```
- **Descripción**: Obtiene todos los eventos académicos de un tipo específico.
- **Parámetros**:
  - `$typeProcess`: Tipo de proceso a buscar.
- **Retorno**: Array asociativo con los campos `id`, `start`, y `end`.

---

#### **`getProcess`**
```php
public function getProcess(int $id)
```
- **Descripción**: Recupera un evento académico específico por su ID.
- **Parámetros**:
  - `$id`: ID del evento académico.
- **Retorno**: Array asociativo con los campos `id`, `start`, y `end`.

---

#### **`getCurrentProcess`**
```php
public function getCurrentProcess()
```
- **Descripción**: Recupera el proceso académico activo actual.
- **Retorno**: Array asociativo con los campos `id` y `name`.

---

#### **`getSummaryProcess`**
```php
public function getSummaryProcess() : array
```
- **Descripción**: Recupera un resumen de los últimos procesos académicos de admisiones no activos.
- **Retorno**: Array de procesos académicos con `id`, `name`, y `applications`.

---

#### **`getAllProcessInYears`**
```php
public function getAllProcessInYears() : array
```
- **Descripción**: Recupera todos los procesos académicos de admisiones organizados por año.
- **Retorno**: Array jerárquico donde cada año contiene una lista de procesos.

---

### **Días y Períodos**

#### **`getDays`**
```php
public function getDays() : array
```
- **Descripción**: Recupera todos los días de la tabla `Days`.
- **Retorno**: Array asociativo con los campos `id`, `name`, y `amountDays`.

---

#### **`getSubjectsDepartment`**
```php
public function getSubjectsDepartment($id) : array
```
- **Descripción**: Recupera todas las clases de un departamento asociado a un profesor o jefe de departamento.
- **Parámetros**:
  - `$id`: ID del profesor o jefe de departamento.
- **Retorno**: Array asociativo con los campos `id`, `class`, y `uv`.

---

#### **`getPeriods`**
```php
public function getPeriods() : array
```
- **Descripción**: Recupera todos los periodos académicos relevantes.
- **Retorno**: Array asociativo con `id` y `name`.

---

#### **`getAllPeriodsInYears`**
```php
public function getAllPeriodsInYears(int $idProfessor) : array
```
- **Descripción**: Recupera todos los periodos académicos organizados por año para un profesor específico.
- **Parámetros**:
  - `$idProfessor`: ID del profesor.
- **Retorno**: Array jerárquico donde cada año contiene sus procesos asociados.

---

# `MailSender.php`

`MailSender.php` contiene la implementación de la clase `MailSenderDAO`, diseñada para gestionar el envío de correos electrónicos masivos en un contexto académico, utilizando datos almacenados en una base de datos. Proporciona métodos para enviar correos individuales y masivos, así como para programar envíos automáticos en horarios específicos.

---

## **Clase: MailSenderDAO**
### Descripción
`MailSenderDAO` es una clase que utiliza `mysqli` para realizar operaciones en la base de datos y gestiona el envío de correos electrónicos a través de la herramienta `msmtp`. La clase incluye métodos para:
- Enviar correos individuales.
- Enviar correos masivos a un grupo de estudiantes basado en datos procesados.
- Programar el envío automático de correos.

---

## **Métodos Públicos**

### **`sendMail`**
```php
public function sendMail($name, $result, $testsResults, $mail, $firstChoice, $secondChoice)
```
- **Descripción**: Envía un correo electrónico individual con resultados personalizados.
- **Parámetros**:
  - `$name`: Nombre del destinatario.
  - `$result`: Dictamen sobre los resultados de admisión.
  - `$testsResults`: Resultados detallados de los exámenes.
  - `$mail`: Dirección de correo electrónico del destinatario.
  - `$firstChoice`: Primera carrera seleccionada.
  - `$secondChoice`: Segunda carrera seleccionada.
- **Implementación**:
  - Genera un mensaje HTML que incluye los resultados del proceso de admisión.
  - Guarda el mensaje en un archivo temporal.
  - Utiliza `msmtp` para enviar el correo.
  - Elimina el archivo temporal después del envío.
- **Retorno**:
  - `true` si el correo se envió exitosamente.
  - `false` en caso de error.

---

### **`sendAllMails`**
```php
public function sendAllMails(int $offset)
```
- **Descripción**: Envía correos electrónicos a un grupo de estudiantes basado en un offset inicial.
- **Parámetros**:
  - `$offset`: Índice inicial de los estudiantes a procesar.
- **Implementación**:
  - Obtiene un grupo de estudiantes desde la base de datos usando un procedimiento almacenado.
  - Genera un mensaje personalizado para cada estudiante basado en sus resultados.
  - Envía el correo a cada estudiante.
  - Resetea la variable `testsResults` después de cada envío para evitar acumulaciones.
- **Retorno**:
  - `true` si todos los correos fueron enviados correctamente.
  - `false` si ocurre algún error durante el proceso.

---

### **`programEmailSend`**
```php
public function programEmailSend()
```
- **Descripción**: Programa el envío automático de correos electrónicos dentro de un rango de horas específico (1:00 AM a 5:00 AM).
- **Implementación**:
  1. Valida si los correos ya han sido enviados para el proceso académico activo.
  2. Obtiene el número total de inscripciones y divide el envío en lotes de 5 correos por hora.
  3. Usa la herramienta `at` para programar los envíos.
  4. Actualiza el estado de envío en la base de datos.
- **Retorno**:
  - Array con el estado y mensaje del resultado:
    - `status`: `true` si la programación fue exitosa, `false` si ocurrió un error.
    - `message`: Mensaje descriptivo del resultado.

---

# `Professor.php`

`Professor.php` contiene la implementación de una clase PHP, `ProfessorDAO`, diseñada para gestionar las operaciones relacionadas con profesores en una base de datos. La clase utiliza un objeto `mysqli` para realizar consultas y operaciones transaccionales.

## Funciones Principales

### 1. **getProfessors($offset)**
```php
public function getProfessors($offset): array
```
- **Propósito**: Obtiene los primeros 10 registros de profesores a partir de un desplazamiento especificado.
- **Puntos Destacables**:
  - Combina varias tablas relacionadas (`Employee`, `Professor`, `ProfessorType`).
  - Retorna los resultados formateados en un arreglo asociativo.
- **Observaciones**:
  - Usa un límite de 10 elementos con paginación basada en `$offset`.

### 2. **getAmountProfessors()**
```php
public function getAmountProfessors(): int
```
- **Propósito**: Cuenta el número total de profesores registrados.
- **Observaciones**:
  - Realiza una consulta simple de conteo en la tabla `Professor`.

### 4. **generatePassword($length = 10)**
```php
public function generatePassword($length = 10)
```
- **Propósito**: Genera una contraseña aleatoria de una longitud específica.
- **Puntos Destacables**:
  - Incluye caracteres alfanuméricos y especiales.

### 5. **setProfessor(...)**
```php
public function setProfessor($dni, $names, $lastNames, ...)
```
- **Propósito**: Inserta un nuevo profesor en la base de datos.
- **Validaciones Incluidas**:
  - DNI válido.
  - Números de teléfono y nombres con formato correcto.
- **Aspectos Notables**:
  - Genera una contraseña aleatoria para el nuevo profesor.
  - Utiliza un procedimiento almacenado `insertProfessor`.

### 6. **getProfessor($id)**
```php
public function getProfessor($id)
```
- **Propósito**: Obtiene los detalles de un profesor específico por su ID.
- **Estructura de Datos Retornada**:
  - Incluye información personal, tipo de profesor, y estado de actividad.

### 7. **updateProfessor(...)**
```php
public function updateProfessor($id, $dni, $names, ...)
```
- **Propósito**: Actualiza los datos de un profesor existente.
- **Validaciones Incluidas**:
  - Similar a `setProfessor`.
- **Observaciones**:
  - Usa un procedimiento almacenado `updateProfessor`.

### 8. **setPassword(...)**
```php
public function setPassword(int $id, string $newPassword, string $currentPassword)
```
- **Propósito**: Cambia la contraseña de un profesor.
- **Características**:
  - Verifica la contraseña actual si no es la primera vez que se cambia.
  - Asegura que la nueva contraseña cumpla con los requisitos de seguridad.

### 9. **getAssignedClasses(...)**
```php
public function getAssignedClasses(int $idProfessor, int $idAcademicProcess)
```
- **Propósito**: Obtiene las clases asignadas a un profesor en un proceso académico específico.

### 10. **homeProfessor($id)**
```php
public function homeProfessor(int $id)
```
- **Propósito**: Proporciona información relevante para la página principal de un profesor, como el periodo académico actual y las clases asignadas.
- **Observaciones**:
  - Retorna mensajes claros si no hay un periodo académico activo.
---

#  `Section.php`


Define una clase `SectionDAO` que se encarga de interactuar con una base de datos para gestionar información sobre secciones académicas, estudiantes y sus respectivas observaciones en el contexto de una plataforma educativa. La clase implementa métodos para obtener detalles de secciones, estudiantes, calificaciones, crear nuevas secciones, modificar existentes, y cancelar secciones, entre otras operaciones.

Cada función tiene un propósito específico y está diseñada para realizar consultas a la base de datos utilizando una instancia de la clase `mysqli`, que se conecta a la base de datos. La mayoría de las funciones ejecutan consultas SQL parametrizadas para prevenir ataques de inyección SQL.
  
### 1. Método `getStudentsSection`

```php
public function getStudentsSection(int $id, int $offset)
```

- **Propósito**: Obtener los primeros 10 estudiantes de una sección específica. Devuelve una lista de estudiantes con su cuenta, nombre, calificación y observaciones.
- **Parámetros**:
  - `$id`: ID de la sección.
  - `$offset`: Desplazamiento para la paginación de los resultados.
- **Retorno**: Un arreglo con dos elementos:
  - `studentsList`: Lista de estudiantes con su cuenta, nombre y calificación.
  - `amountStudents`: Total de estudiantes en la sección (excluyendo los que están en espera).

### 2. Método `getWaitingStudents`

```php
public function getWaitingStudents(int $id, int $offset)
```

- **Propósito**: Obtener los primeros 10 estudiantes en lista de espera para una sección específica.
- **Parámetros**:
  - `$id`: ID de la sección.
  - `$offset`: Desplazamiento para la paginación de los resultados.
- **Retorno**: Un arreglo con dos elementos:
  - `waitingStudentList`: Lista de estudiantes en espera con su cuenta, nombre y correo.
  - `amountWaitingStudents`: Total de estudiantes en espera.

### 3. Método `getGradesSection`

```php
public function getGradesSection(int $id)
```

- **Propósito**: Obtener información sobre las calificaciones de los estudiantes en una sección específica.
- **Parámetros**:
  - `$id`: ID de la sección.
- **Retorno**: Un arreglo que incluye:
  - `sectionInfo`: Detalles sobre la sección (materia, profesor, denominación).
  - `students`: Lista de estudiantes con su cuenta, nombre y calificación.
  - `period`: Detalles sobre el periodo académico.

### 4. Método `getSectionBossDepartment`

```php
public function getSectionBossDepartment(int $id)
```

- **Propósito**: Obtener información detallada de una sección específica, incluyendo detalles sobre el aula, el profesor, la capacidad máxima y los estudiantes.
- **Parámetros**:
  - `$id`: ID de la sección.
- **Retorno**: Un arreglo con los detalles de la sección, el profesor, los estudiantes, y los estudiantes en espera.

### 5. Método `setSection`

```php
public function setSection($class, $professor, $days, $startHour, $finishHour, $classroom, $places)
```

- **Propósito**: Crear una nueva sección en la base de datos utilizando un procedimiento almacenado.
- **Parámetros**:
  - `$class`: ID de la clase.
  - `$professor`: ID del profesor.
  - `$days`: Días en los que se lleva a cabo la sección.
  - `$startHour`: Hora de inicio.
  - `$finishHour`: Hora de finalización.
  - `$classroom`: ID del aula.
  - `$places`: Capacidad máxima de estudiantes.
- **Retorno**: Resultado de la operación de inserción, que incluye un mensaje de éxito o error.

### 6. Método `updateSection`

```php
public function updateSection($id, $class, $professor, $days, $startHour, $finishHour, $classroom, $places)
```

- **Propósito**: Modificar una sección existente en la base de datos.
- **Parámetros**: Similar al método `setSection`, pero con un parámetro adicional `$id`, que es el identificador de la sección a modificar.
- **Retorno**: Resultado de la operación de actualización, que incluye un mensaje de éxito o error.

### 7. Método `canceledSection`

```php
public function canceledSection(int $id)
```

- **Propósito**: Cancelar una sección, validando la cantidad de estudiantes.
- **Parámetros**:
  - `$id`: ID de la sección a cancelar.
- **Retorno**: Resultado de la operación, con un mensaje de éxito o error.

### 8. Método `getSectionProfessor`

```php
public function getSectionProfessor(int $id)
```

- **Propósito**: Obtener información detallada de una sección, incluyendo datos sobre el proceso académico actual y los estudiantes.
- **Parámetros**:
  - `$id`: ID de la sección.
- **Retorno**: Un arreglo con los detalles de la sección, los estudiantes, y si está disponible un video de presentación. Si el periodo académico es específico, también devuelve observaciones.
---

# `SessionValidation.php`

Contiene la clase `SessionValidation`, que se encarga de gestionar la validación de las sesiones activas en un sistema, así como de verificar ciertos parámetros en la URL y permitir el cierre de sesiones específicas de portales. 

---

#### **Métodos de la Clase `SessionValidation`**

##### 1. `isValid($session, $portalKey)`

Este método valida si una sesión está activa para un portal específico.

**Descripción**:
- **Parámetros**:
  - `$session`: Array asociativo que representa los datos de la sesión.
  - `$portalKey`: Clave que identifica un portal dentro de la sesión.
  
- **Funcionamiento**:
  - Verifica si existe el valor `user` dentro del portal identificado por `$portalKey` en la variable de sesión. 
  - Si el valor está presente, la sesión es válida y retorna `true`.
  - Si no, retorna `false`.

```php
static function isValid($session, $portalKey){
    if (isset($session['portals'][$portalKey]["user"])) {
        return true;
    }
    return false;
}
```

**Propósito**: Comprobar si un usuario está logueado y tiene acceso a un portal específico.

---

##### 2. `validateParam($param, $value)`

Este método valida si un parámetro de la URL coincide con un valor determinado.

**Descripción**:
- **Parámetros**:
  - `$param`: Nombre del parámetro en la URL.
  - `$value`: Valor esperado del parámetro.
  
- **Funcionamiento**:
  - Verifica si el parámetro `$param` existe en la URL (`$_GET`), no está vacío y su valor coincide con el valor esperado (`$value`).
  - Si alguna de estas condiciones no se cumple, retorna `false`.
  - Si todas las condiciones se cumplen, retorna `true`.

```php
static function validateParam($param, $value){
    if (!isset($_GET[$param]) || empty($_GET[$param]) || $_GET[$param] != $value){
        return false;
    }
    return true;
}
```

**Propósito**: Asegurar que un parámetro en la URL esté presente y tenga un valor esperado. Esto es útil para validaciones de seguridad o control de acceso.

---

##### 3. `closeSession($portalKey)`

Este método cierra la sesión para un portal específico, eliminando la entrada correspondiente en la sesión.

**Descripción**:
- **Parámetros**:
  - `$portalKey`: Clave del portal que se desea cerrar.
  
- **Funcionamiento**:
  - Inicia la sesión con `session_start()`.
  - Verifica si existe un usuario asociado al portal en la sesión. Si es así, elimina ese portal de la variable `$_SESSION` usando `unset`.
  - Retorna `true` si el portal ha sido eliminado correctamente de la sesión, y `false` si aún persiste.

```php
static function closeSession($portalKey){
    session_start();
    if (isset($_SESSION['portals'][$portalKey]["user"])) {
        unset($_SESSION['portals'][$portalKey]);
        return !isset($_SESSION['portals'][$portalKey]["user"]);
    }
}
```

**Propósito**: Permitir el cierre de sesiones para un portal específico, eliminando cualquier rastro del portal en la sesión actual.

---

# `StudentHistory.php`

Contiene la clase `StudentDAO`, que es responsable de gestionar las operaciones de acceso a datos relacionadas con los estudiantes en un sistema académico. Se utilizan consultas SQL para obtener información detallada sobre el historial académico de un estudiante, realizar búsquedas de estudiantes según un índice de cuenta y cerrar conexiones a la base de datos.

---

#### **Métodos de la Clase `StudentDAO`**

##### 1. **`getStudentAcademicHistory(string $studentId, int $offset = 0, int $limit = 10)`**

Este método obtiene el historial académico de un estudiante, dado su número de cuenta (`studentId`), y permite la paginación con los parámetros `$offset` y `$limit`.

**Parámetros**:
- `$studentId`: Número de cuenta del estudiante.
- `$offset`: Desplazamiento de la paginación (opcional, por defecto es 0).
- `$limit`: Número máximo de registros a retornar (opcional, por defecto es 10).

**Funcionamiento**:
1. **Consulta de información del estudiante**: Obtiene los datos básicos del estudiante, como nombre, carrera, promedio global, etc.
2. **Consulta de clases**: Recupera el historial de clases cursadas por el estudiante, con detalles como el código de la materia, el año, el semestre, la calificación y las observaciones.
3. **Cálculo del total de clases**: Cuenta el total de clases cursadas por el estudiante.
4. **Retorno de datos**: Retorna la información del estudiante y las clases cursadas, junto con el número total de clases.

**Consultas SQL**:
- Consulta de información del estudiante.
- Consulta de clases cursadas con paginación.
- Consulta para contar el total de clases.

```php
public function getStudentAcademicHistory(string $studentId, int $offset = 0, int $limit = 10) {
    // Consulta para obtener la información del estudiante
    $queryStudentInfo = 'SELECT CONCAT(s.name, " ", s.lastName) AS studentName, ...';
    $resultStudentInfo = $this->mysqli->execute_query($queryStudentInfo, [$studentId]);
    
    // Si no se obtiene información, retorna error
    if (!$resultStudentInfo) {
        return [
            "status" => false,
            "message" => "Error al obtener la información del estudiante."
        ];
    }
    
    // Información del estudiante
    $studentInfo = $resultStudentInfo->fetch_assoc();
    
    // Consulta para obtener las clases cursadas por el estudiante con paginación
    $queryClasses = 'SELECT Section.id, Subject.id code, ...';
    $resultClasses = $this->mysqli->execute_query($queryClasses, [$studentId, $limit, $offset]);
    
    // Procesamiento de las clases obtenidas
    $classesList = [];
    if ($resultClasses) {
        while ($row = $resultClasses->fetch_assoc()) {
            $classesList[] = $row;
        }
    }
    
    // Consulta para contar el total de clases cursadas
    $queryTotalClasses = 'SELECT COUNT(*) AS amountClasses FROM StudentSection WHERE studentAccount = ?;';
    $resultTotalClasses = $this->mysqli->execute_query($queryTotalClasses, [$studentId]);
    
    // Obtener el total de clases
    $amountClasses = 0;
    if ($resultTotalClasses) {
        $amountClasses = $resultTotalClasses->fetch_assoc()['amountClasses'];
    }
    
    // Retornar la respuesta con los datos obtenidos
    return [
        "status" => true,
        "message" => "Petición realizada con éxito.",
        "data" => [
            "studentInfo" => $studentInfo,
            "classes" => [
                "amountClasses" => $amountClasses,
                "classList" => $classesList
            ]
        ]
    ];
}
```

**Propósito**: Obtener el historial académico de un estudiante, incluyendo datos personales y un listado de las clases cursadas con detalles de calificaciones.

---

##### 2. **`searchStudents(string $searchIndex)`**

Este método permite realizar una búsqueda de estudiantes cuyo número de cuenta comienza con un índice específico.

**Parámetros**:
- `$searchIndex`: Índice o prefijo con el cual se va a realizar la búsqueda de estudiantes.

**Funcionamiento**:
- Ejecuta una consulta SQL para buscar estudiantes cuyos números de cuenta comienzan con el valor proporcionado en `$searchIndex`.
- Devuelve una lista de resultados que contienen información básica de los estudiantes como número de cuenta, nombre, centro y carrera.

**Consulta SQL**:
```sql
SELECT a.account, a.name, b.acronym as center, c.description as career
FROM Student a
INNER JOIN RegionalCenter b ON (a.regionalCenter = b.id)
INNER JOIN DegreeProgram c ON (a.degreeProgram = c.id)
WHERE account LIKE ?
```

```php
public function searchStudents(string $searchIndex) {
    $searchResults = [];
    $query = "SELECT a.account, a.name, b.acronym as center, c.description as career FROM Student a ...";
    $result = $this->mysqli->execute_query($query, [$searchIndex.'%']);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }
    return $searchResults;
}
```

**Propósito**: Buscar estudiantes por un índice de su número de cuenta, proporcionando información relevante como su nombre, centro regional y carrera.

### Hay mas funciones en estas clase, estas son solo algunas de ellas.

---