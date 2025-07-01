-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-07-2025 a las 10:14:39
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `drakon_luchorentflow_min`
--
CREATE DATABASE IF NOT EXISTS `drakon_luchorentflow_min` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `drakon_luchorentflow_min`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE IF NOT EXISTS `contratos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inquilino_id` int(11) DEFAULT NULL,
  `propiedad_id` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `garantia` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `corredor` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` enum('activo','finalizado') COLLATE utf8_unicode_ci DEFAULT NULL,
  `documentos` text COLLATE utf8_unicode_ci,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `inquilino_id`, `propiedad_id`, `fecha_inicio`, `fecha_fin`, `importe`, `garantia`, `corredor`, `estado`, `documentos`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 1, 1, '2025-01-01', '2025-06-16', 9000.00, '0', '0', 'finalizado', '[\"684e1726ae786-Local10Sol Documentos P\\u00f3liza GA091654.pdf\"]', 0, NULL, NULL),
(2, 2, 2, '2025-01-01', '2026-02-01', 7500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(3, 3, 3, '2025-01-01', '2026-02-01', 7500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(4, 4, 4, '2024-08-15', '2025-08-14', 12100.00, '0', '0', 'activo', '[\"68490635634b3-POLIZA CONTRATO LOCAL 21 DEL SOL SOFIA GARCIA.pdf\"]', 0, NULL, NULL),
(5, 6, 6, '2025-01-01', '2026-02-01', 9500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(6, 7, 7, '2025-01-01', '2026-02-01', 7500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(7, 8, 8, '2025-01-01', '2026-02-01', 8000.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(8, 10, 10, '2025-01-01', '2026-02-01', 9000.00, '0', '0', 'activo', '[\"6849e3efc1d83-Local 35 Gal Americas Sub Contrato Alqui.pdf\"]', 0, NULL, NULL),
(9, 11, 11, '2025-01-01', '2026-02-01', 11000.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(10, 12, 12, '2025-01-01', '2026-02-01', 6500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(11, 13, 13, '2025-01-01', '2026-02-01', 7862.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(13, 15, 15, '2025-01-01', '2026-02-01', 7000.00, '0', '0', 'activo', '[\"685cba395fae3-857c3c80-2782-4c91-85d7-9e30f81e51ca.jpeg\"]', 0, NULL, NULL),
(14, 18, 18, '2025-01-01', '2026-02-01', 9100.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(15, 19, 19, '2025-01-01', '2026-02-01', 40000.00, '0', '0', 'activo', '[]', 0, NULL, NULL),
(16, 20, 20, '2024-08-01', '2025-07-31', 12000.00, '0', '0', 'activo', '[\"685cba5051fbb-1dd7b53c-f354-4518-9243-c26d03eca083.jpeg\"]', 0, NULL, NULL),
(17, 21, 21, '2025-01-01', '2026-02-01', 1.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(18, 23, 23, '2025-01-01', '2026-02-01', 3600.00, '0', '0', 'activo', '[]', 0, NULL, NULL),
(19, 24, 24, '2025-01-01', '2026-02-01', 3600.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(20, 25, 25, '2025-01-01', '2026-02-01', 3400.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(21, 26, 26, '2025-01-01', '2026-02-01', 3200.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(22, 27, 27, '2025-01-01', '2026-02-01', 3400.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(23, 28, 28, '2025-01-01', '2026-02-01', 4300.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(24, 29, 29, '2025-01-01', '2026-02-01', 3600.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(25, 30, 30, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(26, 31, 31, '2025-01-01', '2026-02-01', 4200.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(27, 32, 32, '2025-01-01', '2026-02-01', 3600.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(28, 34, 34, '2025-01-01', '2026-02-01', 1500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(29, 35, 35, '2025-01-01', '2026-02-01', 6200.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(30, 36, 36, '2025-01-01', '2026-02-01', 5500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(31, 37, 37, '2025-01-01', '2026-02-01', 2400.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(32, 38, 38, '2024-01-01', '2024-11-01', 2500.00, '0', '0', 'finalizado', '[]', 0, NULL, NULL),
(33, 39, 39, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(34, 41, 41, '2025-01-01', '2026-02-01', 2600.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(35, 42, 42, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(36, 44, 44, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(46, 47, 48, '2025-02-01', '2026-06-09', 6500.00, '0', '0', 'activo', '[]', 0, NULL, NULL),
(47, 48, 49, '2025-05-01', '2026-06-10', 32705.00, '0', '0', 'activo', '[]', 0, NULL, NULL),
(48, 43, 50, '2025-06-10', '2026-06-10', 31110.00, '0', '0', 'activo', '[\"685eadffced22-IMG_1918.png\"]', 0, NULL, NULL),
(49, 49, 17, '2025-06-01', '2026-05-31', 10000.00, '0', '0', 'activo', '[\"68490081c96b4-POLIZA CONTRATO MAGELA MENDIOROZ LOCAL 7y8 Galeria del Entrevero 01-06-2025 GA109636.pdf\",\"68490081c99b4-CONTRATO ALQUILER FIRMADO LOCAL 7 y 8 Galeria del Entrevero 01-06-2025.pdf\"]', 0, NULL, NULL),
(50, 50, 51, '2025-06-11', '2026-06-11', 18000.00, '0', '0', 'activo', '[]', 0, NULL, NULL),
(51, 51, 52, '2025-03-01', '2026-03-01', 3600.00, '0', '0', 'activo', '[]', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inquilinos`
--

CREATE TABLE IF NOT EXISTS `inquilinos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cedula` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vehiculo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `matricula` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `inquilinos`
--

INSERT INTO `inquilinos` (`id`, `nombre`, `cedula`, `telefono`, `vehiculo`, `matricula`, `documentos`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Patricia', '', '', '', '', '', 0, NULL, NULL),
(2, 'Carolina', '', '', '', '', '', 0, NULL, NULL),
(3, 'Mateo', '9999', '', '', '', '[]', 0, NULL, '2025-06-23 18:25:05'),
(4, 'Sofia', '', '', '', '', '', 0, NULL, NULL),
(6, 'Marcia', '', '', '', '', '', 0, NULL, NULL),
(7, 'Juan Polvera', '', '', '', '', '', 0, NULL, NULL),
(8, 'Exafix', '', '', '', '', '', 0, NULL, NULL),
(10, 'Yasmani y Sheylan', '', '', '', '', '', 0, NULL, NULL),
(11, 'Claudia', '', '', '', '', '', 0, NULL, NULL),
(12, 'Elvis', '', '', '', '', '', 0, NULL, NULL),
(13, 'Juan Carlos Petit', '', '099244504', '', '', '', 0, NULL, NULL),
(15, 'Elsa', '', '094800635', '', '', '', 0, NULL, NULL),
(18, 'Gaby Nails', '', '', '', '', '', 0, NULL, NULL),
(19, 'George', '999', '', '', '', '[]', 0, NULL, '2025-06-25 12:49:46'),
(20, 'Nahuel', '999', '095653586', '', '', '[]', 0, NULL, '2025-06-25 21:58:09'),
(21, 'Porteño', '', '', '', '', '', 0, NULL, NULL),
(23, 'Sarkisian', '999', '099647878', 'Onix Sedan Chevrolet', 'SDC5513', '[\"68616c4a4954b-ec8da04c-8f1c-4e89-817d-2ee8617dcbcb.jpeg\"]', 0, NULL, '2025-06-29 11:39:38'),
(24, 'Eduardo', '', '095199525', 'Geely', 'SDF2678', '', 0, NULL, NULL),
(25, 'Cristian', '999', '099764804', 'Fiat Mobi', 'SCM1429', '[\"686169f9979da-d11edcdb-1fdd-4f05-b6d7-f13f31a62254.jpeg\"]', 0, NULL, '2025-06-29 11:29:58'),
(26, 'Corina', '999', '095277483', 'Hyundai i10', 'SBM1892', '[\"68616a3ac424b-2e9cf63d-46a6-4a7a-bc5d-442eb6d5d2e1.jpeg\"]', 0, NULL, '2025-06-29 11:30:50'),
(27, 'Alejandra ancheta', '', '095860816', 'Onix Hatch', 'SCS2773', '', 0, NULL, NULL),
(28, 'Walter', '', '097089289', 'Amarok', 'SCG3263', '', 0, NULL, NULL),
(29, 'Natacha Figueroa Porley', '999', '099415432', 'Golf', '', '[]', 0, NULL, '2025-06-25 21:43:44'),
(30, 'Martin Gbolo17', '999', '095308197', 'Fiat Ritmo', '', '[]', 0, NULL, '2025-06-25 21:14:14'),
(31, 'Gabriel Galain', '99', '0994052920', 'BMW', 'SDD8965', '[]', 0, NULL, '2025-06-24 20:52:10'),
(32, 'Lau / Fabian', '999', '096325786', 'Corsa', 'SBM6092', '[\"68616c7e5d71f-137de2bd-a6bd-4f1a-829a-33c2e4c3cd19.jpeg\"]', 0, NULL, '2025-06-29 11:40:30'),
(34, 'Martin', '999', '098669973', 'Moto', '', '[\"68616cb78c540-462f5238-71e5-41b5-9203-e01a5dab6dcc.jpeg\"]', 0, NULL, '2025-06-29 11:41:27'),
(35, 'Carlos Guerra', '', '094801410', '', '', '', 0, NULL, NULL),
(36, 'Marta Bueno', '999', '096576342', '', '', '[]', 0, NULL, '2025-06-25 21:33:43'),
(37, 'Alejandro', '', '098171789', 'Toyota', '', '', 0, NULL, NULL),
(38, 'Antonella', '', '095794847', 'Peugeot', '', '', 0, NULL, NULL),
(39, 'Edgardo', '', '', 'Camioneta', '', '', 0, NULL, NULL),
(41, 'Francisco', '', '', 'Ford Ka', '', '', 0, NULL, NULL),
(42, 'Valverde', '', '095856424', 'Ford Escort', '', '', 0, NULL, NULL),
(43, 'Raul Pérez', '', '', 'Jeep', '', '', 0, NULL, NULL),
(44, 'Cristina', '', '094106036', 'Suzuki', '', '', 0, NULL, NULL),
(47, 'Camila (inquilino lucho)', '', '', '', '', '[]', 1, '2025-06-09 19:55:22', '2025-06-09 19:57:58'),
(48, 'Guerrero A Alexis Joel', '', '', '', '', '[]', 1, '2025-06-10 07:54:11', NULL),
(49, 'Camila Perdomo (Magela Mendioroz Gtia)', '12383159', '092476991', '', '', '[\"6848ff672b302-CEDULA MAGELA DORSO.jpg\",\"6848ff672b4e0-CEDULA MAGELA FRENTE.jpg\",\"6848ff672b5e5-RECIBO DE SUELDO 04-2025.jpg\",\"6848ff672b745-RECIBOS DE SUELDO 1.jpg\",\"6848ff672b87e-RECIBOS DE SUELDO 05-2025.jpg\",\"6848ffa92fcf1-CEDULA MAGELA DORSO.jpg\",\"6848ffa92ff31-CEDULA MAGELA FRENTE.jpg\",\"6848ffa9300be-RECIBO DE SUELDO 04-2025.jpg\",\"6848ffa930217-RECIBOS DE SUELDO 1.jpg\",\"6848ffa93035a-RECIBOS DE SUELDO 05-2025.jpg\"]', 2, '2025-06-10 23:00:01', '2025-06-25 22:02:13'),
(50, 'Maria Viviana Perez Bandera', '38284692', '094477007', '', '', '[]', 2, '2025-06-11 00:05:35', NULL),
(51, 'Oscar Moreira', '9999', '099651973', 'BYD F3', 'SCL2011', '[]', 1, '2025-06-24 20:30:35', '2025-06-24 20:30:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE IF NOT EXISTS `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `periodo` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `mes` int(11) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_programada` date DEFAULT NULL,
  `fecha_recibido` date DEFAULT NULL,
  `concepto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_pago` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `importe` decimal(10,0) NOT NULL,
  `comentario` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `comprobante` text COLLATE utf8_unicode_ci,
  `pagado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `contrato_id`, `usuario_id`, `periodo`, `mes`, `anio`, `fecha`, `fecha_creacion`, `fecha_programada`, `fecha_recibido`, `concepto`, `tipo_pago`, `importe`, `comentario`, `comprobante`, `pagado`) VALUES
(1, 18, NULL, '2025-06', NULL, NULL, '2025-06-05', NULL, NULL, '2025-06-05', 'Pago mensual', 'Transferencia Papá', 3600, 'Agregar pago cochera bolo sarkisian 5/6 transf BROU', '68474c9a23c8d-pago sarkis brou.png', NULL),
(2, 23, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 4300, '', '6847731c7f0bb-IMG_1682.jpeg', NULL),
(3, 26, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 4200, 'Pago Gabriel galain', '6847772b46e78-IMG_1682.jpeg', NULL),
(4, 27, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 3600, 'Corsa', '68477956d15ba-IMG_1682.jpeg', NULL),
(5, 35, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Ford escort', '68477b15bfce3-IMG_1682.jpeg', NULL),
(20, 46, NULL, '2025-05', NULL, NULL, '2025-05-06', NULL, NULL, '2025-05-06', 'Pago mensual', 'Depósito Cuenta Lucho', 6500, '', '684782ed5dc57-074bb8cb-d22b-4923-9bfd-2d2fb8a2a798.jpeg', NULL),
(35, 47, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 32705, '', '68482b5dccada-RPMPagoJunio2025.pdf', NULL),
(36, 14, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 9100, '[10/6/25, 10:49:51] Viviana Pérez: Pago alquiler Local 41 GabyNails Este es el que hay que deducir que hacen con los gastos comunes... queda horrible preguntarle a la tipa si están incluidos o no en esos 9100, imagino quw si porque este local es de 2 x 1 metro, es el pasillo no?\n[10:51, 10/6/2025] Raulo: Si calculo q si\n[10:51, 10/6/2025] Raulo: Paga $2200 ese de gc\n[10:51, 10/6/2025] Raulo: En una galería de mierda\n[10:51, 10/6/2025] Raulo: Son $6800 de alquiler está bien', '6848425773709-8843f0ed-0cf3-4b88-87df-82c0100e6e50.jpeg', NULL),
(37, 5, NULL, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 9500, 'Vivi manda por wpp', '6848552446b85-SolLocal27Comprobante_TransferenciaEnElPais_09_06_2025_15_19.pdf', NULL),
(38, 2, NULL, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 7500, 'Vivi manda wpp', '6848557959f89-Local13SolTransferencia_a_terceros_2506090446475352.pdf', NULL),
(52, 48, NULL, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 31110, 'Quedó paga mensualidad alquiler garage Bolognese a Cristina di cándia', '684857bfbb38f-IMG_1696.png', NULL),
(53, 14, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Gastos comunes', 'Efectivo', 2500, 'Pagamos nosotros ', '68485b5c35111-70e89107-016f-4c7b-9af1-2482ad83019e.jpeg', NULL),
(66, 1, NULL, '2025-05', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Depósito Cuenta Papá', 12500, '', '684907bd7f784-Alquiler LOCAL 10 del SOL de Mayo.jpg', NULL),
(80, 50, NULL, '2025-05', NULL, NULL, '2025-06-11', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 32154, '$ 18 Abril + $ 18 Mayo - $ 3.846 Contribucion Inmobiliaria = $ 32.154.- para quedar al dia', '68490f58e6cf6-PAGO ALQUILER ABRIL Y MAYO 2025 IMPRENTA.jpg', NULL),
(81, 8, NULL, '2025-05', NULL, NULL, '2025-06-11', NULL, NULL, NULL, 'Pago mensual', 'Efectivo', 9000, 'Sub contrato nuevo inquilino', '6849e3976dae7-PagoLocal35GalAmericas.jpeg', NULL),
(82, 19, NULL, '2025-06', NULL, NULL, '2025-06-14', NULL, NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 3600, 'Raúl avisa por wpp ', '684e14365a2aa-IMG_1737.jpeg', NULL),
(83, 36, NULL, '2025-06', NULL, NULL, '2025-06-15', NULL, NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Avisa Raúl por wpp', '684ee64835229-IMG_1742.jpeg', NULL),
(84, 15, NULL, '2025-06', NULL, NULL, '2025-06-16', NULL, NULL, NULL, 'Pago mensual', 'Depósito', 40000, 'Raúl avisa por wpp, mes que viene cambia de precio ', '6850186789beb-e4c82e64-cb85-444a-b2aa-5278e21c5a1d.jpeg', NULL),
(85, 7, NULL, '2025-06', NULL, NULL, '2025-06-16', NULL, NULL, NULL, 'Pago mensual', 'Efectivo', 8000, 'Avisa raul wpp ', '685047acb2b1b-IMG_1749.jpeg', NULL),
(86, 1, NULL, '2025-06', NULL, NULL, '2025-06-16', NULL, NULL, NULL, 'Pago mensual', 'Depósito Cuenta Papá', 5384, 'Local 10 del Sol pago esto que es el saldo del mes, HOY ENTREGA LA LLAVE, pago todos los impuestos y este saldito. Ya di de baja el adicional mercantil que papa me pidió, hay que recibirlo, inspeccionarlo, sacarle fotos y ponerlo a alquilar nuevamente', '68505f7da1c1c-IMG_1750.png', NULL),
(87, 46, NULL, '2025-06', NULL, NULL, '2025-06-21', NULL, NULL, NULL, 'Pago mensual', 'Depósito Cuenta Lucho', 500, 'Paga 500 alquiler porque descontamos 6000 del techo. Y agregó 3315 de impuestos que pagué yo de mi cuenta que tenía atrasado.', '6856be0a98368-aae4bd2c-731d-4ec5-a1a9-20ffc18074c6.jpeg', NULL),
(88, 46, NULL, '2025-06', NULL, NULL, '2025-06-21', NULL, NULL, NULL, 'Impuestos', 'Depósito Cuenta Lucho', 3400, 'Paga 500 alquiler porque descontamos 6000 del techo. Y agregó 3315 de impuestos que pagué yo de mi cuenta que tenía atrasado.', '6856be48a5836-aae4bd2c-731d-4ec5-a1a9-20ffc18074c6.jpeg', NULL),
(89, 6, NULL, '2025-06', NULL, NULL, '2025-06-23', NULL, NULL, NULL, 'Pago mensual', 'Efectivo', 7500, 'Avisa Raúl wpp ', '6859f76a33043-IMG_1847.png', NULL),
(90, 51, NULL, '2025-06', NULL, NULL, '2025-06-13', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3600, 'Avisa Raúl por wpp lo encontró en persona ', '685b52041b61b-a25bc35a-aacb-4378-b953-9e3fc9d6950a.jpeg', NULL),
(91, 34, NULL, '2025-06', NULL, NULL, '2025-06-06', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 2600, '', '685b56f19e902-02183c38-bf26-4b38-87e8-cd795edc15fe.jpeg', NULL),
(92, 29, NULL, '2025-06', NULL, NULL, '2025-06-02', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 6200, 'Revisamos celu papá 25/6', '685ca8f7b937c-0b8e5648-31e8-4be0-af4e-823e55a3bfe8.jpeg', NULL),
(93, 28, NULL, '2025-04', NULL, NULL, '2025-05-07', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 1500, 'En mayo pago abril y mayo atrasado ', '685caa5dc21d7-040422c8-e50e-43f3-aae9-0e2d47c79654.jpeg', NULL),
(94, 28, NULL, '2025-05', NULL, NULL, '2025-05-07', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 1500, 'Pago atrasado abril y mayo el 7 de mayo ', '685caa9debdfc-040422c8-e50e-43f3-aae9-0e2d47c79654.jpeg', NULL),
(95, 25, NULL, '2025-06', NULL, NULL, '2025-06-05', NULL, NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Barcode 28287336', '685cacc7587ab-b9abe3a6-5c19-4512-b8cd-161f800cb7b5.jpeg', NULL),
(96, 30, NULL, '2025-05', NULL, NULL, '2025-06-07', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 5500, 'Se hizo cargo del alquiler Marta Bueno ', '685cb230a719c-ae2c1aff-0864-418b-a87a-a30797d19987.jpeg', NULL),
(97, 24, NULL, '2025-06', NULL, NULL, '2025-06-03', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3600, 'Pago por anda transferencia ', '685cb3c2079f8-ab52fcb7-8b16-4f04-a64b-86c7b3ca4676.jpeg', NULL),
(98, 22, NULL, '2025-06', NULL, NULL, '2025-06-12', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3500, 'Deja el garage en julio ', '685cb47f9d35f-b85961b3-2a88-4968-83ae-12290b543cf8.jpeg', NULL),
(99, 21, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3200, '', '685cb52a99cfe-40f5fc08-3364-4b74-bd3c-7dd707a5f433.jpeg', NULL),
(100, 20, NULL, '2025-06', NULL, NULL, '2025-06-05', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3400, 'Aviso a papá transferencia ', '685cb590802ba-e9c01f1b-0295-42df-a989-3454a30e2f83.jpeg', NULL),
(101, 29, 1, '2025-07', NULL, NULL, '2025-07-01', '2025-07-01 07:52:37', NULL, NULL, 'Pago mensual', 'Transferencia', 6200, 'Transfiere a cuenta nuestra', '6863da1522f10-5f135faa-fafb-46ff-b8f8-087bfe812350.jpeg', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

CREATE TABLE IF NOT EXISTS `propiedades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `galeria` text COLLATE utf8_unicode_ci,
  `local` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `incluye_gc` tinyint(1) DEFAULT NULL,
  `gastos_comunes` decimal(10,2) DEFAULT NULL,
  `estado` enum('alquilado','libre','en venta','uso propio') COLLATE utf8_unicode_ci DEFAULT NULL,
  `propietario_id` int(11) DEFAULT NULL,
  `anep` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ose` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ute` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `padron` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribucion_inmobiliaria` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imm_tasa_general` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imm_tarifa_saneamiento` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imm_instalaciones` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imm_adicional_mercantil` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `convenios` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comentarios` text COLLATE utf8_unicode_ci,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `imagenes` text COLLATE utf8_unicode_ci NOT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id`, `nombre`, `tipo`, `direccion`, `galeria`, `local`, `precio`, `incluye_gc`, `gastos_comunes`, `estado`, `propietario_id`, `anep`, `ose`, `ute`, `padron`, `contribucion_inmobiliaria`, `imm_tasa_general`, `imm_tarifa_saneamiento`, `imm_instalaciones`, `imm_adicional_mercantil`, `convenios`, `comentarios`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`, `imagenes`, `documentos`) VALUES
(1, 'Galeria del Sol Local 10', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 10', 9000.00, 0, 0.00, 'libre', 1, '', '', '', '', '0.00', '', '', '', '', '', 'alquilado a Patricia en $9000\r\nhttps://inmueble.mercadolibre.com.uy/MLU-713447896-alquilo-excelente-local-en-galeria-del-sol-l-17-_JM', 1, NULL, '2025-06-29 10:24:41', '[]', '[]'),
(2, 'Galeria del Sol Local 13', 'Local', 'Convencion 1328 / 18 de Julio 918', 'Galeria del Sol', 'Local 13', 7500.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '0.00', '', '', '', '', '', 'solo dice Carolina $7500 mas gastos comunes. por otro lado aprovecho para comentarte lo siguiente: yo estuve comentándole a Raul que la empresa no tuvo andamiento, por lo tanto no estoy yendo al local, se me esta dificultando poder pagar el alquiler, hay alguna forma de poder rescindir el contrato aunque sea pagando multa?\r\ntambien podria ser traspaso del alquiler, pero yo no consigo alguien que quiera alquilar, si ustedes saben de alguien o si lo publican y esto les lleva gastos de comision o los que sea yo me hago cargo de los mismos. Te agradezco tu ayuda. Saludos. Carolina. https://inmueble.mercadolibre.com.uy/MLU-760923170-alquilo-local-chico-en-galeria-del-sol-local-13-_JM', 1, NULL, '2025-06-29 10:20:54', '[]', '[]'),
(3, 'Galeria del Sol Local 18', 'Local', 'Convencion 1328 / 18 de Julio 918', 'Galeria del Sol', 'Local 18', 7500.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'Local &quot;Libre&quot; $7500 mas gastos comunes', 1, NULL, '2025-06-23 18:25:35', '[]', '[]'),
(4, 'Galeria del Sol Local 21', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 21', 12100.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'Alquilado a \"Sofia\" en $12100 gastos comunes incluidos', 0, NULL, NULL, '', ''),
(5, 'Galeria del Sol Local 23', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 23', 9000.00, 0, 0.00, 'libre', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'Local Libre $9000 mas gastos comunes tiene agua e instalacion de peluqueria. \r\n\r\nArmado para peluquería $ 11.000.- y sin las cosas $ 9.000.- seria\r\n\r\nhttps://inmueble.mercadolibre.com.uy/MLU-711075574-alquilo-local-en-galeria-del-sol-l-23-_JM', 1, NULL, '2025-06-19 07:37:08', '[]', '[]'),
(6, 'Galeria del Sol Local 27', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 27', 9500.00, 0, 4110.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'Alquilado a \"Marcia\" , garantia de porto $9500 mas $4110 de gastos counes  mas impuestos', 0, NULL, NULL, '', ''),
(7, 'Galeria de las Americas Local 5', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 5', 7500.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'alquilado juan polvora ( el tatuador) alquiler $7500 lo paga efectivo en mi local a mes vencido mas gastos comunes', 0, NULL, NULL, '', ''),
(8, 'Galeria de las Americas Local 10', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 10', 8000.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'alqulado EXAFIX sin garantia contrato de palabra con raulito alquiler $8000 paga efectivo en mi local paga a mes corriente , mas gastos comunes e impuestos', 0, NULL, NULL, '', ''),
(9, 'Galeria de las Americas Local 31B ', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 31B ', 6500.00, 0, 0.00, 'libre', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'esta libre , es un local chiquito que papa dividio su oficina y lo alquila $6500 luz y gastos comunes incluidos', 0, NULL, NULL, '', ''),
(10, 'Galeria de las Americas Local 35', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 35', 9000.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'alquilado a Yasmani y Sheylan alquiler $9000 mas gastos comunes e impuestos', 1, NULL, '2025-06-11 15:21:02', '[\"6849e52e875cf.png\"]', ''),
(11, 'Galeria de las Americas Local 103', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 103', 11000.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'alquilado a \"Claudia\" $11000 mas gastos comunes e impuestos garantia ANDA y anda deposita en cta brou de papa', 0, NULL, NULL, '', ''),
(12, 'Galeria de las Americas Local 105', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 105', 6500.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'alquilado a Elvis en $6500 mas gastos comunes ,deposita a papa en BROU', 0, NULL, NULL, '', ''),
(13, 'Galeria de las Americas Local 106', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 106', 7862.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'alquilado a Juan Carlos Petit tel 099244504 en $7862', 0, NULL, NULL, '', ''),
(15, 'Galeria Cristal Local 39', 'Local', 'Galeria Cristal', 'Galeria Cristal', 'Local 39', 7000.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '0.00', '', '', '', '', '', 'alquilado a &quot;Elsa&quot; 094800635 $7000', 1, NULL, '2025-06-28 09:07:03', '[\"685ff7076b568.jpeg\",\"685ff7076b99f.jpeg\"]', '[]'),
(16, 'Local Figueroa Local 6', 'Local', 'Local Figueroa', '', 'Local 6', 0.00, 0, 0.00, 'libre', 6, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'es el local 6 esta vacio es de Marta', 1, NULL, '2025-06-18 09:17:23', '[\"6852ca735d737.jpeg\",\"6852ca735da07.jpeg\",\"6852ca735db92.jpeg\",\"6852ca735dcd7.jpeg\",\"6852ca735de4d.jpeg\",\"6852ca735dfd9.jpeg\",\"6852ca735e154.jpeg\",\"6852ca735e2ab.jpeg\",\"6852ca735e439.jpeg\",\"6852ca735e5dc.jpeg\",\"6852ca735e71d.jpeg\",\"6852ca735e89e.jpeg\",\"6852ca735ea5d.jpeg\",\"6852ca735ec34.jpeg\",\"6852ca735ee44.jpeg\"]', '[]'),
(17, 'Galeria Entrevero Local 7 / 8', 'Local', '18 de Julio 1020 Galeria Entrevero', 'Galeria Entrevero', 'Local 7 / 8', 10000.00, 0, 4400.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 1, NULL, '2025-06-23 16:55:09', '[\"684901da10d77.jpeg\",\"684901da1100e.jpeg\",\"684901da11198.jpeg\",\"684901da112d2.jpeg\",\"684901da113e1.jpeg\",\"684901da115c2.jpeg\"]', '[]'),
(18, 'Galeria Entrevero Local 41', 'Local', 'Galeria Entrevero', 'Galeria Entrevero', 'Local 41', 9100.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'alquilado a \"nails\" ', 0, NULL, NULL, '', ''),
(19, 'Local Rondeau', 'Local', 'Local Rondeau', '', 'Local Rondeau', 40000.00, 0, 0.00, 'alquilado', 2, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'Local a medias C/ R Jr , el inquilino paga $40.000 a cta a medias', 1, NULL, '2025-06-16 08:11:48', '[]', '[]'),
(20, 'Villa Serrana', 'Apartamento', 'Villa Serrana', '', 'Villa Serrana', 12000.00, 0, 0.00, 'alquilado', 2, '', '', '', '', '0.00', '', '', '', '', '', 'casa a medias c/R Jr actualmente alquilada a punto de terminar contrato paga $12000 deposita en cuenta a medias', 1, NULL, '2025-06-25 22:11:37', '[]', '[]'),
(21, 'Apto 116B PDE', 'Apartamento', 'Apto 116B PDE', '', 'Apto 116B PDE', 0.00, 0, 0.00, 'alquilado', 2, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'local a medias c/ R Jr actualmente alquilado a \"porte?o\"\" tiene una deuda congelada q paga el titulas y el alquiler lo paga el \"inquilino\" mes a mes', 0, NULL, NULL, '', ''),
(22, 'Apto Galeria Caracol', 'Apartamento', 'Apto Galeria Caracol', 'Galeria Caracol', 'Apto Galeria Caracol', 0.00, 0, 0.00, 'en venta', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, ' es de uso propio ', 0, NULL, NULL, '', ''),
(23, 'Bolo 01', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '0.00', '', '', '', '', '', '', 1, NULL, '2025-06-30 21:22:09', '[]', '[]'),
(24, 'Bolo 02', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(25, 'Bolo 03', 'Cochera', 'Bolo', '', '', 3400.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(26, 'Bolo 04', 'Cochera', 'Bolo', '', '', 3200.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(27, 'Bolo 05', 'Cochera', 'Bolo', '', '', 3400.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(28, 'Bolo 06', 'Cochera', 'Bolo', '', '', 4300.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(29, 'Bolo 07', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(30, 'Bolo 08', 'Cochera', 'Bolo', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(31, 'Bolo 09', 'Cochera', 'Bolo', '', '', 4200.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(32, 'Bolo 10', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(33, 'Bolo Apto', 'Apartamento', 'Bolo', '', 'Apartamento', 0.00, 0, 0.00, 'libre', 1, '', '', '', '', '0.00', '', '', '', '', '', 'https://apartamento.mercadolibre.com.uy/MLU-760936286-alquilo-apartamento-en-el-interior-de-un-garage-_JM', 1, NULL, '2025-06-29 10:22:36', '[]', '[]'),
(34, 'Bolo Moto', 'Cochera', 'Bolo', '', '', 1500.00, 0, 0.00, 'alquilado', 1, '7/5 brou', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(35, 'Deposito GA', 'Deposito', 'Galeria de las Americas', 'Galeria de las Americas', 'D1', 6200.00, 0, 0.00, 'alquilado', 1, '2/5 brou', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(36, 'Tmal Torre Maldonado Local 30', 'Local', 'Torre Maldonado', 'Terminal', 'Local 030', 5500.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '0.00', '', '', '', '', '', 'alquilado a Mariana 094511313 , garantia de porto $5500 gastos comunes inlcuidos pq son muy baratos paga en brou a papa', 1, NULL, '2025-06-26 20:32:30', '[]', '[]'),
(37, 'dc2', 'Cochera', 'Dionisio Coronel', '', '', 2400.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(38, 'dc3', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'libre', 1, '', '', '', '', '0.00', '', '', '', '', '', '', 1, NULL, '2025-06-24 20:50:01', '[]', '[]'),
(39, 'dc4', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '13/5 sob', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(40, 'dc5', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'libre', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(41, 'dc6', 'Cochera', 'Dionisio Coronel', '', '', 2600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(42, 'dc7', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '7/5 sob', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(43, 'dc9', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'uso propio', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(44, 'dc10', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '13/5 sob', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, '', ''),
(48, 'Elysee local 11 Lucho', 'Local', 'San Jose 1029 Local 11 Elysee', 'Elysee', '11', 6500.00, 0, 0.00, 'alquilado', 3, '', '', '', '', '2036342', '659818', '', '', '', '', 'Tributos domiciliarios Tasa General cuenta 659818\r\nContribución inmobiliaria cuenta 2036342', 1, '2025-06-09 19:35:42', '2025-06-30 16:37:18', '[\"6852c9dc08424.jpeg\"]', '[\"doc_684ae16402f5f.jpeg\",\"doc_684ae16403bf5.jpeg\"]'),
(49, 'Ruperto Pérez Martínez', 'Apartamento', 'Ruperto perez martinez 547', '', '', 32705.00, 0, 0.00, 'alquilado', 1, '2675931', '', '', '', '0.00', '', '', '', '', '', '', 1, '2025-06-10 07:53:27', '2025-06-30 17:14:31', '[\"68630c4703719.jpeg\"]', '[]'),
(50, 'Bolognese Local Completo', 'Cochera', 'Bolognese', '', '', 31110.00, 0, 0.00, 'alquilado', 5, '', '', '', '', '0.00', '', '', '', '', '', 'Esto lo alquilamos a Cristina Di Candia (propietaria)… se le hace pago mensual', 1, '2025-06-10 11:04:11', '2025-06-27 10:24:22', '[]', '[\"doc_685eae251de80.png\"]'),
(51, 'Imprenta', 'Local', 'Cerrito 564', '', '', 18000.00, 1, 0.00, 'alquilado', 1, '6373802', '', '', '', '228933.00', '', '', '', '', '', 'DEL PRECIO DEL ALQUILER SE DESCUENTA ANEP Y CONTRIBUCION.\r\nPADRÓN N° 3350', 1, '2025-06-11 00:04:37', '2025-06-27 17:02:57', '[]', '[]'),
(52, 'Bolo 11', 'Cochera', 'Bolognese', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '', '', '', '', '', '', '', 1, '2025-06-24 20:29:55', NULL, '[]', '[]'),
(53, 'Solanas', 'Apartamento', 'Solanas', '', '', 1.00, 0, 0.00, 'libre', 1, '', '', '', '', '', '', '', '', '', '', 'Averiguar', 1, '2025-06-26 10:01:55', NULL, '[]', '[]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietarios`
--

CREATE TABLE IF NOT EXISTS `propietarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `propietarios`
--

INSERT INTO `propietarios` (`id`, `nombre`) VALUES
(1, 'Raul Pérez (de todos)'),
(2, 'Raúl Padre y Raúl Hijo'),
(3, 'Luis Pérez'),
(4, 'Viviana Pérez'),
(5, 'Cristina Di Candia'),
(6, 'Marta Batista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rol` enum('admin','usuario_normal') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `rol`) VALUES
(1, 'adminlucho', '$2y$10$abyePc/p1B5wCEkBuT9ZJOG5lZRffcq7f5lLuFkz.ZOgTZxsA1yz.', 'admin'),
(2, 'viviana', '$2y$10$VJ8yHOKEasfsI4E/m.XvUe5MO0gs0CNOKXKhBLejM3xf56X.7weem', 'usuario_normal'),
(3, 'raul', '$2y$10$.hTmdLZ5ZPBO2ZTD97oU9OXgaG2iuIsUZ6r.pC83AsKcaEsX4yVRy', 'usuario_normal'),
(4, 'raulpadre', '$2y$10$ImNsi8D704BAkg5NKSn5iusnEhY4/C7I18Ut0ngFzKP.JGO9OoZcm', 'usuario_normal');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
