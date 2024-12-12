-- ACTIVAR PROCESO DE PREMATRICULA
UPDATE AcademicEvent
SET active=FALSE
WHERE id=37;

UPDATE AcademicEvent
SET active=TRUE
WHERE id=38;

INSERT INTO Student (account, name, dni, email, degreeProgram, regionalCenter, globalAverage, periodAverage, password) VALUES
('20180012345', 'Carlos Martínez', '0801199901234', 'carlos.martinez@unah.hn', 1, 2, 85, 90, '$2y$10$eWks93kOyb7/aNq4CfbkVeGFysoRYp6vK3VY8k.Z7HHZBdWmKc5NO'),
('20170054321', 'María Lopez', '0801198805678', 'maria.lopez@unah.hn', 2, 3, 87, 89, '$2y$10$Kfsj93Js93kAJ49x76nCZuFso4TYp8hVrHsiQ1K9qTkE9SpPKeVqA'),
('20190067890', 'Ana Hernández', '0801200101111', 'ana.hernandez@unah.hn', 3, 1, 90, 92, '$2y$10$sjkf837Jfh38kLaNp2VHFZrtjoYTpe8VKxhUZ7HHZBdFmqPPe92BD'),
('20180023456', 'Luis Gomez', '0801200202222', 'luis.gomez@unah.hn', 1, 4, 88, 91, '$2y$10$lr8w6w9iow8371F93sokYpe7p8xhV4L2NZyK3TL7kRZdPtPz9k3LD'),
('20190034567', 'Sofía Ramírez', '0801199703333', 'sofia.ramirez@unah.hn', 2, 5, 89, 87, '$2y$10$okdm38skd47F02lscGZFYpe2jshVZXF4PYTJ5MzkRRDdFlMlKc5LZ'),
('20200012345', 'Pedro Castillo', '0801200304444', 'pedro.castillo@unah.hn', 3, 6, 86, 88, '$2y$10$lsk392k93AkdF99oC8FyXpe9smFXF2L4ZYZJ6LR7LHZdPtNPeZ3LV'),
('20210054321', 'Juan Vásquez', '0801200405555', 'juan.vasquez@unah.hn', 1, 7, 87, 85, '$2y$10$slm28Z93kFs93Alz9CFLYpe6joYXF5L2NYXL7QML4MZdPLWPeX5LZ'),
('20220067890', 'Estela Mejía', '0801200506666', 'estela.mejia@unah.hn', 2, 8, 89, 90, '$2y$10$eZp31kFs93jA09oCFLZFYpe2joYXN8L6LYXLQNR7LLZdPqRMLV5LP'),
('20230012345', 'Rosa Flores', '0801200607777', 'rosa.flores@unah.hn', 3, 9, 88, 89, '$2y$10$oNl37l9k3Fo93kPlFCFLYpe2joYXH3L6LYQNR7RR6ZdPtPNMLZ3LV'),
('20240054321', 'Fernando López', '0801200708888', 'fernando.lopez@unah.hn', 1, 10, 85, 87, '$2y$10$plm94Z93sAl91o9CFLFYpe6moYXJ4L3LYXR4QNL4LZdPzPWPe93LZ');


INSERT INTO StudentSection (studentAccount, section, waiting) VALUES
('20180012345', 1189, FALSE),
('20170054321', 1189, FALSE),
('20190067890', 1189, FALSE),
('20180023456', 1189, FALSE),
('20190034567', 1189, FALSE),
('20200012345', 1189, FALSE),
('20210054321', 1189, FALSE),
('20220067890', 1189, FALSE),
('20230012345', 1189, FALSE),
('20240054321', 1189, FALSE)
;