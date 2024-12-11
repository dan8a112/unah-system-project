----------------------INSERTS DE APLICANTES---------------------------------
INSERT INTO Applicant (id, names, lastNames, schoolCertificate, telephoneNumber, personalEmail) VALUES
    ('0601-1999-04567', 'Carlos Andrés', 'Hernández Gómez', 'path2.pdf', '99999999', 'carlos.hernandez@gmail.com'),
    ('0601-2002-01234', 'María Fernanda', 'López Pérez', 'path3.pdf', '88888888', 'maria.lopez@gmail.com'),
    ('0801-1990-02150', 'Carlos Andres', 'Martínez Pérez', 'path2.pdf', '22222222', 'carlos.martinez@gmail.com'),
    ('0801-1991-04210', 'María José', 'Ramírez Hernández', 'path3.pdf', '22334455', 'maria.ramirez@gmail.com'),
    ('0801-1988-06340', 'Juan Carlos', 'García Sánchez', 'path4.pdf', '33667788', 'juan.garcia@gmail.com'),
    ('0801-1995-09120', 'Ana Lucía', 'López Flores', 'path5.pdf', '44556677', 'ana.lopez@gmail.com'),
    ('0801-1987-03099', 'Ricardo Eduardo', 'Pérez Vega', 'path6.pdf', '55667788', 'ricardo.perez@gmail.com'),
    ('0801-1992-05875', 'Sofia Isabel', 'Martínez Gómez', 'path7.pdf', '66778899', 'sofia.martinez@gmail.com'),
    ('0801-1993-07650', 'Luis Alfonso', 'Sánchez Lozada', 'path8.pdf', '77889900', 'luis.sanchez@gmail.com'),
    ('0801-1994-06525', 'Elena Victoria', 'Gutiérrez Ramírez', 'path9.pdf', '88990011', 'elena.gutierrez@gmail.com')
;

INSERT INTO Application (idApplicant, firstDegreeProgramChoice, secondDegreeProgramChoice, regionalCenterChoice, applicationDate, academicEvent) VALUES
    ('0601-1999-04567', 19, 1, 19, '2024-11-23 01:00:00', 28),
    ('0601-2002-01234', 19, 1, 19, '2024-11-23 01:00:00', 28),
    ('0801-1990-02150', 19, 1, 19, '2024-11-23 01:00:00', 28),
    ('0801-1991-04210', 19, 1, 19, '2024-11-23 01:00:00', 28),
    ('0801-1988-06340', 19, 1, 19, '2024-11-23 01:00:00', 28),
    ('0801-1995-09120', 19, 1, 19, '2024-11-23 01:00:00', 28),
    ('0801-1987-03099', 19, 1, 19, '2024-11-23 01:00:00', 28),
    ('0801-1992-05875', 19, 1, 19, '2024-11-23 01:00:00', 28),
    ('0801-1993-07650', 19, 1, 19, '2024-11-23 01:00:00', 28),
    ('0801-1994-06525', 19, 1, 19, '2024-11-23 01:00:00', 28)
;

INSERT INTO Results(application, admissionTest) VALUES
    (46,1),
    (47,1),
    (48,1),
    (49,1),
    (50,1),
    (51,1),
    (52,1),
    (53,1),
    (54,1),
    (55,1),
    (56,2)
;

----------------------ACTIVAR REVISION DE INSCRIPCIONES---------------------
UPDATE AcademicEvent
SET active=FALSE
WHERE id=29;

UPDATE AcademicEvent
SET active=TRUE
WHERE id=30; 

-- Distribuir inscripciones
CALL reviewersEvent;