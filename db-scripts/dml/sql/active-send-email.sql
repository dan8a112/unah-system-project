-- ACTIVAR ENVIO DE CORREOS
UPDATE AcademicEvent
SET active=FALSE
WHERE id=31;

UPDATE AcademicEvent
SET active=TRUE
WHERE id=32;

SELECT * FROM `SendedEmail`;