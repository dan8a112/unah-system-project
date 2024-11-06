DROP DATABASE IF EXISTS ProyectoIS;

CREATE DATABASE ProyectoIS CHARACTER SET 'utf8';

USE ProyectoIS;

CREATE TABLE RegionalCenter(
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(70) NOT NULL,
    location VARCHAR(100) NOT NULL
);

CREATE TABLE AdmissionTest(
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(62) NOT NULL
    
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
    firstName VARCHAR(15) NOT NULL,
    secondName VARCHAR(15) NOT NULL,
    firstLastName VARCHAR(15) NOT NULL,
    secondLastName VARCHAR(15) NOT NULL,
    pathSchoolCertificate VARCHAR(30),
    telephoneNumber VARCHAR(12),
    personalEmail VARCHAR(30)
    
);

CREATE TABLE Application(
	id INT PRIMARY KEY AUTO_INCREMENT,
    idApplicant VARCHAR(15),
    firstDegreeProgramChoice SMALLINT,
    secondDegreeProgramChoice SMALLINT,
    regionalCenterChoice TINYINT,
    CONSTRAINT idApplicant FOREIGN KEY(idApplicant) REFERENCES Applicant(id),
    CONSTRAINT fk_firstDegreeProgramChoice FOREIGN KEY(firstDegreeProgramChoice) REFERENCES DegreeProgram(id),
	CONSTRAINT fk_secondDegreeProgramChoice FOREIGN KEY(secondDegreeProgramChoice) REFERENCES DegreeProgram(id),
    CONSTRAINT fk_regionalCenterChoice FOREIGN KEY (regionalCenterChoice) REFERENCES RegionalCenter(id)
    
);



CREATE TABLE Employee(
	id INT PRIMARY KEY AUTO_INCREMENT,
    dni VARCHAR (15) NOT NULL,
	firstName VARCHAR(15) NOT NULL,
    secondName VARCHAR(15) NOT NULL,
    firstLastName VARCHAR(15) NOT NULL,
    secondLastName VARCHAR(15) NOT NULL,
    telephoneNumber VARCHAR(12) NOT NULL,
    personalEmail VARCHAR(30) NOT NULL,
    password VARCHAR (60) NOT NULL,
    address VARCHAR(30) NOT NULL,
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



INSERT INTO RegionalCenter(description, location) VALUES
    ('Centro Universitario Regional del Centro', 'Comayagua'),
    ('Centro Universitario Regional del Litoral Atlántico', 'La Ceiba, Atlántida'),
    ('Centro Universitario Regional del Litoral Pacífico', 'Choluteca'),
    ('Centro Universitario Regional Nor-Oriental', 'Juticalpa, Olancho'),
    ('Centro Universitario Regional del Occidente', 'Santa Rosa de Copán'),
    ('CRAED Choluteca', 'Choluteca'),
    ('CRAED Juticalpa', 'Juticalpa, Olancho'),
    ('CRAED La Entrada', 'La Entrada, Copán'),
    ('CRAED Paraíso', 'El Paraíso'),
    ('CRAED Progreso', 'El Progreso, Yoro'),
    ('CRAED Siguatepeque', 'Siguatepeque, Comayagua'),
    ('CRAED Tegucigalpa', 'Tegucigalpa'),
    ('CRAED Tocoa', 'Tocoa, Colón'),
    ('Instituto Tecnológico Superior de Tela - UNAH', 'Tegucigalpa'),
    ('UNAH Tecnológico Danlí', 'Danlí, El Paraíso'),
    ('UNAH Telecentro Marcala', 'Marcala, La Paz'),
    ('UNAH Valle de Sula', 'San Pedro Sula, Cortés'),
    ('UNAH Tecnológico Aguan', 'Olanchito, Yoro'),
    ('Ciudad Universitaria', 'Tegucigalpa')
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

INSERT INTO AdmissionTest (description) VALUES 
    ('Prueba de Aptitud Académica'),
    ('Prueba de Conocimientos para Ciencias Naturales y de la Salud')
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

INSERT INTO `RegionalCenterDegree` (degree, regionalCenter) VALUES
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

INSERT INTO Employee (dni, firstName, secondName, firstLastName, secondLastName, telephoneNumber, personalEmail, password, address, dateOfBirth) VALUES 
    ('0801199901234', 'Juan', 'Carlos', 'Perez', 'Lopez', '9876543210', 'juan.perez@unah.edu.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle Principal #123', '1990-05-15'),
    ('0801199805678', 'Maria', 'Elena', 'Ramirez', 'Garcia', '9123456789', 'maria.ramirez@unah.edu.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Avenida Secundaria #456', '1988-10-20'),
    ('0801200101111', 'Pedro', 'Luis', 'Castillo', 'Martinez', '9876543211', 'pedro.castillo@example.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle Norte #789', '2001-03-10'),
    ('0801200202222', 'Ana', 'Maria', 'Lopez', 'Fernandez', '9123456788', 'ana.lopez@example.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Avenida Central #321', '2002-08-22'),
    ('0801200303333', 'Luis', 'Carlos', 'Hernandez', 'Diaz', '9876543212', 'luis.hernandez@example.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Boulevard Principal #555', '2003-12-01'),
    ('0801200404444', 'Sofia', 'Isabel', 'Gomez', 'Rodriguez', '9123456787', 'sofia.gomez@example.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia Primavera #678', '2004-05-14'),
    ('0801200505555', 'Carlos', 'Alberto', 'Martinez', 'Lopez', '9876543213', 'carlos.martinez@example.com', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial Los Pinos #890', '2005-09-25')
;

INSERT INTO Administrative (id, administrativeType) VALUES
    (1,1),
    (2,2)
;

INSERT INTO Department (description) VALUES ('Ingenieria en Sistemas');

INSERT INTO Professor(id, professorType, department) VALUES
    (3, 3, 1),
    (4, 4, 1)
;

DELIMITER //

/**
    author: dorian.contreras@unah.hn
    version: 0.1.0
    date: 5/11/24

    Procedimiento almacenado para hacer insert en la tabla Application manejando si ya existe o no un aplicante
**/
CREATE PROCEDURE insertApplicant(
    IN p_id VARCHAR(15),
    IN p_firstName VARCHAR(15),
    IN p_secondName VARCHAR(15),
    IN p_firstLastName VARCHAR(15),
    IN p_secondLastName VARCHAR(15),
    IN p_pathSchoolCertificate VARCHAR(30),
    IN p_telephoneNumber VARCHAR(12),
    IN p_personalEmail VARCHAR(30),
    IN p_firstDegreeProgramChoice SMALLINT,
    IN p_secondDegreeProgramChoice SMALLINT,
    IN p_regionalCenterChoice TINYINT
)
BEGIN
    -- Verificar si el ID ya existe
    IF EXISTS (SELECT 1 FROM Applicant WHERE id = p_id) THEN
        -- Si existe, solo se crea la aplicacion
        INSERT INTO Application (
            idApplicant,
            firstDegreeProgramChoice,
            secondDegreeProgramChoice,
            regionalCenterChoice
        ) VALUES (
            p_id,
            p_firstDegreeProgramChoice,
            p_secondDegreeProgramChoice,
            p_regionalCenterChoice
        );
    ELSE
        -- Si no existe, hacer la inserción
        INSERT INTO Applicant (
            id,
            firstName,
            secondName,
            firstLastName,
            secondLastName,
            pathSchoolCertificate,
            telephoneNumber,
            personalEmail
        ) VALUES (
            p_id,
            p_firstName,
            p_secondName,
            p_firstLastName,
            p_secondLastName,
            p_pathSchoolCertificate,
            p_telephoneNumber,
            p_personalEmail
        );

        -- Insertar en la tabla Application
        INSERT INTO Application (
            idApplicant,
            firstDegreeProgramChoice,
            secondDegreeProgramChoice,
            regionalCenterChoice
        ) VALUES (
            p_id,
            p_firstDegreeProgramChoice,
            p_secondDegreeProgramChoice,
            p_regionalCenterChoice
        );
    END IF;
END //

/**
    author: wilmer.morales@unah.hn
    version: 0.1.0
    date: 5/11/24

    Procedimiento almacenado para obtener las carreras que pertenecen a un centro regional
**/
CREATE PROCEDURE GetDegreeProgramsByRegionalCenter (IN regionalCenterId INT)
BEGIN
    SELECT `DegreeProgram`.id AS degreeProgramId
    FROM `RegionalCenterDegree`
    INNER JOIN `DegreeProgram`
    ON `RegionalCenterDegree`.degree = `DegreeProgram`.id
    INNER JOIN `RegionalCenter`
    ON `RegionalCenterDegree`.regionalCenter = `RegionalCenter`.id
    WHERE `RegionalCenter`.id = regionalCenterId;
END //

DELIMITER ;


