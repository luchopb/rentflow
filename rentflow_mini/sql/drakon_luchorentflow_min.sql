-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 15-06-2025 a las 15:55:05
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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `inquilino_id`, `propiedad_id`, `fecha_inicio`, `fecha_fin`, `importe`, `garantia`, `corredor`, `estado`, `documentos`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 1, 1, '2025-01-01', '2026-02-01', 9000.00, '0', '0', 'activo', '[\"684e1726ae786-Local10Sol Documentos P\\u00f3liza GA091654.pdf\"]', 0, NULL, NULL),
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
(12, 14, 14, '2025-01-01', '2026-02-01', 5500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(13, 15, 15, '2025-01-01', '2026-02-01', 7000.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(14, 18, 18, '2025-01-01', '2026-02-01', 9100.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(15, 19, 19, '2025-01-01', '2026-02-01', 1.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(16, 20, 20, '2025-01-01', '2026-02-01', 1.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(17, 21, 21, '2025-01-01', '2026-02-01', 1.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(18, 23, 23, '2025-01-01', '2026-02-01', 1.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
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
(32, 38, 38, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(33, 39, 39, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(34, 41, 41, '2025-01-01', '2026-02-01', 2600.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(35, 42, 42, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(36, 44, 44, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(46, 47, 48, '2025-05-01', '2026-06-09', 6500.00, '0', '0', 'activo', '[]', 0, NULL, NULL),
(47, 48, 49, '2025-05-01', '2026-06-10', 32705.00, '0', '0', 'activo', '[]', 0, NULL, NULL),
(48, 43, 50, '2025-06-10', '2026-06-10', 31110.00, '0', '0', 'activo', '[]', 0, NULL, NULL),
(49, 49, 17, '2025-06-01', '2026-05-31', 10000.00, '0', '0', 'activo', '[\"68490081c96b4-POLIZA CONTRATO MAGELA MENDIOROZ LOCAL 7y8 Galeria del Entrevero 01-06-2025 GA109636.pdf\",\"68490081c99b4-CONTRATO ALQUILER FIRMADO LOCAL 7 y 8 Galeria del Entrevero 01-06-2025.pdf\"]', 0, NULL, NULL),
(50, 50, 51, '2025-06-11', '2026-06-11', 18000.00, '0', '0', 'activo', '[]', 0, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `inquilinos`
--

INSERT INTO `inquilinos` (`id`, `nombre`, `cedula`, `telefono`, `vehiculo`, `matricula`, `documentos`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Patricia', '', '', '', '', '', 0, NULL, NULL),
(2, 'Carolina', '', '', '', '', '', 0, NULL, NULL),
(3, 'Inquilino 3', '', '', '', '', '', 0, NULL, NULL),
(4, 'Sofia', '', '', '', '', '', 0, NULL, NULL),
(6, 'Marcia', '', '', '', '', '', 0, NULL, NULL),
(7, 'Juan Polvera', '', '', '', '', '', 0, NULL, NULL),
(8, 'Exafix', '', '', '', '', '', 0, NULL, NULL),
(10, 'Yasmani y Sheylan', '', '', '', '', '', 0, NULL, NULL),
(11, 'Claudia', '', '', '', '', '', 0, NULL, NULL),
(12, 'Elvis', '', '', '', '', '', 0, NULL, NULL),
(13, 'Juan Carlos Petit', '', '099244504', '', '', '', 0, NULL, NULL),
(14, 'Mariana', '', '094511313', '', '', '', 0, NULL, NULL),
(15, 'Elsa', '', '094800635', '', '', '', 0, NULL, NULL),
(18, 'Gaby Nails', '', '', '', '', '', 0, NULL, NULL),
(19, 'Inquilino 1', '', '', '', '', '', 0, NULL, NULL),
(20, 'Inquilino 2', '', '', '', '', '', 0, NULL, NULL),
(21, 'Porteño', '', '', '', '', '', 0, NULL, NULL),
(23, 'Sarkisian', '', '099647878', 'Onix Sedan', 'SDC5513', '', 0, NULL, NULL),
(24, 'Eduardo', '', '095199525', 'Geely', 'SDF2678', '', 0, NULL, NULL),
(25, 'Cristian', '', '099764804', 'Fiat Mobi', '', '', 0, NULL, NULL),
(26, 'Corina', '', '095277483', 'Hyundai i10', 'SBM1892', '', 0, NULL, NULL),
(27, 'Alejandra ancheta', '', '095860816', 'Onix Hatch', 'SCS2773', '', 0, NULL, NULL),
(28, 'Walter', '', '097089289', 'Amarok', 'SCG3263', '', 0, NULL, NULL),
(29, 'Natacha', '', '099415432', 'Golf', '', '', 0, NULL, NULL),
(30, 'Martin', '', '095308197', 'Fiat Ritmo', '', '', 0, NULL, NULL),
(31, 'Gabriel', '', '0994052920', 'BMW', 'SDD8965', '', 0, NULL, NULL),
(32, 'Lau / Fabian', '', '096325786', 'Corsa', 'SBM6092', '', 0, NULL, NULL),
(34, 'Martin', '', '098669973', 'Moto', '', '', 0, NULL, NULL),
(35, 'Carlos Guerra', '', '094801410', '', '', '', 0, NULL, NULL),
(36, 'mariana', '', '094511313', '', '', '', 0, NULL, NULL),
(37, 'Alejandro', '', '098171789', 'Toyota', '', '', 0, NULL, NULL),
(38, 'Antonella', '', '095794847', 'Peugeot', '', '', 0, NULL, NULL),
(39, 'Edgardo', '', '', 'Camioneta', '', '', 0, NULL, NULL),
(41, 'Francisco', '', '', 'Ford Ka', '', '', 0, NULL, NULL),
(42, 'Valverde', '', '095856424', 'Ford Escort', '', '', 0, NULL, NULL),
(43, 'Raul Pérez', '', '', 'Jeep', '', '', 0, NULL, NULL),
(44, 'Cristina', '', '094106036', 'Suzuki', '', '', 0, NULL, NULL),
(47, 'Camila (inquilino lucho)', '', '', '', '', '[]', 1, '2025-06-09 19:55:22', '2025-06-09 19:57:58'),
(48, 'Guerrero A Alexis Joel', '', '', '', '', '[]', 1, '2025-06-10 07:54:11', NULL),
(49, 'Magela Mendioroz', '12383159', '099609630', '', '', '[\"6848ff672b302-CEDULA MAGELA DORSO.jpg\",\"6848ff672b4e0-CEDULA MAGELA FRENTE.jpg\",\"6848ff672b5e5-RECIBO DE SUELDO 04-2025.jpg\",\"6848ff672b745-RECIBOS DE SUELDO 1.jpg\",\"6848ff672b87e-RECIBOS DE SUELDO 05-2025.jpg\",\"6848ffa92fcf1-CEDULA MAGELA DORSO.jpg\",\"6848ffa92ff31-CEDULA MAGELA FRENTE.jpg\",\"6848ffa9300be-RECIBO DE SUELDO 04-2025.jpg\",\"6848ffa930217-RECIBOS DE SUELDO 1.jpg\",\"6848ffa93035a-RECIBOS DE SUELDO 05-2025.jpg\"]', 2, '2025-06-10 23:00:01', '2025-06-11 14:12:09'),
(50, 'Maria Viviana Perez Bandera', '38284692', '094477007', '', '', '[]', 2, '2025-06-11 00:05:35', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE IF NOT EXISTS `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_id` int(11) DEFAULT NULL,
  `periodo` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `mes` int(11) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_programada` date DEFAULT NULL,
  `fecha_recibido` date DEFAULT NULL,
  `concepto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  `comentario` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `comprobante` text COLLATE utf8_unicode_ci,
  `pagado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `contrato_id`, `periodo`, `mes`, `anio`, `fecha`, `fecha_programada`, `fecha_recibido`, `concepto`, `importe`, `comentario`, `comprobante`, `pagado`) VALUES
(1, 18, '2025-06', NULL, NULL, '2025-06-05', NULL, '2025-06-05', 'Pago mensual', 1, 'Agregar pago cochera bolo sarkisian 5/6 transf BROU', '68474c9a23c8d-pago sarkis brou.png', NULL),
(2, 23, '2025-06', NULL, NULL, '2025-06-08', NULL, '2025-06-08', 'Pago mensual', 4300, '', '6847731c7f0bb-IMG_1682.jpeg', NULL),
(3, 26, '2025-06', NULL, NULL, '2025-06-08', NULL, '2025-06-08', 'Pago mensual', 4200, 'Pago Gabriel galain', '6847772b46e78-IMG_1682.jpeg', NULL),
(4, 27, '2025-06', NULL, NULL, '2025-06-08', NULL, '2025-06-08', 'Pago mensual', 3600, 'Corsa', '68477956d15ba-IMG_1682.jpeg', NULL),
(5, 35, '2025-06', NULL, NULL, '2025-06-08', NULL, '2025-06-08', 'Pago mensual', 2500, 'Ford escort', '68477b15bfce3-IMG_1682.jpeg', NULL),
(6, 46, '2025-05', 5, 2025, '2025-05-01', '2025-05-01', NULL, 'Debe', -6500, '', NULL, 0),
(7, 46, '2025-06', 6, 2025, '2025-06-01', '2025-06-01', NULL, 'Debe', -6500, '', NULL, 0),
(8, 46, '2025-07', 7, 2025, '2025-07-01', '2025-07-01', NULL, 'Debe', -6500, '', NULL, 0),
(9, 46, '2025-08', 8, 2025, '2025-08-01', '2025-08-01', NULL, 'Debe', -6500, '', NULL, 0),
(10, 46, '2025-09', 9, 2025, '2025-09-01', '2025-09-01', NULL, 'Debe', -6500, '', NULL, 0),
(11, 46, '2025-10', 10, 2025, '2025-10-01', '2025-10-01', NULL, 'Debe', -6500, '', NULL, 0),
(12, 46, '2025-11', 11, 2025, '2025-11-01', '2025-11-01', NULL, 'Debe', -6500, '', NULL, 0),
(13, 46, '2025-12', 12, 2025, '2025-12-01', '2025-12-01', NULL, 'Debe', -6500, '', NULL, 0),
(14, 46, '2026-01', 1, 2026, '2026-01-01', '2026-01-01', NULL, 'Debe', -6500, '', NULL, 0),
(15, 46, '2026-02', 2, 2026, '2026-02-01', '2026-02-01', NULL, 'Debe', -6500, '', NULL, 0),
(16, 46, '2026-03', 3, 2026, '2026-03-01', '2026-03-01', NULL, 'Debe', -6500, '', NULL, 0),
(17, 46, '2026-04', 4, 2026, '2026-04-01', '2026-04-01', NULL, 'Debe', -6500, '', NULL, 0),
(18, 46, '2026-05', 5, 2026, '2026-05-01', '2026-05-01', NULL, 'Debe', -6500, '', NULL, 0),
(19, 46, '2026-06', 6, 2026, '2026-06-01', '2026-06-01', NULL, 'Debe', -6500, '', NULL, 0),
(20, 46, '2025-05', NULL, NULL, '2025-05-06', NULL, '2025-05-06', 'Pago mensual', 6500, '', '684782ed5dc57-074bb8cb-d22b-4923-9bfd-2d2fb8a2a798.jpeg', NULL),
(21, 47, '2025-05', 5, 2025, '2025-05-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(22, 47, '2025-06', 6, 2025, '2025-06-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(23, 47, '2025-07', 7, 2025, '2025-07-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(24, 47, '2025-08', 8, 2025, '2025-08-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(25, 47, '2025-09', 9, 2025, '2025-09-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(26, 47, '2025-10', 10, 2025, '2025-10-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(27, 47, '2025-11', 11, 2025, '2025-11-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(28, 47, '2025-12', 12, 2025, '2025-12-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(29, 47, '2026-01', 1, 2026, '2026-01-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(30, 47, '2026-02', 2, 2026, '2026-02-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(31, 47, '2026-03', 3, 2026, '2026-03-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(32, 47, '2026-04', 4, 2026, '2026-04-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(33, 47, '2026-05', 5, 2026, '2026-05-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(34, 47, '2026-06', 6, 2026, '2026-06-01', NULL, NULL, 'Debe', -32705, '', NULL, 0),
(35, 47, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, 'Pago mensual', 32705, '', '68482b5dccada-RPMPagoJunio2025.pdf', NULL),
(36, 14, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, 'Pago mensual', 9100, '[10/6/25, 10:49:51] Viviana Pérez: Pago alquiler Local 41 GabyNails Este es el que hay que deducir que hacen con los gastos comunes... queda horrible preguntarle a la tipa si están incluidos o no en esos 9100, imagino quw si porque este local es de 2 x 1 metro, es el pasillo no?\n[10:51, 10/6/2025] Raulo: Si calculo q si\n[10:51, 10/6/2025] Raulo: Paga $2200 ese de gc\n[10:51, 10/6/2025] Raulo: En una galería de mierda\n[10:51, 10/6/2025] Raulo: Son $6800 de alquiler está bien', '6848425773709-8843f0ed-0cf3-4b88-87df-82c0100e6e50.jpeg', NULL),
(37, 5, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, 'Pago mensual', 9500, 'Vivi manda por wpp', '6848552446b85-SolLocal27Comprobante_TransferenciaEnElPais_09_06_2025_15_19.pdf', NULL),
(38, 2, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, 'Pago mensual', 7500, 'Vivi manda wpp', '6848557959f89-Local13SolTransferencia_a_terceros_2506090446475352.pdf', NULL),
(39, 48, '2025-06', 6, 2025, '2025-06-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(40, 48, '2025-07', 7, 2025, '2025-07-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(41, 48, '2025-08', 8, 2025, '2025-08-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(42, 48, '2025-09', 9, 2025, '2025-09-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(43, 48, '2025-10', 10, 2025, '2025-10-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(44, 48, '2025-11', 11, 2025, '2025-11-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(45, 48, '2025-12', 12, 2025, '2025-12-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(46, 48, '2026-01', 1, 2026, '2026-01-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(47, 48, '2026-02', 2, 2026, '2026-02-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(48, 48, '2026-03', 3, 2026, '2026-03-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(49, 48, '2026-04', 4, 2026, '2026-04-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(50, 48, '2026-05', 5, 2026, '2026-05-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(51, 48, '2026-06', 6, 2026, '2026-06-01', NULL, NULL, 'Debe', -31110, '', NULL, 0),
(52, 48, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, 'Pago mensual', 31110, 'Quedó paga mensualidad alquiler garage Bolognese a Cristina di cándia', '684857bfbb38f-IMG_1696.png', NULL),
(53, 14, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, 'Gastos comunes', 2500, 'Pagamos nosotros ', '68485b5c35111-70e89107-016f-4c7b-9af1-2482ad83019e.jpeg', NULL),
(54, 49, '2025-06', 6, 2025, '2025-06-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(55, 49, '2025-07', 7, 2025, '2025-07-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(56, 49, '2025-08', 8, 2025, '2025-08-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(57, 49, '2025-09', 9, 2025, '2025-09-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(58, 49, '2025-10', 10, 2025, '2025-10-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(59, 49, '2025-11', 11, 2025, '2025-11-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(60, 49, '2025-12', 12, 2025, '2025-12-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(61, 49, '2026-01', 1, 2026, '2026-01-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(62, 49, '2026-02', 2, 2026, '2026-02-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(63, 49, '2026-03', 3, 2026, '2026-03-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(64, 49, '2026-04', 4, 2026, '2026-04-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(65, 49, '2026-05', 5, 2026, '2026-05-01', NULL, NULL, 'Debe', -10000, '', NULL, 0),
(66, 1, '2025-05', NULL, NULL, '2025-06-09', NULL, NULL, 'Pago mensual', 12500, '', '684907bd7f784-Alquiler LOCAL 10 del SOL de Mayo.jpg', NULL),
(67, 50, '2025-06', 6, 2025, '2025-06-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(68, 50, '2025-07', 7, 2025, '2025-07-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(69, 50, '2025-08', 8, 2025, '2025-08-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(70, 50, '2025-09', 9, 2025, '2025-09-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(71, 50, '2025-10', 10, 2025, '2025-10-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(72, 50, '2025-11', 11, 2025, '2025-11-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(73, 50, '2025-12', 12, 2025, '2025-12-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(74, 50, '2026-01', 1, 2026, '2026-01-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(75, 50, '2026-02', 2, 2026, '2026-02-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(76, 50, '2026-03', 3, 2026, '2026-03-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(77, 50, '2026-04', 4, 2026, '2026-04-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(78, 50, '2026-05', 5, 2026, '2026-05-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(79, 50, '2026-06', 6, 2026, '2026-06-01', NULL, NULL, 'Debe', -18000, '', NULL, 0),
(80, 50, '2025-05', NULL, NULL, '2025-06-11', NULL, NULL, 'Pago mensual', 32154, '$ 18 Abril + $ 18 Mayo - $ 3.846 Contribucion Inmobiliaria = $ 32.154.- para quedar al dia', '68490f58e6cf6-PAGO ALQUILER ABRIL Y MAYO 2025 IMPRENTA.jpg', NULL),
(81, 8, '2025-05', NULL, NULL, '2025-06-11', NULL, NULL, 'Pago mensual', 9000, 'Sub contrato nuevo inquilino', '6849e3976dae7-Local 35 Gal Americas Sub Contrato Alqui.pdf', NULL),
(82, 19, '2025-06', NULL, NULL, '2025-06-14', NULL, NULL, 'Pago mensual', 3600, 'Raúl avisa por wpp ', '684e14365a2aa-IMG_1737.jpeg', NULL),
(83, 36, '2025-06', NULL, NULL, '2025-06-15', NULL, NULL, 'Pago mensual', 2500, 'Avisa Raúl por wpp', '684ee64835229-IMG_1742.jpeg', NULL);

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
  `garantia` decimal(10,2) DEFAULT NULL,
  `corredor` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `anep` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contribucion_inmobiliaria` decimal(10,2) DEFAULT NULL,
  `comentarios` text COLLATE utf8_unicode_ci,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `imagenes` text COLLATE utf8_unicode_ci NOT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id`, `nombre`, `tipo`, `direccion`, `galeria`, `local`, `precio`, `incluye_gc`, `gastos_comunes`, `estado`, `garantia`, `corredor`, `anep`, `contribucion_inmobiliaria`, `comentarios`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`, `imagenes`, `documentos`) VALUES
(1, 'Galeria del Sol Local 10', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 10', 9000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"Patricia\" en $9000', 0, NULL, NULL, '', ''),
(2, 'Galeria del Sol Local 13', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 13', 7500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'solo dice &quot;Carolina&quot; $7500 mas gastos comunes. por otro lado aprovecho para comentarte lo siguiente: yo estuve comentándole a Raul que la empresa no tuvo andamiento, por lo tanto no estoy yendo al local, se me esta dificultando poder pagar el alquiler, hay alguna forma de poder rescindir el contrato aunque sea pagando multa?\r\ntambien podria ser traspaso del alquiler, pero yo no consigo alguien que quiera alquilar, si ustedes saben de alguien o si lo publican y esto les lleva gastos de comision o los que sea yo me hago cargo de los mismos. Te agradezco tu ayuda. Saludos. Carolina.', 1, NULL, '2025-06-10 10:57:03', '[]', ''),
(3, 'Galeria del Sol Local 18', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 18', 7500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'Local \"Libre\" $7500 mas gastos comunes', 0, NULL, NULL, '', ''),
(4, 'Galeria del Sol Local 21', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 21', 12100.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'Alquilado a \"Sofia\" en $12100 gastos comunes incluidos', 0, NULL, NULL, '', ''),
(5, 'Galeria del Sol Local 23', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 23', 9000.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, 'Local \"Libre\" $9000 mas gastos comunes tiene agua e instalacion de peluqueria ', 0, NULL, NULL, '', ''),
(6, 'Galeria del Sol Local 27', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 27', 9500.00, 0, 4110.00, 'alquilado', 0.00, '', '', 0.00, 'Alquilado a \"Marcia\" , garantia de porto $9500 mas $4110 de gastos counes  mas impuestos', 0, NULL, NULL, '', ''),
(7, 'Galeria de las Americas Local 5', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 5', 7500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado juan polvora ( el tatuador) alquiler $7500 lo paga efectivo en mi local a mes vencido mas gastos comunes', 0, NULL, NULL, '', ''),
(8, 'Galeria de las Americas Local 10', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 10', 8000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alqulado EXAFIX sin garantia contrato de palabra con raulito alquiler $8000 paga efectivo en mi local paga a mes corriente , mas gastos comunes e impuestos', 0, NULL, NULL, '', ''),
(9, 'Galeria de las Americas Local 31B ', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 31B ', 6500.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, 'esta libre , es un local chiquito que papa dividio su oficina y lo alquila $6500 luz y gastos comunes incluidos', 0, NULL, NULL, '', ''),
(10, 'Galeria de las Americas Local 35', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 35', 9000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a Yasmani y Sheylan alquiler $9000 mas gastos comunes e impuestos', 1, NULL, '2025-06-11 15:21:02', '[\"6849e52e875cf.png\"]', ''),
(11, 'Galeria de las Americas Local 103', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 103', 11000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"Claudia\" $11000 mas gastos comunes e impuestos garantia ANDA y anda deposita en cta brou de papa', 0, NULL, NULL, '', ''),
(12, 'Galeria de las Americas Local 105', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 105', 6500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a Elvis en $6500 mas gastos comunes ,deposita a papa en BROU', 0, NULL, NULL, '', ''),
(13, 'Galeria de las Americas Local 106', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 106', 7862.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a Juan Carlos Petit tel 099244504 en $7862', 0, NULL, NULL, '', ''),
(14, 'Torre Maldonado Local 030', 'Local', 'Torre Maldonado', 'Torre Maldonado', 'Local 030', 5500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"Mariana\" 094511313 , garantia de porto $5500 gastos comunes inlcuidos pq son muy baratos paga en brou a papa', 0, NULL, NULL, '', ''),
(15, 'Galeria Cristal Local 39', 'Local', 'Galeria Cristal', 'Galeria Cristal', 'Local 39', 7000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"Elsa\" 094800635 $7000', 0, NULL, NULL, '', ''),
(16, 'Local Figueroa Local 6', 'Local', 'Local Figueroa', '', 'Local 6', 0.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, 'es el local 6 esta vacio', 0, NULL, NULL, '', ''),
(17, 'Galeria Entrevero Local 7 / 8', 'Local', 'Galeria Entrevero', 'Galeria Entrevero', 'Local 7 / 8', 10000.00, 0, 4400.00, 'alquilado', 0.00, '', '', 0.00, '', 2, NULL, '2025-06-10 23:11:06', '[\"684901da10d77.jpeg\",\"684901da1100e.jpeg\",\"684901da11198.jpeg\",\"684901da112d2.jpeg\",\"684901da113e1.jpeg\",\"684901da115c2.jpeg\"]', ''),
(18, 'Galeria Entrevero Local 41', 'Local', 'Galeria Entrevero', 'Galeria Entrevero', 'Local 41', 9100.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"nails\" ', 0, NULL, NULL, '', ''),
(19, 'Local Rondeau ', 'Local', 'Local Rondeau ', '', 'Local Rondeau ', 0.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'Local a medias C/ R Jr , el inquilino paga $40.000 a cta a medias', 0, NULL, NULL, '', ''),
(20, 'Villa Serrana', 'Apto', 'Villa Serrana', '', 'Villa Serrana', 0.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'casa a medias c/R Jr actualmente alquilada a punto de terminar contrato paga $12000 deposita en cuenta a medias', 0, NULL, NULL, '', ''),
(21, 'Apto 116B PDE', 'Apto', 'Apto 116B PDE', '', 'Apto 116B PDE', 0.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'local a medias c/ R Jr actualmente alquilado a \"porte?o\"\" tiene una deuda congelada q paga el titulas y el alquiler lo paga el \"inquilino\" mes a mes', 0, NULL, NULL, '', ''),
(22, 'Apto Galeria Caracol', 'Apto', 'Apto Galeria Caracol', 'Galeria Caracol', 'Apto Galeria Caracol', 0.00, 0, 0.00, 'en venta', 0.00, '', '', 0.00, ' es de uso propio ', 0, NULL, NULL, '', ''),
(23, 'Bolo 01', 'Cochera', 'Bolo', '', '', 0.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(24, 'Bolo 02', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(25, 'Bolo 03', 'Cochera', 'Bolo', '', '', 3400.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(26, 'Bolo 04', 'Cochera', 'Bolo', '', '', 3200.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(27, 'Bolo 05', 'Cochera', 'Bolo', '', '', 3400.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(28, 'Bolo 06', 'Cochera', 'Bolo', '', '', 4300.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(29, 'Bolo 07', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(30, 'Bolo 08', 'Cochera', 'Bolo', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(31, 'Bolo 09', 'Cochera', 'Bolo', '', '', 4200.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(32, 'Bolo 10', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(33, 'Bolo Apto', 'Apto', 'Bolo', '', 'Apartamento', 0.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(34, 'Bolo Moto', 'Cochera', 'Bolo', '', '', 1500.00, 0, 0.00, 'alquilado', 0.00, '', '7/5 brou', 0.00, '', 0, NULL, NULL, '', ''),
(35, 'Deposito GA', 'Deposito', 'Galeria de las Americas', 'Galeria de las Americas', 'D1', 6200.00, 0, 0.00, 'alquilado', 0.00, '', '2/5 brou', 0.00, '', 0, NULL, NULL, '', ''),
(36, 'Tmal', 'Local', 'Terminal', 'Terminal', 'Local 030', 5500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(37, 'dc2', 'Cochera', 'Dionisio Coronel', '', '', 2400.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(38, 'dc3', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(39, 'dc4', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '13/5 sob', '13/5 sob', 0.00, '', 0, NULL, NULL, '', ''),
(40, 'dc5', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(41, 'dc6', 'Cochera', 'Dionisio Coronel', '', '', 2600.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(42, 'dc7', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '', '7/5 sob', 0.00, '', 0, NULL, NULL, '', ''),
(43, 'dc9', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'uso propio', 0.00, '', '', 0.00, '', 0, NULL, NULL, '', ''),
(44, 'dc10', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '', '13/5 sob', 0.00, '', 0, NULL, NULL, '', ''),
(48, 'Elysee local 11 Lucho', 'Local', 'Elysee', 'Elysee', '11', 6500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'Tributos domiciliarios cuenta 659818\r\nContribución inmobiliaria cuenta 2036342', 1, '2025-06-09 19:35:42', '2025-06-14 19:39:43', '[]', '[\"doc_684ae16402f5f.jpeg\",\"doc_684ae16403bf5.jpeg\"]'),
(49, 'Ruperto Pérez Martínez', 'Apartamento', 'Ruperto perez martinez 547', '', '', 32705.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 1, '2025-06-10 07:53:27', NULL, '[]', ''),
(50, 'Bolognese Local Completo', 'Cochera', 'Bolognese', '', '', 31110.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 1, '2025-06-10 11:04:11', '2025-06-10 11:23:19', '[]', ''),
(51, 'Imprenta', 'Local', 'Cerrito 564', '', '', 18000.00, 1, 0.00, 'alquilado', 0.00, '', '6373802', 228933.00, 'DEL PRECIO DEL ALQUILER SE DESCUENTA ANEP Y CONTRIBUCION.\r\nPADRÓN N° 3350', 2, '2025-06-11 00:04:37', '2025-06-11 00:07:18', '[]', '');

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
