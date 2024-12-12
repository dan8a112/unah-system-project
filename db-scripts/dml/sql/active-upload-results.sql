-- ACTIVAR SUBIR NOTAS
UPDATE AcademicEvent
SET active=FALSE
WHERE id=30;

UPDATE AcademicEvent
SET active=TRUE
WHERE id=31; 