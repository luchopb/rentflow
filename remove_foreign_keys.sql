-- Eliminar foreign keys de la tabla contratos
ALTER TABLE contratos
DROP FOREIGN KEY contratos_ibfk_1, -- foreign key de propiedad_id
DROP FOREIGN KEY contratos_ibfk_2; -- foreign key de inquilino_id

-- Eliminar foreign key de la tabla pagos
ALTER TABLE pagos
DROP FOREIGN KEY pagos_ibfk_1; -- foreign key de contrato_id

-- Limpiar la tabla de propiedades
TRUNCATE TABLE propiedades; 