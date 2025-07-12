CREATE TABLE IF NOT EXISTS `listado_conceptos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `listado_conceptos` (`nombre`) VALUES
('Pago de Gastos comunes'),
('Pago de Impuestos'),
('Pago de Servicios'),
('Pago de Reparaciones'),
('Pago de Mantenimiento'),
('Pago de Convenios'),
('Otros');

ALTER TABLE `gastos`
ADD COLUMN `concepto_id` INT(11) NULL AFTER concepto;
