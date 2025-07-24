-- Tabla para registrar gastos de la inmobiliaria
CREATE TABLE IF NOT EXISTS `gastos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `concepto` enum('Pago de Gastos comunes','Pago de Impuestos','Pago de Servicios','Pago de Reparaciones','Pago de Mantenimiento') COLLATE utf8_unicode_ci NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `forma_pago` enum('Efectivo','Transferencia') COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8_unicode_ci,
  `comprobante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `propiedad_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `validado` tinyint(1) DEFAULT '0',
  `fecha_validacion` datetime DEFAULT NULL,
  `usuario_validacion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gastos_propiedad` (`propiedad_id`),
  KEY `fk_gastos_usuario` (`usuario_id`),
  CONSTRAINT `fk_gastos_propiedad` FOREIGN KEY (`propiedad_id`) REFERENCES `propiedades` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_gastos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 