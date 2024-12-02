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

CREATE TABLE Student(
    account VARCHAR(11) PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    DNI VARCHAR(13) NOT NULL,
    address VARCHAR(70) NOT NULL,
    email VARCHAR(60) NOT NULL,
    degreeProgram SMALLINT NOT NULL,
    regionalCenter TINYINT NOT NULL,
    globalAverage TINYINT,
    periodAverage TINYINT,
    photo1 LONGBLOB,
    photo2 LONGBLOB,
    photo3 LONGBLOB,
    password VARCHAR(80),
   CONSTRAINT fk_degreeProgram_student FOREIGN KEY (degreeProgram) REFERENCES DegreeProgram(id),
   CONSTRAINT fk_regionalCenter_student FOREIGN KEY (regionalCenter) REFERENCES RegionalCenter(id)
);

CREATE TABLE Subject(
    id VARCHAR(8) PRIMARY KEY,
    description VARCHAR(60),
    department SMALLINT,
    uv  SMALLINT, 
    CONSTRAINT fk_department_subject FOREIGN KEY(department) REFERENCES Department(id)
);

CREATE TABLE SubjectDegree(
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(8),
    degreeProgram SMALLINT,
    requirement VARCHAR(8),
    CONSTRAINT fk_degreeProgram_SubjectDegree FOREIGN KEY(degreeProgram) REFERENCES DegreeProgram(id),
    CONSTRAINT fk_SubjectDegree_Subject FOREIGN KEY(subject) REFERENCES Subject(id),
    CONSTRAINT fk_SubjectDegree_Subject2 FOREIGN KEY(requirement) REFERENCES Subject(id)
);

CREATE TABLE Building(
    id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(10),
    regionalCenter TINYINT,
    CONSTRAINT fk_Building_RegionalCenter FOREIGN KEY(regionalCenter) REFERENCES RegionalCenter(id)
);

CREATE TABLE Classroom(
    id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(20),
    building SMALLINT,
    CONSTRAINT fk_building_classroom FOREIGN KEY(building) REFERENCES Building(id)
);

CREATE TABLE Section(
    id INT PRIMARY KEY AUTO_INCREMENT,
    subject VARCHAR(8),
    professor INT,
    year INT,
    period INT,
    section INT,
    building SMALLINT,
    classroom SMALLINT,
    maximumCapacity TINYINT,
    CONSTRAINT fk_subject_section FOREIGN KEY(subject) REFERENCES Subject(id),
    CONSTRAINT fk_subject_professor FOREIGN KEY(professor) REFERENCES Professor(id),
    CONSTRAINT fk_building_section FOREIGN KEY(building) REFERENCES Building(id),
    CONSTRAINT fk_classroom_section FOREIGN KEY(classroom) REFERENCES Classroom(id));

CREATE TABLE Observation(
    id TINYINT PRIMARY KEY,
    observation VARCHAR(4)
);

CREATE TABLE StudentSection(
    id INT PRIMARY KEY AUTO_INCREMENT,
    studentAccount VARCHAR(11),
    section INT,
    grade TINYINT,
    observation TINYINT,
   CONSTRAINT fk_student_studentSection FOREIGN KEY(studentAccount) REFERENCES Student(account),
   CONSTRAINT fk_section_studentSection FOREIGN KEY(section) REFERENCES Section(id),
   CONSTRAINT fk_observation_studentSection FOREIGN KEY(observation) REFERENCES Observation(id));


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
    (4, '2024-11-27 00:00:00', '2024-11-30 00:00:00', false, 5),
    (5, '2024-12-01 00:00:00', '2024-12-09 00:00:00', false, 5),
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
