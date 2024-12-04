DROP DATABASE IF EXISTS ProyectoIS;

CREATE DATABASE ProyectoIS CHARACTER SET 'utf8';

USE ProyectoIS;

/*-------------------------------------------------------------------CREATE TABLE------------------------------------------------------------------------------*/
CREATE TABLE RegionalCenter(
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(70) NOT NULL,
    location VARCHAR(100) NOT NULL,
    acronym VARCHAR(10)
);

CREATE TABLE AdmissionTest(
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(62) NOT NULL,
    points INT
    
);

CREATE TABLE DegreeProgram(
	id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR (60) NOT NULL
);

CREATE TABLE RegionalCenterDegree(
    id INT PRIMARY KEY AUTO_INCREMENT,
    degree SMALLINT,
    regionalCenter TINYINT,
    CONSTRAINT fk_degreerc FOREIGN KEY (degree) REFERENCES DegreeProgram(id),
    CONSTRAINT fk_regionalCenter FOREIGN KEY (regionalCenter) REFERENCES RegionalCenter(id)
);

CREATE TABLE AdmissionDegree(
	id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR (100) NOT NULL,
    degree SMALLINT,
    admissionTest TINYINT,
	passingGrade SMALLINT,
    CONSTRAINT fk_degree FOREIGN KEY(degree) REFERENCES DegreeProgram(id),
    CONSTRAINT fk_admissionTest FOREIGN KEY(admissionTest) REFERENCES AdmissionTest(id)
);

CREATE TABLE Applicant(
	id VARCHAR(15) PRIMARY KEY,
    names VARCHAR(60) NOT NULL,
    lastNames VARCHAR(60) NOT NULL,
    schoolCertificate LONGBLOB NOT NULL,
    telephoneNumber VARCHAR(12),
    personalEmail VARCHAR(50) 
);

CREATE TABLE AcademicProcess(
    id INT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(50)
);

CREATE TABLE AcademicEvent(
    id INT PRIMARY KEY AUTO_INCREMENT,
    process INT NOT NULL,
    startDate DATETIME,
    finalDate DATETIME,
    active BOOLEAN,
    parentId INT DEFAULT NULL,
    CONSTRAINT fk_parent_id FOREIGN KEY (parentID) REFERENCES AcademicEvent(id) ON DELETE SET NULL,
    CONSTRAINT fk_process FOREIGN KEY(process) REFERENCES AcademicProcess(id)
);

CREATE TABLE SendedEmail(
    id INT PRIMARY KEY AUTO_INCREMENT,
    academicProcess INT NOT NULL,
    active BOOLEAN,
    programmingDate DATETIME DEFAULT NULL,
    CONSTRAINT fk_academicProcess FOREIGN KEY(academicProcess) REFERENCES AcademicEvent(id)
);

CREATE TABLE Reviewer(
	id INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(15) NOT NULL,
    firstLastName VARCHAR(15) NOT NULL,
    telephoneNumber VARCHAR(12),
    personalEmail VARCHAR(50),
    lowerLimit INT DEFAULT NULL,
    password VARCHAR (60) NOT NULL, 
    active BOOLEAN DEFAULT TRUE,
    dailyGoal INT DEFAULT 0
);

CREATE TABLE Application(
	id INT PRIMARY KEY AUTO_INCREMENT,
    idApplicant VARCHAR(15),
    firstDegreeProgramChoice SMALLINT,
    secondDegreeProgramChoice SMALLINT,
    regionalCenterChoice TINYINT,
    applicationDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    academicEvent INT,
    approvedFirstChoice BOOLEAN DEFAULT false,
    approvedSecondChoice BOOLEAN DEFAULT false,
    approved BOOLEAN DEFAULT NULL,
    idReviewer INT DEFAULT NULL,
    CONSTRAINT fk_idApplicant FOREIGN KEY(idApplicant) REFERENCES Applicant(id),
    CONSTRAINT fk_firstDegreeProgramChoice FOREIGN KEY(firstDegreeProgramChoice) REFERENCES DegreeProgram(id),
	CONSTRAINT fk_secondDegreeProgramChoice FOREIGN KEY(secondDegreeProgramChoice) REFERENCES DegreeProgram(id),
    CONSTRAINT fk_regionalCenterChoice FOREIGN KEY (regionalCenterChoice) REFERENCES RegionalCenter(id),
    CONSTRAINT fk_academicEvent FOREIGN KEY (academicEvent) REFERENCES AcademicEvent(id),
    CONSTRAINT fk_idReviewer FOREIGN KEY (idReviewer) REFERENCES Reviewer(id)  
);

CREATE TABLE Employee(
	id INT PRIMARY KEY AUTO_INCREMENT,
    dni VARCHAR (15) NOT NULL,
    names VARCHAR(60) NOT NULL,
    lastNames VARCHAR(60) NOT NULL,
    telephoneNumber VARCHAR(12) NOT NULL,
    personalEmail VARCHAR(30) NOT NULL,
    password VARCHAR (60) NOT NULL,
    address VARCHAR(60) NOT NULL,
    dateOfBirth DATE
);

CREATE TABLE ProfessorType(
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(30)
);

CREATE TABLE Department(
	id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(60)
);

CREATE TABLE Professor(
	id INT PRIMARY KEY,
    professorType TINYINT,
    department SMALLINT,
    CONSTRAINT fk_id FOREIGN KEY (id) REFERENCES Employee(id),
    active BOOLEAN,
    CONSTRAINT fk_professorType FOREIGN KEY (professorType) REFERENCES ProfessorType(id),
    CONSTRAINT fk_department FOREIGN KEY (department) REFERENCES Department (id)
);

CREATE TABLE AdministrativeType(
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(20)
);

CREATE TABLE Administrative(
	id INT PRIMARY KEY,
    administrativeType TINYINT,
    CONSTRAINT fk_id_adm FOREIGN KEY (id) REFERENCES Employee(id),
    CONSTRAINT fk_administrativeType FOREIGN KEY (administrativeType) REFERENCES AdministrativeType(id)
);

CREATE TABLE Results(
    id INT PRIMARY KEY AUTO_INCREMENT,
    application INT NOT NULL,
    admissionTest TINYINT NOT NULL,
    grade SMALLINT DEFAULT NULL,
    CONSTRAINT fk_application FOREIGN KEY(application) REFERENCES Application(id),
    CONSTRAINT fk_admissionTest_Results FOREIGN KEY(admissionTest) REFERENCES AdmissionTest(id)
);

CREATE TABLE Configuration(
    id INT PRIMARY KEY AUTO_INCREMENT,
    data json
);

/*--------------------------------------------------------------------PROCEDURES--------------------------------------------------------------------------------*/
DELIMITER //

/**
    author: dorian.contreras@unah.hn
    version: 0.3.0
    date: 28/11/24

    Procedimiento almacenado para hacer insert en la tabla Application manejando si ya existe o no un aplicante y el limite de aplicaciones que puede hacer
**/
CREATE PROCEDURE insertApplicant(
    IN p_id VARCHAR(15),
    IN p_names VARCHAR(60),
    IN p_lastNames VARCHAR(60),
    IN p_schoolCertificate LONGBLOB,
    IN p_telephoneNumber VARCHAR(12),
    IN p_personalEmail VARCHAR(50),
    IN p_firstDegreeProgramChoice SMALLINT,
    IN p_secondDegreeProgramChoice SMALLINT,
    IN p_regionalCenterChoice TINYINT
)
BEGIN

    DECLARE maxAttempts INT;
    DECLARE attempts INT;
    DECLARE idCurrentProcess INT;

    -- Verificar si el ID y el nombre completo ya existen en la tabla Applicant
    IF EXISTS (SELECT 1 FROM Applicant WHERE id = p_id AND names = p_names AND lastNames = p_lastNames) THEN
        -- Si existen, actualizar los datos del solicitante y hacer la nueva aplicacion
        UPDATE Applicant
        SET 
            schoolCertificate = p_schoolCertificate,
            telephoneNumber = p_telephoneNumber,
            personalEmail = p_personalEmail
        WHERE id = p_id;

    ELSEIF EXISTS (SELECT 1 FROM Applicant WHERE id = p_id) THEN
        -- Si el ID ya existe pero los datos no coinciden, lanzamos un error
        SELECT JSON_OBJECT(
            'status', false,
            'message', 'El ID ya existe con datos diferentes; no se puede insertar el nuevo solicitante.',
            'code', '3'
        ) AS resultJson;

    ELSE
        -- Si el solicitante no existe, insertamos un nuevo registro en Applicant y en Application
        INSERT INTO Applicant (
            id,
            names,
            lastNames,
            schoolCertificate,
            telephoneNumber,
            personalEmail
        ) VALUES (
            p_id,
            p_names,
            p_lastNames,
            p_schoolCertificate,
            p_telephoneNumber,
            p_personalEmail
        );
    END IF;

    -- Extraer el valor de "attempts" del campo JSON en la tabla Configuration
    SET maxAttempts = (SELECT JSON_EXTRACT(data, "$.maxAttemtps") FROM Configuration WHERE id=1);
    SET attempts = (SELECT COUNT(*) FROM Application WHERE idApplicant = p_id AND approved=true);
    SET idCurrentProcess = (SELECT id FROM AcademicEvent WHERE active = true AND process=1);

    IF (attempts >= 3) THEN
        SELECT JSON_OBJECT(
            'status', false,
            'message', 'Excede el limite de intentos permitidos para el proceso de admisión',
            'code', '4'
        ) AS resultJson;  
    ELSE
        INSERT INTO Application (
            idApplicant,
            firstDegreeProgramChoice,
            secondDegreeProgramChoice,
            regionalCenterChoice,
            academicEvent

        ) VALUES (
            p_id,
            p_firstDegreeProgramChoice,
            p_secondDegreeProgramChoice,
            p_regionalCenterChoice,
            idCurrentProcess
        );

        SELECT JSON_OBJECT(
            'status', true,
            'idApplication', LAST_INSERT_ID(),
            'message', 'Inscripción hecha correctamente'
        ) AS resultJson;
    END IF;
END //

/**
    author: dorian.contreras@unah.hn
    version: 0.1.0
    date: 11/11/24

    Procedimiento almacenado para saber si un aplicante ya tiene una aplicacion en el proceso de admision actual
**/
CREATE PROCEDURE ApplicationInCurrentEvent (IN p_identityNumber VARCHAR(15))
BEGIN
    DECLARE idCurrentEvent int;

    SET idCurrentEvent = (SELECT id FROM AcademicEvent WHERE active = true AND process=1);

    IF EXISTS (SELECT * FROM Application WHERE idApplicant = p_identityNumber AND academicEvent=idCurrentEvent AND (approved=true OR approved IS NULL)) THEN 
        SELECT JSON_OBJECT(
            'status', true,
            'message', 'Ya hay una inscripcion para este proceso'
        ) AS resultJson; 
    ELSE
        SELECT JSON_OBJECT(
            'status', false,
            'message', 'No hay una inscripcion para este proceso'
        ) AS resultJson; 
    END IF;   
END //

/**
    author: wamorales@unah.hn
    version: 0.1.0
    date: 5/11/24

    Procedimiento almacenado para obtener las carreras que pertenecen a un centro regional
**/
CREATE PROCEDURE GetDegreeProgramsByRegionalCenter (IN regionalCenterId INT)
BEGIN
    SELECT DegreeProgram.id AS degreeProgramId
    FROM RegionalCenterDegree
    INNER JOIN DegreeProgram
    ON RegionalCenterDegree.degree = DegreeProgram.id
    INNER JOIN RegionalCenter
    ON RegionalCenterDegree.regionalCenter = RegionalCenter.id
    WHERE RegionalCenter.id = regionalCenterId;
END //

/**
    author: dorian.contreras@unah.hn
    version: 0.1.0
    date: 11/11/24

    Procedimiento almacenado para obtener la informacion del proceso actual
**/
CREATE PROCEDURE InfoCurrentProcessAdmission ()
BEGIN
    SET lc_time_names = 'es_ES';

    SELECT a.id as idAcademicEvent, CONCAT(b.description,' ', CONCAT(UPPER(LEFT(DATE_FORMAT(a.startDate, '%M'), 1)), SUBSTRING(DATE_FORMAT(a.startDate, '%M'), 2)), ' ', YEAR(a.startDate)) as processName, DATE_FORMAT(c.startDate, '%d de %M, %Y') as start, DATE_FORMAT(c.finalDate, '%d de %M, %Y') as final, d.id as idProcessState, d.description as processState
    FROM AcademicEvent a
    INNER JOIN AcademicProcess b ON (a.process = b.id)
    INNER JOIN AcademicEvent c ON (a.id = c.parentId)
    INNER JOIN AcademicProcess d ON (c.process = d.id)
    WHERE a.active = true AND b.id=1 and c.active=true;      
END //

/**
    author: dorian.contreras@unah.hn
    version: 0.2.0
    date: 23/11/24

    Procedimiento almacenado para saber la cantidad de inscripciones totales, inscripciones aprobadas, inscripciones que faltan de revisar
**/
CREATE PROCEDURE AmountInscription (IN p_id INT)
BEGIN
    DECLARE amountInscriptions INT DEFAULT 0;
    DECLARE approvedInscriptions INT DEFAULT 0;
    DECLARE missingReviewInscriptions INT DEFAULT 0;

    SET approvedInscriptions = (SELECT COUNT(*) FROM Application WHERE academicEvent=p_id AND approved=true);
    SET amountInscriptions = (SELECT COUNT(*) FROM Application WHERE academicEvent=p_id);
    SET missingReviewInscriptions = (SELECT COUNT(*) FROM Application WHERE academicEvent=p_id AND approved IS NULL);

    SELECT JSON_OBJECT(
        'amountInscriptions', amountInscriptions,
        'approvedInscriptions', approvedInscriptions,
        'missingReviewInscriptions', missingReviewInscriptions
    ) AS resultJson; 
END //

/**
    author: dorian.contreras@unah.hn
    version: 0.2.0
    date: 28/11/24

    Procedimiento almacenado para obtener los resultados de las inscripciones
**/
CREATE PROCEDURE ResultsActualProcess(IN p_offset INT)
BEGIN
    DECLARE idCurrent INT;
    SET idCurrent = (SELECT id FROM AcademicEvent WHERE process=1 and active=true);

    SELECT a.id as idApplication, CONCAT(b.names, ' ', b.lastNames) as name, b.personalEmail, c.description as firstCareer, d.description as secondCareer, a.approvedFirstChoice, a.approvedSecondChoice
    FROM Application a
    INNER JOIN Applicant b ON(a.idApplicant=b.id)
    INNER JOIN DegreeProgram c ON(a.firstDegreeProgramChoice = c.id)
    INNER JOIN DegreeProgram d ON(a.secondDegreeProgramChoice = d.id)
    WHERE a.academicEvent=idCurrent AND a.approved=true
    ORDER BY a.id ASC
    LIMIT 5 OFFSET p_offset;
END //

/**
    author: dorian.contreras@unah.hn
    version: 0.2.0
    date: 28/11/24

    Procedimiento almacenado para insertar docentes
**/
CREATE PROCEDURE insertProfessor(
    IN p_dni VARCHAR(15),
    IN p_names VARCHAR(60),
    IN p_lastNames VARCHAR(60),
    IN p_telephoneNumber VARCHAR(12),
    IN p_password VARCHAR(60),
    IN p_address VARCHAR(30),
    IN p_dateOfBirth DATE,
    IN p_professorType INT,
    IN p_department INT
)
BEGIN
    DECLARE newEmail VARCHAR(50);
    DECLARE randomLetter CHAR(1);
    DECLARE emailExists BOOLEAN DEFAULT TRUE;
    DECLARE counter INT DEFAULT 1;
    DECLARE nameParts INT;
    DECLARE lastNameParts INT;
    DECLARE firstName VARCHAR(15);
    DECLARE secondName VARCHAR(15);
    DECLARE firstLastName VARCHAR(15);
    DECLARE secondLastName VARCHAR(15);
    DECLARE nameLength INT;

    -- Verificar si el ID existe
    IF EXISTS (SELECT 1 FROM Employee WHERE dni = p_dni) THEN
         -- Si el ID ya existe no se puede insertar
        SELECT JSON_OBJECT(
            'status', false,
            'message', 'El DNI ya existe, no se puede insertar docente.'
        ) AS resultJson;
    ELSEIF EXISTS(SELECT * FROM Professor WHERE department=p_department AND active=true AND professorType=4) THEN
         -- Ya existe jefe de departamento 
        SELECT JSON_OBJECT(
            'status', false,
            'message', 'Ya existe un jefe de departamento.'
        ) AS resultJson;
    ELSEIF EXISTS(SELECT * FROM Professor WHERE department=p_department AND active=true AND professorType=3) THEN
         -- Ya existe jefe de departamento 
        SELECT JSON_OBJECT(
            'status', false,
            'message', 'Ya existe un coordinador de departamento.'
        ) AS resultJson;
    ELSE
        -- Separar los nombres
        SET nameParts = LENGTH(p_names) - LENGTH(REPLACE(p_names, ' ', '')) + 1;
        SET lastNameParts = LENGTH(p_lastNames) - LENGTH(REPLACE(p_lastNames, ' ', '')) + 1;

        -- Extraer nombres
        SET firstName = TRIM(SUBSTRING_INDEX(p_names, ' ', 1));
        SET secondName = TRIM(IF(nameParts > 1, SUBSTRING_INDEX(SUBSTRING_INDEX(p_names, ' ', 2), ' ', -1), ''));

        -- Extraer apellidos
        SET firstLastName = TRIM(SUBSTRING_INDEX(p_lastNames, ' ', 1));
        SET secondLastName = TRIM(IF(lastNameParts > 1, SUBSTRING_INDEX(SUBSTRING_INDEX(p_lastNames, ' ', 2), ' ', -1), ''));

        SET newEmail = CONCAT(firstName, '.', firstLastName, '@unah.edu.hn');
        
        WHILE emailExists DO
            -- Verificar si el correo ya existe
            IF EXISTS (SELECT 1 FROM Employee WHERE personalEmail = newEmail) THEN
                CASE counter
                    WHEN 1 THEN
                        -- Primera letra del primer nombre + primer apellido
                        SET newEmail = CONCAT(LOWER(SUBSTRING(firstName, 1, 1)), LOWER(firstLastName), '@unah.edu.hn');
                    WHEN 2 THEN
                        -- Primeras dos letras del primer nombre + primer apellido
                        SET newEmail = CONCAT(LOWER(SUBSTRING(firstName, 1, 2)), LOWER(firstLastName), '@unah.edu.hn');
                    WHEN 3 THEN
                        -- Primer nombre completo + primera letra del segundo nombre (si existe) + primer apellido
                        SET newEmail = CONCAT(LOWER(firstName), LOWER(SUBSTRING(secondName, 1, 1)), LOWER(firstLastName), '@unah.edu.hn');
                    WHEN 4 THEN
                        -- Primer nombre completo + primeras dos letras del segundo nombre (si existe) + primer apellido
                        SET newEmail = CONCAT(LOWER(firstName), LOWER(SUBSTRING(secondName, 1, 2)), LOWER(firstLastName), '@unah.edu.hn');
                    WHEN 5 THEN
                        -- Primera letra del primer nombre + segundo apellido (si existe)
                        SET newEmail = CONCAT(LOWER(SUBSTRING(firstName, 1, 1)), LOWER(secondLastName), '@unah.edu.hn');
                    WHEN 6 THEN
                        -- Primeras dos letras del primer nombre + segundo apellido (si existe)
                        SET newEmail = CONCAT(LOWER(SUBSTRING(firstName, 1, 2)), LOWER(secondLastName), '@unah.edu.hn');
                    ELSE
                        -- Continuar incrementando las letras del primer nombre si no hay combinaciones
                        SET nameLength = LENGTH(firstName);
                        IF counter - 6 <= nameLength THEN
                            -- Usar hasta la siguiente letra del primer nombre
                            SET newEmail = CONCAT(LOWER(SUBSTRING(firstName, 1, counter - 6)), '.', LOWER(firstLastName), '@unah.edu.hn');
                        ELSE
                            -- Agregar una letra como último recurso
                            SET randomLetter = CHAR(FLOOR(65 + (RAND() * 26)));
                            SET newEmail = CONCAT(LOWER(firstName), '.', LOWER(firstLastName), LOWER(randomLetter), '@unah.edu.hn');
                        END IF;
                END CASE;
                -- Incrementar el contador
                SET counter = counter + 1;
            ELSE
                -- Salir del bucle si el correo es único
                SET emailExists = FALSE;
            END IF;
        END WHILE;

        INSERT INTO Employee (
            dni, 
            names,
            lastNames,
            telephoneNumber, 
            personalEmail, 
            password, 
            address, 
            dateOfBirth
        ) VALUES (
            p_dni, 
            p_names, 
            p_lastNames, 
            p_telephoneNumber, 
            newEmail, 
            p_password, 
            p_address, 
            p_dateOfBirth
        );

        INSERT INTO Professor (
            id, 
            professorType, 
            department, 
            active
        ) VALUES (
            LAST_INSERT_ID(), 
            p_professorType, 
            p_department, 
            true
        );

        SELECT JSON_OBJECT(
            'status', true,
            'personalEmail', newEmail,
            'idProfessor', LAST_INSERT_ID(),
            'message', 'Usuario del docente creado correctamente'
        ) AS resultJson;
    END IF;
END //

/**
    author: dorian.contreras@unah.hn
    version: 0.2.0
    date: 28/11/24

    Procedimiento almacenado para actualizar docentes
**/
CREATE PROCEDURE updateProfessor(
    IN p_id INT,
    IN p_dni VARCHAR(15),
    IN p_names VARCHAR(60),
    IN p_lastNames VARCHAR(60),
    IN p_telephoneNumber VARCHAR(12),
    IN p_address VARCHAR(30),
    IN p_dateOfBirth DATE,
    IN p_professorType INT,
    IN p_department INT,
    IN p_active BOOLEAN
)
BEGIN

    DECLARE idVerify INT;
    SET idVerify = (SELECT id FROM Employee WHERE dni=p_dni);

    -- Verificar si el ID existe hacer el update
    IF EXISTS (SELECT 1 FROM Professor WHERE id = p_id) AND (idVerify IS NULL OR idVerify=p_id)THEN


        UPDATE Employee
        SET 
            dni = p_dni,
            names = p_names,
            lastNames = p_lastNames,
            telephoneNumber = p_telephoneNumber,
            address = p_address,
            dateOfBirth = p_dateOfBirth
        WHERE id = p_id;

        UPDATE Professor
        SET 
            professorType = p_professorType, 
            department = p_department,    
            active = p_active     
        WHERE id = p_id;

        SELECT JSON_OBJECT(
            'status', true,
            'message', 'Datos actualizados correctamente.'
        ) AS resultJson;
    ELSE

        SELECT JSON_OBJECT(
            'status', false,
            'message', 'El id no existe o el dni ya pertenece a otra persona.'
        ) AS resultJson;
    END IF;
END //

/**
    author: dorian.contreras@unah.hn
    version: 0.1.0
    date: 17/11/24

    Procedimiento almacenado para actualizar results 
**/
CREATE PROCEDURE updateResults(
    IN p_dni VARCHAR(15),
    IN p_test INT,
    IN p_grade FLOAT
)
BEGIN

    DECLARE idApplication INT;
    DECLARE points1 INT;

    SET idApplication = (SELECT a.id
                            FROM Application a
                            INNER JOIN AcademicEvent c ON (a.academicEvent = c.id)
                            WHERE c.active=true AND a.idApplicant=p_dni);

    SET points1 = (SELECT points
                    FROM AdmissionTest WHERE id=p_test);

    IF(idApplication IS NOT NULL) THEN

        IF (points1 IS NOT NULL) THEN
            IF (points1>=p_grade) THEN
                UPDATE Results
                    SET grade = p_grade
                WHERE application = idApplication AND admissionTest = p_test;

                SELECT JSON_OBJECT(
                    'status', true,
                    'message', 'Resultado insertado'
                ) AS resultJson;
            ELSE
                SELECT JSON_OBJECT(
                        'status', false,
                        'message', 'Puntuación inválida.'
                    ) AS resultJson;
            END IF;
        ELSE
            SELECT JSON_OBJECT(
                    'status', false,
                    'message', 'Id del examen incorrecto.',
                    'points', points
                ) AS resultJson;
        END IF;
    ELSE
        SELECT JSON_OBJECT(
                'status', false,
                'message', 'No existe aplicante con ese DNI en el proceso de admisión actual'
            ) AS resultJson;
    END IF;
END //

/**
    author: dorian.contreras@unah.hn
    version: 0.1.0
    date: 24/11/24

    Procedimiento almacenado para poner los limites inferiores y las metas del dia para los revisadores
**/
CREATE PROCEDURE reviewersEvent ()
BEGIN
    DECLARE amountInscriptions INT DEFAULT 0;
    DECLARE totalDays INT;
    DECLARE amountReviewers INT;
    DECLARE dayGoal INT;
    DECLARE lim INT;
    DECLARE cont INT DEFAULT 1;
    DECLARE idReviewer INT;
    DECLARE reviewerGoal INT;
    DECLARE totalInscriptions INT;

    IF EXISTS (SELECT 1 FROM AcademicEvent WHERE NOW() BETWEEN startDate AND finalDate AND id = (SELECT b.id FROM AcademicEvent a INNER JOIN AcademicEvent b ON (a.id = b.parentId) WHERE a.process=1 AND a.active=true AND b.active=true AND b.process=4)) THEN
    
        -- obtener el limite inferior 
        SET lim = (SELECT COUNT(*) FROM Application WHERE academicEvent= (SELECT id FROM AcademicEvent WHERE active = true AND process=1) AND approved IS NOT NULL);

        -- Limpiar limites
        UPDATE Reviewer
        SET lowerLimit = NULL, dailyGoal=0
        WHERE active = true;

        SET amountInscriptions = (SELECT COUNT(*) FROM Application WHERE academicEvent= (SELECT id FROM AcademicEvent WHERE active = true AND process=1) AND approved IS NULL);
        SET totalDays = (SELECT DATEDIFF(finalDate, NOW()) AS total_dias
                    FROM AcademicEvent WHERE id=(SELECT b.id 
                    FROM AcademicEvent a
                    INNER JOIN AcademicEvent b ON (a.id = b.parentId)
                    WHERE a.process=1 AND a.active=true AND b.active=true AND b.process=4));
        SET amountReviewers = (SELECT COUNT(*) FROM Reviewer WHERE active=true);
        SET dayGoal = CEIL(amountInscriptions/totalDays);
        SET reviewerGoal = CEIL(dayGoal/amountReviewers);
        SET totalInscriptions = (SELECT COUNT(*) FROM Application WHERE academicEvent= (SELECT id FROM AcademicEvent WHERE active = true AND process=1));

        WHILE cont<=amountReviewers DO

            SET idReviewer = (SELECT id FROM Reviewer WHERE active = true AND lowerLimit IS NULL ORDER BY RAND() LIMIT 1);

            IF(dayGoal - reviewerGoal >= 0 && lim< totalInscriptions) THEN
                UPDATE Reviewer
                SET lowerLimit = lim, dailyGoal = reviewerGoal
                WHERE id = idReviewer;
                SET dayGoal = dayGoal - reviewerGoal;
            ELSEIF(dayGoal > 0) THEN
                UPDATE Reviewer
                SET lowerLimit = lim, dailyGoal = dayGoal
                WHERE id = idReviewer;
                SET dayGoal = 0;
                SET cont = amountReviewers + 1;
            ELSE
                UPDATE Reviewer
                SET lowerLimit = NULL, dailyGoal = 0
                WHERE id = idReviewer;
                SET dayGoal = 0;
                SET cont = amountReviewers + 1;
            END IF;

            SET cont = cont + 1;
            SET lim = lim + reviewerGoal;
        END WHILE;

        DROP TABLE IF EXISTS TempTableApplication;

        CREATE TABLE TempTableApplication AS
        SELECT 
            a.id, 
            CONCAT(b.names, ' ', b.lastNames) as name, 
            c.description as firstCareer, 
            a.applicationDate, 
            a.approved
        FROM Application a
        INNER JOIN Applicant b ON(a.idApplicant=b.id)
        INNER JOIN DegreeProgram c ON(a.firstDegreeProgramChoice = c.id)
        INNER JOIN RegionalCenter e ON(a.regionalCenterChoice = e.id)
        WHERE a.academicEvent = (SELECT id FROM AcademicEvent WHERE active = true AND process=1)
        ORDER BY a.approved IS NULL ASC;

        ALTER TABLE TempTableApplication ADD PRIMARY KEY (id);
    END IF;
END//


/**
    author: dorian.contreras@unah.hn
    version: 0.1.0
    date: 24/11/24

    Procedimiento obtener estadisticas por centro regional
**/
CREATE PROCEDURE RegionalCentersStadistics(IN academicEventId INT)
BEGIN
    SELECT b.acronym, COUNT(*) as amountInscriptions, COUNT(CASE WHEN a.approved = true THEN 1 ELSE NULL END) AS approvedReview, COUNT(CASE WHEN a.approvedFirstChoice = true OR a.approvedSecondChoice = true THEN 1 ELSE NULL END) AS approvedApplicants
    FROM Application a
    INNER JOIN RegionalCenter b
    ON (a.regionalCenterChoice=b.id)
    WHERE academicEvent = academicEventId
    GROUP BY b.id;
END //

/**
    author: dorian.contreras@unah.hn
    version: 0.1.0
    date: 24/11/24

    Procedimiento obtener las inscripciones que va a revisar cada revisor
**/
CREATE PROCEDURE ToReview (IN p_id INT)
BEGIN 
    DECLARE lim INT;
    DECLARE goal INT;

    SET lim = (SELECT lowerLimit FROM Reviewer WHERE id=p_id);
    SET goal = (SELECT dailyGoal FROM Reviewer WHERE id=p_id);

    IF lim IS NOT NULL THEN
        SELECT * FROM TempTableApplication
        LIMIT goal
        OFFSET lim;
    END IF;
END//

/*-------------------------------------------------------------------TRIGGERS-------------------------------------------------------------------------------------*/
/**
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 17/11/24
 */
CREATE TRIGGER after_update_result
AFTER UPDATE ON Results
FOR EACH ROW
BEGIN
    DECLARE num_required_exams_first INT;
    DECLARE num_passed_exams_first INT;
    DECLARE num_required_exams_second INT;
    DECLARE num_passed_exams_second INT;

    SELECT COUNT(*) INTO num_required_exams_first
    FROM AdmissionDegree
    WHERE degree = (SELECT firstDegreeProgramChoice FROM Application WHERE id = NEW.application);

    SELECT COUNT(*)
    INTO num_passed_exams_first
    FROM Results R
    JOIN AdmissionDegree AD ON R.admissionTest = AD.admissionTest
    WHERE R.application = NEW.application
    AND AD.degree = (SELECT firstDegreeProgramChoice FROM Application WHERE id = NEW.application)
    AND R.grade >= AD.passingGrade;

    SELECT COUNT(*) INTO num_required_exams_second
    FROM AdmissionDegree
    WHERE degree = (SELECT secondDegreeProgramChoice FROM Application WHERE id = NEW.application);

    SELECT COUNT(*)
    INTO num_passed_exams_second
    FROM Results R
    JOIN AdmissionDegree AD ON R.admissionTest = AD.admissionTest
    WHERE R.application = NEW.application
    AND AD.degree = (SELECT secondDegreeProgramChoice FROM Application WHERE id = NEW.application)
    AND R.grade >= AD.passingGrade;

    IF num_required_exams_first = num_passed_exams_first THEN
        UPDATE Application
        SET approvedFirstChoice = TRUE
        WHERE id = NEW.application;
    END IF;

    IF num_required_exams_second = num_passed_exams_second THEN
        UPDATE Application
        SET approvedSecondChoice = TRUE
        WHERE id = NEW.application;
    END IF;
END //


CREATE TRIGGER after_insert_academic_event
AFTER INSERT ON AcademicEvent
FOR EACH ROW
BEGIN
    -- Verificar si el valor del proceso es igual a 1
    IF NEW.process = 1 THEN
        -- Insertar en la tabla SendedEmail
        INSERT INTO SendedEmail (academicProcess, active) 
        VALUES (NEW.id, FALSE);
    END IF;
END //

/*------------------------------------------------------------------------EVENTS--------------------------------------------------------------------------------*/
-- Set the event scheduler ON
SET GLOBAL event_scheduler = ON;

-- Create the scheduled event
CREATE EVENT statusVerification
ON SCHEDULE EVERY 1 DAY
STARTS '2024-11-25 00:00:00'
DO
BEGIN
    -- Activate events within date range
    UPDATE AcademicEvent
    SET active = 1
    WHERE startDate <= CURDATE() AND CURDATE() <= finalDate;

    -- Deactivate events outside date range
    UPDATE AcademicEvent
    SET active = 0
    WHERE CURDATE() < startDate OR CURDATE() > finalDate;
END;

/**
    author: dorian.contreras@unah.hn
    version: 0.1.0
    date: 24/11/24

    Evento para poner los limites inferiores y las metas del dia para los revisadores
**/
-- Evento para definir la cantidad de inscripciones a revisar por dia y los rangos de los revisores
CREATE EVENT reviewersEvent
ON SCHEDULE EVERY 1 DAY
STARTS '2024-11-25 00:00:00'
DO
BEGIN
   CALL reviewersEvent; 
END;

/*------------------------------------------------------------------INSERTS-------------------------------------------------------------------------------------*/
INSERT INTO RegionalCenter(description, location, acronym) VALUES
    ('Centro Universitario Regional del Centro', 'Comayagua', 'CURNO'),
    ('Centro Universitario Regional del Litoral Atlántico', 'La Ceiba, Atlántida', 'CURLA'),
    ('Centro Universitario Regional del Litoral Pacífico', 'Choluteca', 'CURLP'),
    ('Centro Universitario Regional Nor-Oriental', 'Juticalpa, Olancho', 'CURNO'),
    ('Centro Universitario Regional del Occidente', 'Santa Rosa de Copán', 'CURO'),
    ('CRAED Choluteca', 'Choluteca', 'CRAED-C'),
    ('CRAED Juticalpa', 'Juticalpa, Olancho', 'CRAED-J'),
    ('CRAED La Entrada', 'La Entrada, Copán', 'CRAED-LE'),
    ('CRAED Paraíso', 'El Paraíso', 'CRAED P'),
    ('CRAED Progreso', 'El Progreso, Yoro', 'CRAED PR'),
    ('CRAED Siguatepeque', 'Siguatepeque, Comayagua', 'CRAED-SGT'),
    ('CRAED Tegucigalpa', 'Tegucigalpa', 'CRAED-TGU'),
    ('CRAED Tocoa', 'Tocoa, Colón','CRAED-TCA'),
    ('Instituto Tecnológico Superior de Tela - UNAH', 'Tegucigalpa', 'ITST'),
    ('UNAH Tecnológico Danlí', 'Danlí, El Paraíso','TEC-DANLI'),
    ('UNAH Telecentro Marcala', 'Marcala, La Paz', 'TEL-MARC'),
    ('UNAH Valle de Sula', 'San Pedro Sula, Cortés', 'VS'),
    ('UNAH Tecnológico Aguan', 'Olanchito, Yoro','TEC-AGUAN'),
    ('Ciudad Universitaria', 'Tegucigalpa', 'CU')
;

INSERT INTO AdministrativeType(description) VALUES
    ('SEDP'),
    ('Admisiones')
;

INSERT INTO DegreeProgram (description) VALUES 
    ('Derecho'),
    ('Antropología'),
    ('Periodismo'),
    ('Psicología'),
    ('Pedagogía'),
    ('Trabajo Social'),
    ('Historia'),
    ('Letras'),
    ('Filosofía'),
    ('Sociología'),
    ('Educación Física'),
    ('Lenguas Extranjeras'),
    ('Música'),
    ('Desarrollo Local'),
    ('Ingeniería Civil'),
    ('Ingeniería Mecánica '),
    ('Ingeniería Eléctrica '),
    ('Ingeniería Industrial'),
    ('Ingeniería en Sistemas'),
    ('Arquitectura'),
    ('Matemáticas'),
    ('Física'),
    ('Astronomía y Astrofísica'),
    ('Ciencia y Tecnologías de la Información'),
    ('Medicina'),
    ('Odontología'),
    ('Nutrición'),
    ('Química y Farmacia'),
    ('Enfermería'),
    ('Microbiología'),
    ('Biología'),
    ('Administración de Empresas'),
    ('Administración Pública'),
    ('Economía'),
    ('Contaduría Pública y Finanzas'),
    ('Administración Aduanera'),
    ('Administración de Banca y Finanzas'),
    ('Comercio Internacional'),
    ('Informática Administrativa'),
    ('Mercadotecnia'),
    ('Ingeniería Agronómica'),
    ('Ingeniería Forestal'),
    ('Ingeniería Agroindustrial'),
    ('Ingeniería en Ciencias Acuícolas y Recursos Marinos Costeros'),
    ('Economía Agrícola'),
    ('Comercio Internacional con Orientación en Agroindustria'),
    ('Administración de Empresas Agropecuarias'),
    ('Ecoturismo'),
    ('Ingeniería Química'),
    ('Química Industrial'),
    ('Geología')
;

INSERT INTO ProfessorType(description) VALUES
    ('Docente por hora'),
    ('Docente Permanente'),
    ('Coordinador'),
    ('Jefe de departamento')
;

INSERT INTO AdmissionTest (description, points) VALUES 
    ('Prueba de Aptitud Académica', 1600),
    ('Prueba de Conocimientos para Ciencias Naturales y de la Salud', 800)
;

INSERT INTO AdmissionDegree (description, degree, admissionTest, passingGrade) VALUES 
    ('PAA para Derecho', 1, 1, 700),
    ('PAA para Antropología', 2, 1, 700),
    ('PAA para Periodismo', 3, 1, 700),
    ('PAA para Psicología', 4, 1, 700),
    ('PAA para Pedagogía', 5, 1, 700),
    ('PAA para Trabajo Social', 6, 1, 700),
    ('PAA para Historia', 7, 1, 700),
    ('PAA para Letras', 8, 1, 700),
    ('PAA para Filosofía', 9, 1, 700),
    ('PAA para Sociología', 10, 1, 700),
    ('PAA para Educación Física', 11, 1, 700),
    ('PAA para Lenguas Extranjeras', 12, 1, 700),
    ('PAA para Música', 13, 1, 700),
    ('PAA para Desarrollo Local', 14, 1, 700),
    ('PAA para Ingeniería Civil', 15, 1, 1000),
    ('PAA para Ingeniería Mecánica Industrial', 16, 1, 1000),
    ('PAA para Ingeniería Eléctrica Industrial', 17, 1, 1000),
    ('PAA para Ingeniería Industrial', 18, 1, 1000),
    ('PAA para Ingeniería en Sistemas', 19, 1, 1000),
    ('PAA para Arquitectura', 20, 1, 700),
    ('PAA para Matemáticas', 21, 1, 700),
    ('PAA para Física', 22, 1, 700),
    ('PAA para Astronomía y Astrofísica', 23, 1, 700),
    ('PAA para Ciencia y Tecnologías de la Información Geográfica', 24, 1, 700),
    ('PAA para Medicina', 25, 1, 1100),
    ('PAA para Odontología', 26, 1, 900),
    ('PAA para Nutrición', 27, 1, 900),
    ('PAA para Química y Farmacia', 28, 1, 900),
    ('PAA para Enfermería', 29, 1, 900),
    ('PAA para Microbiología', 30, 1, 900),
    ('PAA para Biología', 31, 1, 700),
    ('PAA para Administración de Empresas', 32, 1, 700),
    ('PAA para Administración Pública', 33, 1, 700),
    ('PAA para Economía', 34, 1, 700),
    ('PAA para Contaduría Pública y Finanzas', 35, 1, 700),
    ('PAA para Administración Aduanera', 36, 1, 700),
    ('PAA para Administración de Banca y Finanzas', 37, 1, 700),
    ('PAA para Comercio Internacional', 38, 1, 700),
    ('PAA para Informática Administrativa', 39, 1, 700),
    ('PAA para Mercadotecnia', 40, 1, 700),
    ('PAA para Ingeniería Agronómica', 41, 1, 1000),
    ('PAA para Ingeniería Forestal', 42, 1, 1000),
    ('PAA para Ingeniería Agroindustrial', 43, 1, 1000),
    ('PAA para Ingeniería en Ciencias Acuícolas', 44, 1, 1000),
    ('PAA para Economía Agrícola', 45, 1, 700),
    ('PAA para Comercio Internacional con Orientación en Agroindustria', 46, 1, 700),
    ('PAA para Administración de Empresas Agropecuarias', 47, 1, 700),
    ('PAA para Ecoturismo', 48, 1, 700),
    ('PAA para Ingeniería Química', 49, 1, 1000),
    ('PAA para Química Industrial', 50, 1, 700),
    ('PAA para Geología', 51, 1, 700),
    ('PCCNS para Medicina', 25, 2, 400),
    ('PCCNS para Odontología', 26, 2, 400),
    ('PCCNS para Nutrición', 27, 2, 400),
    ('PCCNS para Química y Farmacia', 28, 2, 400),
    ('PCCNS para Enfermería', 29, 2, 400),
    ('PCCNS para Microbiología', 30, 2, 400)
;

INSERT INTO RegionalCenterDegree (degree, regionalCenter) VALUES
    (1,17),
    (1,19),
    (2,19),
    (2,6),
    (2,7),
    (2,8),
    (2,9),
    (2,10),
    (2,11),
    (2,12),
    (2,13),
    (3,17),
    (3,19),
    (4,17),
    (4,19),
    (5,17),
    (5,19),
    (6,19),
    (7,19),
    (8,17),
    (8,19),
    (9,19),
    (10,17),
    (10,19),
    (11,19),
    (12,19),
    (13,19),
    (14,19),
    (14,5),
    (14,15),
    (14,1),
    (15,17),
    (15,19),
    (16,17),
    (16,19),
    (17,17),
    (17,19),
    (18,17),
    (18,19),
    (19,17),
    (19,19),
    (19,5),
    (19,3),
    (19,1),
    (20,19),
    (21,19),
    (21,17),
    (22,19),
    (23,19),
    (24,19),
    (25,19),
    (25,17),
    (26,19),
    (26,17),
    (27,19),
    (28,19),
    (29,19),
    (29,17),
    (29,2),
    (29,4),
    (29,15),
    (30,19),
    (31,19),
    (32,19),
    (32,17),
    (32,5),
    (32,1),
    (32,2),
    (32,3),
    (32,15),
    (32,4),
    (33,19),
    (34,19),
    (35,19),
    (35,17),
    (36,19),
    (37,19),
    (38,19),
    (38,4),
    (39,19),
    (39,17),
    (39,15),
    (39,4),
    (39,18),
    (39,14),
    (40,19),
    (41,2),
    (42,2),
    (43,5),
    (43,15),
    (43,1),
    (43,3),
    (43,4),
    (43,18),
    (44,3),
    (45,2),
    (46,5),
    (46,1),
    (46,3),
    (46,4),
    (47,6),
    (47,7),
    (47,8),
    (47,9),
    (47,10),
    (47,11),
    (47,12),
    (47,13),
    (47,6),
    (48,2),
    (49,19),
    (50,17),
    (51,19)
;

INSERT INTO Employee (dni, names, lastNames, telephoneNumber, personalEmail, password, address, dateOfBirth) VALUES 
    ('0801-1999-01234', 'Juan Carlos', 'Perez Lopez', '98765432', 'juan.perez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle Principal #123', '1990-05-15'),
    ('0801-1998-05678', 'Maria Elena', 'Ramirez Garcia', '91234567', 'maria.ramirez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Avenida Secundaria #456', '1988-10-20'),
    ('0801-2001-01111', 'Pedro Luis', 'Castillo Martinez', '98765432', 'pedro.castillo@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle Norte #789', '2001-03-10'),
    ('0801-2002-02222', 'Ana Maria', 'Lopez Fernandez', '91234567', 'ana.lopez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Avenida Central #321', '2002-08-22'),
    ('0801-2003-03333', 'Luis Carlos', 'Hernandez Diaz', '98765432', 'luis.hernandez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Boulevard Principal #555', '2003-12-01'),
    ('0801-2004-04444', 'Sofia Isabel', 'Gomez Rodriguez', '91234567', 'sofia.gomez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia Primavera #678', '2004-05-14'),
    ('0801-2005-05555', 'Carlos Alberto', 'Martinez Lopez', '98765432', 'carlos.martinez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial Los Pinos #890', '2005-09-25')
;

INSERT INTO Administrative (id, administrativeType) VALUES
    (1,1),
    (2,2)
;

INSERT INTO Department (description) VALUES 
    ('Ingeniería en Sistemas'),
    ('Ingeniería Civil'),
    ('Ingeniería Industrial'),
    ('Ingeniería Eléctrica'),
    ('Ingeniería Mecánica'),
    ('Ingeniería Química'),
    ('Medicina'),
    ('Odontología'),
    ('Farmacia'),
    ('Biología'),
    ('Química y Farmacia'),
    ('Arquitectura'),
    ('Derecho'),
    ('Economía'),
    ('Administración de Empresas'),
    ('Contaduría Pública y Finanzas'),
    ('Psicología'),
    ('Trabajo Social'),
    ('Pedagogía'),
    ('Ciencias de la Comunicación'),
    ('Turismo'),
    ('Arte'),
    ('Música'),
    ('Matemática'),
    ('Física'),
    ('Estadística'),
    ('Ciencias Computacionales'),
    ('Filosofía'),
    ('Sociología'),
    ('Antropología'),
    ('Historia'),
    ('Relaciones Internacionales'),
    ('Enfermería'),
    ('Tecnología Médica'),
    ('Agronomía'),
    ('Zootecnia'),
    ('Veterinaria'),
    ('Microbiología')
;

INSERT INTO Professor(id, professorType, department, active) VALUES
    (3, 3, 1, true),
    (4, 4, 1, true),
    (5, 1, 1, true),
    (6, 2, 1, false)
;

INSERT INTO AcademicProcess(description) VALUES 
    ('Proceso de Admisiones'),
    ('Proceso de Matricula'),
    ('Inscripciones'),
    ('Revisión de inscripciones'),
    ('Subir calificaciones'),
    ('Envio de resultados'),
    ('Creación de expediente'),
    ('Planificación académica')
;

INSERT INTO AcademicEvent(process, startDate, finalDate, active, parentId) VALUES
    (1,'2022-01-13 00:00:00', '2022-01-12 00:00:00', false, NULL),
    (1,'2022-05-20 00:00:00', '2022-06-12 00:00:00', false, NULL),
    (1,'2023-01-20 00:00:00', '2023-02-12 00:00:00', false, NULL),
    (1,'2023-08-20 00:00:00', '2023-09-12 00:00:00', false, NULL),
    (1, '2024-11-23 00:00:00', '2024-12-20 00:00:00', true, NULL),
    (3, '2024-11-23 00:00:00', '2024-11-25 00:00:00', true, 5),
    (4, '2024-11-27 00:00:00', '2024-12-08 00:00:00', false, 5),
    (5, '2024-12-08 00:00:00', '2024-12-09 00:00:00', false, 5),
    (6, '2024-12-09 00:00:00', '2024-12-11 00:00:00', false, 5),
    (7, '2024-12-11 00:00:00', '2024-12-20 00:00:00', false, 5)
;

INSERT INTO Configuration(data) VALUES
    ('{"maxAttemtps":2}')
;

INSERT INTO Applicant (id, names, lastNames, schoolCertificate, telephoneNumber, personalEmail) VALUES
    ('0801-1990-01234', 'Juan Carlos', 'Martínez López', 'path1.pdf', '12345678', 'juan.carlos@gmail.com'),
    ('0802-1995-05678', 'María Alejandra', 'Gómez Cruz', 'path2.pdf', '87654321', 'maria.gomez@gmail.com'),
    ('0803-1993-04567', 'Carlos Eduardo', 'Pérez Mejía', 'path3.pdf', '12349876', 'carlos.perez@gmail.com'),
    ('0804-1992-02345', 'Ana Lucía', 'Rodríguez Hernández', 'path4.pdf', '56781234', 'ana.rodriguez@gmail.com'),
    ('0805-1994-08765', 'Luis Fernando', 'Ramos García', 'path5.pdf', '23456789', 'luis.ramos@gmail.com'),
    ('0806-1991-03456', 'Sofía María', 'Flores Martínez', 'path6.pdf', '34567891', 'sofia.flores@gmail.com'),
    ('0807-1997-09876', 'Miguel Ángel', 'López Ortega', 'path7.pdf', '45678912', 'miguel.lopez@gmail.com'),
    ('0808-1996-05674', 'Sara Isabel', 'Castro Padilla', 'path8.pdf', '56789123', 'sara.castro@gmail.com'),
    ('0809-1992-01234', 'Jorge Manuel', 'Mendoza Gutiérrez', 'path9.pdf', '67891234', 'jorge.mendoza@gmail.com'),
    ('0810-1995-02345', 'Lucía Andrea', 'Reyes Castillo', 'path10.pdf', '78912345', 'lucia.reyes@gmail.com'),
    ('0811-1991-04567', 'Daniel Alberto', 'González Díaz', 'path11.pdf', '89123456', 'daniel.gonzalez@gmail.com'),
    ('0812-1998-03456', 'Paola Montserrat', 'Sánchez Morales', 'path12.pdf', '91234567', 'paola.sanchez@gmail.com'),
    ('0813-1993-05678', 'Fernando José', 'Ramírez Velásquez', 'path13.pdf', '23451234', 'fernando.ramirez@gmail.com'),
    ('0814-1997-01234', 'Alejandro Luis', 'Navarro Acosta', 'path14.pdf', '34562345', 'alejandro.navarro@gmail.com'),
    ('0815-1995-08765', 'Mónica Patricia', 'Campos Ruiz', 'path15.pdf', '45673456', 'monica.campos@gmail.com'),
    ('0816-1992-03456', 'Andrea Carolina', 'Álvarez Montes', 'path16.pdf', '56784567', 'andrea.alvarez@gmail.com'),
    ('0817-1993-09876', 'Julio César', 'Hernández Espinoza', 'path17.pdf', '67895678', 'julio.hernandez@gmail.com'),
    ('0818-1996-05678', 'Francisco José', 'Lara González', 'path18.pdf', '78906789', 'francisco.lara@gmail.com'),
    ('0819-1995-02345', 'Sandra Marcela', 'Velasco Zelaya', 'path19.pdf', '89017890', 'sandra.velasco@gmail.com'),
    ('0820-1991-06789', 'Ricardo Antonio', 'Moncada Benítez', 'path20.pdf', '90128901', 'ricardo.moncada@gmail.com')
;

INSERT INTO Reviewer (firstName, firstLastName, telephoneNumber, personalEmail, password, active) 
VALUES 
    ('Carlos', 'Hernández', '9988776655', 'carlos.hernandez@gmail.com','$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', true),
    ('María', 'Lopez', '9966554433', 'maria.lopez@gmail.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', true),
    ('Luis', 'Martínez', '9876543210', 'luis.martinez@gmail.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', true),
    ('Ana', 'González', '9999888877', 'ana.gonzalez@gmail.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', false),
    ('Jorge', 'Mejía', '9900112233', 'jorge.mejia@gmail.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', false)
;

INSERT INTO Application (idApplicant, firstDegreeProgramChoice, secondDegreeProgramChoice, regionalCenterChoice, applicationDate, academicEvent, approvedFirstChoice, approvedSecondChoice, approved, idReviewer) VALUES
    ('0801-1990-01234', 12, 1, 19, '2022-01-14 01:00:00', 1, true, false, true, 4),
    ('0802-1995-05678', 4, 5, 17, '2022-01-14 01:00:00', 1, false, false, false, 3),
    ('0803-1993-04567', 9, 8, 19, '2022-01-14 01:00:00', 1, false, true, true, 1),
    ('0804-1992-02345', 38, 32, 4, '2022-01-14 01:00:00', 1, true, true, true, 2),
    ('0805-1994-08765', 39, 32, 15, '2022-01-14 01:00:00', 1, false, false, false, 5),
    ('0806-1991-03456', 34, 35, 19, '2022-01-14 01:00:00', 1, false, true, true, 1),
    ('0807-1997-09876', 41, 42, 2, '2022-01-14 01:00:00', 1, true, true, true, 2),
    ('0808-1996-05674', 14, 29, 15, '2022-01-14 01:00:00', 1, true, false, true, 3),
    ('0809-1992-01234', 12, 1, 19, '2022-01-14 01:00:00', 1, false, true, true, 4),
    ('0810-1995-02345', 25, 24, 19, '2022-01-14 01:00:00', 1, true, false, true, 5),
    ('0811-1991-04567', 38, 32, 4, '2022-01-14 01:00:00', 1, false,false, true, 1),
    ('0812-1998-03456', 14, 19, 1, '2022-01-14 01:00:00', 1, true, true, true, 2),
    ('0813-1993-05678', 21, 20, 19, '2022-01-14 01:00:00', 1, false, true, true, 3),
    ('0814-1997-01234', 14, 19, 1, '2022-01-14 01:00:00', 1, true, true, true, 4),
    ('0815-1995-08765', 43, 19, 3, '2022-01-14 01:00:00', 1, false, false, false, 5),
    ('0816-1992-03456', 45, 42, 2, '2023-08-21 01:00:00', 2, true, false, true, 1),
    ('0817-1993-09876', 36, 35, 19, '2023-08-21 01:00:00', 2, false, true, true, 2),
    ('0818-1996-05678', 38, 32, 4, '2023-08-21 01:00:00', 2, false, false, false, 3),
    ('0819-1995-02345', 21, 20, 19, '2023-08-21 01:00:00', 2, true, true, true, 4),
    ('0820-1991-06789', 14, 19, 1, '2023-08-21 01:00:00', 2, true, true, true, 5),
    ('0805-1994-08765', 39, 32, 15, '2023-08-21 01:00:00', 2, true, true, true, 2),
    ('0806-1991-03456', 34, 35, 19, '2023-08-21 01:00:00', 2, false, true, true, 1),
    ('0807-1997-09876', 41, 42, 2, '2023-08-21 01:00:00', 2, true, false, true, 3),
    ('0808-1996-05674', 14, 29, 15, '2023-08-21 01:00:00', 2, false, false, false, 4),
    ('0809-1992-01234', 12, 1, 19, '2023-08-21 01:00:00', 2, true, true, true, 5),
    ('0801-1990-01234', 12, 1, 19, '2022-01-14 01:00:00', 2, true, false, true, 4),
    ('0801-1990-01234', 12, 1, 19, '2022-01-14 01:00:00', 3, true, false, true, 1),
    ('0802-1995-05678', 4, 5, 17, '2022-01-14 01:00:00', 3, true, true, true, 2),
    ('0803-1993-04567', 9, 8, 19, '2022-01-14 01:00:00', 3, false, true, true, 3),
    ('0804-1992-02345', 38, 32, 4, '2022-01-14 01:00:00', 3, false, false, false, 4),
    ('0805-1994-08765', 39, 32, 15, '2022-01-14 01:00:00', 3, false, false, false, 5),
    ('0806-1991-03456', 34, 35, 19, '2022-01-14 01:00:00', 3, false, true, true, 1),
    ('0807-1997-09876', 41, 42, 2, '2022-01-14 01:00:00', 3, true, true, true, 2),
    ('0808-1996-05674', 14, 29, 15, '2022-01-14 01:00:00', 4, true, false, true, 3),
    ('0809-1992-01234', 12, 1, 19, '2022-01-14 01:00:00', 4, false, true, true, 4),
    ('0810-1995-02345', 25, 24, 19, '2022-01-14 01:00:00', 4, false, false, false, 5),
    ('0811-1991-04567', 38, 32, 4, '2022-01-14 01:00:00', 4, false,false, false, 1),
    ('0812-1998-03456', 14, 19, 1, '2022-01-14 01:00:00', 4, true, true, true, 2),
    ('0813-1993-05678', 21, 20, 19, '2022-01-14 01:00:00', 4, false, false, false, 3),
    ('0814-1997-01234', 14, 19, 1, '2022-01-14 01:00:00', 4, true, true, true, 4),
    ('0815-1995-08765', 43, 19, 3, '2022-01-14 01:00:00', 4, false, true, true, 5),
    ('0816-1992-03456', 45, 42, 2, '2023-08-21 01:00:00', 4, true, false, true, 1),
    ('0817-1993-09876', 36, 35, 19, '2023-08-21 01:00:00', 4, false, true, true, 2),
    ('0818-1996-05678', 38, 32, 4, '2023-08-21 01:00:00', 4, true, true, true, 3),
    ('0819-1995-02345', 21, 20, 19, '2023-08-21 01:00:00', 4, true, true, true, 4),
    ('0820-1991-06789', 14, 19, 1, '2023-08-21 01:00:00', 4, true, true, false, 5)
;

INSERT INTO Results(application, admissionTest, grade) VALUES
    (1,1,750),
    (2,1,1520),
    (3,1,985),
    (4,1,1547),
    (5,1,365),
    (6,1,658),
    (7,1,968),
    (8,1,1024),
    (9,1,1369),
    (10,1,785),
    (10,2,459),
    (11,1,369),
    (12,1,852),
    (13,1,148),
    (14,1,985),
    (15,1,658),
    (16,1,789),
    (17,1,852),
    (18,1,1236),
    (19,1,1458),
    (20,1,1369),
    (21,1,1245),
    (22,1,569),
    (23,1,785),
    (24,1,1259),
    (25,1,1026),
    (26,1,750),
    (27,1,1520),
    (28,1,985),
    (29,1,1547),
    (30,1,365),
    (31,1,658),
    (32,1,968),
    (33,1,1024),
    (34,1,1369),
    (35,1,785),
    (36,2,459),
    (37,1,369),
    (38,1,852),
    (39,1,148),
    (40,1,985),
    (41,1,658),
    (42,1,789),
    (43,1,852),
    (44,1,1236),
    (45,1,1458)
;
