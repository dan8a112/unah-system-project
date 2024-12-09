
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
;

INSERT INTO DegreeProgram (description) VALUES 
    ('Derecho'),
    ('Antropología'),git
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
    ('0801199901234', 'Juan', 'Carlos', 'Perez', 'Lopez', '9876543210', 'juan.perez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle Principal #123', '1990-05-15'),
    ('0801199805678', 'Maria', 'Elena', 'Ramirez', 'Garcia', '9123456789', 'maria.ramirez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Avenida Secundaria #456', '1988-10-20')
    ('0801200101111', 'Pedro', 'Luis', 'Castillo', 'Martinez', '9876543211', 'pedro.castillo@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle Norte #789', '2001-03-10'),
    ('0801200202222', 'Ana', 'Maria', 'Lopez', 'Fernandez', '9123456788', 'ana.lopez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Avenida Central #321', '2002-08-22'),
    ('0801200303333', 'Luis', 'Carlos', 'Hernandez', 'Diaz', '9876543212', 'luis.hernandez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Boulevard Principal #555', '2003-12-01'),
    ('0801200404444', 'Sofia', 'Isabel', 'Gomez', 'Rodriguez', '9123456787', 'sofia.gomez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia Primavera #678', '2004-05-14'),
    ('0801200505555', 'Carlos', 'Alberto', 'Martinez', 'Lopez', '9876543213', 'carlos.martinez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial Los Pinos #890', '2005-09-25')
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

INSERT INTO AcademicProcess(description) VALUES 
    ('Inscripciones'),
    ('Revisión de examenes'),
    ('Envio de resultados'),
    ('Creación de expediente'),
    ('Planificación académica'),
    ('Matricula'),
    ('Ingreso de notas')
;

INSERT INTO AcademicEvent(process, startDate, finalDate) VALUES
    (1, '2024-11-11 00:00:00', '2024-11-12 00:00:00')
;

INSERT INTO Configuration(data) VALUES
    ('{"maxAttemtps":3}')
;

INSERT INTO Applicant (id, firstName, secondName, firstLastName, secondLastName, pathSchoolCertificate, telephoneNumber, personalEmail) VALUES
    ('0801-1990-01234', 'Juan', 'Carlos', 'Martínez', 'López', 'path1.pdf', '12345678', 'juan.carlos@gmail.com'),
    ('0802-1995-05678', 'María', 'Alejandra', 'Gómez', 'Cruz', 'path2.pdf', '87654321', 'maria.gomez@gmail.com'),
    ('0803-1993-04567', 'Carlos', 'Eduardo', 'Pérez', 'Mejía', 'path3.pdf', '12349876', 'carlos.perez@gmail.com'),
    ('0804-1992-02345', 'Ana', 'Lucía', 'Rodríguez', 'Hernández', 'path4.pdf', '56781234', 'ana.rodriguez@gmail.com'),
    ('0805-1994-08765', 'Luis', 'Fernando', 'Ramos', 'García', 'path5.pdf', '23456789', 'luis.ramos@gmail.com'),
    ('0806-1991-03456', 'Sofía', 'María', 'Flores', 'Martínez', 'path6.pdf', '34567891', 'sofia.flores@gmail.com'),
    ('0807-1997-09876', 'Miguel', 'Ángel', 'López', 'Ortega', 'path7.pdf', '45678912', 'miguel.lopez@gmail.com'),
    ('0808-1996-05674', 'Sara', 'Isabel', 'Castro', 'Padilla', 'path8.pdf', '56789123', 'sara.castro@gmail.com'),
    ('0809-1992-01234', 'Jorge', 'Manuel', 'Mendoza', 'Gutiérrez', 'path9.pdf', '67891234', 'jorge.mendoza@gmail.com'),
    ('0810-1995-02345', 'Lucía', 'Andrea', 'Reyes', 'Castillo', 'path10.pdf', '78912345', 'lucia.reyes@gmail.com'),
    ('0811-1991-04567', 'Daniel', 'Alberto', 'González', 'Díaz', 'path11.pdf', '89123456', 'daniel.gonzalez@gmail.com'),
    ('0812-1998-03456', 'Paola', 'Montserrat', 'Sánchez', 'Morales', 'path12.pdf', '91234567', 'paola.sanchez@gmail.com'),
    ('0813-1993-05678', 'Fernando', 'José', 'Ramírez', 'Velásquez', 'path13.pdf', '23451234', 'fernando.ramirez@gmail.com'),
    ('0814-1997-01234', 'Alejandro', 'Luis', 'Navarro', 'Acosta', 'path14.pdf', '34562345', 'alejandro.navarro@gmail.com'),
    ('0815-1995-08765', 'Mónica', 'Patricia', 'Campos', 'Ruiz', 'path15.pdf', '45673456', 'monica.campos@gmail.com'),
    ('0816-1992-03456', 'Andrea', 'Carolina', 'Álvarez', 'Montes', 'path16.pdf', '56784567', 'andrea.alvarez@gmail.com'),
    ('0817-1993-09876', 'Julio', 'César', 'Hernández', 'Espinoza', 'path17.pdf', '67895678', 'julio.hernandez@gmail.com'),
    ('0818-1996-05678', 'Francisco', 'José', 'Lara', 'González', 'path18.pdf', '78906789', 'francisco.lara@gmail.com'),
    ('0819-1995-02345', 'Sandra', 'Marcela', 'Velasco', 'Zelaya', 'path19.pdf', '89017890', 'sandra.velasco@gmail.com'),
    ('0820-1991-06789', 'Ricardo', 'Antonio', 'Moncada', 'Benítez', 'path20.pdf', '90128901', 'ricardo.moncada@gmail.com')
;

INSERT INTO Application (idApplicant, firstDegreeProgramChoice, secondDegreeProgramChoice, regionalCenterChoice, applicationDate) VALUES
    ('0801-1990-01234', 12, 1, 19, '2022-11-11 01:00:00'),
    ('0802-1995-05678', 4, 5, 17, '2022-11-11 01:00:00'),
    ('0803-1993-04567', 9, 8, 19, '2022-11-11 01:00:00'),
    ('0804-1992-02345', 38, 32, 4, '2022-11-11 01:00:00'),
    ('0805-1994-08765', 39, 32, 15, '2022-11-11 01:00:00'),
    ('0806-1991-03456', 34, 35, 19, '2022-11-11 01:00:00'),
    ('0807-1997-09876', 41, 42, 2, '2022-11-11 01:00:00'),
    ('0808-1996-05674', 14, 29, 15, '2022-11-11 01:00:00'),
    ('0809-1992-01234', 12, 1, 19, '2022-11-11 01:00:00'),
    ('0810-1995-02345', 25, 24, 19, '2022-11-11 01:00:00'),
    ('0811-1991-04567', 38, 32, 4, '2022-11-11 01:00:00'),
    ('0812-1998-03456', 14, 19, 1, '2022-11-11 01:00:00'),
    ('0813-1993-05678', 21, 20, 19, '2022-11-11 01:00:00'),
    ('0814-1997-01234', 14, 19, 1, '2022-11-11 01:00:00'),
    ('0815-1995-08765', 43, 19, 3, '2022-11-11 01:00:00'),
    ('0816-1992-03456', 45, 42, 2, '2023-11-11 01:00:00'),
    ('0817-1993-09876', 36, 35, 19, '2023-11-11 01:00:00'),
    ('0818-1996-05678', 38, 32, 4, '2023-11-11 01:00:00'),
    ('0819-1995-02345', 21, 20, 19, '2023-11-11 01:00:00'),
    ('0820-1991-06789', 14, 19, 1, '2023-11-11 01:00:00'),
    ('0805-1994-08765', 39, 32, 15, '2023-11-11 01:00:00'),
    ('0806-1991-03456', 34, 35, 19, '2023-11-11 01:00:00'),
    ('0807-1997-09876', 41, 42, 2, '2023-11-11 01:00:00'),
    ('0808-1996-05674', 14, 29, 15, '2023-11-11 01:00:00'),
    ('0809-1992-01234', 12, 1, 19, '2023-11-11 01:00:00')
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
    (25,1,1026)
;