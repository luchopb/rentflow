-- Eliminar foreign keys de la tabla contratos
ALTER TABLE contratos
DROP FOREIGN KEY contratos_ibfk_1, -- foreign key de propiedad_id
DROP FOREIGN KEY contratos_ibfk_2; -- foreign key de inquilino_id

-- Eliminar foreign key de la tabla pagos
ALTER TABLE pagos
DROP FOREIGN KEY pagos_ibfk_1; -- foreign key de contrato_id

-- Limpiar la tabla de propiedades
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE propiedad_imagenes;
TRUNCATE TABLE propiedades;
SET FOREIGN_KEY_CHECKS = 1;

