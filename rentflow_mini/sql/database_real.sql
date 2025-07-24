-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 08-07-2025 a las 20:57:56
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
  `comentarios` text COLLATE utf8_unicode_ci,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `inquilino_id`, `propiedad_id`, `fecha_inicio`, `fecha_fin`, `importe`, `garantia`, `corredor`, `estado`, `documentos`, `comentarios`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 1, 1, '2025-01-01', '2025-06-16', 9000.00, '0', '0', 'finalizado', '[\"684e1726ae786-Local10Sol Documentos P\\u00f3liza GA091654.pdf\"]', NULL, 0, NULL, NULL),
(2, 2, 2, '2025-01-01', '2026-02-01', 7500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(3, 3, 3, '2025-01-01', '2026-02-01', 7500.00, '0', '0', 'activo', '[\"686c76fc6de6b-Contrato de arrendamiento LOCAL 18 SOL PORTO.doc\",\"686c777f0906b-535ae5c3-ddcd-43e1-9ff2-08c9d18aa2a4.jpeg\"]', NULL, 0, NULL, NULL),
(4, 4, 4, '2024-08-15', '2025-08-14', 12100.00, '0', '0', 'activo', '[\"68490635634b3-POLIZA CONTRATO LOCAL 21 DEL SOL SOFIA GARCIA.pdf\"]', NULL, 0, NULL, NULL),
(5, 6, 6, '2025-01-01', '2026-02-01', 9500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(6, 7, 7, '2025-01-01', '2026-02-01', 7500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(7, 8, 8, '2025-01-01', '2026-02-01', 8000.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(8, 10, 10, '2025-01-01', '2026-02-01', 9000.00, '0', '0', 'activo', '[\"6849e3efc1d83-Local 35 Gal Americas Sub Contrato Alqui.pdf\"]', NULL, 0, NULL, NULL),
(9, 11, 11, '2025-01-01', '2025-07-19', 11000.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(10, 12, 12, '2025-01-01', '2026-02-01', 6500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(11, 13, 13, '2025-01-01', '2026-02-01', 7862.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(13, 15, 15, '2025-01-01', '2026-02-01', 7000.00, '0', '0', 'activo', '[\"685cba395fae3-857c3c80-2782-4c91-85d7-9e30f81e51ca.jpeg\"]', NULL, 0, NULL, NULL),
(14, 18, 18, '2025-01-01', '2026-02-01', 9100.00, '0', '0', 'activo', '[\"686c7d651bc18-Contrato de arrendamiento SURA LOCAL 41 ENTREVERO MACHIN.doc\",\"686c7d9b530d6-IMG_2089.png\"]', NULL, 0, NULL, NULL),
(15, 19, 19, '2025-01-01', '2026-02-01', 40000.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(16, 20, 20, '2024-08-01', '2025-07-31', 12000.00, '0', '0', 'activo', '[\"685cba5051fbb-1dd7b53c-f354-4518-9243-c26d03eca083.jpeg\"]', NULL, 0, NULL, NULL),
(17, 21, 21, '2025-01-01', '2026-02-01', 1.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(18, 23, 23, '2025-01-01', '2026-02-01', 3600.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(19, 24, 24, '2025-01-01', '2026-02-01', 3600.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(20, 25, 25, '2025-01-01', '2026-02-01', 3400.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(21, 26, 26, '2025-01-01', '2026-02-01', 3200.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(22, 27, 27, '2025-01-01', '2025-06-30', 3400.00, '0', '0', 'finalizado', '[]', NULL, 0, NULL, NULL),
(23, 28, 28, '2025-01-01', '2026-02-01', 4300.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(24, 29, 29, '2025-01-01', '2026-02-01', 3600.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(25, 30, 30, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(26, 31, 31, '2025-01-01', '2026-02-01', 4200.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(27, 32, 32, '2025-01-01', '2026-02-01', 3600.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(28, 34, 34, '2025-01-01', '2026-02-01', 1500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(29, 35, 35, '2025-01-01', '2026-02-01', 6200.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(30, 36, 36, '2025-01-01', '2026-02-01', 5500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(31, 37, 37, '2025-01-01', '2026-02-01', 2400.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(32, 38, 38, '2024-01-01', '2024-11-01', 2500.00, '0', '0', 'finalizado', '[]', NULL, 0, NULL, NULL),
(33, 39, 39, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(34, 41, 41, '2025-01-01', '2026-02-01', 2600.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(35, 42, 42, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(36, 44, 44, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(46, 47, 48, '2025-02-01', '2026-06-09', 6500.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(47, 48, 49, '2025-05-01', '2026-06-10', 32705.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(48, 43, 50, '2025-06-10', '2026-06-10', 31110.00, '0', '0', 'activo', '[\"685eadffced22-IMG_1918.png\"]', NULL, 0, NULL, NULL),
(49, 49, 17, '2025-06-01', '2026-05-31', 10000.00, '0', '0', 'activo', '[\"68490081c96b4-POLIZA CONTRATO MAGELA MENDIOROZ LOCAL 7y8 Galeria del Entrevero 01-06-2025 GA109636.pdf\",\"68490081c99b4-CONTRATO ALQUILER FIRMADO LOCAL 7 y 8 Galeria del Entrevero 01-06-2025.pdf\",\"686c7f3d14681-IMG_2089.png\"]', NULL, 0, NULL, NULL),
(50, 50, 51, '2025-06-11', '2026-06-11', 18000.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(51, 51, 52, '2025-03-01', '2026-03-01', 3600.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(52, 52, 59, '2015-07-04', '2030-07-04', 1.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(53, 53, 9, '2025-06-01', '2026-11-30', 6300.00, '0', '0', 'activo', '[\"686c86bc55200-IMG_2090.png\",\"686c86fae406f-Contrato de arrendamiento Local 31B Americas \\u00c1lvaro Correa Ferrin.doc\"]', 'Paga a mes corriente, le vamos a cobrar cuando entra el propio mes ósea él empezó el 1/6 ya debe junio y ahora antes del 10 ya tiene q pagar julio', 0, NULL, NULL),
(54, 54, 27, '2025-07-01', '2026-07-01', 3600.00, '', '', 'activo', '[]', 'Eduardo de bolognese va a ingresar la hija con una Tiggo 4, $3600 Ariana Bonilla se llama\r\nVa a pagar este mes porque quiere reservar el lugar\r\nLa camioneta ingresa a fin de mes se la dan', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

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
  KEY `fk_gastos_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id`, `fecha`, `concepto`, `importe`, `forma_pago`, `observaciones`, `comprobante`, `propiedad_id`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`, `validado`, `fecha_validacion`, `usuario_validacion_id`) VALUES
(1, '2025-07-02', 'Pago de Gastos comunes', 1829.00, 'Transferencia', 'pago gastos comunes galeria de las americas propietario local 5 , 10 , 31 , 35 , 103 , 105, 106', '6865e7581cc34-IMG_2026.png', NULL, 1, '2025-07-02 21:13:44', '2025-07-02 21:13:44', 0, NULL, NULL),
(2, '2025-07-07', 'Pago de Impuestos', 27960.00, 'Transferencia', 'Paga Raúl de su cuenta devolver la mitad de la cuenta en conjunto', '686c130d63e9e-31e321d7-e026-4ca5-bbcb-6c590a68e806.jpeg', 19, 1, '2025-07-07 13:33:49', '2025-07-07 13:33:49', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inquilinos`
--

CREATE TABLE IF NOT EXISTS `inquilinos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cedula` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `vehiculo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `matricula` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  `comentarios` text COLLATE utf8_unicode_ci,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `inquilinos`
--

INSERT INTO `inquilinos` (`id`, `nombre`, `cedula`, `telefono`, `email`, `vehiculo`, `matricula`, `documentos`, `comentarios`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Patricia', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(2, 'Carolina', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(3, 'Mateo Guzzo', '9999', '', '', '', '', '[]', NULL, 0, NULL, '2025-07-07 16:22:55'),
(4, 'Sofia', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(6, 'Marcia', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(7, 'Juan Polvera', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(8, 'Exafix', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(10, 'Yasmani y Sheylan', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(11, 'Claudia', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(12, 'Elvis', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(13, 'Juan Carlos Petit', '', '099244504', '', '', '', '', NULL, 0, NULL, NULL),
(15, 'Elsa', '', '094800635', '', '', '', '', NULL, 0, NULL, NULL),
(18, 'Gaby Nails', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(19, 'George', '999', '', '', '', '', '[]', NULL, 0, NULL, '2025-06-25 12:49:46'),
(20, 'Nahuel', '999', '095653586', '', '', '', '[]', NULL, 0, NULL, '2025-06-25 21:58:09'),
(21, 'Porteño Diego Borja', '999', '', '', '', '', '[]', NULL, 0, NULL, '2025-07-05 10:51:27'),
(23, 'Sarkisian', '999', '099647878', '', 'Onix Sedan Chevrolet', 'SDC5513', '[\"68616c4a4954b-ec8da04c-8f1c-4e89-817d-2ee8617dcbcb.jpeg\"]', NULL, 0, NULL, '2025-06-29 11:39:38'),
(24, 'Eduardo', '', '095199525', '', 'Geely', 'SDF2678', '', NULL, 0, NULL, NULL),
(25, 'Cristian y Érica', '999', '099764804', '', 'Fiat Mobi', 'SCM1429', '[\"686169f9979da-d11edcdb-1fdd-4f05-b6d7-f13f31a62254.jpeg\"]', NULL, 0, NULL, '2025-07-04 13:26:55'),
(26, 'Corina', '999', '095277483', '', 'Hyundai i10', 'SBM1892', '[\"68616a3ac424b-2e9cf63d-46a6-4a7a-bc5d-442eb6d5d2e1.jpeg\"]', NULL, 0, NULL, '2025-06-29 11:30:50'),
(27, 'Alejandra Ancheta', '999', '095860816', '', 'Onix Hatch', 'SCS2773', '[]', '', 0, NULL, '2025-07-08 15:16:31'),
(28, 'Walter', '', '097089289', '', 'Amarok', 'SCG3263', '', NULL, 0, NULL, NULL),
(29, 'Natacha Figueroa Porley', '999', '099415432', '', 'Golf', '', '[]', NULL, 0, NULL, '2025-06-25 21:43:44'),
(30, 'Martin Gbolo17', '999', '095308197', '', 'Fiat Ritmo', '', '[]', NULL, 0, NULL, '2025-06-25 21:14:14'),
(31, 'Gabriel Galain', '99', '0994052920', '', 'BMW', 'SDD8965', '[]', NULL, 0, NULL, '2025-06-24 20:52:10'),
(32, 'Laura / Fabian', '999', '096325786', '', 'Corsa', 'SBM6092', '[\"68616c7e5d71f-137de2bd-a6bd-4f1a-829a-33c2e4c3cd19.jpeg\"]', NULL, 0, NULL, '2025-07-07 09:01:48'),
(34, 'Martin', '999', '098669973', '', 'Moto', '', '[\"68616cb78c540-462f5238-71e5-41b5-9203-e01a5dab6dcc.jpeg\"]', NULL, 0, NULL, '2025-06-29 11:41:27'),
(35, 'Carlos Guerra', '', '094801410', '', '', '', '', NULL, 0, NULL, NULL),
(36, 'Marta Bueno', '999', '096576342', '', '', '', '[]', NULL, 0, NULL, '2025-06-25 21:33:43'),
(37, 'Alejandro', '', '098171789', '', 'Toyota', '', '', NULL, 0, NULL, NULL),
(38, 'Antonella', '', '095794847', '', 'Peugeot', '', '', NULL, 0, NULL, NULL),
(39, 'Edgardo', '', '', '', 'Camioneta', '', '', NULL, 0, NULL, NULL),
(41, 'Francisco', '', '', '', 'Ford Ka', '', '', NULL, 0, NULL, NULL),
(42, 'Valverde', '', '095856424', '', 'Ford Escort', '', '', NULL, 0, NULL, NULL),
(43, 'Raul Pérez Rosado (todos)', '13474169', '', '', 'Jeep', '', '[]', '', 0, NULL, '2025-07-08 15:48:25'),
(44, 'Cristina', '', '094106036', '', 'Suzuki', '', '', NULL, 0, NULL, NULL),
(47, 'Camila Moreira', '999', '92959219', 'moreiracamila1891@gmail.com', '', '', '[]', '', 1, '2025-06-09 19:55:22', '2025-07-08 15:49:00'),
(48, 'Guerrero A Alexis Joel', '', '', '', '', '', '[]', NULL, 1, '2025-06-10 07:54:11', NULL),
(49, 'Camila Perdomo (Magela Mendioroz Gtia)', '12383159', '092476991', '', '', '', '[\"6848ff672b302-CEDULA MAGELA DORSO.jpg\",\"6848ff672b4e0-CEDULA MAGELA FRENTE.jpg\",\"6848ff672b5e5-RECIBO DE SUELDO 04-2025.jpg\",\"6848ff672b745-RECIBOS DE SUELDO 1.jpg\",\"6848ff672b87e-RECIBOS DE SUELDO 05-2025.jpg\"]', NULL, 2, '2025-06-10 23:00:01', '2025-06-25 22:02:13'),
(50, 'Maria Viviana Perez Bandera', '38284692', '094477007', '', '', '', '[]', NULL, 2, '2025-06-11 00:05:35', NULL),
(51, 'Oscar Moreira', '9999', '099651973', '', 'BYD F3', 'SCL2011', '[]', NULL, 1, '2025-06-24 20:30:35', '2025-06-24 20:30:52'),
(52, 'Raúl Pérez Bandera Jr', '999', '59894423423', 'raulperez53@hotmail.com', '', '', '[]', '', 1, '2025-07-04 11:53:44', '2025-07-08 16:48:18'),
(53, 'Álvaro Correa Ferrin', '15764380', '', '', '', '', '[\"686c8608b9176-IMG_2090.png\"]', NULL, 1, '2025-07-07 21:44:54', NULL),
(54, 'Ariana Bonilla', '999', '', '', 'Tiggo 4', '', '[]', '[15:22, 8/7/2025] Raulo: Hablé con Eduardo de bolognese va a ingresar la hija con una Tiggo 4 , $3600 Ariana Bonilla se llama\r\n[15:22, 8/7/2025] Raulo: Ya va a pagar este mes porque quiere reservar el lugar\r\n[15:23, 8/7/2025] Raulo: La camioneta ingresa a fin de mes se la dan', 1, '2025-07-08 15:12:10', NULL);

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
  `validado` tinyint(1) DEFAULT '0',
  `fecha_validacion` datetime DEFAULT NULL,
  `usuario_validacion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `contrato_id`, `usuario_id`, `periodo`, `mes`, `anio`, `fecha`, `fecha_creacion`, `fecha_programada`, `fecha_recibido`, `concepto`, `tipo_pago`, `importe`, `comentario`, `comprobante`, `pagado`, `validado`, `fecha_validacion`, `usuario_validacion_id`) VALUES
(1, 18, NULL, '2025-06', NULL, NULL, '2025-06-05', NULL, NULL, '2025-06-05', 'Pago mensual', 'Transferencia Papá', 3600, 'Agregar pago cochera bolo sarkisian 5/6 transf BROU', '68474c9a23c8d-pago sarkis brou.png', NULL, 0, NULL, NULL),
(2, 23, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 4300, '', '6847731c7f0bb-IMG_1682.jpeg', NULL, 0, NULL, NULL),
(3, 26, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 4200, 'Pago Gabriel galain', '6847772b46e78-IMG_1682.jpeg', NULL, 0, NULL, NULL),
(4, 27, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 3600, 'Corsa', '68477956d15ba-IMG_1682.jpeg', NULL, 0, NULL, NULL),
(5, 35, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Ford escort', '68477b15bfce3-IMG_1682.jpeg', NULL, 0, NULL, NULL),
(20, 46, NULL, '2025-05', NULL, NULL, '2025-05-06', NULL, NULL, '2025-05-06', 'Pago mensual', 'Depósito Cuenta Lucho', 6500, '', '684782ed5dc57-074bb8cb-d22b-4923-9bfd-2d2fb8a2a798.jpeg', NULL, 0, NULL, NULL),
(35, 47, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 32705, '', '68482b5dccada-RPMPagoJunio2025.pdf', NULL, 0, NULL, NULL),
(36, 14, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 9100, '[10/6/25, 10:49:51] Viviana Pérez: Pago alquiler Local 41 GabyNails Este es el que hay que deducir que hacen con los gastos comunes... queda horrible preguntarle a la tipa si están incluidos o no en esos 9100, imagino quw si porque este local es de 2 x 1 metro, es el pasillo no?\n[10:51, 10/6/2025] Raulo: Si calculo q si\n[10:51, 10/6/2025] Raulo: Paga $2200 ese de gc\n[10:51, 10/6/2025] Raulo: En una galería de mierda\n[10:51, 10/6/2025] Raulo: Son $6800 de alquiler está bien', '6848425773709-8843f0ed-0cf3-4b88-87df-82c0100e6e50.jpeg', NULL, 0, NULL, NULL),
(37, 5, NULL, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 9500, 'Vivi manda por wpp', '6848552446b85-SolLocal27Comprobante_TransferenciaEnElPais_09_06_2025_15_19.pdf', NULL, 0, NULL, NULL),
(38, 2, NULL, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 7500, 'Vivi manda wpp', '6848557959f89-Local13SolTransferencia_a_terceros_2506090446475352.pdf', NULL, 0, NULL, NULL),
(52, 48, NULL, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 31110, 'Quedó paga mensualidad alquiler garage Bolognese a Cristina di cándia', '684857bfbb38f-IMG_1696.png', NULL, 0, NULL, NULL),
(53, 14, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Gastos comunes', 'Efectivo', 2500, 'Pagamos nosotros ', '68485b5c35111-70e89107-016f-4c7b-9af1-2482ad83019e.jpeg', NULL, 0, NULL, NULL),
(66, 1, NULL, '2025-05', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Depósito Cuenta Papá', 12500, '', '684907bd7f784-Alquiler LOCAL 10 del SOL de Mayo.jpg', NULL, 0, NULL, NULL),
(80, 50, NULL, '2025-05', NULL, NULL, '2025-06-11', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 32154, '$ 18 Abril + $ 18 Mayo - $ 3.846 Contribucion Inmobiliaria = $ 32.154.- para quedar al dia', '68490f58e6cf6-PAGO ALQUILER ABRIL Y MAYO 2025 IMPRENTA.jpg', NULL, 0, NULL, NULL),
(81, 8, NULL, '2025-05', NULL, NULL, '2025-06-11', NULL, NULL, NULL, 'Pago mensual', 'Efectivo', 9000, 'Sub contrato nuevo inquilino', '6849e3976dae7-PagoLocal35GalAmericas.jpeg', NULL, 0, NULL, NULL),
(82, 19, NULL, '2025-06', NULL, NULL, '2025-06-14', NULL, NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 3600, 'Raúl avisa por wpp ', '684e14365a2aa-IMG_1737.jpeg', NULL, 0, NULL, NULL),
(83, 36, NULL, '2025-06', NULL, NULL, '2025-06-15', NULL, NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Avisa Raúl por wpp', '684ee64835229-IMG_1742.jpeg', NULL, 0, NULL, NULL),
(84, 15, NULL, '2025-06', NULL, NULL, '2025-06-16', NULL, NULL, NULL, 'Pago mensual', 'Depósito', 40000, 'Raúl avisa por wpp, en noviembre cambia de precio ', '6850186789beb-e4c82e64-cb85-444a-b2aa-5278e21c5a1d.jpeg', NULL, 0, NULL, NULL),
(85, 7, NULL, '2025-06', NULL, NULL, '2025-06-16', NULL, NULL, NULL, 'Pago mensual', 'Efectivo', 8000, 'Avisa raul wpp ', '685047acb2b1b-IMG_1749.jpeg', NULL, 0, NULL, NULL),
(86, 1, NULL, '2025-06', NULL, NULL, '2025-06-16', NULL, NULL, NULL, 'Pago mensual', 'Depósito Cuenta Papá', 5384, 'Local 10 del Sol pago esto que es el saldo del mes, HOY ENTREGA LA LLAVE, pago todos los impuestos y este saldito. Ya di de baja el adicional mercantil que papa me pidió, hay que recibirlo, inspeccionarlo, sacarle fotos y ponerlo a alquilar nuevamente', '68505f7da1c1c-IMG_1750.png', NULL, 0, NULL, NULL),
(87, 46, NULL, '2025-06', NULL, NULL, '2025-06-21', NULL, NULL, NULL, 'Pago mensual', 'Depósito Cuenta Lucho', 500, 'Paga 500 alquiler porque descontamos 6000 del techo. Y agregó 3315 de impuestos que pagué yo de mi cuenta que tenía atrasado.', '6856be0a98368-aae4bd2c-731d-4ec5-a1a9-20ffc18074c6.jpeg', NULL, 0, NULL, NULL),
(88, 46, NULL, '2025-06', NULL, NULL, '2025-06-21', NULL, NULL, NULL, 'Impuestos', 'Depósito Cuenta Lucho', 3400, 'Paga 500 alquiler porque descontamos 6000 del techo. Y agregó 3315 de impuestos que pagué yo de mi cuenta que tenía atrasado.', '6856be48a5836-aae4bd2c-731d-4ec5-a1a9-20ffc18074c6.jpeg', NULL, 0, NULL, NULL),
(89, 6, NULL, '2025-06', NULL, NULL, '2025-06-23', NULL, NULL, NULL, 'Pago mensual', 'Efectivo', 7500, 'Avisa Raúl wpp ', '6859f76a33043-IMG_1847.png', NULL, 0, NULL, NULL),
(90, 51, NULL, '2025-06', NULL, NULL, '2025-06-13', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3600, 'Avisa Raúl por wpp lo encontró en persona ', '685b52041b61b-a25bc35a-aacb-4378-b953-9e3fc9d6950a.jpeg', NULL, 0, NULL, NULL),
(91, 34, NULL, '2025-06', NULL, NULL, '2025-06-06', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 2600, '', '685b56f19e902-02183c38-bf26-4b38-87e8-cd795edc15fe.jpeg', NULL, 0, NULL, NULL),
(92, 29, NULL, '2025-06', NULL, NULL, '2025-06-02', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 6200, 'Revisamos celu papá 25/6', '685ca8f7b937c-0b8e5648-31e8-4be0-af4e-823e55a3bfe8.jpeg', NULL, 0, NULL, NULL),
(93, 28, NULL, '2025-04', NULL, NULL, '2025-05-07', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 1500, 'En mayo pago abril y mayo atrasado ', '685caa5dc21d7-040422c8-e50e-43f3-aae9-0e2d47c79654.jpeg', NULL, 0, NULL, NULL),
(94, 28, NULL, '2025-05', NULL, NULL, '2025-05-07', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 1500, 'Pago atrasado abril y mayo el 7 de mayo ', '685caa9debdfc-040422c8-e50e-43f3-aae9-0e2d47c79654.jpeg', NULL, 0, NULL, NULL),
(95, 25, NULL, '2025-06', NULL, NULL, '2025-06-05', NULL, NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Barcode 28287336', '685cacc7587ab-b9abe3a6-5c19-4512-b8cd-161f800cb7b5.jpeg', NULL, 0, NULL, NULL),
(96, 30, NULL, '2025-05', NULL, NULL, '2025-06-07', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 5500, 'Se hizo cargo del alquiler Marta Bueno ', '685cb230a719c-ae2c1aff-0864-418b-a87a-a30797d19987.jpeg', NULL, 0, NULL, NULL),
(97, 24, NULL, '2025-06', NULL, NULL, '2025-06-03', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3600, 'Pago por anda transferencia ', '685cb3c2079f8-ab52fcb7-8b16-4f04-a64b-86c7b3ca4676.jpeg', NULL, 0, NULL, NULL),
(98, 22, NULL, '2025-06', NULL, NULL, '2025-06-12', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3500, 'Deja el garage en julio ', '685cb47f9d35f-b85961b3-2a88-4968-83ae-12290b543cf8.jpeg', NULL, 0, NULL, NULL),
(99, 21, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3200, '', '685cb52a99cfe-40f5fc08-3364-4b74-bd3c-7dd707a5f433.jpeg', NULL, 0, NULL, NULL),
(100, 20, NULL, '2025-06', NULL, NULL, '2025-06-05', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3400, 'Aviso a papá transferencia ', '685cb590802ba-e9c01f1b-0295-42df-a989-3454a30e2f83.jpeg', NULL, 0, NULL, NULL),
(101, 29, 1, '2025-07', NULL, NULL, '2025-07-01', '2025-07-01 07:52:37', NULL, NULL, 'Pago mensual', 'Transferencia', 6200, 'Transfiere a cuenta nuestra', '6863da1522f10-5f135faa-fafb-46ff-b8f8-087bfe812350.jpeg', NULL, 0, NULL, NULL),
(102, 46, 1, '2025-07', NULL, NULL, '2025-07-01', '2025-07-01 12:35:35', NULL, NULL, 'Pago mensual', 'Depósito Cuenta Lucho', 6500, 'Pago mensual ', '68641c67e4552-3f8aec50-1f59-487c-b773-68573a94beca.jpeg', NULL, 0, NULL, NULL),
(103, 4, 1, '2025-07', NULL, NULL, '2025-07-01', '2025-07-01 21:48:47', NULL, NULL, 'Pago mensual', 'Transferencia', 10300, 'Se va a cambiar al local 23', '68649e0fdf677-d32aa4d5-fe49-4845-80a1-27fe3d8070ce.jpeg', NULL, 0, NULL, NULL),
(104, 18, 1, '2025-07', NULL, NULL, '2025-07-02', '2025-07-02 08:32:04', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'Sarkisian gbolo ónix sedan', '686534d43b74a-IMG_2012.png', NULL, 0, NULL, NULL),
(105, 27, 1, '2025-07', NULL, NULL, '2025-07-02', '2025-07-02 21:10:23', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 3600, 'Avisa por wpp a Vivi', '6865e68fe1739-f337eb52-3dda-4054-a12f-a2ec246f4333.jpeg', NULL, 0, NULL, NULL),
(106, 24, 1, '2025-07', NULL, NULL, '2025-07-02', '2025-07-02 21:11:27', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'Avisa por wpp a Vivi', '6865e6cfa9026-944380f4-eb6b-494f-9b34-c46a684d624e.jpeg', NULL, 0, NULL, NULL),
(108, 26, 1, '2025-07', NULL, NULL, '2025-07-03', '2025-07-03 18:19:44', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4200, 'Retira sobre Raúl ', '686710106983f-016b6bc2-bfb4-437a-b2b3-82707fbdcf1e.jpeg', NULL, 0, NULL, NULL),
(109, 35, 1, '2025-07', NULL, NULL, '2025-07-03', '2025-07-03 18:21:43', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Retira sobre Raúl ', '6867108757a36-016b6bc2-bfb4-437a-b2b3-82707fbdcf1e.jpeg', NULL, 0, NULL, NULL),
(110, 20, 1, '2025-07', NULL, NULL, '2025-07-04', '2025-07-04 13:19:27', NULL, NULL, 'Pago mensual', 'Transferencia', 3400, 'Avisa Vivi por wpp mandaron desde otro celular Érica gbolo o dc 099338850', '68681b2f1bee9-6137ff81-293a-4a66-bfd7-73734f4c60a1.jpeg', NULL, 0, NULL, NULL),
(111, 10, 1, '2025-06', NULL, NULL, '2025-06-09', '2025-07-04 20:40:40', NULL, NULL, 'Pago mensual', 'Transferencia Papá', 6500, 'Cargamos atrasado porque no lo habíamos visto en el celular de papá ', '68688298a8110-796509d2-4dec-4e4d-b331-a6b590d931da.jpeg', NULL, 0, NULL, NULL),
(112, 14, 1, '2025-07', NULL, NULL, '2025-07-04', '2025-07-04 20:58:06', NULL, NULL, 'Pago mensual', 'Transferencia', 9100, 'Avisa Vivi por wpp', '686886ae5d141-844acf35-6a1a-4d16-9954-8589ad330862.jpeg', NULL, 0, NULL, NULL),
(113, 17, 1, '2025-05', NULL, NULL, '2025-07-05', '2025-07-05 10:51:03', NULL, NULL, 'Pago mensual', 'Transferencia', 18000, 'Diego Borja punta del este , este corresponde si no estoy mal al alquiler del mes pasado ', '686949e75d961-e437aef3-e121-4c13-8bd2-dce1be39e6e8.jpeg', NULL, 0, NULL, NULL),
(114, 34, 1, '2025-07', NULL, NULL, '2025-07-05', '2025-07-05 15:05:12', NULL, NULL, 'Pago mensual', 'Transferencia', 2600, 'Avisa Vivi por wpp', '68698578d7e1d-cb7646da-f469-4d5f-a3ff-c4d1ec861998.jpeg', NULL, 0, NULL, NULL),
(115, 2, 1, '2025-06', NULL, NULL, '2025-07-07', '2025-07-07 10:45:31', NULL, NULL, 'Pago mensual', 'Transferencia', 7500, 'Caro Local 13 del Sol', '686beb9b5f77a-IMG_2066.png', NULL, 0, NULL, NULL),
(116, 3, 1, '2025-06', NULL, NULL, '2025-07-07', '2025-07-07 16:21:06', NULL, NULL, 'Pago mensual', 'Transferencia', 10420, 'El mes pasado no había mandado pago ', '686c3a42ce410-45c9a43f-9650-4268-8e4d-98d9e7cc2e49.jpeg', NULL, 0, NULL, NULL),
(117, 3, 1, '2025-05', NULL, NULL, '2025-06-03', '2025-07-07 20:37:14', NULL, NULL, 'Pago mensual', 'Transferencia Papá', 7500, 'Encontramos tarde el ticket estaba al día 7/7/2025 cargamos lo del 6', '686c764ad42e6-99bd0d22-44fd-4c2d-8347-db1c8d76b402.jpeg', NULL, 0, NULL, NULL),
(118, 23, 1, '2025-07', NULL, NULL, '2025-07-08', '2025-07-08 09:23:20', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4300, 'Avisa Raúl wpp ', '686d29d805912-d2db8159-78bd-47f9-96fe-b6094b790c48.jpeg', NULL, 0, NULL, NULL),
(119, 21, 1, '2025-07', NULL, NULL, '2025-07-08', '2025-07-08 14:49:41', NULL, NULL, 'Pago mensual', 'Transferencia', 3200, 'Avisa Vivi por wpp ', '686d7655cadd0-5c552bc2-cbfc-4fea-ad2b-eb764143bf1c.jpeg', NULL, 0, NULL, NULL),
(120, 54, 1, '2025-07', NULL, NULL, '2025-07-08', '2025-07-08 15:15:46', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'te envío el comprobante. por favor confírmame si te llegó así ya guardo la plantilla con los datos gracias!\r\nAriana Bonilla Gbolo tiggo 4', '686d7c72eb0e9-Transferencia_a_terceros_2507080464836001.pdf', NULL, 0, NULL, NULL);

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
  `link_mercadolibre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_otras` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `imagenes` text COLLATE utf8_unicode_ci NOT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id`, `nombre`, `tipo`, `direccion`, `galeria`, `local`, `precio`, `incluye_gc`, `gastos_comunes`, `estado`, `propietario_id`, `anep`, `ose`, `ute`, `padron`, `contribucion_inmobiliaria`, `imm_tasa_general`, `imm_tarifa_saneamiento`, `imm_instalaciones`, `imm_adicional_mercantil`, `convenios`, `comentarios`, `link_mercadolibre`, `link_otras`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`, `imagenes`, `documentos`) VALUES
(1, 'Galeria del Sol Local 10', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 10', 9000.00, 0, 0.00, 'libre', 1, '', '', '', '6198', '0.00', '68352', '', '', '', '', 'alquilado a Patricia en $9000', 'https://inmueble.mercadolibre.com.uy/MLU-761468886-alquilo-excelente-local-en-galeria-del-sol-local-10-_JM', '', 1, NULL, '2025-07-02 21:48:03', '[]', '[]'),
(2, 'Galeria del Sol Local 13', 'Local', 'Convencion 1328 / 18 de Julio 918', 'Galeria del Sol', 'Local 13', 7500.00, 0, 0.00, 'alquilado', 1, '', '', '', '6198', '0.00', '', '', '', '5094084', '', 'solo dice Carolina $7500 mas gastos comunes. por otro lado aprovecho para comentarte lo siguiente: yo estuve comentándole a Raul que la empresa no tuvo andamiento, por lo tanto no estoy yendo al local, se me esta dificultando poder pagar el alquiler, hay alguna forma de poder rescindir el contrato aunque sea pagando multa?\r\ntambien podria ser traspaso del alquiler, pero yo no consigo alguien que quiera alquilar, si ustedes saben de alguien o si lo publican y esto les lleva gastos de comision o los que sea yo me hago cargo de los mismos. Te agradezco tu ayuda. Saludos. Carolina.', 'https://inmueble.mercadolibre.com.uy/MLU-760923170-alquilo-local-chico-en-galeria-del-sol-local-13-_JM', '', 1, NULL, '2025-07-02 21:49:32', '[]', '[]'),
(3, 'Galeria del Sol Local 18', 'Local', 'Convencion 1328 / 18 de Julio 918', 'Galeria del Sol', 'Local 18', 7500.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, '6198', '240950', '657110', NULL, NULL, NULL, '5433182', 'Local &quot;Libre&quot; $7500 mas gastos comunes', NULL, NULL, 1, NULL, '2025-06-23 18:25:35', '[]', '[]'),
(4, 'Galeria del Sol Local 21', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 21', 12100.00, 0, 0.00, 'alquilado', 1, '5094088', NULL, NULL, '6198', '240953', '2143431', NULL, NULL, '658371', NULL, 'Alquilado a \"Sofia\" en $12100 gastos comunes incluidos', NULL, NULL, 0, NULL, NULL, '', ''),
(5, 'Galeria del Sol Local 23', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 23', 9000.00, 0, 0.00, 'alquilado', 1, '1884062', '', '', '6198', '240255', '657123', '', '', '214432', '', 'Local Libre $9000 mas gastos comunes tiene agua e instalacion de peluqueria. \r\nConsultar a Vivi dice que está alquilado \r\nArmado para peluquería $ 11.000.- y sin las cosas $ 9.000.- seria\r\n\r\nhttps://inmueble.mercadolibre.com.uy/MLU-711075574-alquilo-local-en-galeria-del-sol-l-23-_JM', '', '', 1, NULL, '2025-07-07 11:47:47', '[]', '[]'),
(6, 'Galeria del Sol Local 27', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 27', 9500.00, 0, 4110.00, 'alquilado', 1, '', NULL, NULL, '6198', '2002262', '658355', NULL, NULL, '5094108', NULL, 'Alquilado a \"Marcia\" , garantia de porto $9500 mas $4110 de gastos counes  mas impuestos', NULL, NULL, 0, NULL, NULL, '', ''),
(7, 'Galeria de las Americas Local 5', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 5', 7500.00, 0, 0.00, 'alquilado', 1, '1997049', NULL, NULL, '8665', '253666', '665608', NULL, NULL, '665604', NULL, 'alquilado juan polvora ( el tatuador) alquiler $7500 lo paga efectivo en mi local a mes vencido mas gastos comunes', NULL, NULL, 0, NULL, NULL, '', ''),
(8, 'Galeria de las Americas Local 10', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 10', 8000.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'alqulado EXAFIX sin garantia contrato de palabra con raulito alquiler $8000 paga efectivo en mi local paga a mes corriente , mas gastos comunes e impuestos', NULL, NULL, 0, NULL, NULL, '', ''),
(9, 'Galeria de las Americas Local 31B', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 31B', 6500.00, 0, 0.00, 'alquilado', 1, '1997189', '', '', '8665', '253692', '665622', '', '', '665626', '', 'esta libre , es un local chiquito que papa dividio su oficina y lo alquila $6500 luz y gastos comunes incluidos', '', '', 1, NULL, '2025-07-08 09:30:38', '[]', '[\"doc_686d2b8ee9376.jpeg\"]'),
(10, 'Galeria de las Americas Local 35', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 35', 9000.00, 0, 0.00, 'alquilado', 1, '1997329', '', '', '8665', '253696', '665651', '', '', '665634', '', 'alquilado a Yasmani y Sheylan alquiler $9000 mas gastos comunes e impuestos', NULL, NULL, 1, NULL, '2025-07-01 10:35:33', '[]', '[\"doc_6864004536f3d.png\"]'),
(11, 'Galeria de las Americas Local 103', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 103', 11000.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, '8665', '253704', '665654', NULL, NULL, '66639', '5662868', 'alquilado a \"Claudia\" $11000 mas gastos comunes e impuestos garantia ANDA y anda deposita en cta brou de papa', NULL, NULL, 0, NULL, NULL, '', ''),
(12, 'Galeria de las Americas Local 105', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 105', 6500.00, 0, 0.00, 'alquilado', 1, '', '', '', '8665', '2003472', '665656', '', '', '', '', 'alquilado a Elvis en $6500 mas gastos comunes ,deposita a papa en BROU\r\nPADRON 8665 UNIDAD 105 PLANTA EP / VALOR IMPONIBLE 00000941522.00 / CARPETA CATASTRAL 331 SOLAR 11', '', '', 1, NULL, '2025-07-04 20:44:53', '[]', '[]'),
(13, 'Galeria de las Americas Local 106', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 106', 7862.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, '8665', '253710', '665630', NULL, NULL, NULL, NULL, 'alquilado a Juan Carlos Petit tel 099244504 en $7862', NULL, NULL, 0, NULL, NULL, '', ''),
(15, 'Galeria Cristal Local 39', 'Local', 'Galeria Cristal', 'Galeria Cristal', 'Local 39', 7000.00, 0, 0.00, 'alquilado', 1, '', '', '', '5373', '236999', '672529', '', '', '2186501', '', 'alquilado a Elsa 094800635 $7000', '', '', 1, NULL, '2025-07-03 21:23:47', '[\"685ff7076b568.jpeg\",\"685ff7076b99f.jpeg\"]', '[]'),
(16, 'Local Figueroa Local 6', 'Local', 'Local Figueroa', '', 'Local 6', 0.00, 0, 0.00, 'libre', 6, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'es el local 6 esta vacio es de Marta', NULL, NULL, 1, NULL, '2025-06-18 09:17:23', '[\"6852ca735d737.jpeg\",\"6852ca735da07.jpeg\",\"6852ca735db92.jpeg\",\"6852ca735dcd7.jpeg\",\"6852ca735de4d.jpeg\",\"6852ca735dfd9.jpeg\",\"6852ca735e154.jpeg\",\"6852ca735e2ab.jpeg\",\"6852ca735e439.jpeg\",\"6852ca735e5dc.jpeg\",\"6852ca735e71d.jpeg\",\"6852ca735e89e.jpeg\",\"6852ca735ea5d.jpeg\",\"6852ca735ec34.jpeg\",\"6852ca735ee44.jpeg\"]', '[]'),
(17, 'Galeria Entrevero Local 7 / 8', 'Local', '18 de Julio 1020 Galeria Entrevero', 'Galeria Entrevero', 'Local 7 / 8', 10000.00, 0, 4400.00, 'alquilado', 1, '', NULL, '0841699157', '6562', '0.00', '5522753', NULL, NULL, NULL, '5627448', '', NULL, NULL, 1, NULL, '2025-06-23 16:55:09', '[\"684901da10d77.jpeg\",\"684901da1100e.jpeg\",\"684901da11198.jpeg\",\"684901da112d2.jpeg\",\"684901da113e1.jpeg\",\"684901da115c2.jpeg\"]', '[]'),
(18, 'Galeria Entrevero Local 41', 'Local', 'Galeria Entrevero', 'Galeria Entrevero', 'Local 41', 9100.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, '6562', '0.00', '660198', NULL, NULL, NULL, NULL, 'alquilado a \"nails\" ', NULL, NULL, 0, NULL, NULL, '', ''),
(19, 'Local Rondeau', 'Local', 'Local Rondeau', '', 'Local Rondeau', 40000.00, 0, 0.00, 'alquilado', 2, '', NULL, NULL, '7171', '245682', '676148', NULL, NULL, '676149', NULL, 'Local a medias C/ R Jr , el inquilino paga $40.000 a cta a medias', NULL, NULL, 1, NULL, '2025-06-16 08:11:48', '[]', '[]'),
(20, 'Villa Serrana', 'Apartamento', 'Villa Serrana', '', 'Villa Serrana', 12000.00, 0, 0.00, 'alquilado', 2, '', '', '', '', '0.00', '', '', '', '', '', 'casa a medias c/R Jr actualmente alquilada a punto de terminar contrato paga $12000 deposita en cuenta a medias', NULL, NULL, 1, NULL, '2025-06-25 22:11:37', '[]', '[]'),
(21, 'Apto 116B PDE', 'Apartamento', 'Apto 116B PDE', '', 'Apto 116B PDE', 0.00, 0, 0.00, 'alquilado', 2, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'local a medias c/ R Jr actualmente alquilado a \"porte?o\"\" tiene una deuda congelada q paga el titulas y el alquiler lo paga el \"inquilino\" mes a mes', NULL, NULL, 0, NULL, NULL, '', ''),
(22, 'Apto Galeria Caracol', 'Apartamento', 'Apto Galeria Caracol', 'Galeria Caracol', 'Apto Galeria Caracol', 0.00, 0, 0.00, 'en venta', 1, '', NULL, NULL, '338', '0.00', NULL, NULL, NULL, NULL, NULL, ' es de uso propio ', NULL, NULL, 0, NULL, NULL, '', ''),
(23, 'Bolo 01', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '0.00', '', '', '', '', '', '', NULL, NULL, 1, NULL, '2025-06-30 21:22:09', '[]', '[]'),
(24, 'Bolo 02', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(25, 'Bolo 03', 'Cochera', 'Bolo', '', '', 3400.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(26, 'Bolo 04', 'Cochera', 'Bolo', '', '', 3200.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(27, 'Bolo 05', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '0.00', '', '', '', '', '', 'Estaba Alejandra Ancheta dejó libre a fin de junio 2025', '', '', 1, NULL, '2025-07-08 16:11:28', '[]', '[]'),
(28, 'Bolo 06', 'Cochera', 'Bolo', '', '', 4300.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(29, 'Bolo 07', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(30, 'Bolo 08', 'Cochera', 'Bolo', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(31, 'Bolo 09', 'Cochera', 'Bolo', '', '', 4200.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(32, 'Bolo 10', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(33, 'Bolo Apto', 'Apartamento', 'Bolo', '', 'Apartamento', 0.00, 0, 0.00, 'libre', 1, '', '', '', '', '0.00', '', '', '', '', '', 'https://apartamento.mercadolibre.com.uy/MLU-760936286-alquilo-apartamento-en-el-interior-de-un-garage-_JM', NULL, NULL, 1, NULL, '2025-06-29 10:22:36', '[]', '[]'),
(34, 'Bolo Moto', 'Cochera', 'Bolo', '', '', 1500.00, 0, 0.00, 'alquilado', 1, '7/5 brou', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(35, 'Deposito GA', 'Deposito', 'Galeria de las Americas', 'Galeria de las Americas', 'D1', 6200.00, 0, 0.00, 'alquilado', 1, '2/5 brou', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(36, 'Tmal Torre Maldonado Local 30', 'Local', 'Torre Maldonado', 'Terminal', 'Local 030', 5500.00, 0, 0.00, 'alquilado', 1, '6998682', '', '', '160', '0.00', '', '', '', '', '', 'alquilado a Mariana 094511313 , garantia de porto $5500 gastos comunes inlcuidos pq son muy baratos paga en brou a papa', NULL, NULL, 1, NULL, '2025-06-26 20:32:30', '[]', '[]'),
(37, 'dc2', 'Cochera', 'Dionisio Coronel', '', '', 2400.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, '37744', '355822', '1056584', NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(38, 'dc3', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'libre', 1, '', '', '', '', '0.00', '', '', '', '', '', '', NULL, NULL, 1, NULL, '2025-06-24 20:50:01', '[]', '[]'),
(39, 'dc4', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '13/5 sob', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(40, 'dc5', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'libre', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(41, 'dc6', 'Cochera', 'Dionisio Coronel', '', '', 2600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(42, 'dc7', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '7/5 sob', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(43, 'dc9', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'uso propio', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(44, 'dc10', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '13/5 sob', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(48, 'Elysee local 11 Lucho', 'Local', 'San Jose 1029 Local 11 Elysee', 'Elysee', '11', 6500.00, 0, 0.00, 'alquilado', 3, '', '', '', '409234', '2036342', '659818', '', '', '', '', 'Tributos domiciliarios Tasa General cuenta 659818\r\nContribución inmobiliaria cuenta 2036342', '', '', 1, '2025-06-09 19:35:42', '2025-07-03 21:25:34', '[\"6852c9dc08424.jpeg\"]', '[\"doc_684ae16402f5f.jpeg\",\"doc_684ae16403bf5.jpeg\"]'),
(49, 'Ruperto Pérez Martínez', 'Casa', 'Ruperto Perez Martinez 547', '', '', 32705.00, 0, 0.00, 'alquilado', 1, '2675931', '', '', '36982', '', '', '', '', '', '', '', '', '', 1, '2025-06-10 07:53:27', '2025-07-05 20:48:16', '[\"68630c4703719.jpeg\"]', '[]'),
(50, 'Bolognese Garage Completo', 'Garage', 'Bolognese', '', '', 31110.00, 0, 0.00, 'alquilado', 5, 'NO', '32338646', '6248041675', '40538', '', '1062617', '2776128', '5913400', '1062618', '', 'Esto lo alquilamos a Cristina Di Candia (propietaria)… se le hace pago mensual', '', '', 1, '2025-06-10 11:04:11', '2025-07-05 20:30:26', '[]', '[\"doc_685eae251de80.png\"]'),
(51, 'Imprenta', 'Local', 'Cerrito 564', '', '', 18000.00, 1, 0.00, 'alquilado', 1, '6373802', '', '', '3350 / 001', '228933.00', '', '', '', '', '', 'DEL PRECIO DEL ALQUILER SE DESCUENTA ANEP Y CONTRIBUCION.\r\nPADRÓN N° 3350', NULL, NULL, 1, '2025-06-11 00:04:37', '2025-06-27 17:02:57', '[]', '[]'),
(52, 'Bolo 11', 'Cochera', 'Bolognese', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, 1, '2025-06-24 20:29:55', NULL, '[]', '[]'),
(53, 'Solanas Tiempo Compartido', 'Apartamento', 'Solanas', '', '', 1.00, 0, 0.00, 'libre', 1, '', '', '', '', '', '', '', '', '', '', 'Averiguar', '', '', 1, '2025-06-26 10:01:55', '2025-07-05 20:32:05', '[]', '[]'),
(54, 'Galería del Sol Local 29', 'Local', 'Galería del Sol', 'Galeria del Sol', '29', 1.00, 0, 0.00, 'libre', 7, '', '', '', '', '', '', '', '', '', '', '', 'https://inmueble.mercadolibre.com.uy/MLU-761741210-alquilo-local-en-galeria-del-sol-local-29-_Jm', '', 1, '2025-07-03 20:34:15', NULL, '[]', '[]'),
(55, 'Galería del Sol local 17', 'Local', 'Galería del Sol', 'Galería del Sol', '17', 1.00, 0, 0.00, 'libre', 8, '', '', '', '', '', '', '', '', '', '', '', 'https://inmueble.mercadolibre.com.uy/MLU-713447896-alquilo-excelente-local-en-galeria-del-sol-l-17-_JM', '', 1, '2025-07-03 20:37:03', '2025-07-03 20:51:07', '[]', '[]'),
(56, 'Dionisio Coronel Garage', 'Garage', 'Dionisio Coronel', '', '', 1.00, 0, 0.00, 'uso propio', 1, '', '', '5421541000', '36992', '334707', '1047951', '', '', '', '', '', '', '', 1, '2025-07-04 10:30:57', '2025-07-05 20:30:10', '[]', '[]'),
(57, 'Luis Battle Berres', 'Casa', 'Luis Battle Berres 4137', '', '', 1.00, 0, 0.00, 'uso propio', 1, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '2025-07-04 10:35:37', '2025-07-05 20:30:02', '[]', '[]'),
(58, 'Neptunia', 'Casa', 'Neptunia', '', '', 1.00, 0, 0.00, 'uso propio', 3, '', '33093931', '0788181000', '', '', '', '', '', '', '', '', '', '', 1, '2025-07-04 10:37:11', '2025-07-05 20:29:53', '[]', '[]'),
(59, 'Galería de las Americas Local 34', 'Local', '18 de Julio 1240', 'Galería de las Americas', 'Local 34', 1.00, 0, 0.00, 'uso propio', 9, '', '', '', '8665', '253695', '665650', '', '', '4183770', '', '', '', '', 1, '2025-07-04 11:55:49', '2025-07-04 13:23:04', '[]', '[]'),
(60, 'Elysee local 12 Raul', 'Local', 'Galería Elysee', 'Galería Elysee', '12', 1.00, 0, 0.00, 'libre', 9, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '2025-07-07 11:17:35', NULL, '[\"686bf31f88c59.jpeg\",\"686bf31f89215.jpeg\",\"686bf31f89a85.jpeg\",\"686bf31f89f84.jpeg\",\"686bf31f8ab29.jpeg\",\"686bf31f8af80.jpeg\"]', '[]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietarios`
--

CREATE TABLE IF NOT EXISTS `propietarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `propietarios`
--

INSERT INTO `propietarios` (`id`, `nombre`, `telefono`, `email`) VALUES
(1, 'Raul Pérez Rosado (de todos)', '', 'fasterworks@gmail.com, vivianaperezbandera@gmail.com, raulperez53@hotmail.com'),
(2, 'Raúl Padre y Raúl Hijo', '', ''),
(3, 'Luis Pérez', '5491138334519', 'fasterworks@gmail.com'),
(4, 'Viviana Pérez', '', ''),
(5, 'Cristina Di Candia', '', ''),
(6, 'Marta Batista', '', ''),
(7, 'Cliente Local 29 del Sol', '', ''),
(8, 'Raúl García Local 17 del Sol', '', ''),
(9, 'Raúl Pérez Bandera Jr', '', '');

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

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `fk_gastos_propiedad` FOREIGN KEY (`propiedad_id`) REFERENCES `propiedades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_gastos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
