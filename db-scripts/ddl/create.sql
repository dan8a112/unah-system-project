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
    description VARCHAR(30) NOT NULL
    
);

CREATE TABLE DegreeProgram(
	id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR (50) NOT NULL
);

CREATE TABLE AdmissionDegree(
	id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR (30) NOT NULL,
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
    password VARCHAR (30) NOT NULL,
    address VARCHAR(30) NOT NULL,
    dateOfBirth DATE
);

CREATE TABLE ProfessorType(
	id TINYINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(20)
);

CREATE TABLE Department(
	id SMALLINT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(20)
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
    ('Ciudad Universitaria (CU)','Tegucigalpa, Francisco Morazán'),
    ('Centro Universitario Regional del Norte (CURN)','San Pedro Sula, Cortés'),
    ('Centro Universitario Regional del Litoral Atlántico (CURLA)','La Ceiba, Atlántida'),
    ('Centro Universitario Regional del Litoral Pacífico (CURLP)','Choluteca, Choluteca'),
    ('Centro Universitario Regional del Centro (CURC)','Comayagua, Comayagua'),
    ('Centro Universitario Regional de Occidente (CUROC)','Santa Rosa de Copán, Copán'),
    ('Centro Tecnológico Universitario de Danlí (CTU)','Danlí, El Paraíso'),
    ('Centro Universitario Regional de Olancho (CURO)','Juticalpa, Olancho')
;
INSERT INTO AdministrativeType(description) VALUES
    ('SEDP'),
    ('Admisiones'),
    ('DIPP')
;

INSERT INTO DegreeProgram(description) VALUES
    ('Licenciatura en Administración de Empresas'),
    ('Licenciatura en Contaduría Pública'),
    ('Licenciatura en Mercadotecnia'),
    ('Licenciatura en Recursos Humanos'),
    ('Licenciatura en Economía'),
    ('Licenciatura en Desarrollo Internacional'),
    ('Licenciatura en Sociología'),
    ('Licenciatura en Trabajo Social'),
    ('Licenciatura en Psicología'),
    ('Licenciatura en Comunicación Social'),
    ('Licenciatura en Ciencias Jurídicas'),
    ('Licenciatura en Notariado y Registro'),
    ('Licenciatura en Ingeniería Civil'),
    ('Licenciatura en Ingeniería Industrial'),
    ('Licenciatura en Ingeniería en Sistemas'),
    ('Licenciatura en Ingeniería Electrónica'),
    ('Licenciatura en Ingeniería Agronómica'),
    ('Licenciatura en Medicina'),
    ('Licenciatura en Enfermería'),
    ('Licenciatura en Odontología'),
    ('Licenciatura en Nutrición'),
    ('Licenciatura en Farmacia'),
    ('Licenciatura en Biología'),
    ('Licenciatura en Química'),
    ('Licenciatura en Física'),
    ('Licenciatura en Matemáticas'),
    ('Licenciatura en Tecnología de Alimentos'),
    ('Licenciatura en Artes Plásticas'),
    ('Licenciatura en Música'),
    ('Licenciatura en Danza'),
    ('Licenciatura en Teología'),
    ('Licenciatura en Educación Teológica'),
    ('Licenciatura en Agronomía'),
    ('Licenciatura en Zootecnia'),
    ('Licenciatura en Medicina Veterinaria'),
    ('Licenciatura en Educación Primaria'),
    ('Licenciatura en Educación Secundaria'),
    ('Licenciatura en Psicopedagogía'),
    ('Licenciatura en Enseñanza de Inglés'),
    ('Licenciatura en Traducción e Interpretación'),
    ('Licenciatura en Periodismo'),
    ('Licenciatura en Publicidad y Relaciones Públicas'),
    ('Licenciatura en Filosofía'),
    ('Licenciatura en Literatura')
;

INSERT INTO ProfessorType(description) VALUES
    ('Docente'),
    ('Coordinador'),
    ('Jefe de departamento')
;