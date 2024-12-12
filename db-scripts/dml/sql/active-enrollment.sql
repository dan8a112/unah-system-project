-- Activar proceso de Matricula
UPDATE AcademicEvent
SET active=FALSE
WHERE id=38;

UPDATE AcademicEvent
SET active=TRUE
WHERE id=39;

INSERT INTO Student (account, name, dni, email, degreeProgram, regionalCenter, globalAverage, periodAverage, password) VALUES
('20240123456', 'Alejandro Torres', '0801200809999', 'alejandro.torres@unah.hn', 2, 19, 88, 86, '$2y$10$axkj28skfL29jshV8kQZLY3RLHZrPJZM3k9LZ94A'),
('20240234567', 'Elena Cruz', '0801200910001', 'elena.cruz@unah.hn', 3, 19, 87, 85, '$2y$10$plnm38k3SkdF92js8CFXJ4M7PZNLR7LL5LPZM3k92J'),
('20240345678', 'Manuel Reyes', '0801201011112', 'manuel.reyes@unah.hn', 1, 19, 89, 87, '$2y$10$sam28k3KFs91FLr7JZXNR5LZ5LPqJM3N9JZM7PqJ'),
('20240456789', 'Andrea Paz', '0801201112223', 'andrea.paz@unah.hn', 2, 19, 86, 89, '$2y$10$lskm92J39Al9FNL9Z5XPQ8kMRJXN4P9ZM5QJ4LR'),
('20240567890', 'Gabriel Rivera', '0801201213334', 'gabriel.rivera@unah.hn', 3, 19, 90, 88, '$2y$10$msk39AL94KFs8CFXJ9P4NQZ8LP6MJ9RXP3PJ7LZ'),
('20240678901', 'Daniela Ochoa', '0801201314445', 'daniela.ochoa@unah.hn', 1, 19, 87, 90, '$2y$10$lsk28Zm91Al8NF4XJRZN6PJ7LZ5PqJRXP7LRZM9'),
('20240789012', 'Ricardo Peralta', '0801201415556', 'ricardo.peralta@unah.hn', 2, 19, 85, 86, '$2y$10$lsm39NF91AL8Z4XJFNRP8XM3L5ZLQNRXP6PZM3J'),
('20240890123', 'Carla Mendoza', '0801201516667', 'carla.mendoza@unah.hn', 3, 19, 88, 89, '$2y$10$msl29L39NF8Z4L7JRNQ6PL5XM9QNRXP8Z5PZM3J'),
('20240901234', 'Francisco Lara', '0801201617778', 'francisco.lara@unah.hn', 1, 19, 86, 85, '$2y$10$alm28NF91PL8Z4NRXJM7PZN8Z5XPQJXM7LZ9PZ'),
('20241012345', 'Silvia Cáceres', '0801201718889', 'silvia.caceres@unah.hn', 2, 19, 90, 92, '$2y$10$lsk48ZF91AL8NP5L7PRZ6L5QNRXP8M5ZM6PJ7LZ');

-- Nuevos registros para la tabla StudentSection
INSERT INTO StudentSection (studentAccount, section, waiting) VALUES
('20240123456', 1189, FALSE),
('20240234567', 1189, TRUE),
('20240345678', 1189, FALSE),
('20240456789', 1189, TRUE),
('20240567890', 1189, FALSE),
('20240678901', 1189, TRUE),
('20240789012', 1189, FALSE),
('20240890123', 1189, TRUE),
('20240901234', 1189, FALSE),
('20241012345', 1189, TRUE);