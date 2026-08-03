-- Permitir registrar pagos asociados a una propiedad sin contrato
ALTER TABLE pagos
  ADD COLUMN propiedad_id INT NULL AFTER contrato_id;

-- Rellenar propiedad_id en pagos existentes a partir del contrato
UPDATE pagos p
INNER JOIN contratos c ON c.id = p.contrato_id
SET p.propiedad_id = c.propiedad_id
WHERE p.propiedad_id IS NULL AND p.contrato_id IS NOT NULL;
