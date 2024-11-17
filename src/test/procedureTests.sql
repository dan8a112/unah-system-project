
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

/*Procedimiento para obtener el id de las carreras de un centro regional*/
CALL GetDegreeProgramsByRegionalCenter(3);

/*Procedimiento para saber si existe una inscrpcion de un aplicante en el proceso actual*/
CALL ApplicationInCurrentEvent('0801-2004-03085');
