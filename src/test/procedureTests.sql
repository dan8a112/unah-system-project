
/*Procedimeinto para generar una inscripcion de admision*/
CALL insertApplicant(
    'A123',
    'Juan',
    'Carlos',
    'Hernández',
    'Gómez',
    '/path/to/certificate.jpg',
    '1234567890',
    'juan.carlos@example.com',
    2,
    1,
    2
);

SELECT * FROM Applicant;
SELECT * FROM Application;