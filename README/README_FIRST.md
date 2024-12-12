
# Introducción del sistema
Este sistema es para el manejo y gestión de una universidad. El sistema esta capacitado para gestionar las inscripciones de admisión, la matricula de estudiantes y el personal tanto administrativo como docente de dicha universidad.

### **Principio del sistema**
EL sistema se rige bajo el concepto de **procesos académicos**. Un proceso académico puede ser un proceso de matricula de un periodo, inscripciones de admisiones, cancelasciones excepcionales, etc.
En el sistema tenemos dos tipos de procesos académicos:
- **Procesos padres:** como ser un periodo académico o un proceso de admisión.
- **Subprocesos:** van asociados un proceso padre, por ejemplo el proceso de inscripciones es un subproceso del proceso de admisión o el proceso de matrícula es un subproceso del periodo académico.

Dicho esto este sistema tiene dos procesos padres que cuentas con varios subprocesos.
 
- **Proceso de admisiones:** cuenta con los siguientes subprocesos en dicho orden 
  - Inscripciones
  - Revisión de inscripciones
  - Subida de resultados de los exámenes de los aplicantes al sistema
  - Envio de correos con los resultados de los examenes a los aplicantes
  - Generación de expedientes de los aplicantes aprobados
- **Periodo académico:** cuenta con los siguinetes subprocesos en dicho orden
  - Planificación académica
  - Prematrícula
  - Matricula
  - Inicio de clases
  - Adiciones y cancelaciones
  - Cancelación Excepcional
  - Ingreso de notas y evaluaciones a docentes

  
El sistema es capaz de saber que proceso y/o subproceso estan activos en base a la fecha de inicio y fin de cada proceso/subproceso.

Como el sistema hace la comparación de la fecha actual con las de los subprocesps es difícil probar su funcionalidad en el instante ya que dependiendo de que subproceso este activo se pueden realizar ciertas acciones. Por lo tanto se han creado una serie de sripts y sh para activar los procesos manualmente.

---
# Pasos para probar el sistema

## **Proceso de admisiones**
En este proceso se ven involucrados 3 tipos de usuarios:
- **Aplicantes:** los encargados de hacer inscripciones
- **APA (Administrador de proceso de admisiones):** puede ver todo el flujo del proceso padre y realizar acciones dependiendo de que subproceso este activo.
- **CRI (Comité de Revisión de Incripciones):** aprueban o desaprueban las incripciones hechas por los aplicantes.

### 1. **Inscripciones**
Por defecto el sistema inicia con este subproceso activo por lo tanto podremos hacer inscripciones por parte de los `aplicantes` y hacer el seguimiento de las inscripciones en `APA`.

![alt text](/README/img/image.png)
![alt text](/README/img/image-1.png)

### 2. **Revisión de inscripciones:** 
Ejecutar `activeRevisions.sh` que se encuentra en la carpeta *db-scripts/dml/sh*

Aquí ya podremos entrar con los usuarios de `CRI` para poder aprobar o desaprobar (al desaprobar una inscripción el sistema le envía un correo al aplicante informando porque se desaprobo su inscripción) inscripciones y de la misma forma hacer el seguimiento con `APA`.

![alt text](/README/img/image-2.png)
![alt text](/README/img/image-3.png)

### 2. **Subir calificaciones de los examenes de admisión:** 
Ejecutar `activeUploadResults.sh` que se encuentra en la carpeta *db-scripts/dml/sh*

Esto deshabilitará el acceso a las portal de CRI ya que este solo se puede acceder cuando es proceso de revisión de inscripciones y podrmos subir un CSV con las notas de los aplicantes con las inscripciones aprobadas con `APA`.

![alt text](/README/img/image-4.png)


### 3. **Enviar correos a aplicantes:**
Ejecutar `activeSendEmail.sh` que se encuentra en la carpeta *db-scripts/dml/sh*

Aquí el usuario de `APA` puede presionar el botón para enviar correos y automáticamente se programara el envío de correos por lotes (de 1:00 - 5:00 am).

### 4. **Creación de expedientes:**
Ejecutar `activeFileCreation.sh` que se encuentra en la carpeta *db-scripts/dml/sh*

EL usuario `APA` podrá descargar un CSV con los aplicantes aprobados en el proceso de admisión.

### 5. **Finalizar el proceso de admisión:**
Ejecutar `endAdmisionProcess.sh` que se encuentra en la carpeta *db-scripts/dml/sh*

Al terminar el proceso de admisión activo, este pasa a ser un proceso de admisión historico por lo tanto en el home de `APA` podremos acceder a sus estadísticas como con cualquie otro proceso de admisión pasado.

--- 
## **Periodo académico**
En este proceso participan usuarios:

- **Docentes:** encargados de subir notas de una sección, video de presentación y pueden visualizar las clases que tienen asignadas en los distintos periodos academicos (actual/historico) con un detalle de estas secciones, entre otras cosas.
- **Jefes de carrera:** Encargados de crear, modificar y cancelas secciones, también pueden ver el historial de los estudiantes, entre otras cosas.
- **Coordinadores:** pueden ver la carga académica creada por los jefes de departamento y descargarla en un CSV, pueden ver el historial de los estudiantes y aprueban o desaprueban las solicitudes de los estudiantes (no implementado aún).
- **Estudiantes:** pueden ver su historial académico, subir foto de perfil y matricular clases (no implementado aún).

*Cabe mencionar que los jefes y coordinadores son docentes por lo tanto pueden usar sus credenciales para entrar a cualquiera de los dos logins.*

### 1. **Planificación académica:**
Por defecto el sistema inicia con este subproceso activo por lo tanto los `jefes de departamento` podran hacer el CRUD de secciones mientras que los `docentes` solo podran ver las secciones que se las asignaron en los periodos pasados.

### 2. **Prematrícula:**
Ejecutar `activePreEnrollment.sh` que se encuentra en la carpeta *db-scripts/dml/sh*

Esto hace que los `docentes` ya puedan ver las secciones que tiene asignadas, los estudiantes que estan matrículados y podrá descargar un CSV con los datos de estos estudiantes. Los `jefes de departamento` podran seguir haciendo el CRUD de secciones.

### 3. **Matrícula:**
Ejecutar `activeEnrollment.sh` que se encuentra en la carpeta *db-scripts/dml/sh*

Se puede seguir haciendo lo mismo que en el proceso anterior. Cabe aclarar que los `estudiantes` y `coordinadores` no ven sus acciones afectadas por estos cambios ya que son los módulos que aún no estan completos.

### 4. **Ingreso de notas y evaluación de docentes:**
Ejecutar `activeUploadCalifications.sh` que se encuentra en la carpeta *db-scripts/dml/sh*

Nos saltamos hasta el subproceso de ingreso de notas de parte de los `docentes` ya que aún no se implementó lo de cancelaciones excepcionales. En este proceso el docente puede subir un CSV con las notas de los estudiantes. 

### 5. **Terminar el periodo:**
Ejecutar `endPeriod.sh` que se encuentra en la carpeta *db-scripts/dml/sh*

Al desactivar o terminar el los `docentes` podran ver las notas que subieron de los estudiantes en el historico de las clases. 