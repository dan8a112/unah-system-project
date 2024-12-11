
# Documentación de Archivos para la creacion de la Base de Datos

## **1. Archivo `install.sh`**

Este archivo contiene un script shell utilizado para configurar o instalar componentes necesarios para el proyecto.

### **Detalles principales:**
- **Propósito:** Automatizar procesos de instalación o configuración.
- **Dependencias:** Es probable que incluya comandos para instalar paquetes, configurar servicios o realizar otras tareas administrativas.
- **Comandos a ejecutar en consola:**
  ```bash
  chmod +x install.sh
  sudo ./install.sh
  ```  
- **Requisitos previos:**
  - Tener permisos de administrador.
  - Contar con un sistema operativo compatible (en este caso Linux).
- **🚩Luego de la ejecucion de los comandos se pedira la contraseña de la computadora y la contraseña del usuario de la base de datos**
---

## **2. Archivo `create.sql`**

Este archivo contiene los scripts SQL necesarios para crear y configurar la base de datos de el sistema.


1. **Creación de Base de Datos:**
   ```sql
   DROP DATABASE IF EXISTS ProyectoIS;
   CREATE DATABASE ProyectoIS CHARACTER SET 'utf8';
   USE ProyectoIS;
   ```

2. **Creación de Tablas:** Define tablas esenciales como `RegionalCenter`, `AdmissionTest`, `DegreeProgram`, `Applicant`, `Application`, entre otras. Cada tabla incluye llaves primarias y, en su caso, relaciones mediante llaves foráneas.

#### Tablas principales:
- **`Applicant`**:
  - Esta tabla registra la información personal de los solicitantes que aplican a la universidad.
  - Campos clave:
    - `id`: Identificación única del solicitante.
    - `names` y `lastNames`: Nombre completo.
    - `schoolCertificate`: Documento que certifica estudios previos.
    - `telephoneNumber` y `personalEmail`: Datos de contacto.
  - Relación:
    - Se vincula con la tabla `Application` mediante el campo `id`, permitiendo gestionar las aplicaciones asociadas a cada solicitante.

- **`Application`**:
  - Maneja las solicitudes de admisión realizadas por los solicitantes registrados en la tabla `Applicant`.
  - Campos clave:
    - `idApplicant`: Referencia al solicitante en `Applicant`.
    - `firstDegreeProgramChoice` y `secondDegreeProgramChoice`: Opciones de carreras académicas seleccionadas.
    - `approvedFirstChoice` y `approvedSecondChoice`: Indicadores de aprobación para cada opción.
  - Función:
    - Permite registrar múltiples aplicaciones de un solicitante y controlar su estado.

- **`RegionalCenter`**:
  - Contiene información sobre los centros regionales en los que se desarrollan actividades académicas.
  - Campos clave:
    - `id`: Identificación única del centro regional.
    - `description`: Nombre del centro.
    - `location`: Ubicación geográfica.
    - `acronym`: Abreviatura del centro.
  - Relación:
    - Se vincula con la tabla `Application` para identificar en qué centro regional se realiza una solicitud específica.

Estas tablas interactúan para gestionar de manera integral a los solicitantes, sus aplicaciones y los centros en los que participan. Por ejemplo, al registrar una nueva aplicación en `Application`, se valida que el solicitante exista en `Applicant` y que el centro regional especificado esté en `RegionalCenter`.

3. **Funciones y Procedimientos Almacenados:**

### Ejemplos concretos de uso:

- **Asignación de metas diarias a revisores:**
  El procedimiento `reviewersEvent` distribuye las aplicaciones pendientes entre los revisores activos:
  ```sql
  CALL reviewersEvent();
  ```
  Este procedimiento calcula las metas diarias y ajusta los límites inferiores para cada revisor con base en el número de solicitudes pendientes y el tiempo disponible.

- **Actualización de información de un profesor:**
  Para modificar los datos de un profesor, como su departamento o tipo, se utiliza el procedimiento `updateProfessor`:
  ```sql
  CALL updateProfessor(
      1,               -- ID del profesor
      '0801200304287',     -- DNI
      'Juan',          -- Nombres
      'Pérez',         -- Apellidos
      '98765432',      -- Teléfono
      'Calle 123',     -- Dirección
      '1980-01-01',    -- Fecha de nacimiento
      2,               -- Tipo de profesor
      1,               -- Departamento
      TRUE             -- Estado activo
  );
  ```
  Este procedimiento verifica que el profesor exista antes de realizar cambios.

### Impacto en operaciones del sistema:
Estos procedimientos automatizan tareas complejas, como validaciones, asignaciones y actualizaciones, asegurando consistencia y eficiencia en la gestión de datos.
   
#### Procedimientos almacenados importantes:
- **`actualAcademicPeriod()`**:
  - Devuelve el ID del evento académico activo.
  - Uso: Permite identificar el evento académico vigente para operaciones relacionadas.
  - Ejemplo:
    ```sql
    SELECT actualAcademicPeriod();
    ```

- **`insertApplicant`**:
  - Maneja la inserción de nuevos solicitantes o actualiza los existentes.
  - Validaciones:
    - Verifica si el solicitante ya existe.
    - Controla el número máximo de intentos permitidos.
  - Ejemplo:
    ```sql
    CALL insertApplicant('0801-2004-12344', 'Andrea', 'Hernández', 'certificate1.pdf', '98765432', 'andrea@gmail.com', 1, 2, 3);
    ```

- **`updateProfessor`**:
  - Actualiza información de los profesores, como tipo de profesor y departamento.
  - Validaciones:
    - Verifica si el profesor existe antes de actualizar.
  - Ejemplo:
    ```sql
    CALL updateProfessor(1, '123456789', 'Juan', 'Pérez', '98765432', 'Calle 123', '1980-01-01', 2, 1, TRUE);
    ```

- **`reviewersEvent`**:
  - Asigna metas diarias y límites de revisión a los revisores.
  - Beneficio: Optimiza la distribución de trabajo entre revisores activos.
  - Ejemplo:
    ```sql
    CALL reviewersEvent();
    ```

- **`RegionalCentersStadistics`**:
  - Genera estadísticas por centro regional en base al evento académico actual.
  - Ejemplo:
    ```sql
    CALL RegionalCentersStadistics(5);
    ```

4. **Triggers:**

Los triggers en este sistema son fundamentales para automatizar tareas y garantizar la integridad de los datos. Cada uno se activa automáticamente ante eventos específicos en las tablas relacionadas, reduciendo errores humanos y asegurando la consistencia de las operaciones.

#### Beneficios de los triggers:
- **Automatización de procesos:** Los triggers ejecutan lógicas complejas inmediatamente después de insertar, actualizar o eliminar registros, eliminando la necesidad de intervenciones manuales.
- **Integridad referencial:** Actualizan o validan datos automáticamente para mantener consistencia en las relaciones entre tablas.
- **Validaciones en tiempo real:** Detectan y previenen inconsistencias en los datos al momento de la operación.

#### Triggers principales:
- **`after_update_result`**:
  - **Descripción:** Actualiza los campos `approvedFirstChoice` y `approvedSecondChoice` en la tabla `Application` después de modificar resultados en `Results`.
  - **Beneficio:** Asegura que las decisiones de aprobación reflejen los resultados más recientes, manteniendo actualizada la información de las aplicaciones.

- **`insert_last_period_academic_index`**:
  - **Descripción:** Calcula y actualiza el promedio académico del último período del estudiante después de registrar una nueva inscripción.
  - **Ejemplo:**
    ```sql
    INSERT INTO StudentSection (studentAccount, section, grade) VALUES ('123456', 1, 90);
    -- Trigger ejecutado para recalcular el promedio del período.
    ```
  - **Beneficio:** Garantiza que los promedios académicos se mantengan precisos en todo momento.

- **`update_academic_index`**:
  - **Descripción:** Recalcula el promedio académico global del estudiante tras la actualización de una calificación.
  - **Beneficio:** Asegura que los indicadores académicos sean coherentes y actualizados según las modificaciones.

#### Triggers principales:
- **`after_update_result`**:
  - Descripción: Actualiza los campos `approvedFirstChoice` y `approvedSecondChoice` en la tabla `Application` después de modificar resultados en `Results`.
  - Beneficio: Asegura que las decisiones de aprobación reflejen los resultados más recientes.

- **`insert_last_period_academic_index`**:
  - Descripción: Calcula y actualiza el promedio académico del último período del estudiante después de registrar una nueva inscripción.
  - Ejemplo:
    ```sql
    INSERT INTO StudentSection (studentAccount, section, grade) VALUES ('123456', 1, 90);
    -- Trigger ejecutado para recalcular el promedio del período.
    ```

- **`update_academic_index`**:
  - Descripción: Recalcula el promedio académico global del estudiante tras la actualización de una calificación.

5. **Eventos:**
   - **`statusVerification`**:
     - Activa y desactiva eventos académicos según la fecha actual.
     - Ejemplo:
       ```sql
       -- Este evento se ejecuta diariamente:
       UPDATE AcademicEvent SET active = TRUE WHERE startDate <= CURDATE() AND CURDATE() <= finalDate;
       ```
   - **`reviewersEvent`**:
     - Llama al procedimiento `reviewersEvent` diariamente para ajustar metas y distribuciones.

6. **Datos de prueba:**

Los datos de prueba proporcionados en el archivo permiten verificar el correcto funcionamiento del sistema al simular escenarios reales. Por ejemplo:

- **Tablas iniciales:**
  - Las inserciones en tablas como `RegionalCenter`, `AdministrativeType` y `DegreeProgram` aseguran que el sistema tiene un entorno de datos base para realizar operaciones.

- **Solicitantes y aplicaciones:**
  - Registros en las tablas `Applicant` y `Application` permiten evaluar procesos clave como:
    - Registro de nuevos solicitantes.
    - Vinculación de aplicaciones a programas académicos.
    - Validación de límites de intentos.

- **Pruebas de procedimientos y triggers:**
  - Los datos de prueba se utilizan para validar procedimientos almacenados como `insertApplicant` y `reviewersEvent`, comprobando que realicen cálculos correctos y asignaciones adecuadas.
  - Los triggers, como `after_update_result`, se prueban asegurando que actualicen automáticamente campos relevantes al modificar datos en tablas relacionadas.

Estos datos sirven para realizar pruebas unitarias y de integración, garantizando que las funcionalidades principales se comporten como se espera bajo diferentes condiciones.
   Incluye datos iniciales para entidades como `RegionalCenter`, `AdministrativeType`, `DegreeProgram`, y otros.

---

## **3. Archivo `active-revision-process.sql`**

Este archivo contiene scripts SQL orientados a gestionar el proceso activo de revisión en un sistema académico.

### **Contenido principal:**
1. **Inserción de Datos:**
   - Solicitudes de admisión para diferentes solicitantes (`Applicant`) y sus aplicaciones (`Application`).
   - Ejemplo:
     ```sql
     INSERT INTO Applicant (id, names, lastNames, schoolCertificate, telephoneNumber, personalEmail) VALUES
     ('0801-2004-12344', 'Andrea Valeria', 'Hernández López', 'certificate1.pdf', '98765432', 'andrea.hernandez@gmail.com');
     ```

2. **Actualización de Estado:**
   - Cambia el estado de eventos académicos.
     ```sql
     UPDATE AcademicEvent
     SET active=FALSE
     WHERE id=6;
     UPDATE AcademicEvent
     SET active=TRUE
     WHERE id=7;
     ```

3. **Ejecución de Procedimientos:**
   - Llama al procedimiento `reviewersEvent` para definir metas de revisión.

### **Detalles del Procedimiento `reviewersEvent`**
Este procedimiento distribuye de manera equitativa las solicitudes pendientes entre los revisores activos y organiza las metas diarias con base en la capacidad disponible.

#### Funcionamiento:
1. **Cálculo de variables clave:**
   - Determina el número total de solicitudes pendientes.
   - Calcula los días restantes para completar la revisión y el número de revisores activos.
   - Asigna un objetivo diario para cada revisor, ajustado según la cantidad de trabajo y tiempo disponible.

2. **Asignación de límites:**
   - Establece límites inferiores para cada revisor, indicando desde qué posición en la lista de solicitudes comenzará su revisión.
   - Optimiza la distribución mediante un algoritmo aleatorio para balancear la carga de trabajo.

3. **Creación de una tabla temporal:**
   - Genera una tabla con las solicitudes asignadas para cada revisor, permitiendo un seguimiento detallado de las tareas.

#### Impacto en el flujo de trabajo:
- **Optimización:** Asegura una distribución equitativa de las solicitudes, reduciendo la posibilidad de sobrecargar a revisores individuales.
- **Eficiencia:** Minimiza el tiempo necesario para completar el proceso de revisión al utilizar los recursos disponibles de manera efectiva.
- **Seguimiento:** Proporciona un sistema claro para monitorear el progreso diario de las revisiones.

#### Ejemplo de uso:
```sql
CALL reviewersEvent();
```
Este llamado ajusta automáticamente las metas de los revisores y prepara el sistema para procesar las solicitudes asignadas.

### **Propósito:**
- Gestionar procesos académicos activos y simular datos reales para pruebas.

Este archivo contiene scripts SQL orientados a gestionar el proceso activo de revisión en un sistema académico.

### **Contenido principal:**
1. **Inserción de Datos:**
   - Solicitudes de admisión para diferentes solicitantes (`Applicant`) y sus aplicaciones (`Application`).
   - Ejemplo:
     ```sql
     INSERT INTO Applicant (id, names, lastNames, schoolCertificate, telephoneNumber, personalEmail) VALUES
     ('0801-2004-12344', 'Andrea Valeria', 'Hernández López', 'certificate1.pdf', '98765432', 'andrea.hernandez@gmail.com');
     ```

2. **Actualización de Estado:**
   - Cambia el estado de eventos académicos.
     ```sql
     UPDATE AcademicEvent
     SET active=FALSE
     WHERE id=6;
     UPDATE AcademicEvent
     SET active=TRUE
     WHERE id=7;
     ```

3. **Ejecución de Procedimientos:**
   - Llama al procedimiento `reviewersEvent` para definir metas de revisión.

### **Propósito:**
- Gestionar procesos académicos activos y simular datos reales para pruebas.

---

## **Instrucciones Generales para Ejecutar los Archivos**

1. **`install.sh`**:
   - Ejecute el script en una terminal con permisos de superusuario:
     ```bash
     sudo ./install.sh
     ```

2. **`create.sql`**:
   - Importe el archivo en su gestor de base de datos (MySQL):
     ```bash
     mysql -u usuario -p < create.sql
     ```

3. **`active-revision-process.sql`**:
   - Ejecute el archivo en el entorno SQL para insertar y actualizar datos:
     ```bash
     mysql -u usuario -p < active-revision-process.sql
     ```

