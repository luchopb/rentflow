-- Insertar contratos (usando subqueries para obtener los IDs)
INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria del Sol' AND local = 'Local 10'),
    (SELECT id FROM inquilinos WHERE nombre = 'Patricia'),
    CURRENT_DATE, -- fecha inicio
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR), -- fecha fin (2 años desde hoy)
    9000, -- renta mensual
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria del Sol' AND local = 'Local 13'),
    (SELECT id FROM inquilinos WHERE nombre = 'Carolina'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    7500,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria del Sol' AND local = 'Local 21'),
    (SELECT id FROM inquilinos WHERE nombre = 'Sofia'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    12100,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria del Sol' AND local = 'Local 27'),
    (SELECT id FROM inquilinos WHERE nombre = 'Marcia'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    9500,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria de las Americas' AND local = 'Local 5'),
    (SELECT id FROM inquilinos WHERE nombre = 'Juan Polonio'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    7500,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria de las Americas' AND local = 'Local 10'),
    (SELECT id FROM inquilinos WHERE nombre = 'Exafix'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    8000,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria de las Americas' AND local = 'Local 35'),
    (SELECT id FROM inquilinos WHERE nombre = 'Yasmani y Sheylan'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    9000,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria de las Americas' AND local = 'Local 103'),
    (SELECT id FROM inquilinos WHERE nombre = 'Claudia'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    11000,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria de las Americas' AND local = 'Local 105'),
    (SELECT id FROM inquilinos WHERE nombre = 'Elvis'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    6500,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria de las Americas' AND local = 'Local 106'),
    (SELECT id FROM inquilinos WHERE nombre = 'Juan Carlos Petit'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    7862,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Torre Maldonado' AND local = 'Local 030'),
    (SELECT id FROM inquilinos WHERE nombre = 'Mariana'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    5500,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria Cristal' AND local = 'Local 39'),
    (SELECT id FROM inquilinos WHERE nombre = 'Elsa'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    7000,
    'Activo';

INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
SELECT 
    (SELECT id FROM propiedades WHERE galeria = 'Galeria Entrevero' AND local = 'Local 41'),
    (SELECT id FROM inquilinos WHERE nombre = 'Gaby Nails'),
    CURRENT_DATE,
    DATE_ADD(CURRENT_DATE, INTERVAL 2 YEAR),
    9100,
    'Activo'; 