INSERT INTO Applicant (id, firstName, secondName, firstLastName, secondLastName, pathSchoolCertificate, telephoneNumber, personalEmail) VALUES
    ('0801-2004-03085', 'Dorian', 'Samantha', 'Contreras', 'Velasquez', 'path1.pdf', '33333333', 'dorian.contreras@gmail.com'),
    ('0601-1999-04567', 'Carlos', 'Andrés', 'Hernández', 'Gómez', 'path2.pdf', '99999999', 'carlos.hernandez@gmail.com'),
    ('0601-2002-01234', 'María', 'Fernanda', 'López', 'Pérez', 'path3.pdf', '88888888', 'maria.lopez@gmail.com'),
    ('0801-1990-02150', 'Carlos', 'Andres', 'Martínez', 'Pérez', 'path2.pdf', '22222222', 'carlos.martinez@gmail.com'),
    ('0801-1991-04210', 'María', 'José', 'Ramírez', 'Hernández', 'path3.pdf', '22334455', 'maria.ramirez@gmail.com'),
    ('0801-1988-06340', 'Juan', 'Carlos', 'García', 'Sánchez', 'path4.pdf', '33667788', 'juan.garcia@gmail.com'),
    ('0801-1995-09120', 'Ana', 'Lucía', 'López', 'Flores', 'path5.pdf', '44556677', 'ana.lopez@gmail.com'),
    ('0801-1987-03099', 'Ricardo', 'Eduardo', 'Pérez', 'Vega', 'path6.pdf', '55667788', 'ricardo.perez@gmail.com'),
    ('0801-1992-05875', 'Sofia', 'Isabel', 'Martínez', 'Gómez', 'path7.pdf', '66778899', 'sofia.martinez@gmail.com'),
    ('0801-1993-07650', 'Luis', 'Alfonso', 'Sánchez', 'Lozada', 'path8.pdf', '77889900', 'luis.sanchez@gmail.com'),
    ('0801-1994-06525', 'Elena', 'Victoria', 'Gutiérrez', 'Ramírez', 'path9.pdf', '88990011', 'elena.gutierrez@gmail.com')
;

INSERT INTO Application (idApplicant, firstDegreeProgramChoice, secondDegreeProgramChoice, regionalCenterChoice, applicationDate, academicEvent) VALUES
    ('0801-2004-03085', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0601-1999-04567', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0601-2002-01234', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0801-1990-02150', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0801-1991-04210', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0801-1988-06340', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0801-1995-09120', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0801-1987-03099', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0801-1992-05875', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0801-1993-07650', 12, 1, 19, '2024-11-23 01:00:00', 5),
    ('0801-1994-06525', 12, 1, 19, '2024-11-23 01:00:00', 5)
;

UPDATE AcademicEvent
SET active=FALSE
WHERE id=6;

UPDATE AcademicEvent
SET active=TRUE
WHERE id=7;

CALL reviewersEvent;