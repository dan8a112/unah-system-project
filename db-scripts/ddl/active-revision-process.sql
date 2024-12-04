INSERT INTO Applicant (id, names, lastNames, schoolCertificate, telephoneNumber, personalEmail) VALUES
    ('0801-2004-12345', 'Andrea Valeria', 'Hernández López', 'certificate1.pdf', '98765432', 'andrea.hernandez@gmail.com'),
    ('0801-2004-54321', 'Carlos Eduardo', 'Martínez Rivera', 'certificate2.pdf', '87654321', 'carlos.martinez@hotmail.com'),
    ('0801-2004-67891', 'Sofía Alejandra', 'Gómez García', 'certificate3.pdf', '76543210', 'sofia.gomez@yahoo.com'),
    ('0801-2004-98765', 'Luis Fernando', 'Ramírez Torres', 'certificate4.pdf', '65432109', 'luis.ramirez@gmail.com'),
    ('0801-2004-23456', 'Gabriela Natalia', 'Rojas Mejía', 'certificate5.pdf', '54321098', 'gabriela.rojas@hotmail.com'),
    ('0801-2004-34567', 'Javier Ignacio', 'Castillo Ortiz', 'certificate6.pdf', '43210987', 'javier.castillo@yahoo.com'),
    ('0801-2004-45678', 'María Fernanda', 'Vargas Sánchez', 'certificate7.pdf', '32109876', 'maria.vargas@gmail.com'),
    ('0801-2004-56789', 'Ricardo Andrés', 'Morales Jiménez', 'certificate8.pdf', '21098765', 'ricardo.morales@hotmail.com'),
    ('0801-2004-67890', 'Daniela Paola', 'Pérez Rodríguez', 'certificate9.pdf', '10987654', 'daniela.perez@yahoo.com'),
    ('0801-2004-78901', 'Pedro Antonio', 'Aguilar Cruz', 'certificate10.pdf', '19876543', 'pedro.aguilar@gmail.com'),
    ('0801-2004-89012', 'Alejandra Beatriz', 'Navarro Soto', 'certificate11.pdf', '29765432', 'alejandra.navarro@hotmail.com'),
    ('0801-2004-90123', 'Esteban Alonso', 'Cordero Ruiz', 'certificate12.pdf', '39654321', 'esteban.cordero@yahoo.com'),
    ('0801-2004-01234', 'Camila Isabel', 'Medina Flores', 'certificate13.pdf', '49543210', 'camila.medina@gmail.com'),
    ('0801-2004-12340', 'Manuel José', 'Ramos Vega', 'certificate14.pdf', '59432109', 'manuel.ramos@hotmail.com'),
    ('0801-2004-23451', 'Juliana Estefanía', 'López Cabrera', 'certificate15.pdf', '69321098', 'juliana.lopez@yahoo.com'),
    ('0801-2004-34562', 'Francisco Javier', 'Vargas Guerrero', 'certificate16.pdf', '79210987', 'francisco.vargas@gmail.com'),
    ('0801-2004-45673', 'Natalia Viviana', 'Peña Márquez', 'certificate17.pdf', '89109876', 'natalia.pena@hotmail.com'),
    ('0801-2004-56784', 'Roberto Alejandro', 'Salas Castillo', 'certificate18.pdf', '99098765', 'roberto.salas@yahoo.com'),
    ('0801-2004-67895', 'Lucía Andrea', 'Cano Escobar', 'certificate19.pdf', '08987654', 'lucia.cano@gmail.com'),
    ('0801-2004-78906', 'Oscar Enrique', 'Quintana Torres', 'certificate20.pdf', '18976543', 'oscar.quintana@hotmail.com');



INSERT INTO Application (idApplicant, firstDegreeProgramChoice, secondDegreeProgramChoice, regionalCenterChoice, applicationDate, academicEvent) VALUES
    ('0801-2004-12345', 10, 18, 5, '2024-11-23 01:00:00', 5),
    ('0801-2004-54321', 3, 7, 12, '2024-11-23 01:00:00', 5),
    ('0801-2004-67891', 15, 20, 8, '2024-11-23 01:00:00', 5),
    ('0801-2004-98765', 6, 9, 17, '2024-11-23 01:00:00', 5),
    ('0801-2004-23456', 12, 2, 4, '2024-11-23 01:00:00', 5),
    ('0801-2004-34567', 5, 16, 14, '2024-11-23 01:00:00', 5),
    ('0801-2004-45678', 20, 3, 9, '2024-11-23 01:00:00', 5),
    ('0801-2004-56789', 8, 13, 11, '2024-11-23 01:00:00', 5),
    ('0801-2004-67890', 1, 4, 19, '2024-11-23 01:00:00', 5),
    ('0801-2004-78901', 17, 11, 2, '2024-11-23 01:00:00', 5),
    ('0801-2004-89012', 9, 6, 7, '2024-11-23 01:00:00', 5),
    ('0801-2004-90123', 13, 10, 15, '2024-11-23 01:00:00', 5),
    ('0801-2004-01234', 7, 5, 18, '2024-11-23 01:00:00', 5),
    ('0801-2004-12340', 2, 8, 3, '2024-11-23 01:00:00', 5),
    ('0801-2004-23451', 19, 14, 16, '2024-11-23 01:00:00', 5),
    ('0801-2004-34562', 11, 1, 13, '2024-11-23 01:00:00', 5),
    ('0801-2004-45673', 16, 12, 6, '2024-11-23 01:00:00', 5),
    ('0801-2004-56784', 14, 19, 10, '2024-11-23 01:00:00', 5),
    ('0801-2004-67895', 4, 17, 18, '2024-11-23 01:00:00', 5),
    ('0801-2004-78906', 18, 15, 1, '2024-11-23 01:00:00', 5);

UPDATE AcademicEvent
SET active=FALSE
WHERE id=6;

UPDATE AcademicEvent
SET active=TRUE
WHERE id=7;

CALL reviewersEvent;