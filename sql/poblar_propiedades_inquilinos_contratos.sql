-- Poblar propiedades
INSERT INTO propiedades (tipo, direccion, precio, caracteristicas, estado) VALUES
('Cochera', 'Bolo 001', 3600, '5/5 brou', 'Alquilado'),
('Cochera', 'Bolo 002', 3600, '14/5 sob', 'Alquilado'),
('Cochera', 'Bolo 003', 3400, '2/5 brou', 'Alquilado'),
('Cochera', 'Bolo 004', 3200, '7/5 brou', 'Alquilado'),
('Cochera', 'Bolo 005', 3400, 'brou', 'Alquilado'),
('Cochera', 'Bolo 006', 4300, '5/5 sob', 'Alquilado'),
('Cochera', 'Bolo 007', 3600, '5/5 brou', 'Alquilado'),
('Cochera', 'Bolo 008', 2500, '5/5 sob', 'Alquilado'),
('Cochera', 'Bolo 009', 4200, '5/5 brou', 'Alquilado'),
('Cochera', 'Bolo 010', 3600, '5/5 sob', 'Alquilado'),
('Cochera', 'Bolo 011', 1500, '7/5 brou', 'Alquilado'),
('Departamento', 'Bolo Apto', 0, 'Apartamento', 'Disponible');

-- Poblar inquilinos
INSERT INTO inquilinos (nombre, documento, email, vehiculo, matricula, telefono) VALUES
('Sarkisian', 'pendiente-011', 'pendiente@email.com', 'Onix Sedan', 'SDC5513', '099647878'),
('Eduardo', 'pendiente-012', 'pendiente@email.com', 'Geely', 'SDF2678', '095199525'),
('Cristian', 'pendiente-013', 'pendiente@email.com', 'Fiat Mobi', '', '099764804'),
('Corina', 'pendiente-014', 'pendiente@email.com', 'Hyundai i10', 'SBM1892', '095277483'),
('Alejandra ancheta', 'pendiente-015', 'pendiente@email.com', 'Onix Hatch', 'SCS2773', '095860816'),
('Walter', 'pendiente-016', 'pendiente@email.com', 'Amarok', 'SCG3263', '097089289'),
('Natacha', 'pendiente-017', 'pendiente@email.com', 'Golf', '', '099415432'),
('Martin', 'pendiente-018', 'pendiente@email.com', 'Fiat Ritmo', '', '095038197'),
('Gabriel', 'pendiente-019', 'pendiente@email.com', 'BMW', 'SBD8965', '099405290'),
('Lau / Fabian', 'pendiente-020', 'pendiente@email.com', 'Corsa', 'SBM6092', '096325786'),
('Martin', 'pendiente-021', 'pendiente@email.com', 'Moto', '', '098669973');

-- Poblar contratos usando subqueries para IDs
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 001' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Sarkisian'), '2024-06-01', '2025-05-31', 3600, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 002' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Eduardo'), '2024-06-01', '2025-05-31', 3600, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 003' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Cristian'), '2024-06-01', '2025-05-31', 3400, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 004' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Corina'), '2024-06-01', '2025-05-31', 3200, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 005' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Alejandra ancheta'), '2024-06-01', '2025-05-31', 3400, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 006' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Walter'), '2024-06-01', '2025-05-31', 4300, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 007' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Natacha'), '2024-06-01', '2025-05-31', 3600, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 008' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Martin' AND vehiculo = 'Fiat Ritmo'), '2024-06-01', '2025-05-31', 2500, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 009' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Gabriel'), '2024-06-01', '2025-05-31', 4200, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 010' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Lau / Fabian'), '2024-06-01', '2025-05-31', 3600, 'Activo';
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) SELECT (SELECT id FROM propiedades WHERE direccion = 'Bolo 011' AND tipo = 'Cochera'), (SELECT id FROM inquilinos WHERE nombre = 'Martin' AND vehiculo = 'Moto'), '2024-06-01', '2025-05-31', 1500, 'Activo'; 