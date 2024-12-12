-- Aprobar solicitudes
UPDATE Application
SET approved= true, idReviewer=1
WHERE academicEvent = 28 AND approved IS NULL;

UPDATE TempTableApplication
SET approved = true
WHERE approved IS NULL;

-- ACTIVAR SUBIR NOTAS
UPDATE AcademicEvent
SET active=FALSE
WHERE id=30;

UPDATE AcademicEvent
SET active=TRUE
WHERE id=31; 