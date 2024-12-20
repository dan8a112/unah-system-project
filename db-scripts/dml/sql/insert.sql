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
    ('Admisiones'),
    ('DIPP')
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
    ('0801-2005-05555', 'Carlos Alberto', 'Martinez Lopez', '98765432', 'carlos.martinez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial Los Pinos #890', '2005-09-25'),
    ('0801-2006-06666', 'Andrea Carolina', 'Reyes Mejia', '98887766', 'andrea.reyes@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia Palmira #123', '2006-02-18'),
    ('0801-2007-07777', 'Fernando Javier', 'Ortiz Gonzalez', '93334455', 'fernando.ortiz@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Barrio El Centro #456', '2007-07-29'),
    ('0801-2008-08888', 'Valeria Susana', 'Castro Romero', '94445566', 'valeria.castro@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Urbanización Las Lomas #789', '2008-11-12'),
    ('0801-2009-09999', 'Diego Alejandro', 'Mejia Cruz', '95556677', 'diego.mejia@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial San Ángel #321', '2009-03-05'),
    ('0801-2010-10001', 'Isabella Sofia', 'Morales Jimenez', '96667788', 'isabella.morales@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia El Prado #654', '2010-08-22'),
    ('0801-2011-11001', 'Sebastian Daniel', 'Hernandez Torres', '97778899', 'sebastian.hernandez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Urbanización El Bosque #987', '2011-01-14'),
    ('0801-2012-12001', 'Camila Andrea', 'Lopez Martinez', '98889900', 'camila.lopez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia Santa Clara #123', '2012-04-03'),
    ('0801-2013-13001', 'Mateo Antonio', 'Perez Gutierrez', '91112233', 'mateo.perez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial Altamira #456', '2013-06-18'),
    ('0801-2014-14001', 'Emma Victoria', 'Garcia Ruiz', '92223344', 'emma.garcia@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia Los Almendros #789', '2014-09-25'),
    ('0801-2015-15001', 'Lucas Gabriel', 'Ramirez Silva', '93334455', 'lucas.ramirez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Barrio Las Flores #321', '2015-12-10'),
    ('0801-1985-16001', 'Valentina Carolina', 'Vasquez Pineda', '93445566', 'valentina.vasquez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia El Mirador #654', '1985-02-19'),
    ('0801-1986-17001', 'Felipe Andres', 'Morales Lopez', '94556677', 'felipe.morales@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle Luna #987', '1986-04-03'),
    ('0801-1987-18001', 'Lina Gabriela', 'Alvarado Castro', '95667788', 'lina.alvarado@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial Vista Bella #321', '1987-05-14'),
    ('0801-1988-19001', 'Oscar Leonardo', 'Vega Mejia', '96778899', 'oscar.vega@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle Roble #456', '1988-07-27'),
    ('0801-1989-20001', 'Natalia Isabel', 'Mendoza Ruiz', '97889900', 'natalia.mendoza@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia Los Pinos #123', '1989-08-16'),
    ('0801-1990-21001', 'Raul Eduardo', 'Herrera Soto', '98990011', 'raul.herrera@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Avenida Sol #654', '1990-11-05'),
    ('0801-1991-22001', 'Martina Isabel', 'Castro Torres', '90001122', 'martina.castro@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial Bella Vista #321', '1991-02-08'),
    ('0801-1992-23001', 'Sergio Ramon', 'Martinez Velasquez', '91112233', 'sergio.martinez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia La Paz #789', '1992-03-22'),
    ('0801-1993-24001', 'Marcos Elias', 'Diaz Morales', '92223344', 'marcos.diaz@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Avenida Hidalgo #321', '1993-04-30'),
    ('0801-1994-25001', 'Patricia Valeria', 'Sanchez Castro', '93334455', 'patricia.sanchez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle San Jose #123', '1994-07-12'),
    ('0801-1995-26001', 'Carlos Enrique', 'Ramirez Cruz', '94445566', 'carlos.ramirez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial Los Robles #456', '1995-08-20'),
    ('0801-1996-27001', 'Diana Carolina', 'Morales Rivera', '95556677', 'diana.morales@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Colonia La Esperanza #789', '1996-01-03'),
    ('0801-1997-28001', 'Manuel Alfonso', 'Gonzalez Rios', '96667788', 'manuel.gonzalez@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Avenida Independencia #123', '1997-02-17'),
    ('0801-1998-29001', 'Elena Patricia', 'Vega Gutierrez', '97778899', 'elena.vega@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Calle El Sol #654', '1998-05-14'),
    ('0801-1999-30001', 'Javier Esteban', 'Fuentes Martínez', '98880011', 'javier.fuentes@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Residencial Las Colinas #321', '1999-09-19'),
    ('0801-2000-31001', 'Gabriela Alejandra', 'Navarro Castillo', '97776655', 'gabriela.navarro@unah.edu.hn', '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.', 'Urbanización El Retiro #987', '2000-03-28');


INSERT INTO Administrative (id, administrativeType) VALUES
    (1,1),
    (2,2),
    (9,2),
    (10,1),
    (32,3),
    (33,3)
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

INSERT INTO AcademicProcess(description) VALUES 
    ('Proceso de Admisiones'),
    ('Proceso'),
    ('Inscripciones'),
    ('Revisión de inscripciones'),
    ('Subir calificaciones'),
    ('Envio de resultados'),
    ('Creación de expediente'),
    ("I PAC"),
    ("II PAC"),
    ("III PAC"),
    ('Planificación académica'),
    ('Prematrícula'),
    ('Matrícula'),
    ('Inicio de clases'),
    ('Adiciones y cancelaciones'),
    ('Cancelación excepcional'),
    ('Ingreso de notas y evaluaciones de docentes')
;

INSERT INTO AcademicEvent (process, startDate, finalDate, active, parentId) VALUES
    (8, '2015-01-15 00:00:00', '2015-05-31 00:00:00', 0, NULL),
    (9, '2015-06-12 00:00:00', '2015-09-20 00:00:00', 0, NULL),
    (10, '2015-09-25 00:00:00', '2015-12-20 00:00:00', 0, NULL),
    (8, '2016-01-15 00:00:00', '2016-05-31 00:00:00', 0, NULL),
    (9, '2016-06-12 00:00:00', '2016-09-20 00:00:00', 0, NULL),
    (10, '2016-09-25 00:00:00', '2016-12-20 00:00:00', 0, NULL),
    (8, '2017-01-15 00:00:00', '2017-05-31 00:00:00', 0, NULL),
    (9, '2017-06-12 00:00:00', '2017-09-20 00:00:00', 0, NULL),
    (10, '2017-09-25 00:00:00', '2017-12-20 00:00:00', 0, NULL),
    (8, '2018-01-15 00:00:00', '2018-05-31 00:00:00', 0, NULL),
    (9, '2018-06-12 00:00:00', '2018-09-20 00:00:00', 0, NULL),
    (10, '2018-09-25 00:00:00', '2018-12-20 00:00:00', 0, NULL),
    (8, '2019-01-15 00:00:00', '2019-05-31 00:00:00', 0, NULL),
    (9, '2019-06-12 00:00:00', '2019-09-20 00:00:00', 0, NULL),
    (10, '2019-09-25 00:00:00', '2019-12-20 00:00:00', 0, NULL),
    (8, '2020-01-15 00:00:00', '2020-05-31 00:00:00', 0, NULL),
    (9, '2020-06-12 00:00:00', '2020-09-20 00:00:00', 0, NULL),
    (10, '2020-09-25 00:00:00', '2020-12-20 00:00:00', 0, NULL),
    (8, '2021-01-15 00:00:00', '2021-05-31 00:00:00', 0, NULL),
    (9, '2021-06-12 00:00:00', '2021-09-20 00:00:00', 0, NULL),
    (10, '2021-09-25 00:00:00', '2021-12-20 00:00:00', 0, NULL),
    (8, '2022-01-15 00:00:00', '2022-05-31 00:00:00', 0, NULL),
    (9, '2022-06-12 00:00:00', '2022-09-20 00:00:00', 0, NULL),
    (10, '2022-09-25 00:00:00', '2022-12-20 00:00:00', 0, NULL),
    (8, '2023-01-15 00:00:00', '2023-05-31 00:00:00', 0, NULL),
    (9, '2023-06-12 00:00:00', '2023-09-20 00:00:00', 0, NULL),
    (10, '2023-09-25 00:00:00', '2023-12-20 00:00:00', 0, NULL),
    (1, '2024-11-23 00:00:00', '2024-12-20 00:00:00', 1, NULL),
    (3, '2024-11-23 00:00:00', '2024-11-25 00:00:00', 1, 28),
    (4, '2024-12-10 00:00:00', '2024-12-13 00:00:00', 0, 28),
    (5, '2024-12-08 00:00:00', '2024-12-09 00:00:00', 0, 28),
    (6, '2024-12-09 00:00:00', '2024-12-11 00:00:00', 0, 28),
    (7, '2024-12-11 00:00:00', '2024-12-20 00:00:00', 0, 28),
    (8, '2024-01-15 00:00:00', '2024-05-31 00:00:00', 0, NULL),
    (9, '2024-06-12 00:00:00', '2024-09-20 00:00:00', 0, NULL),
    (10, '2024-09-25 00:00:00', '2024-12-20 00:00:00', 1, NULL),
    (11, '2024-09-25 00:00:00', '2024-09-30 00:00:00', 1, 36),
    (12, '2024-09-30 00:00:00', '2024-10-05 00:00:00', 0, 36),
    (13, '2024-10-10 00:00:00', '2024-10-11 00:00:00', 0, 36),
    (14, '2024-10-15 00:00:00', '2024-12-10 00:00:00', 0, 36),
    (15, '2024-10-15 00:00:00', '2024-10-27 00:00:00', 0, 36),
    (16, '2024-11-27 00:00:00', '2024-12-03 00:00:00', 0, 36),
    (17, '2024-12-03 00:00:00', '2024-12-10 00:00:00', 0, 36),
    (1,'2022-01-13 00:00:00', '2022-01-12 00:00:00', false, NULL),
    (1,'2022-05-20 00:00:00', '2022-06-12 00:00:00', false, NULL),
    (1,'2023-01-20 00:00:00', '2023-02-12 00:00:00', false, NULL),
    (1,'2023-08-20 00:00:00', '2023-09-12 00:00:00', false, NULL)
;


INSERT INTO Configuration (data) VALUES ('{"maxAttemtps":2}');

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
    ('0801-1990-01234', 12, 1, 19, '2022-01-14 01:00:00', 45, true, false, true, 4),
    ('0802-1995-05678', 4, 5, 17, '2022-01-14 01:00:00', 45, false, false, false, 3),
    ('0803-1993-04567', 9, 8, 19, '2022-01-14 01:00:00', 45, false, true, true, 1),
    ('0804-1992-02345', 38, 32, 4, '2022-01-14 01:00:00', 45, true, true, true, 2),
    ('0805-1994-08765', 39, 32, 15, '2022-01-14 01:00:00', 45, false, false, false, 5),
    ('0806-1991-03456', 34, 35, 19, '2022-01-14 01:00:00', 45, false, true, true, 1),
    ('0807-1997-09876', 41, 42, 2, '2022-01-14 01:00:00', 45, true, true, true, 2),
    ('0808-1996-05674', 14, 29, 15, '2022-01-14 01:00:00', 45, true, false, true, 3),
    ('0809-1992-01234', 12, 1, 19, '2022-01-14 01:00:00', 45, false, true, true, 4),
    ('0810-1995-02345', 25, 24, 19, '2022-01-14 01:00:00', 45, true, false, true, 5),
    ('0811-1991-04567', 38, 32, 4, '2022-01-14 01:00:00', 45, false,false, true, 1),
    ('0812-1998-03456', 14, 19, 1, '2022-01-14 01:00:00', 45, true, true, true, 2),
    ('0813-1993-05678', 21, 20, 19, '2022-01-14 01:00:00', 45, false, true, true, 3),
    ('0814-1997-01234', 14, 19, 1, '2022-01-14 01:00:00', 45, true, true, true, 4),
    ('0815-1995-08765', 43, 19, 3, '2022-01-14 01:00:00', 45, false, false, false, 5),
    ('0816-1992-03456', 45, 42, 2, '2023-08-21 01:00:00', 46, true, false, true, 1),
    ('0817-1993-09876', 36, 35, 19, '2023-08-21 01:00:00', 46, false, true, true, 2),
    ('0818-1996-05678', 38, 32, 4, '2023-08-21 01:00:00', 46, false, false, false, 3),
    ('0819-1995-02345', 21, 20, 19, '2023-08-21 01:00:00', 46, true, true, true, 4),
    ('0820-1991-06789', 14, 19, 1, '2023-08-21 01:00:00', 46, true, true, true, 5),
    ('0805-1994-08765', 39, 32, 15, '2023-08-21 01:00:00', 46, true, true, true, 2),
    ('0806-1991-03456', 34, 35, 19, '2023-08-21 01:00:00', 46, false, true, true, 1),
    ('0807-1997-09876', 41, 42, 2, '2023-08-21 01:00:00', 46, true, false, true, 3),
    ('0808-1996-05674', 14, 29, 15, '2023-08-21 01:00:00', 46, false, false, false, 4),
    ('0809-1992-01234', 12, 1, 19, '2023-08-21 01:00:00', 46, true, true, true, 5),
    ('0801-1990-01234', 12, 1, 19, '2022-01-14 01:00:00', 46, true, false, true, 4),
    ('0801-1990-01234', 12, 1, 19, '2022-01-14 01:00:00', 47, true, false, true, 1),
    ('0802-1995-05678', 4, 5, 17, '2022-01-14 01:00:00', 47, true, true, true, 2),
    ('0803-1993-04567', 9, 8, 19, '2022-01-14 01:00:00', 47, false, true, true, 3),
    ('0804-1992-02345', 38, 32, 4, '2022-01-14 01:00:00', 47, false, false, false, 4),
    ('0805-1994-08765', 39, 32, 15, '2022-01-14 01:00:00', 47, false, false, false, 5),
    ('0806-1991-03456', 34, 35, 19, '2022-01-14 01:00:00', 47, false, true, true, 1),
    ('0807-1997-09876', 41, 42, 2, '2022-01-14 01:00:00', 47, true, true, true, 2),
    ('0808-1996-05674', 14, 29, 15, '2022-01-14 01:00:00', 44, true, false, true, 3),
    ('0809-1992-01234', 12, 1, 19, '2022-01-14 01:00:00', 44, false, true, true, 4),
    ('0810-1995-02345', 25, 24, 19, '2022-01-14 01:00:00', 44, false, false, false, 5),
    ('0811-1991-04567', 38, 32, 4, '2022-01-14 01:00:00', 44, false,false, false, 1),
    ('0812-1998-03456', 14, 19, 1, '2022-01-14 01:00:00', 44, true, true, true, 2),
    ('0813-1993-05678', 21, 20, 19, '2022-01-14 01:00:00', 44, false, false, false, 3),
    ('0814-1997-01234', 14, 19, 1, '2022-01-14 01:00:00', 44, true, true, true, 4),
    ('0815-1995-08765', 43, 19, 3, '2022-01-14 01:00:00', 44, false, true, true, 5),
    ('0816-1992-03456', 45, 42, 2, '2023-08-21 01:00:00', 44, true, false, true, 1),
    ('0817-1993-09876', 36, 35, 19, '2023-08-21 01:00:00', 44, false, true, true, 2),
    ('0818-1996-05678', 38, 32, 4, '2023-08-21 01:00:00', 44, true, true, true, 3),
    ('0819-1995-02345', 21, 20, 19, '2023-08-21 01:00:00', 44, true, true, true, 4),
    ('0820-1991-06789', 14, 19, 1, '2023-08-21 01:00:00', 44, true, true, false, 5)
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

INSERT INTO Department (description) VALUES ('Economía');
INSERT INTO Department (description) VALUES ('Administración de Empresas');
INSERT INTO Department (description) VALUES ('Contaduría Pública y Finanzas');
INSERT INTO Department (description) VALUES ('Informática Administrativa');
INSERT INTO Department (description) VALUES ('Comercio Internacional');
INSERT INTO Department (description) VALUES ('Administración Aduanera');
INSERT INTO Department (description) VALUES ('Admon. Banca y Finanzas');
INSERT INTO Department (description) VALUES ('Mercadotecnia');
INSERT INTO Department (description) VALUES ('Métodos Cuantitativos');
INSERT INTO Department (description) VALUES ('Administración Pública');
INSERT INTO Department (description) VALUES ('Control Químico Farmacéutico');
INSERT INTO Department (description) VALUES ('Química');
INSERT INTO Department (description) VALUES ('Tecnología Farmacéutica');
INSERT INTO Department (description) VALUES ('Astronomía y Astrofísica');
INSERT INTO Department (description) VALUES ('Ciencia y Tecnologías de la Información Geográfica');
INSERT INTO Department (description) VALUES ('Arqueoastronomía y Astronomía Cultural');
INSERT INTO Department (description) VALUES ('Ciencias Aeronáuticas');
INSERT INTO Department (description) VALUES ('Psicología');
INSERT INTO Department (description) VALUES ('Historia');
INSERT INTO Department (description) VALUES ('Sociología');
INSERT INTO Department (description) VALUES ('Periodismo');
INSERT INTO Department (description) VALUES ('Trabajo Social');
INSERT INTO Department (description) VALUES ('Ciencias Políticas');
INSERT INTO Department (description) VALUES ('Antropología');
INSERT INTO Department (description) VALUES ('Arquitectura');
INSERT INTO Department (description) VALUES ('Arte');
INSERT INTO Department (description) VALUES ('Ciencias de la Cultura Física y Deportes');
INSERT INTO Department (description) VALUES ('Filosofía');
INSERT INTO Department (description) VALUES ('Lenguas Extranjeras');
INSERT INTO Department (description) VALUES ('Letras');
INSERT INTO Department (description) VALUES ('Pedagogía y Ciencias de la Educación');
INSERT INTO Department (description) VALUES ('Prótesis Bucal y Maxilofacial');
INSERT INTO Department (description) VALUES ('Odontología Preventiva y Social');
INSERT INTO Department (description) VALUES ('Odontología Restauradora');
INSERT INTO Department (description) VALUES ('Estomatología');
INSERT INTO Department (description) VALUES ('Ingeniería Eléctrica');
INSERT INTO Department (description) VALUES ('Ingeniería Química');
INSERT INTO Department (description) VALUES ('Ingeniería Mecánica');
INSERT INTO Department (description) VALUES ('Ingeniería Civil');
INSERT INTO Department (description) VALUES ('Ingeniería en Sistemas');
INSERT INTO Department (description) VALUES ('Ingeniería Industrial');
INSERT INTO Department (description) VALUES ('Biología');
INSERT INTO Department (description) VALUES ('Ecología y Recursos Naturales');
INSERT INTO Department (description) VALUES ('Biología Celular y Genética');
INSERT INTO Department (description) VALUES ('Física de la Tierra');
INSERT INTO Department (description) VALUES ('Materia Condensada');
INSERT INTO Department (description) VALUES ('Gravitación, Altas Energías y Radiaciones');
INSERT INTO Department (description) VALUES ('Estadística');
INSERT INTO Department (description) VALUES ('Matemática Aplicada');
INSERT INTO Department (description) VALUES ('Matemática Pura');
INSERT INTO Department (description) VALUES ('Bioanálisis e Inmunología');
INSERT INTO Department (description) VALUES ('Parasitología');

INSERT INTO Professor(id, professorType, department, active, changePassword) VALUES
    (3, 3, 1, true, false),
    (4, 4, 1, true, false),
    (5, 1, 1, true, false),
    (6, 2, 1, true, false),
    (7, 3, 88, true, false),
    (8, 4, 88, true, false),
    (9, 3, 87, true, false),
    (10, 4, 86, true, false),
    (11, 1, 63, true, false),
    (12, 2, 1, true, false),
    (13, 3, 1, true, false),
    (14, 4, 84, true, false),
    (15, 1, 57, true, false),
    (16, 2, 67, true, false),
    (17, 3, 88, true, false),
    (18, 4, 58, true, false),
    (19, 1, 1, true, false),
    (20, 4, 67, true, false),
    (21, 1, 81, true, false),
    (22, 2, 68, true, false),
    (23, 3, 66, true, false),
    (24, 4, 65, true, false),
    (25, 1, 1, true, false),
    (26, 4, 1, true, false),
    (27, 1, 1, true, false),
    (28, 4, 1, true, false),
    (29, 3, 1, true, false),
    (30, 4, 1, true, false),
    (31, 4, 1, true, false);


INSERT INTO Subject(id, description, department, uv) VALUES('MM110', 'MATEMATICA I', 88, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('MM111', 'GEOMETRIA Y TRIGONOMETRIA', 88, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('MM211', 'VECTORES Y MATRICES', 88, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('MM201', 'CALCULO I', 88, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('MM420', 'MATEMATICA DISCRETA', 88, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('MM202', 'CALCULO II', 88, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('MM411', 'ECUACIONES DIFERENCIALES', 88, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('MM314', 'PROGRAMACION I', 87, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('FS100', 'FISICA GENERAL I', 84, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('FS200', 'FISICA GENERAL II', 84, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('RR100', 'JUEGOS ORGANIZADOS', 65, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IN101', 'INGLES I', 67, 4);

INSERT INTO Subject(id, description, department, uv) VALUES('IN102', 'INGLES II', 67, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IN103', 'INGLES III', 67, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('EG011', 'ESPAÑOL GENERAL', 68, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('FF101', 'FILOSOFIA', 66, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('MM401', 'ESTADISTICA I', 86, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('DQ101', 'DIBUJO I', 63, 2);
INSERT INTO Subject(id, description, department, uv) VALUES('DQ102', 'DIBUJO II', 63, 2);
INSERT INTO Subject(id, description, department, uv) VALUES('HH101', 'HISTORIA DE HONDURAS', 57, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('EO025', 'REDACCION GENERAL', 68, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS110', 'INTRO. A LA INGENIERIA EN SISTEMAS', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS210', 'PROGRAMACION II', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS311', 'CIRCUITOS ELECTRICOS PARA IS', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS310', 'ALGORITMOS Y ESTRUCTURA DE DATOS', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS410', 'PROGRAMACION ORIENTADA A OBJETOS', 1, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('IS411', 'ELECTRONICA PARA IS', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS501', 'BASE DE DATOS I', 1, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('IS510', 'INSTALACIONES ELECTRICAS PARA IS', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS412', 'SISTEMAS OPERATIVOS I', 1, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('IS511', 'REDES DE DATOS', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS512', 'SISTEMAS OPERATIVOS II', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS601', 'BASE DE DATOS II', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS603', 'ARQUITECTURA DE COMPUTADORES', 1, 4);

INSERT INTO Subject(id, description, department, uv) VALUES('IS513', 'LENGUAJES DE PROGRAMACION', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS611', 'REDES DE DATOS II', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS711', 'DISEÑO DIGITAL', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS602', 'SISTEMA DE INFORMACION', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS811', 'SEGURIDAD INFORMATICA', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS720', 'ADMINISTRACION', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS702', 'ANALISIS Y DISEÑO DE SISTEMAS', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS721', 'CONTABILIDAD', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS903', 'AUDITORIA INFORMATICA', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS701', 'INTELIGENCIA ARTIFICIAL', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS802', 'INGENIERIA DEL SOFTWARE', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS820', 'FINANZAS ADMINISTRATIVAS', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS902', 'INDUSTRIA DEL SOFTWARE', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS904', 'GERENCIA INFORMATICA', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS906', 'TOPICOS ESPECIALES Y AVANZADOS', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS905', 'ECONOMIA DIGITAL', 1, 5);
INSERT INTO Subject(id, description, department, uv) VALUES('IS115', 'SEMINARIO DE INVESTIGACION', 1, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('IS910', 'TEORIA DE LA SIMULACION', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS911', 'MICROPROCESADORES', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS914', 'LIDERAZGO PARA EL CAMBIO INFORMATICO', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS912', 'SISTEMAS EXPERTOS', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('IS913', 'DISEÑO DE COMPILADORES', 1, 3);
INSERT INTO Subject(id, description, department, uv) VALUES('SC101', 'SOCIOLOGIA', 58, 4);
INSERT INTO Subject(id, description, department, uv) VALUES('BL130', 'EDUCACION AMBIENTAL OPTATIVA', 81, 4);

INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM110', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM111', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS110', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('SC101', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM211', 19, 'MM110');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IN101', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM201', 19, 'MM110');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM201', 19, 'MM111');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('RR100', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM202', 19, 'MM201');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IN102', 19, 'IN101');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM314', 19, 'MM110');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM314', 19, 'IS110');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('EG011', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('FS100', 19, 'MM201');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('FS100', 19, 'MM211');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM411', 19, 'MM202');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS210', 19, 'MM314');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('FF101', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IN103', 19, 'IN102');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('DQ101', 19, 'MM211');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('FS200', 19, 'FS100');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS311', 19, 'MM411');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS311', 19, 'FS100');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM420', 19, 'MM314');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM420', 19, 'FF101');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('DQ102', 19, 'DQ101');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('MM401', 19, 'MM202');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS310', 19, 'IS210');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS410', 19, 'IS310');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS411', 19, 'IS311');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS412', 19, 'IS310');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS412', 19, 'MM420');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('BL130', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS501', 19, 'MM401');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS501', 19, 'IS410');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('HH101', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS510', 19, 'IS311');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS511', 19, 'IS411');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS512', 19, 'IS412');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS601', 19, 'IS501');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS603', 19, 'IS511');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS513', 19, 'IS410');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS611', 19, 'IS511');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS711', 19, 'IS603');

INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS602', 19, 'IS513');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('EO025', 19, NULL);
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS811', 19, 'IS711');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS811', 19, 'IS512');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS720', 19, 'MM420');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS702', 19, 'IS602');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS910', 19, 'IS904');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS914', 19, 'IS820');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS912', 19, 'IS701');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS911', 19, 'IS603');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS914', 19, 'IS820');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS912', 19, 'IS701');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS913', 19, 'IS603');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS721', 19, 'IS720');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS903', 19, 'IS811');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS701', 19, 'IS601');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS701', 19, 'IS602');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS802', 19, 'IS702');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS811', 19, 'IS711');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS820', 19, 'IS721');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS902', 19, 'IS802');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS904', 19, 'IS811');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS906', 19, 'IS904');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS905', 19, 'IS820');
INSERT INTO SubjectDegree(subject, degreeProgram, requirement) VALUES ('IS115', 19, 'IS906');

INSERT INTO Building (description, regionalCenter) VALUES
    ('A1', 19),
    ('A2', 19),
    ('B1', 19),
    ('B2', 19),
    ('C1', 19),
    ('Anexo C1', 19),
    ('C2', 19),
    ('C3', 19),
    ('D1', 19),
    ('E1', 19),
    ('F1', 19),
    ('G1', 19),
    ('H1', 19),
    ('I1', 19),
    ('J1', 19),
    ('K1', 19),
    ('K2', 19),
    ('1847', 19),
    ('PUD', 19)
;

INSERT INTO Classroom (description, building) values
    (101, 2), 
    (102, 2), 
    (103, 2), 
    (104, 2), 
    (105, 2), 
    (201, 2), 
    (202, 2), 
    (301, 2), 
    (302, 2), 
    (303, 2), 
    (304, 2), 
    (305, 2), 
    (306, 2), 
    (401, 2), 
    (402, 2), 
    (403, 2), 
    (404, 2), 
    (405, 2), 
    (406, 2), 
    (407, 2), 
    (201, 3), 
    (202, 3), 
    (203, 3), 
    (204, 3), 
    (205, 3),
    (201, 4), 
    (202, 4), 
    (203, 4), 
    (301, 4), 
    (302, 4), 
    (303, 4), 
    (304, 4), 
    (305, 4), 
    (306, 4), 
    (307, 4), 
    (308, 4), 
    (309, 4), 
    (310, 4), 
    (311, 4), 
    (312, 4), 
    (313, 4), 
    (401, 4), 
    (402, 4), 
    (403, 4), 
    (404, 4), 
    (405, 4), 
    (406, 4), 
    (407, 4), 
    (101, 5), 
    (102, 5), 
    (103, 5), 
    (104, 5), 
    (105, 5), 
    (106, 5), 
    (107, 5), 
    (201, 5), 
    (202, 5), 
    (203, 5), 
    (204, 5), 
    (205, 5), 
    (301, 5), 
    (302, 5), 
    (303, 5), 
    (304, 5), 
    (305, 5), 
    (306, 5), 
    (307, 5), 
    (501, 5), 
    (502, 5), 
    (503, 5), 
    (504, 5), 
    (505, 5), 
    (506, 5), 
    (507, 5), 
    (508, 5), 
    (101, 6), 
    (102, 6), 
    (103, 6), 
    (104, 6), 
    (201, 6), 
    (202, 6), 
    (203, 6), 
    (204, 6), 
    (301, 6), 
    (302, 6), 
    (303, 6), 
    (304, 6), 
    (401, 6), 
    (402, 6), 
    (403, 6), 
    (404, 6), 
    (101, 7), 
    (102, 7), 
    (103, 7), 
    (201, 7), 
    (202, 7), 
    (203, 7), 
    (204, 7), 
    (205, 7), 
    (206, 7), 
    (207, 7), 
    (208, 7), 
    (209, 7), 
    (210, 7), 
    (211, 7), 
    (212, 7), 
    (213, 7), 
    (214, 7), 
    (301, 7), 
    (302, 7), 
    (303, 7), 
    (304, 7), 
    (305, 7), 
    (306, 7), 
    (307, 7), 
    (401, 7), 
    (402, 7), 
    (403, 7), 
    (404, 7), 
    (405, 7), 
    (406, 7), 
    (407, 7), 
    (101, 8), 
    (102, 8), 
    (103, 8), 
    (104, 8), 
    (105, 8), 
    (106, 8), 
    (107, 8), 
    (108, 8), 
    (109, 8), 
    (110, 8), 
    (111, 8), 
    (112, 8), 
    (113, 8), 
    (114, 8), 
    (115, 8), 
    (116, 8), 
    (117, 8), 
    (118, 8), 
    (119, 8), 
    (120, 8), 
    (301, 8), 
    (302, 8), 
    (303, 8), 
    (304, 8), 
    (305, 8), 
    (306, 8), 
    (307, 8), 
    (308, 8), 
    (309, 8), 
    (310, 8), 
    (311, 8), 
    (312, 8), 
    (313, 8), 
    (401, 8), 
    (402, 8), 
    (403, 8), 
    (404, 8), 
    (501, 8), 
    (502, 8), 
    (101, 9), 
    (102, 9), 
    (103, 9), 
    (104, 9), 
    (105, 9), 
    (106, 9), 
    (107, 9), 
    (108, 9), 
    (109, 9), 
    (110, 9), 
    (111, 9), 
    (112, 9), 
    (113, 9), 
    (201, 9), 
    (202, 9), 
    (203, 9), 
    (204, 9), 
    (205, 9), 
    (301, 9), 
    (302, 9), 
    (303, 9), 
    (304, 9), 
    (305, 9), 
    (306, 9), 
    (307, 9), 
    (401, 9), 
    (402, 9), 
    (403, 9), 
    (404, 9), 
    (405, 9), 
    (406, 9), 
    (407, 9), 
    (101, 10), 
    (102, 10), 
    (201, 10), 
    (202, 10), 
    (203, 10), 
    (301, 10), 
    (302, 10), 
    (101, 11), 
    (102, 11), 
    (103, 11), 
    (104, 11), 
    (105, 11), 
    (106, 11), 
    (107, 11), 
    (108, 11), 
    (109, 11), 
    (201, 11), 
    (202, 11), 
    (301, 11), 
    (302, 11), 
    (303, 11), 
    (304, 11), 
    (305, 11), 
    (306, 11), 
    (307, 11), 
    (401, 11), 
    (402, 11), 
    (403, 11), 
    (404, 11), 
    (405, 11), 
    (101, 12), 
    (102, 12), 
    (103, 12), 
    (104, 12), 
    (105, 12), 
    (106, 12), 
    (201, 12), 
    (202, 12), 
    (301, 12), 
    (302, 12), 
    (101, 13), 
    (102, 13), 
    (103, 13), 
    (201, 13), 
    (202, 13), 
    (203, 13), 
    (204, 13), 
    (301, 13), 
    (302, 13), 
    (303, 13), 
    (401, 13), 
    (402, 13), 
    (403, 13), 
    (404, 13), 
    (101, 14), 
    (102, 14), 
    (103, 14), 
    (201, 14), 
    (202, 14), 
    (301, 14), 
    (302, 14), 
    (303, 14), 
    (401, 14), 
    (402, 14), 
    (101, 15), 
    (102, 15), 
    (103, 15), 
    (104, 15), 
    (105, 15), 
    (201, 15), 
    (202, 15), 
    (301, 15), 
    (302, 15), 
    (401, 15), 
    (402, 15), 
    (101, 16), 
    (102, 16), 
    (103, 16), 
    (201, 16), 
    (202, 16), 
    (301, 16), 
    (302, 16), 
    (401, 16), 
    (402, 16), 
    (301, 17), 
    (302, 17), 
    (303, 17), 
    (304, 17), 
    (305, 17), 
    (306, 17), 
    (307, 17), 
    (401, 17), 
    (402, 17),
    (301, 18), 
    (302, 18), 
    (303, 18), 
    (304, 18), 
    (401, 18), 
    (402, 18)
;

INSERT INTO Days(description, amountDays) VALUES
    ("LuMaMiJuVi",5),
    ("LuMaMiJu",4),
    ("LuMaMi",3),
    ("LuMaJu",3),
    ("LuMi",2),
    ("MaJu",2),
    ("Lu",1),
    ("Ma",1),
    ("Mi",1),
    ("Ju", 1),
    ("Vi",1),
    ("Sa",1)
;

INSERT INTO Section(subject, professor, academicEvent, section, days, 
startHour, finishHour, classroom, maximumCapacity, canceled) VALUES
('BL130', 21, 1, 1000, 2, 10, 11, 263, 30, FALSE ),
('DQ101', 11, 1, 1100, 5, 11, 12, 180, 15, FALSE ),
('DQ102', 11, 1, 1200, 5, 12, 13, 180, 15, FALSE ),
('EG011', 22, 1, 1300, 2, 13, 14, 180, 15, FALSE ),
('EO025', 11, 1, 1400, 4, 14, 15, 181, 40, FALSE ),
('FF101', 23, 1, 1500, 2, 15, 16, 181, 40, FALSE ),
('FS100', 14, 1, 1600, 1, 16, 17, 182, 40, FALSE ),
('FS200', 14, 1, 1700, 1, 17, 18, 182, 40, FALSE ),
('HH101', 15, 1, 1700, 2, 17, 18, 183, 40, FALSE ),
('IN101', 16, 1, 1800, 2, 18, 19, 184, 40, FALSE ),
('IN102', 16, 1, 1900, 2, 19, 20, 185, 40, FALSE ),
('IN103', 16, 1, 0600, 2, 6, 7, 184, 40, FALSE ),
('IS110', 3, 1, 0700, 3, 07, 08, 26, 30, FALSE ),
('IS115', 3, 1, 0900, 2, 09, 10, 26, 30, FALSE ),
('IS310', 3, 1, 1000, 2, 10, 11, 26, 30, FALSE ),
('IS311', 4, 1, 1100, 3, 11, 12, 27, 31, FALSE ),
('IS410', 4, 1, 1200, 1, 12, 13, 27, 31, FALSE ),
('IS411', 4, 1, 1300, 3, 13, 14, 27, 31, FALSE ),
('IS412', 5, 1, 1000, 1, 10, 11, 28, 31, FALSE ),
('IS501', 5, 1, 1100, 1, 11, 12, 28, 31, FALSE ),
('IS510', 5, 1, 1200, 3, 12, 13, 28, 30, FALSE),
('IS513', 6, 1, 1300, 2, 13, 14, 29, 31, FALSE),
('IS601', 6, 1, 1400, 2, 14, 15, 29, 30, FALSE),
('IS602', 6, 1, 1500, 2, 15, 16, 29, 30, FALSE),
('IS603', 12, 1, 1600, 2, 16, 17, 30, 30, FALSE ),
('IS611', 12, 1, 1700, 2, 17, 18, 30, 30, FALSE ),
('IS701', 12, 1, 1800, 2, 18, 19, 30, 30, FALSE ),
('IS702', 13, 1, 1100, 2, 11, 12, 26, 30, FALSE ),
('IS711', 13, 1, 1200, 2, 12, 13, 26, 30, FALSE ),
('IS720', 13, 1, 1300, 2, 13, 14, 26, 30, FALSE ),
('IS721', 19, 1, 0700, 2, 07, 08, 27, 30, FALSE ),
('IS802', 19, 1, 0800, 2, 08, 09, 27, 30, FALSE ),
('IS811', 19, 1, 0900, 2, 09, 10, 27, 30, FALSE ),
('IS820', 25, 1, 0700, 2, 07, 08, 28, 30, FALSE ),
('IS902', 25, 1, 0800, 2, 08, 09, 28, 30, FALSE ),
('IS903', 25, 1, 0900, 2, 09, 10, 28, 30, FALSE ),
('IS904', 26, 1, 0700, 2, 07, 08, 29, 30, FALSE ),
('IS905', 26, 1, 0800, 1, 08, 09, 29, 30, FALSE ),
('IS906', 26, 1, 0900, 3, 09, 10, 29, 30, FALSE ),
('IS910', 27, 1, 0700, 3, 07, 08, 31, 30, FALSE ),
('IS911', 27, 1, 0800, 3, 08, 09, 31, 30, FALSE ),
('IS912', 27, 1, 0900, 3, 09, 10, 31, 30, FALSE ),
('IS913', 28, 1, 1000, 3, 10, 11, 31, 30, FALSE ),
('IS913', 28, 1, 1100, 3, 11, 12, 31, 30, FALSE ),
('IS914', 28, 1, 1200, 3, 12, 13, 31, 30, FALSE ),
('MM110', 7, 1, 0600, 1, 06, 07, 203, 40, FALSE ),
('MM111', 7, 1, 0700, 1, 07, 08, 203, 40, FALSE ),
('MM201', 7, 1, 0700, 1, 07, 08, 203, 40, FALSE ),
('MM202', 8, 1, 0600, 1, 06, 07, 204, 40, FALSE ),
('MM211', 8, 1, 0700, 3, 07, 08, 204, 40, FALSE ),
('MM411', 8, 1, 0800, 3, 08, 09, 204, 40, FALSE ),
('MM420', 8, 1, 0900, 3, 09, 10, 204, 40, FALSE ),
('MM314', 9, 1, 0700, 3, 07, 08, 205, 40, FALSE ),
('MM401', 10, 1, 0700, 3, 07, 08, 206 , 40, FALSE ),
('RR100', 24, 1, 0700, 3, 13, 14, 190, 40, FALSE ),
('SC101', 18, 1, 1700, 3, 17, 18, 200, 40, FALSE );





CREATE PROCEDURE InsertAllSections(IN academicEvent INT)
BEGIN
    INSERT INTO Section(subject, professor, academicEvent, section, days, startHour, finishHour, classroom, maximumCapacity, canceled) 
    VALUES
        -- Bloque Original
        ('BL130', 21, academicEvent, 1000, 2, 10, 11, 263, 30, FALSE),
        ('DQ101', 11, academicEvent, 1100, 5, 11, 12, 180, 15, FALSE),
        ('DQ102', 11, academicEvent, 1200, 5, 12, 13, 180, 15, FALSE),
        ('EG011', 22, academicEvent, 1300, 2, 13, 14, 180, 15, FALSE),
        ('EO025', 11, academicEvent, 1400, 4, 14, 15, 181, 40, FALSE),
        ('FF101', 23, academicEvent, 1500, 2, 15, 16, 181, 40, FALSE),
        ('FS100', 14, academicEvent, 1600, 1, 16, 17, 182, 40, FALSE),
        ('FS200', 14, academicEvent, 1700, 1, 17, 18, 182, 40, FALSE),
        ('HH101', 15, academicEvent, 1700, 2, 17, 18, 183, 40, FALSE),
        ('IN101', 16, academicEvent, 1800, 2, 18, 19, 184, 40, FALSE),
        ('IN102', 16, academicEvent, 1900, 2, 19, 20, 185, 40, FALSE),
        ('IN103', 16, academicEvent, 0600, 2, 06, 07, 184, 40, FALSE),
        ('IS110', 3, academicEvent, 0700, 3, 07, 08, 26, 30, FALSE),
        ('IS115', 3, academicEvent, 0900, 2, 09, 10, 26, 30, FALSE),
        ('IS310', 3, academicEvent, 1000, 2, 10, 11, 26, 30, FALSE),
        ('IS311', 4, academicEvent, 1100, 3, 11, 12, 27, 31, FALSE),
        ('IS410', 4, academicEvent, 1200, 1, 12, 13, 27, 31, FALSE),
        ('IS411', 4, academicEvent, 1300, 3, 13, 14, 27, 31, FALSE),
        ('IS412', 5, academicEvent, 1000, 1, 10, 11, 28, 31, FALSE),
        ('IS501', 5, academicEvent, 1100, 1, 11, 12, 28, 31, FALSE),
        ('IS510', 5, academicEvent, 1200, 3, 12, 13, 28, 30, FALSE),
        ('IS513', 6, academicEvent, 1300, 2, 13, 14, 29, 31, FALSE),
        ('IS601', 6, academicEvent, 1400, 2, 14, 15, 29, 30, FALSE),
        ('IS602', 6, academicEvent, 1500, 2, 15, 16, 29, 30, FALSE),
        ('IS603', 12, academicEvent, 1600, 2, 16, 17, 30, 30, FALSE),
        ('IS611', 12, academicEvent, 1700, 2, 17, 18, 30, 30, FALSE),
        ('IS701', 12, academicEvent, 1800, 2, 18, 19, 30, 30, FALSE),
        ('IS702', 13, academicEvent, 1100, 2, 11, 12, 26, 30, FALSE),
        ('IS711', 13, academicEvent, 1200, 2, 12, 13, 26, 30, FALSE),
        ('IS720', 13, academicEvent, 1300, 2, 13, 14, 26, 30, FALSE),
        ('IS721', 19, academicEvent, 0700, 2, 07, 08, 27, 30, FALSE),
        ('IS802', 19, academicEvent, 0800, 2, 08, 09, 27, 30, FALSE),
        ('IS811', 19, academicEvent, 0900, 2, 09, 10, 27, 30, FALSE),
        ('IS820', 25, academicEvent, 0700, 2, 07, 08, 28, 30, FALSE),
        ('IS902', 25, academicEvent, 0800, 2, 08, 09, 28, 30, FALSE),
        ('IS903', 25, academicEvent, 0900, 2, 09, 10, 28, 30, FALSE),
        ('IS904', 26, academicEvent, 0700, 2, 07, 08, 29, 30, FALSE),
        ('IS905', 26, academicEvent, 0800, 1, 08, 09, 29, 30, FALSE),
        ('IS906', 26, academicEvent, 0900, 3, 09, 10, 29, 30, FALSE),
        ('IS910', 27, academicEvent, 0700, 3, 07, 08, 31, 30, FALSE),
        ('IS911', 27, academicEvent, 0800, 3, 08, 09, 31, 30, FALSE),
        ('IS912', 27, academicEvent, 0900, 3, 09, 10, 31, 30, FALSE),
        ('IS913', 28, academicEvent, 1000, 3, 10, 11, 31, 30, FALSE),
        ('IS913', 28, academicEvent, 1100, 3, 11, 12, 31, 30, FALSE),
        ('IS914', 28, academicEvent, 1200, 3, 12, 13, 31, 30, FALSE),
        ('MM110', 7, academicEvent, 0600, 1, 06, 07, 203, 40, FALSE),
        ('MM111', 7, academicEvent, 0700, 1, 07, 08, 203, 40, FALSE),
        ('MM201', 7, academicEvent, 0700, 1, 07, 08, 203, 40, FALSE),
        ('MM202', 8, academicEvent, 0600, 1, 06, 07, 204, 40, FALSE),
        ('MM211', 8, academicEvent, 0700, 3, 07, 08, 204, 40, FALSE),
        ('MM411', 8, academicEvent, 0800, 3, 08, 09, 204, 40, FALSE),
        ('MM420', 8, academicEvent, 0900, 3, 09, 10, 204, 40, FALSE),
        ('MM314', 9, academicEvent, 0700, 3, 07, 08, 205, 40, FALSE),
        ('MM401', 10, academicEvent, 0700, 3, 07, 08, 206, 40, FALSE),
        ('RR100', 24, academicEvent, 0700, 3, 13, 14, 190, 40, FALSE),
        ('SC101', 18, academicEvent, 1700, 3, 17, 18, 200, 40, FALSE);
END;



CREATE PROCEDURE InsertSectionsIteratively()
BEGIN
    DECLARE i INT DEFAULT 10;
    
   
    WHILE i <= 27 DO
        CALL InsertAllSections(i);  
        SET i = i + 1;
    END WHILE;

    
    CALL InsertAllSections(34);  
    CALL InsertAllSections(35);  
    CALL InsertAllSections(36);  
     

END;

CALL InsertSectionsIteratively;

INSERT INTO Student (account, name, dni, email, degreeProgram, regionalCenter, globalAverage, periodAverage, photo1, photo2, photo3, password)
VALUES
('20181000001', 'JUAN CARLOS LOPEZ GARCÍA', '0801-1999-00001', 'juan.lopez@unah.hn', 19, 19, NULL, NULL, NULL, NULL, NULL, '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.'),
('20201000001', 'MARÍA FERNANDA PÉREZ MORALES', '0801-2001-10001', 'maria.perez@unah.hn', 19, 19, NULL, NULL, NULL, NULL, NULL, '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.'),
('20211000001', 'PEDRO ALBERTO RIVERA HERRERA', '0801-2002-10001', 'pedro.rivera@unah.hn', 19, 19, NULL, NULL, NULL, NULL, NULL, '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.'),
('20221000001', 'ANA PAOLA SÁNCHEZ RAMÍREZ', '0801-2003-10001', 'ana.sanchez@unah.hn', 19, 19, NULL, NULL, NULL, NULL, NULL, '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.'),
('20231000001', 'PEDRO ALBERTO GÓMEZ FERNÁNDEZ', '0801-2004-10001', 'pedro.gomez@unah.hn', 19, 19, NULL, NULL, NULL, NULL, NULL, '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.'),
('20241000001', 'LAURA BEATRIZ FLORES CASTRO', '0801-2003-10001', 'laura.flores@unah.hn', 19, 19, NULL, NULL, NULL, NULL, NULL, '$2y$10$wxuif9leohc8Glm86O4YKO7x0.sEA714DTg43iLx5luEeWkRzqfL.');

INSERT INTO Observation(id, observation) VALUES
(1, 'APB'),
(2, 'RPB'),
(3, 'ABD'),
(4, 'NSP'),
(5, 'CAN');


INSERT INTO StudentSection(studentAccount, section, grade, observation, waiting)
VALUES
    ('20181000001', 102, 95, 1, 0),
    ('20181000001', 103, 87, 1, 0),
    ('20181000001', 69, 76, 1, 0),
    ('20181000001', 112, 88, 1, 0),
    ('20181000001', 162, 92, 1, 0),
    ('20181000001', 122, 78, 1, 0),
    ('20181000001', 160, 85, 1, 0),
    ('20181000001', 167, 94, 1, 0),
    ('20181000001', 217, 79, 1, 0),
    ('20181000001', 179, 93, 1, 0),
    ('20181000001', 221, 70, 1, 0),
    ('20181000001', 172, 88, 1, 0),
    ('20181000001', 231, 91, 1, 0),
    ('20181000001', 275, 80, 1, 0),
    ('20181000001', 230, 84, 1, 0),
    ('20181000001', 236, 77, 1, 0),
    ('20181000001', 282, 89, 1, 0),
    ('20181000001', 288, 95, 1, 0),
    ('20181000001', 296, 90, 1, 0),
    ('20181000001', 332, 83, 1, 0),
    ('20181000001', 339, 98, 1, 0),
    ('20181000001', 390, 75, 1, 0),
    ('20181000001', 351, 80, 1, 0),
    ('20181000001', 353, 92, 1, 0),
    ('20181000001', 410, 87, 1, 0),
    ('20181000001', 411, 88, 1, 0),
    ('20181000001', 393, 76, 1, 0),
    ('20181000001', 412, 93, 1, 0),
    ('20181000001', 457, 72, 1, 0),
    ('20181000001', 469, 84, 1, 0),
    ('20181000001', 471, 79, 1, 0),
    ('20181000001', 473, 95, 1, 0),
    ('20181000001', 526, 82, 1, 0),
    ('20181000001', 530, 91, 1, 0),
    ('20181000001', 533, 94, 1, 0),
    ('20181000001', 528, 89, 1, 0),
    ('20181000001', 565, 70, 1, 0),
    ('20181000001', 593, 77, 1, 0),
    ('20181000001', 590, 92, 1, 0),
    ('20181000001', 588, 80, 1, 0),
    ('20181000001', 656, 98, 1, 0),
    ('20181000001', 661, 85, 1, 0),
    ('20181000001', 658, 95, 1, 0),
    ('20181000001', 657, 78, 1, 0),
    ('20181000001', 714, 87, 1, 0),
    ('20181000001', 715, 92, 1, 0),
    ('20181000001', 716, 84, 1, 0),
    ('20181000001', 703, 91, 1, 0),
    ('20181000001', 764, 77, 1, 0),
    ('20181000001', 755, 96, 1, 0),
    ('20181000001', 760, 79, 1, 0),
    ('20181000001', 761, 92, 1, 0),
    ('20181000001', 818, 85, 1, 0),
    ('20181000001', 819, 90, 1, 0),
    ('20181000001', 821, 87, 1, 0),
    ('20181000001', 823, 94, 1, 0),
    ('20181000001', 878, 93, 1, 0),
    ('20181000001', 854, 82, 1, 0),
    ('20241000001', 1222, NULL, NULL,0),
    ('20241000001', 1223, NULL, NULL,0),
    ('20241000001', 1232, NULL, NULL,0);


INSERT INTO Question (question) VALUES 
('¿Cómo evalúa la claridad de las explicaciones durante las clases?'),
('¿Qué tan efectivo considera que es el material didáctico utilizado en el curso?'),
('¿Qué tan útil ha sido la retroalimentación recibida en sus tareas y exámenes?'),
('¿Cómo calificaría la organización del curso?'),
('¿Qué tan accesible ha sido el profesor para responder sus dudas?'),
('¿Cómo evalúa la calidad de los recursos en línea (videos, lecturas, foros)?'),
('¿Qué tan bien considera que se cumplen los objetivos de aprendizaje del curso?'),
('¿Cómo calificaría la metodología utilizada en el curso?'),
('¿Qué tan eficiente considera que ha sido el uso del tiempo en las clases?'),
('¿Cómo evalúa el nivel de dificultad de los contenidos del curso?');


INSERT INTO Question (question) VALUES
('¿Qué aspectos del curso considera que deberían mejorarse?'),
('¿Qué parte del contenido del curso le resultó más útil para su aprendizaje?'),
('¿Cómo calificaría la interacción entre los estudiantes y el profesor durante el curso?'),
('¿Qué cambios sugeriría para hacer que el curso sea más efectivo?'),
('¿Qué le motivó a tomar este curso y cómo ha satisfecho sus expectativas?');


INSERT INTO AnswerSelection (description) VALUES
('EXCELENTE'),
('BUENO'),
('MUY BUENO'),
('DEFICIENTE');