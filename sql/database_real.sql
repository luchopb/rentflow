-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-11-2025 a las 06:54:54
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `drakon_luchorentflow`
--
CREATE DATABASE IF NOT EXISTS `drakon_luchorentflow` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `drakon_luchorentflow`;

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `inquilino_id`, `propiedad_id`, `fecha_inicio`, `fecha_fin`, `importe`, `garantia`, `corredor`, `estado`, `documentos`, `comentarios`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 1, 1, '2025-01-01', '2025-06-16', 9000.00, '0', '0', 'finalizado', '[\"684e1726ae786-Local10Sol Documentos P\\u00f3liza GA091654.pdf\"]', NULL, 0, NULL, NULL),
(2, 2, 2, '2024-12-01', '2025-12-01', 7500.00, '', '', 'activo', '[\"690d3772ec905-Contrato de arrendamiento LOC 13 SOL CAROLINA SURA.doc\"]', '', 0, NULL, NULL),
(3, 3, 3, '2024-12-07', '2025-12-06', 7500.00, '0', '0', 'activo', '[\"686c76fc6de6b-Contrato de arrendamiento LOCAL 18 SOL PORTO.doc\",\"686c777f0906b-535ae5c3-ddcd-43e1-9ff2-08c9d18aa2a4.jpeg\"]', '$7000 Alquiler + $3420 GC = $10420', 0, NULL, NULL),
(4, 4, 4, '2024-08-15', '2025-07-31', 12100.00, '0', '0', 'finalizado', '[\"68490635634b3-POLIZA CONTRATO LOCAL 21 DEL SOL SOFIA GARCIA.pdf\"]', '', 0, NULL, NULL),
(5, 6, 6, '2024-09-03', '2025-09-03', 9500.00, '', '', 'finalizado', '[\"68bf624a01f05-Contrato de arrendamiento local 27 sol ana perez.doc\",\"68bf62cad6c15-51e7c27d-4d5e-450a-9a51-0215e8cd7a3b.jpeg\"]', '', 0, NULL, NULL),
(6, 7, 7, '2025-01-01', '2026-02-01', 7500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(7, 8, 8, '2025-01-01', '2026-02-01', 8000.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(8, 10, 10, '2025-01-01', '2026-02-01', 9000.00, '0', '0', 'activo', '[\"6849e3efc1d83-Local 35 Gal Americas Sub Contrato Alqui.pdf\"]', NULL, 0, NULL, NULL),
(9, 11, 11, '2025-01-01', '2025-07-19', 11000.00, 'ANDA', '', 'finalizado', '[]', 'Se va del alquiler queda libre', 0, NULL, NULL),
(10, 12, 12, '2025-01-01', '2026-02-01', 6500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(11, 13, 13, '2025-01-01', '2026-02-01', 7862.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(13, 15, 15, '2025-01-01', '2026-02-01', 7000.00, '0', '0', 'activo', '[\"685cba395fae3-857c3c80-2782-4c91-85d7-9e30f81e51ca.jpeg\"]', NULL, 0, NULL, NULL),
(14, 18, 18, '2024-10-01', '2026-10-01', 9100.00, '0', '0', 'activo', '[\"686c7d651bc18-Contrato de arrendamiento SURA LOCAL 41 ENTREVERO MACHIN.doc\",\"686c7d9b530d6-IMG_2089.png\"]', 'GC inc', 0, NULL, NULL),
(15, 19, 19, '2025-01-01', '2026-02-01', 40000.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(16, 20, 20, '2024-08-01', '2025-07-31', 12000.00, '0', '0', 'finalizado', '[\"685cba5051fbb-1dd7b53c-f354-4518-9243-c26d03eca083.jpeg\"]', '', 0, NULL, NULL),
(17, 21, 21, '2025-01-01', '2025-10-01', 1.00, '', '', 'finalizado', '[]', '', 0, NULL, NULL),
(18, 23, 23, '2025-01-01', '2026-02-01', 3600.00, '0', '0', 'activo', '[]', NULL, 0, NULL, NULL),
(19, 24, 24, '2025-01-01', '2026-02-01', 3600.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(20, 25, 25, '2025-01-01', '2026-02-01', 3400.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(21, 26, 26, '2025-01-01', '2026-02-01', 3200.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(22, 27, 27, '2025-01-01', '2025-06-30', 3400.00, '0', '0', 'finalizado', '[]', NULL, 0, NULL, NULL),
(23, 28, 28, '2025-01-01', '2026-02-01', 4300.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(24, 29, 29, '2025-01-01', '2026-02-01', 3600.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(25, 30, 30, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(26, 31, 31, '2025-01-01', '2026-02-01', 4200.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(27, 32, 32, '2025-01-01', '2025-10-31', 3600.00, '', '', 'finalizado', '[]', '', 0, NULL, NULL),
(28, 34, 34, '2025-01-01', '2026-02-01', 1500.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(29, 35, 35, '2025-01-01', '2026-02-01', 6200.00, NULL, NULL, 'activo', NULL, NULL, 0, NULL, NULL),
(30, 36, 36, '2025-01-01', '2025-07-18', 5500.00, '', '', 'finalizado', '[]', '', 0, NULL, NULL),
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
(53, 53, 9, '2025-06-01', '2025-11-30', 6300.00, '0', '0', 'activo', '[\"686c86bc55200-IMG_2090.png\",\"686c86fae406f-Contrato de arrendamiento Local 31B Americas \\u00c1lvaro Correa Ferrin.doc\",\"686fd7ef70ffb-Contrato Local 31B gal americas teatro.pdf\"]', 'Contrato 31b a 6 meses con opción a 6 meses más 1/6/25 $6300 paga a mes adelantado\r\n\r\nÁlvaro Correa Ferrin \r\nC.I. 1576438-0\r\n\r\nTeatro La gringa \r\nRut 216977150010\r\n\r\nPaga a mes corriente, le vamos a cobrar cuando entra el propio mes ósea él empezó el 1/6 ya debe junio y ahora antes del 10 ya tiene q pagar julio', 0, NULL, NULL),
(54, 54, 27, '2025-07-01', '2026-07-01', 3600.00, '', '', 'activo', '[]', 'Eduardo de bolognese va a ingresar la hija con una Tiggo 4, $3600 Ariana Bonilla se llama\r\nVa a pagar este mes porque quiere reservar el lugar\r\nLa camioneta ingresa a fin de mes se la dan', 0, NULL, NULL),
(55, 55, 61, '2025-07-17', '2026-07-17', 1500.00, '', '', 'activo', '[]', '1500 por mes ', 0, NULL, NULL),
(56, 56, 20, '2025-08-01', '2026-08-01', 12000.00, 'Porto', 'Porto', 'activo', '[\"6897caa2e239c-FIRMADO CONTRATO VILLA SERRANA MIGUEL ALARCON 01-08-2025.pdf\",\"6897caa2e293d-GA113217 MIGUEL ALARCON.pdf\"]', '', 0, NULL, NULL),
(57, 4, 5, '2025-08-01', '2026-07-31', 10000.00, '', '', 'activo', '[\"68b10fa3beded-FIRMADO CONTRATO LOCAL 23 DEL SOL 01-08-2025 con MARTIN DOS SANTOS.pdf\"]', 'Estaba en local 21 y se pasó al 23. Contrato a nombre del marido Martin Dos Santos', 0, NULL, NULL),
(58, 57, 36, '2025-09-01', '2026-08-31', 7000.00, 'Porto Seguro Póliza GA114555', 'Edgard Charec Kamil', 'activo', '[\"68b621f32dbaa-POLIZA ALQUILER TORRE MALDONADO ANA PAULA GUTIERREZ BERON 01-09-2025 al 31-08-2026.pdf\"]', '@⁨Lucho⁩  Esta es la POLIZA de TORRE MALDONADO, tiene contrato del 01-09-2025 al 31-08-2026, SETIEMBRE lo paga en OCTUBRE, a es vencido', 0, NULL, NULL),
(59, 58, 4, '2025-11-01', '2026-11-01', 7000.00, '', '', 'activo', '[\"690bfb603e6b2-poliza orellanes reyes.pdf\",\"690bfb603ec0a-FIRMADO Contrato de arrendamiento GALERIA DEL SOL LOCAL 21 Yerardo Rangel Orellanes 01-11-2025 al 01.pdf\"]', 'Alejandra es la inquilina, el contrató está a nombre de Yerardo Orellanes', 0, NULL, NULL),
(60, 59, 60, '2025-09-01', '2026-09-01', 7800.00, '', '', 'activo', '[\"690c03b244154-YENISSE FERREIRA.pdf\",\"690c03b2446ac-FIRMADO Contrato de arrendamiento Porto YENISSE NOEL FERREIRA LOPEZ Local 12 Elysee 01-09-2025.pdf\"]', '', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE IF NOT EXISTS `gastos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `concepto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id`, `fecha`, `concepto`, `importe`, `forma_pago`, `observaciones`, `comprobante`, `propiedad_id`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`, `validado`, `fecha_validacion`, `usuario_validacion_id`) VALUES
(1, '2025-07-02', 'Pago de Gastos comunes', 1829.00, 'Transferencia', 'pago gastos comunes galeria de las americas propietario local 5 , 10 , 31 , 35 , 103 , 105, 106', '6865e7581cc34-IMG_2026.png', NULL, 1, '2025-07-02 21:13:44', '2025-07-02 21:13:44', 0, NULL, NULL),
(2, '2025-07-07', 'Pago de Impuestos', 13980.00, 'Transferencia', 'Paga Raúl de su cuenta el total y se le giró la mitad ', '686c130d63e9e-31e321d7-e026-4ca5-bbcb-6c590a68e806.jpeg', 19, 1, '2025-07-07 13:33:49', '2025-07-14 21:29:36', 0, NULL, NULL),
(3, '2025-07-10', 'Pago de Convenios', 4226.00, 'Transferencia', 'Convenio Fátima', '68701ea3db6e3-eebbc19c-d7e5-4105-abbd-7b225c86e160.jpeg', NULL, 1, '2025-07-10 15:12:19', '2025-07-12 10:19:39', 0, NULL, NULL),
(4, '2025-07-10', 'Pago de Gastos comunes', 2500.00, 'Efectivo', 'Lo pagué de efectivo cocheras', '68701f365f99d-e8469389-12b0-47cc-aa36-f03eccfe58cd.jpeg', 18, 1, '2025-07-10 15:14:46', '2025-07-10 15:14:46', 0, NULL, NULL),
(5, '2025-07-10', 'Pago de Gastos comunes', 4400.00, 'Efectivo', 'Lo pagué de efectivo cocheras', '68701f67aab4a-e8469389-12b0-47cc-aa36-f03eccfe58cd.jpeg', 17, 1, '2025-07-10 15:15:35', '2025-07-10 15:15:35', 0, NULL, NULL),
(6, '2025-06-10', 'Pago de Gastos comunes', 2500.00, 'Efectivo', NULL, '68485b5c35111-70e89107-016f-4c7b-9af1-2482ad83019e.jpeg', 18, 1, '2025-07-14 13:25:39', '2025-07-14 13:25:39', 0, NULL, NULL),
(7, '2025-06-10', 'Pago de Gastos comunes', 4400.00, 'Efectivo', 'Pagamos nosotros', '68485b5c35111-70e89107-016f-4c7b-9af1-2482ad83020e.jpeg', 17, 1, '2025-07-14 13:31:10', '2025-07-14 13:31:10', 0, NULL, NULL),
(8, '2025-06-10', 'Otros', 2000.00, 'Efectivo', 'Carina', '68755133d1b76-gastosefectivo.png', NULL, 1, '2025-07-14 13:49:23', '2025-07-14 13:52:02', 0, NULL, NULL),
(9, '2025-06-10', 'Otros', 5089.00, 'Efectivo', 'SOA BMW', '6875515b60dca-gastosefectivo.png', NULL, 1, '2025-07-14 13:50:03', '2025-07-14 14:11:35', 0, NULL, NULL),
(10, '2025-07-14', 'Arqueo de Caja (resta)', 80000.00, 'Efectivo', 'Depositamos en cuenta corriente', '687554e320e47-83545dfb-7c63-45d2-8f8a-d77f3c555e11.jpeg', NULL, 1, '2025-07-14 14:05:07', '2025-11-06 19:23:30', 1, '2025-08-22 19:57:38', 1),
(11, '2025-07-14', 'Pago de Servicios', 26000.00, 'Transferencia', 'ahi le pague  a la escribana el costo de los titulos del Suzuki y del BMW', '6875b8d8c8132-Pago Titulos Suzuki y Bmw.pdf', NULL, 1, '2025-07-14 21:11:36', '2025-08-22 19:57:08', 1, '2025-08-22 19:57:08', 1),
(12, '2025-07-14', 'Pago de Impuestos', 828.00, 'Transferencia', 'el de $ 828 fue la contribucon que pague ahora del local 10', '6875b9c640c90-IMG_2196.png', 8, 1, '2025-07-14 21:15:34', '2025-08-22 19:57:02', 1, '2025-08-22 19:57:02', 1),
(13, '2025-07-15', 'Pago de Servicios', 950.00, 'Transferencia', 'Pago Movistar', '687670a47ca57-e40379bd-2e96-4b67-9f04-2dfb42540dcd.jpeg', NULL, 1, '2025-07-15 10:15:48', '2025-08-22 19:56:31', 1, '2025-08-22 19:56:31', 1),
(14, '2025-07-15', 'Otros', 1560.00, 'Efectivo', '@⁨Lucho⁩ gasto $1560 8 controles remotos para garage', NULL, NULL, 1, '2025-07-15 18:50:43', '2025-07-15 18:50:43', 0, NULL, NULL),
(15, '2025-07-15', 'Pago de Servicios', 11985.00, 'Transferencia', 'Este es el pago de Mercadolibre, pase plata de la cuenta Alquileres a mi Prex y de ahí pude pagar ??', '6877082a0120b-34832dca-9249-434f-ad41-ec631f2c8681.jpeg', NULL, 1, '2025-07-15 21:02:18', '2025-08-22 19:56:15', 1, '2025-08-22 19:56:15', 1),
(16, '2025-07-16', 'Pago de Gastos comunes', 2059.00, 'Transferencia', 'Pago de gastos comunes locales de galería de las americas\r\nL5 $347\r\nL31 $585\r\nL35 $405\r\nL103 $202\r\nL105 $260\r\nL106 $260\r\nTotal $2059', '68780afd9b257-IMG_2231.png', NULL, 1, '2025-07-16 15:26:37', '2025-08-22 19:55:28', 1, '2025-08-22 19:55:28', 1),
(17, '2025-07-23', 'Pago de Impuestos', 5455.00, 'Transferencia', 'PAGO CONTRIBUCION RONDEAU $ 5.455.- desde la cuenta ALQUILERES de todos', '68814427373ee-16bca775-0508-4dd1-bb49-6d316be240d0.jpeg', 19, 1, '2025-07-23 15:20:55', '2025-08-22 19:48:43', 1, '2025-08-22 19:48:43', 1),
(18, '2025-07-22', 'Pago de Impuestos', 4841.00, 'Transferencia', 'Pago ute', '68818d2b0093c-lbberresute.png', NULL, 1, '2025-07-23 20:32:27', '2025-08-22 19:48:53', 1, '2025-08-22 19:48:53', 1),
(19, '2025-07-08', 'Pago de Impuestos', 714.00, 'Transferencia', 'UTE', NULL, 9, 1, '2025-07-23 22:18:51', '2025-07-23 22:19:27', 0, NULL, NULL),
(20, '2025-07-08', 'Pago de Servicios', 805.00, 'Transferencia', 'OSE', NULL, 22, 1, '2025-07-23 22:19:55', '2025-07-23 22:19:55', 0, NULL, NULL),
(21, '2025-07-24', 'Arqueo de Caja (resta)', 120000.00, 'Transferencia', 'Retiro $30.000 x4 = $120.000 total', NULL, NULL, 1, '2025-07-23 23:12:59', '2025-10-30 19:20:31', 1, '2025-08-22 18:30:58', 1),
(22, '2025-07-24', 'Pago de Servicios', 822.00, 'Transferencia', 'PAGO LUZ APARTAMENTO BOLOGNESI $831', '6882ed03377c3-899f0d33-37cf-4a1e-b076-0aeecf9c7c12.jpeg', 33, 1, '2025-07-24 21:33:39', '2025-08-22 18:33:33', 1, '2025-08-22 18:33:33', 1),
(23, '2025-07-24', 'Pago de Servicios', 2777.00, 'Transferencia', 'PAGO OSE BOLOGNESI $2816', '6882ee0643589-f8545761-0ffa-4773-970d-4409690d4e52.jpeg', 50, 1, '2025-07-24 21:37:58', '2025-08-22 18:33:00', 1, '2025-08-22 18:33:00', 1),
(24, '2025-07-24', 'Pago de Servicios', 856.00, 'Transferencia', 'PAGO OSE NEPTUNIA Cta 33093931 $858', '6882ee923c22b-740a80e8-95c9-481a-8309-42f9b136efc9.jpeg', 58, 1, '2025-07-24 21:40:18', '2025-08-22 18:32:52', 1, '2025-08-22 18:32:52', 1),
(25, '2025-07-25', 'Pago de Servicios', 11608.00, 'Transferencia', 'Tarjeta Visa papá', '6883a7a44133c-373f1de6-f2c8-4b9e-80af-27f34e183495.jpeg', NULL, 1, '2025-07-25 10:49:56', '2025-08-22 18:34:08', 1, '2025-08-22 18:34:08', 1),
(26, '2025-07-25', 'Pago de Servicios', 0.00, 'Transferencia', 'Visa papá $4456 total, por error Raul depositó en vez de restar, pongo el ingreso como arqueo luego restar', '6883cbabd9ccf-73e169ae-f127-4837-a8f0-f64933e96687.jpeg', NULL, 1, '2025-07-25 13:23:39', '2025-08-22 22:18:52', 0, NULL, NULL),
(27, '2025-07-24', 'Otros', 26272.00, 'Transferencia', 'Rondeau PDE imp \r\n20mil Rondeau + 9mil Diego Borja\r\nmenos Contribución Rondeau $ 5.455 / 2 = $ 2.727.-\r\nTOTAL $ 26.272.-', NULL, 19, 1, '2025-07-25 17:24:16', '2025-08-22 18:31:25', 1, '2025-08-22 18:31:25', 1),
(28, '2025-07-31', 'Pago de Impuestos', 882.00, 'Transferencia', 'PAGO CONTRIBUCION INMOBILIARIA 105 EP', '688c3226c1e15-c866cf43-18e2-4d5d-a731-64cb36bfda57.jpeg', 12, 1, '2025-07-31 22:19:02', '2025-08-22 18:48:02', 1, '2025-08-22 18:48:02', 1),
(29, '2025-07-31', 'Pago de Impuestos', 1889.00, 'Transferencia', 'PAGO CONTRIBUCION INMOBILIARIA 106 EP', '688c32757480b-dd2482d9-2a9b-4059-b4f1-87353b462e41.jpeg', 13, 1, '2025-07-31 22:20:21', '2025-08-22 18:47:57', 1, '2025-08-22 18:47:57', 1),
(30, '2025-07-31', 'Pago de Impuestos', 856.00, 'Transferencia', 'PAGO CONTRIBUCION INMOBILIARIA LOCAL 5 AMERICAS', '688cf6ef9339b-c69641ad-32da-4744-9702-da5d535c5673.jpeg', NULL, 1, '2025-08-01 12:18:39', '2025-08-22 18:47:44', 1, '2025-08-22 18:47:44', 1),
(31, '2025-07-31', 'Pago de Impuestos', 2115.00, 'Transferencia', 'PAGO CONTRIBUCION INMOBILIARIA LOCAL 35 AMERICAS', '688cf73f75c86-ff3f2dc8-2f1d-4f67-8b44-ef3e1250d28a.jpeg', 10, 1, '2025-08-01 12:19:59', '2025-08-22 18:47:33', 1, '2025-08-22 18:47:33', 1),
(32, '2025-07-31', 'Pago de Impuestos', 1521.00, 'Transferencia', 'PAGO CONTRIBUCION LOCAL 31 AMERICAS', '688cf784c6476-6ab07854-727e-4a55-9713-b540e30cd05d.jpeg', 9, 1, '2025-08-01 12:21:08', '2025-08-22 18:47:25', 1, '2025-08-22 18:47:25', 1),
(33, '2025-08-01', 'Pago de Impuestos', 677.00, 'Transferencia', 'PAGO TARIFA DE SANEAMIENTO LBB', '688cf7dd941ad-93fe9c09-f2d9-4d26-b220-095d04deb603.jpeg', 57, 1, '2025-08-01 12:22:37', '2025-08-22 18:53:55', 1, '2025-08-22 18:53:55', 1),
(34, '2025-08-01', 'Pago de Servicios', 606.00, 'Transferencia', 'PAGO UTE DIONISIO CORONEL', '688cf83a0e75b-9f5e582a-b526-4cf9-9aec-00c94ac16878.jpeg', 56, 1, '2025-08-01 12:24:10', '2025-08-22 18:53:47', 1, '2025-08-22 18:53:47', 1),
(35, '2025-07-30', 'Pago de Servicios', 472.00, 'Transferencia', 'PAGO OSE LBB', '688cf89e7edbc-8c848e4e-b45f-4140-86ae-94efe4264a8f.jpeg', 57, 1, '2025-08-01 12:25:50', '2025-08-22 18:53:39', 1, '2025-08-22 18:53:39', 1),
(36, '2025-07-30', 'Pago de Servicios', 472.00, 'Transferencia', 'PAGO OSE FIGUEROA', '688cf8e9d7b26-33110ac5-e78e-45e1-8037-19d90fb119a5.jpeg', 16, 1, '2025-08-01 12:27:05', '2025-08-22 18:53:35', 1, '2025-08-22 18:53:35', 1),
(37, '2025-07-30', 'Pago de Servicios', 901.00, 'Transferencia', 'PAGO UTE BOLOGNESI GARAJE', '688cf938375bd-ad1c97ba-8ee8-49a6-812c-3e97c14efac9.jpeg', 50, 1, '2025-08-01 12:28:24', '2025-08-22 18:53:31', 1, '2025-08-22 18:53:31', 1),
(38, '2025-08-01', 'Pago de Impuestos', 1651.00, 'Transferencia', 'PAGO CONTRIBUCION LOCAL 39 CRISTAL', '688cf97c7ea8c-8de441ce-5239-436e-89a6-2359350cb572.jpeg', 15, 1, '2025-08-01 12:29:32', '2025-08-22 19:40:12', 1, '2025-08-22 19:40:12', 1),
(39, '2025-08-04', 'Pago de Impuestos', 4622.00, 'Transferencia', '@⁨Lucho⁩  anotar gasto, PRIMARIA ANEP Imprenta y RPM, dejamos pago TODO EL AÑO $ 2.550 + $ 2.072 = $ 4.622.-\r\nme tengo que pasar a la cuenta de imprenta, luego lo hago y paso el comprobante', '689167516e9ff-99fb871f-d9dc-4cfb-b893-69ccc2affedb.jpeg', 49, 1, '2025-08-04 21:07:13', '2025-08-22 19:03:42', 1, '2025-08-22 19:03:42', 1),
(40, '2025-08-04', 'Pago de Servicios', 736.00, 'Transferencia', '@⁨Lucho⁩ anotar pago UTE Neptunia', '689167c514667-9c4d46c3-838d-4918-8796-acd97a9d0384.jpeg', 58, 1, '2025-08-04 21:09:09', '2025-08-22 18:55:05', 1, '2025-08-22 18:55:05', 1),
(41, '2025-08-04', 'Pago de Servicios', 668.00, 'Transferencia', '@⁨Lu ♡⁩ anotar pago UTE Local 31, es la oficina de papá', '6891681310594-6188ed80-62fd-41d3-842a-7bab6007799d.jpeg', 9, 1, '2025-08-04 21:10:27', '2025-08-22 18:54:59', 1, '2025-08-22 18:54:59', 1),
(42, '2025-08-04', 'Pago de Servicios', 595.00, 'Transferencia', '@⁨Lucho⁩ anotar pago UTE Figueroa', '68916864ce724-112cb9dc-0a8d-469c-a51d-ee0df20611ad.jpeg', 16, 1, '2025-08-04 21:11:48', '2025-08-22 18:54:53', 1, '2025-08-22 18:54:53', 1),
(43, '2025-08-05', 'Pago de Servicios', 451.00, 'Transferencia', 'UTE local 103', '68923b2f74bc5-b18900da-69cd-428d-8650-95822a5afb22.jpeg', 11, 1, '2025-08-05 12:11:11', '2025-08-22 19:04:34', 1, '2025-08-22 19:04:34', 1),
(44, '2025-08-08', 'Pago de Convenios', 13980.00, 'Transferencia', '$27960 convenio Rondeau, $13.980 mitad convenio Rondeau 1524', '68960dcdb783f-07b61947-4972-4260-a1eb-f1183552fea0.jpeg', 19, 1, '2025-08-08 09:46:37', '2025-08-22 19:11:39', 1, '2025-08-22 19:11:39', 1),
(45, '2025-08-08', 'Pago de Convenios', 4226.00, 'Transferencia', 'Convenio Fátima', '68960df8bbf67-c352a2ba-c3df-4196-8c7e-ae75b749d80b.jpeg', NULL, 1, '2025-08-08 09:47:20', '2025-08-22 19:11:29', 1, '2025-08-22 19:11:29', 1),
(46, '2025-08-11', 'Pago de Gastos comunes', 2500.00, 'Efectivo', 'Pago gastos comunes galería entrevero', '689a25a52de8a-0b815d24-e821-4da1-8f91-a9e19b4b1cd3.jpeg', 18, 1, '2025-08-11 12:17:25', '2025-08-11 12:17:25', 0, NULL, NULL),
(47, '2025-08-11', 'Pago de Gastos comunes', 4400.00, 'Efectivo', 'Pago gastos comunes galería entrevero', '689a25d2c0475-0b815d24-e821-4da1-8f91-a9e19b4b1cd3.jpeg', 17, 1, '2025-08-11 12:18:10', '2025-08-11 12:18:10', 0, NULL, NULL),
(48, '2025-08-05', 'Pago de Impuestos', 1123.00, 'Transferencia', 'Pago Tributos Domiciliarios LBB', '689d3b933b2aa-8cfdaed8-8561-4ae8-a68e-168f76469f8e.jpeg', 57, 1, '2025-08-13 20:27:47', '2025-08-22 21:34:15', 1, '2025-08-22 19:04:09', 1),
(49, '2025-08-13', 'Pago de Servicios', 805.00, 'Transferencia', 'Pago OSE Caracol', '689d3bd0d0392-b5666c42-24c3-46ef-9bce-d30e0720810a.jpeg', 22, 1, '2025-08-13 20:28:48', '2025-08-22 19:14:33', 1, '2025-08-22 19:14:33', 1),
(50, '2025-08-13', 'Pago de Impuestos', 1559.00, 'Transferencia', 'Pago IM Tasa General Local 10 del Sol', '689d3c39c9034-5a393eab-7feb-420c-89ad-addbf6c8746c.jpeg', 1, 1, '2025-08-13 20:30:33', '2025-08-22 19:14:38', 1, '2025-08-22 19:14:38', 1),
(51, '2025-08-13', 'Pago de Impuestos', 1321.00, 'Transferencia', 'Pago Adicional Mercantil BOLO', '689d3c8666006-05c558c0-b555-4653-9655-04d6525234f0.jpeg', 50, 1, '2025-08-13 20:31:50', '2025-08-22 19:14:43', 1, '2025-08-22 19:14:43', 1),
(52, '2025-08-13', 'Pago de Servicios', 537.00, 'Transferencia', 'Pago UTE Caracol', '689d3cbe7bf44-a5cb0caf-c6a0-49f0-8b63-8a1116f0815f.jpeg', 22, 1, '2025-08-13 20:32:46', '2025-08-22 19:14:48', 1, '2025-08-22 19:14:48', 1),
(53, '2025-08-13', 'Pago de Servicios', 618.00, 'Transferencia', '@⁨Lucho⁩  anotar pago UTE Torre Maldonado', '689d3f0b2bfd6-4316b108-b55b-410f-b548-5abda28f0447.jpeg', 36, 1, '2025-08-13 20:42:35', '2025-08-22 19:19:10', 1, '2025-08-22 19:19:10', 1),
(54, '2025-08-15', 'Pago de Gastos comunes', 4719.00, 'Transferencia', '@⁨Lucho⁩ ingresar gastos , comunes galería de las americas', '689fb538cf287-db039a9c-12af-4111-a7bb-b56935638b1c.jpeg', NULL, 1, '2025-08-15 17:31:20', '2025-08-22 19:26:08', 1, '2025-08-22 19:26:08', 1),
(55, '2025-08-15', 'Pago de Gastos comunes', 1316.00, 'Transferencia', '@⁨Lucho⁩  anotar pago $1276 GC local 103 que está libre + $40 comision del banco', '689fb5b9ab3a1-ffd9d851-08bb-4a89-9c5b-09661b5075ae.jpeg', NULL, 1, '2025-08-15 17:33:29', '2025-08-22 19:26:06', 1, '2025-08-22 19:26:06', 1),
(56, '2025-08-18', 'Pago de Mantenimiento', 7629.00, 'Transferencia', 'Arreglo portón materiales', '68a373d4a10a8-cba31435-11dc-4aeb-847d-801b9044dd51.jpeg', 50, 1, '2025-08-18 13:41:24', '2025-08-22 19:32:25', 1, '2025-08-22 19:32:25', 1),
(57, '2025-08-18', 'Pago de Mantenimiento', 3390.00, 'Transferencia', 'Materiales arreglo portón', '68a37409bef63-71b1e9d2-c8bd-4db3-8f0d-6e546866af3f.jpeg', 50, 1, '2025-08-18 13:42:17', '2025-08-22 19:32:30', 1, '2025-08-22 19:32:30', 1),
(58, '2025-08-18', 'Pago de Mantenimiento', 439.00, 'Transferencia', 'Ingresar ese gasto barraca para Dionisio coronel 520 transferencia', '68a3a20612a26-DCTransferencia_a_terceros_2508180488746355.pdf', 56, 1, '2025-08-18 16:58:30', '2025-08-22 19:32:43', 1, '2025-08-22 19:32:43', 1),
(59, '2025-08-22', 'Pago de Servicios', 337.00, 'Efectivo', 'Anotar gasto Movistar papá Martha en efectivo pague $337', '68a89a5a69a5e-105be715-c388-4caa-ac3f-8387e2560d43.jpeg', NULL, 1, '2025-08-22 11:27:06', '2025-08-22 11:27:06', 0, NULL, NULL),
(60, '2025-08-19', 'Pago de Impuestos', 4122.00, 'Transferencia', 'Paganza varios', '68a90d0d5f970-724e6015-9c01-4569-895f-cdb0e2432401.jpeg', NULL, 1, '2025-08-22 19:36:29', '2025-08-22 19:36:42', 1, '2025-08-22 19:36:42', 1),
(61, '2025-08-20', 'Pago de Impuestos', 612.00, 'Transferencia', 'Paganza quedó en la billetera', '68a90d910423a-776d430a-fe26-4523-a714-b6750cb0ac75.jpeg', NULL, 1, '2025-08-22 19:38:41', '2025-08-22 19:38:57', 1, '2025-08-22 19:38:57', 1),
(64, '2025-07-02', 'Otros', 6584.00, 'Transferencia', '02/07/2025	TRF. E-BROU OTROS		2507020457125576	MARÍA PÉREZ - FORESTIER PAGO VI	6,584.00', NULL, NULL, 1, '2025-08-22 21:42:41', '2025-08-22 21:42:41', 0, NULL, NULL),
(65, '2025-08-22', 'Arqueo de Caja (resta)', 6.00, 'Transferencia', 'Resto $6 para quedar iguales', NULL, NULL, 1, '2025-08-22 22:22:24', '2025-08-22 22:23:17', 0, NULL, NULL),
(66, '2025-08-27', 'Pago de Mantenimiento', 40850.00, 'Transferencia', 'Ahí @⁨Lucho⁩  anota el gasto $40.850 que es la mano de obra y materiales , eso lo pagué yo , ahora ya giro esa plata y en asunto le pongo reforma garage DC', '68af89fc91947-f7d9ddc7-9fbb-4a75-b752-881ca1d4bed0.jpeg', 56, 1, '2025-08-27 17:43:08', '2025-10-30 19:34:56', 1, '2025-10-30 19:34:56', 1),
(67, '2025-08-31', 'Pago de Gastos comunes', 4526.00, 'Transferencia', '@⁨Lucho⁩  Anotar pago de Gastos Comunes Galeria Caracol 106 SS, es nuestro apto de Punta', '68b50892d5c7a-GASTOS COMUNES GALERIA CARACOL 106 SS JULIO AGOSTO Y SETIEMBRE.pdf', 22, 1, '2025-08-31 21:44:34', '2025-10-30 19:38:04', 1, '2025-10-30 19:38:04', 1),
(68, '2025-08-31', 'Pago de Gastos comunes', 5300.00, 'Transferencia', '@⁨Lucho⁩  Este es el pago de las expensas de SOLANAS', '68b508f2aad31-PAGO EXPENSAS SOLANAS.pdf', 53, 1, '2025-08-31 21:46:10', '2025-10-30 19:39:26', 1, '2025-10-30 19:39:26', 1),
(69, '2025-09-04', 'Pago de Gastos comunes', 19574.00, 'Transferencia', 'Pago gastos comunes edificio pan de azúcar 116B diego Borgia\r\nEsto tengo q pagar la mitad yo Raúl', '68ba072eaf900-Transferencia_a_Otros_Bancos_2509040495270146.pdf', 21, 1, '2025-09-04 16:39:58', '2025-10-30 19:43:41', 1, '2025-10-30 19:43:41', 1),
(70, '2025-09-04', 'Pago de Gastos comunes', 4480.00, 'Efectivo', '@⁨Lucho⁩ anotar gasto en efectivo gastos comunes local 7-8 y 41 galería entrevero', '68ba0e37adeb4-752e5828-4cf3-4425-aac1-760571de96ff.jpeg', 17, 1, '2025-09-04 17:09:59', '2025-09-04 17:09:59', 0, NULL, NULL),
(71, '2025-09-04', 'Pago de Gastos comunes', 2500.00, 'Efectivo', '@⁨Lucho⁩ anotar gasto en efectivo gastos comunes local 7-8 y 41 galería entrevero', '68ba0e6806853-752e5828-4cf3-4425-aac1-760571de96ff.jpeg', 18, 1, '2025-09-04 17:10:48', '2025-09-04 17:10:48', 0, NULL, NULL),
(72, '2025-09-08', 'Pago de Impuestos', 13980.00, 'Transferencia', '@⁨Lucho⁩  anotar gasto impuestos Rondeau el total es $27960 pero de la cuenta sale solo $13.980 q es la mitad la otra mitad la pago. Eso ya lo pagué yo y me transferi la mitad', '68bf21ceaf3d3-8d1a49fd-bfda-472f-9547-32223022c85d.jpeg', 19, 1, '2025-09-08 13:34:54', '2025-10-30 19:45:11', 1, '2025-10-30 19:45:11', 1),
(73, '2025-09-09', 'Arqueo de Caja (resta)', 99000.00, 'Efectivo', 'Depósito en banco efectivo 99mil', NULL, NULL, 1, '2025-09-09 10:02:38', '2025-09-09 10:02:38', 0, NULL, NULL),
(74, '2025-08-28', 'Pago de Servicios', 3569.00, 'Transferencia', '@⁨Lucho⁩  anotar pago PAGANZA \r\n$ 606 + $ 642 + $ 945 + $ 472 + $ 904 =\r\n$ 3.569,18 el 28/8', '68c0e0dbce8c6-cd0882f5-3dad-4b1d-b7f4-867cf2333a10.jpeg', NULL, 1, '2025-09-09 21:22:19', '2025-10-30 19:35:26', 1, '2025-10-30 19:35:26', 1),
(75, '2025-09-03', 'Pago de Servicios', 2295.00, 'Transferencia', '@⁨Lucho⁩  anotar pago PAGANZA $ 1559 + $ 736 =\r\n$ 2.295,00 el 3/9', '68c0e1255ee14-IMG_3193.png', NULL, 1, '2025-09-09 21:23:33', '2025-10-30 19:47:40', 1, '2025-10-30 19:46:51', 1),
(76, '2025-09-09', 'Pago de Servicios', 2690.00, 'Transferencia', '@⁨Lucho⁩ anotar pago PAGANZA\r\n$ 676,72 + $ 671,80 + $ 537,29 + $ 805\r\n$ 2.690,81 el 09/09', '68c0e15eb093c-e98a55b8-8bea-4ef3-af45-41cf62a5d2b7.jpeg', NULL, 1, '2025-09-09 21:24:30', '2025-10-30 19:46:16', 1, '2025-10-30 19:46:16', 1),
(77, '2025-09-12', 'Pago de Impuestos', 1766.00, 'Transferencia', '@⁨Lucho⁩  anotar pago de Tributos Local 21 del SOL', '68c4aa22223ba-a191bc4f-e508-4652-aec7-0b56cb2e2b5e.jpeg', 4, 1, '2025-09-12 18:17:54', '2025-10-30 19:53:25', 1, '2025-10-30 19:53:25', 1),
(78, '2025-09-12', 'Pago de Impuestos', 1766.00, 'Transferencia', '@⁨Lucho⁩  anotar pago de Tributos Local 23 del SOL', '68c4aa64158cd-0e589246-af0d-48ea-9b75-5134ea39d792.jpeg', 5, 1, '2025-09-12 18:19:00', '2025-10-30 19:53:28', 1, '2025-10-30 19:53:28', 1),
(79, '2025-09-15', 'Pago de Servicios', 14874.00, 'Transferencia', '@⁨Lucho⁩ anotar gasto le pague a liana hasta el día de hoy', '68c81f50ba652-Transferencia_a_terceros_2509150499600063.pdf', NULL, 1, '2025-09-15 09:14:40', '2025-10-30 19:57:25', 1, '2025-10-30 19:57:25', 1),
(80, '2025-09-15', 'Otros', 31100.00, 'Transferencia', '@⁨Lucho⁩  REGISTRAR PAGO DE alquiler Agosto que corresponde pagar en SETIEMBRE de Garage Bolo', '68c84652e9523-747085b6-b120-4cb9-859d-e8bf96593ce0.jpeg', 50, 1, '2025-09-15 12:01:06', '2025-10-30 19:57:43', 1, '2025-10-30 19:57:43', 1),
(81, '2025-09-19', 'Pago de Gastos comunes', 6875.00, 'Transferencia', '@⁨Lucho⁩ anotar gasto , GC galería americas\r\nL5 - 346\r\nL31 - 2830\r\nL35 - 403\r\n103 Prop E inq - 2721\r\n105 - 259\r\n106 - 259\r\nTOTAL PAGO $ 6818\r\ncomision banco $57,95\r\nTotal banco $6875', '68cdae5e50de9-00100171000670006703284038420250919-Detalle_Movimiento_Cuenta.pdf', NULL, 1, '2025-09-19 14:26:22', '2025-11-05 19:14:28', 1, '2025-10-30 20:00:56', 1),
(82, '2025-10-02', 'Pago de Convenios', 13980.00, 'Transferencia', '@⁨Lucho⁩ anotar gasto pago convenio Rondeau 1524 $13980 Es la mitad de el total la otra mitad la pagué yo', '68dedc67c9b94-3a5648b9-67fe-450c-9b75-066b6fe656a4.jpeg', 19, 1, '2025-10-02 15:11:19', '2025-10-30 20:04:19', 1, '2025-10-30 20:04:19', 1),
(83, '2025-10-02', 'Pago de Convenios', 8475.00, 'Transferencia', '@⁨Lucho⁩ anotar gasto convenio Fátima 2 cuotas , la del mes pasado y este', '68dedcc7c1de9-2d723f2a-b78e-4b04-81f1-fc8e49d7df74.jpeg', NULL, 1, '2025-10-02 15:12:55', '2025-10-30 20:05:28', 1, '2025-10-30 20:05:28', 1),
(84, '2025-10-08', 'Pago de Reparaciones', 1580.00, 'Transferencia', '@⁨Lucho⁩ ingresar GASTO herrajes para puerta de vidrio', '68e6a6dbbb8d5-f7881b69-f222-4719-aabc-8e1a6c228101.jpeg', NULL, 1, '2025-10-08 13:00:59', '2025-10-30 20:07:01', 1, '2025-10-30 20:07:01', 1),
(85, '2025-10-10', 'Pago de Gastos comunes', 6958.00, 'Transferencia', '@⁨Lucho⁩ ingresar pago gastos comunes galeria entrevero local 7y 8 y 41 \r\n$6900 + $58 comision', '68e9b247952df-Transferencia_a_Otros_Bancos_2510100511249739.pdf', 17, 1, '2025-10-10 20:26:31', '2025-11-05 19:12:33', 1, '2025-10-30 20:08:45', 1),
(86, '2025-10-10', 'Otros', 31100.00, 'Transferencia', '@⁨Lucho⁩ ingresar pago garage bolonese a maria di candia , anotar gasto $31.100', '68e9b29094daa-00100171007230005516362257520251010-Detalle_Movimiento_Cuenta.pdf', 50, 1, '2025-10-10 20:27:44', '2025-10-30 20:08:38', 1, '2025-10-30 20:08:38', 1),
(87, '2025-10-10', 'Pago de Servicios', 993.00, 'Transferencia', '@⁨Lucho⁩  anotar gasto BROU Movistar papá y Martha $993 los 2', '68e9b4cc1c8d9-e7de600e-2ff5-4a47-92c7-ccec812cfe57.jpeg', NULL, 1, '2025-10-10 20:37:16', '2025-10-30 20:09:01', 1, '2025-10-30 20:09:01', 1),
(88, '2025-10-13', 'Arqueo de Caja (resta)', 80000.00, 'Efectivo', '@⁨Viviana Pérez⁩ @⁨Lucho⁩ hice depósito en la cuenta de alquileres $80.000 de el efectivo recaudado , queda en la caja $1.614', NULL, NULL, 1, '2025-10-13 18:44:08', '2025-10-13 18:44:08', 0, NULL, NULL),
(89, '2025-10-15', 'Pago de Servicios', 13483.00, 'Transferencia', '@⁨Lucho⁩ anotar pago Mercadolibre $ 13.483.-', '68f015aea86cb-d60d7c26-4c29-440f-ae1c-b3e22d32f919.jpeg', NULL, 1, '2025-10-15 16:44:14', '2025-10-30 20:16:37', 1, '2025-10-30 20:16:37', 1),
(90, '2025-10-16', 'Pago de Gastos comunes', 86220.00, 'Transferencia', 'Pago Galería del SOL Gastos Comunes AL DIA\r\n10\r\n19900\r\n\r\n13\r\n8200\r\n\r\n18\r\n17000\r\n\r\n21\r\n16450\r\n\r\n23\r\n16450\r\n\r\n27\r\n8220\r\n\r\nTOTAL\r\n86220', '68f18d965184d-Transferencia_a_terceros_2510160513665154.pdf', NULL, 1, '2025-10-16 19:28:06', '2025-10-30 20:16:45', 1, '2025-10-30 20:16:45', 1),
(91, '2025-10-17', 'Pago de Gastos comunes', 7260.00, 'Transferencia', 'pago gastos comunes galeria de las americas desde el brou\r\nL5 - 367\r\nL31 - 3000\r\nL35 - 428\r\nL103 prop inq - 2853\r\nL105 - 275\r\nL106 - 276\r\nTotal 7199', '68f26e68d8e16-Transferencia_a_Otros_Bancos_2510170514135419.pdf', NULL, 1, '2025-10-17 11:27:20', '2025-11-05 19:11:16', 1, '2025-10-30 20:16:53', 1),
(92, '2025-10-21', 'Pago de Gastos comunes', 4413.00, 'Transferencia', '@⁨Lucho⁩ anotar pago Expensas extraordinarias Solanas', '68f8c4738a69c-SOLANAS pago expensas extraordinarias.pdf', 53, 1, '2025-10-22 06:48:03', '2025-11-05 17:59:15', 1, '2025-11-05 17:59:15', 1),
(93, '2025-10-21', 'Pago de Gastos comunes', 6001.00, 'Transferencia', '@⁨Lucho⁩  anotar pago Gastos Comunes PAN DE AZUCAR OCT - DIC 2025 (ex Diego Borja)', '68f8c51ad4bb6-GS CS PAN DE AZUCAR OCT DIC 2025.pdf', 21, 1, '2025-10-22 06:50:50', '2025-11-05 19:09:12', 1, '2025-10-30 20:22:57', 1),
(94, '2025-09-16', 'Paganza', 1587.00, 'Transferencia', '16/09/2025\r\n* $ 1587,41.-*\r\nOSE Neptunia $ 757.-\r\nUTE Bolognesi Apartamento $ 830,41', '68fc0ae144171-Captura de pantalla 2025-10-24 202420.png', NULL, 1, '2025-10-24 18:25:21', '2025-10-30 20:00:42', 1, '2025-10-30 20:00:42', 1),
(95, '2025-09-18', 'Paganza', 2087.00, 'Transferencia', '18/09/2025\r\n$ 2087,37\r\nOse bolognesi 117 $ 514,29\r\nUte Sol 21 $ 654,35\r\nUte 27 del SOL $ 918,75', '68fc0b1f7384d-Captura de pantalla 2025-10-24 202609.png', NULL, 1, '2025-10-24 18:26:23', '2025-10-30 20:00:45', 1, '2025-10-30 20:00:45', 1),
(96, '2025-09-30', 'Paganza', 3127.00, 'Transferencia', '30/09/2025\r\n$ 3127,15\r\nOSE Luis B. Berres 4137	642\r\nTarifa Saneamiento LBB 4137	501\r\nUTE Dionisio Coronel 528	606\r\nOse Figueroa 1845	472\r\nUte Bolognesi Garage	906,15', '68fc0b5f397bb-Captura de pantalla 2025-10-24 202659.png', NULL, 1, '2025-10-24 18:27:27', '2025-10-30 20:04:11', 1, '2025-10-30 20:04:11', 1),
(97, '2025-10-03', 'Paganza', 2779.00, 'Transferencia', '$ 2779,89\r\n03/10/2025\r\nUte Bolognesi Garage	920,89\r\nIMM TD LBB 4137	1123\r\nUTE Neptunia	736', '68fc0b83c1fed-Captura de pantalla 2025-10-24 202756.png', NULL, 1, '2025-10-24 18:28:03', '2025-10-30 20:05:39', 1, '2025-10-30 20:05:39', 1),
(98, '2025-10-10', 'Paganza', 5764.00, 'Transferencia', '$ 5764,23\r\n10/10/2025\r\nTD Dionisio coronel 528	845\r\nIMM TG Sol 21	1559\r\nUTE Caracol 106ss	537,29\r\nUte Acuña de Figueroa 1845 ap 6	600,98\r\nIMM TG galeria sol local 10	1559\r\nUTE local 31 galeria de las americas	662,96', '68fc0c290d6e8-Captura de pantalla 2025-10-24 203028.png', NULL, 1, '2025-10-24 18:30:49', '2025-10-30 20:09:11', 1, '2025-10-30 20:09:11', 1),
(99, '2025-10-13', 'Paganza', 4373.00, 'Transferencia', '$ 4367\r\n13/10/2025\r\nIM TG Sol 27	1559\r\nImpuesto de Primaria	2808', '68fc0c5dd6074-Captura_de_pantalla_2025-10-24_203125.png', NULL, 1, '2025-10-24 18:31:41', '2025-10-30 20:15:56', 1, '2025-10-30 20:15:56', 1),
(100, '2025-10-20', 'Paganza', 7680.00, 'Transferencia', '$ 7680,51\r\n20/10/2025\r\nIntendencia de Montevideo local 103ep americas	1559\r\nIMM Adic Merc Bolognesi 117	1321\r\nTD Bolognese 117	1123\r\nCaracol 106ss	805\r\nUte 27 del SOL	654,35\r\nUte Sol 21	654,35\r\nUTE Bolognesi Apartamento	806,81\r\nOSE Neptunia	757', '68fc0c88f423b-Captura de pantalla 2025-10-24 203214.png', NULL, 1, '2025-10-24 18:32:25', '2025-10-30 20:19:08', 1, '2025-10-30 20:19:08', 1),
(101, '2025-10-21', 'Paganza', 514.00, 'Transferencia', '$ 514,29\r\nOSE Bolognesi', '68fc0cc38223a-Captura de pantalla 2025-10-24 203315.png', 50, 1, '2025-10-24 18:33:23', '2025-10-30 20:19:39', 1, '2025-10-30 20:19:39', 1),
(102, '2025-11-04', 'Pago de Gastos comunes', 3798.00, 'Transferencia', '@⁨Lucho⁩  anotar pago GALERIA CARACOL $ 3.798.- Octubre Noviembre y Diciembre 2025', '690a6ce452ae7-85423401-6c9b-46cb-9392-9f646b6522aa.jpeg', NULL, 1, '2025-11-04 15:15:16', '2025-11-05 20:17:20', 1, '2025-11-05 20:17:20', 1),
(103, '2025-11-04', 'Pago de Gastos comunes', 6958.00, 'Transferencia', 'y GALERIA ENTREVERO Local 41 ($ 2.500) , 7 y 8 ($ 4.400)\r\n$ 6.900.- en total', '690a6d50940fc-974620b9-20af-4e3d-ba65-94df5704e864.jpeg', NULL, 1, '2025-11-04 15:17:04', '2025-11-05 20:17:31', 1, '2025-11-05 20:17:31', 1),
(104, '2025-10-21', 'Pago de Gastos comunes', 5248.00, 'Transferencia', 'Pago expensas 4 de 6', '690bf4d347005-SOLANAS pago expensas 4 de 6.pdf', 53, 1, '2025-11-05 19:07:31', '2025-11-05 19:08:08', 1, '2025-11-05 19:08:08', 1),
(105, '2025-09-15', 'Pago de Impuestos', 232.00, 'Transferencia', 'PAGO SERVICIOS IM-Otros tribut	\r\n2509130499295913\r\nNo sabemos a qué corresponde pero está en el banco', NULL, NULL, 1, '2025-11-05 19:19:03', '2025-11-05 19:43:47', 1, '2025-11-05 19:43:47', 1),
(106, '2025-11-05', 'Pago de Impuestos', 5193.00, 'Transferencia', '@Lucho anotar pago TRIBUTOS DOMICILIARIOS LOCAL 41 Gaby Nails', '690c045f75f44-WhatsApp Image 2025-11-05 at 23.06.55.jpeg', 18, 1, '2025-11-05 20:13:51', '2025-11-05 20:18:59', 1, '2025-11-05 20:18:59', 1),
(107, '2025-11-04', 'Paganza', 2795.00, 'Transferencia', '04/11/2025	PAGANZA - DEBITOS AUTOMATICOS		000000008806004		199 - Casa Matriz	FALSO	2,795.78', NULL, NULL, 1, '2025-11-05 20:22:07', '2025-11-05 20:23:40', 1, '2025-11-05 20:23:40', 1),
(108, '2025-11-05', 'Paganza', 1266.00, 'Transferencia', '05/11/2025	PAGANZA - DEBITOS AUTOMATICOS		000000008806004		199 - Casa Matriz	FALSO	1,266.00', NULL, NULL, 1, '2025-11-05 20:22:32', '2025-11-05 20:23:38', 1, '2025-11-05 20:23:38', 1),
(109, '2025-11-06', 'Arqueo de Caja (resta)', 11.00, 'Transferencia', 'Resto para quedar igual banco', NULL, NULL, 1, '2025-11-05 21:07:41', '2025-11-05 21:07:41', 0, NULL, NULL),
(110, '2025-11-06', 'Pago de Convenios', 13980.00, 'Transferencia', '@⁨Lucho⁩ anotar gasto impuestos de Rondeau 1524 la mitad , la otra mitad pagó yo $13.980 BROU', '690cd13497f00-17efe112-ee92-493e-b0d6-01ff62c8ae21.jpeg', 19, 1, '2025-11-06 10:47:48', '2025-11-06 10:47:48', 0, NULL, NULL),
(111, '2025-11-06', 'Pago de Convenios', 4226.00, 'Transferencia', '@⁨Lucho⁩ anotar gasto pago convenio Fátima $4226 BROU', '690cd1758088c-9d738e04-01d2-4601-a4d4-a7433da37b4f.jpeg', NULL, 1, '2025-11-06 10:48:53', '2025-11-06 10:48:53', 0, NULL, NULL),
(112, '2025-11-06', 'Pago de Servicios', 993.00, 'Transferencia', '@⁨Lucho⁩ anota gasto Movistar papa y Martha $993 BROU', '690cdba7ef82f-6bc79de5-62aa-4f76-bb4c-1d5630d4f37d.jpeg', NULL, 1, '2025-11-06 11:32:23', '2025-11-06 11:32:23', 0, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `inquilinos`
--

INSERT INTO `inquilinos` (`id`, `nombre`, `cedula`, `telefono`, `email`, `vehiculo`, `matricula`, `documentos`, `comentarios`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Patricia', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(2, 'Carolina', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(3, 'Mateo Guzzo Arcadia', '9999', '', '', '', '', '[]', '', 0, NULL, '2025-07-23 21:42:02'),
(4, 'Sofia Veronica García', '999', '', '', '', '', '[]', '', 0, NULL, '2025-07-23 21:45:46'),
(6, 'Marcia (Ana Karen P)', '999', '', '', '', '', '[]', '', 0, NULL, '2025-07-23 21:46:43'),
(7, 'Juan Polvera', '999', '‪59897023166‬', '', '', '', '[]', '', 0, NULL, '2025-08-19 10:52:30'),
(8, 'Exafix', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(10, 'Yasmani y Sheylan (Hector Pérez)', '999', '096062790', '', '', '', '[]', '', 0, NULL, '2025-07-23 21:16:09'),
(11, 'Claudia', '', '', '', '', '', '', NULL, 0, NULL, NULL),
(12, 'Elvis Parra', '999', '', '', '', '', '[]', '', 0, NULL, '2025-07-10 14:09:22'),
(13, 'Juan Carlos Petit', '', '099244504', '', '', '', '', NULL, 0, NULL, NULL),
(15, 'Elsa Núñez', '999', '94800635', '', '', '', '[]', '', 0, NULL, '2025-07-15 11:08:27'),
(18, 'Gaby Nails Yaima Machin', '999', '', '', '', '', '[]', '', 0, NULL, '2025-07-23 22:02:36'),
(19, 'George', '999', '', '', '', '', '[]', NULL, 0, NULL, '2025-06-25 12:49:46'),
(20, 'Nahuel', '999', '095653586', '', '', '', '[]', NULL, 0, NULL, '2025-06-25 21:58:09'),
(21, 'Porteño Diego Borja', '999', '', '', '', '', '[]', NULL, 0, NULL, '2025-07-05 10:51:27'),
(23, 'Sarkisian', '999', '099647878', '', 'Onix Sedan Chevrolet', 'SDC5513', '[\"68616c4a4954b-ec8da04c-8f1c-4e89-817d-2ee8617dcbcb.jpeg\"]', NULL, 0, NULL, '2025-06-29 11:39:38'),
(24, 'Eduardo Walter Bonilla', '999', '095199525', '', 'Geely', 'SDF2678', '[]', '', 0, NULL, '2025-08-07 11:55:45'),
(25, 'Cristian y Érica', '999', '099764804', '', 'Fiat Mobi', 'SCM1429', '[\"686169f9979da-d11edcdb-1fdd-4f05-b6d7-f13f31a62254.jpeg\"]', NULL, 0, NULL, '2025-07-04 13:26:55'),
(26, 'Corina', '999', '095277483', '', 'Hyundai i10', 'SBM1892', '[\"68616a3ac424b-2e9cf63d-46a6-4a7a-bc5d-442eb6d5d2e1.jpeg\"]', NULL, 0, NULL, '2025-06-29 11:30:50'),
(27, 'Alejandra Ancheta', '999', '095860816', '', 'Onix Hatch', 'SCS2773', '[]', '', 0, NULL, '2025-07-08 15:16:31'),
(28, 'Walter Amarok', '999', '097089289', '', 'Amarok', 'SCG3263', '[]', '', 0, NULL, '2025-08-07 11:50:51'),
(29, 'Natacha Figueroa Porley', '999', '099415432', '', 'Golf', '', '[]', NULL, 0, NULL, '2025-06-25 21:43:44'),
(30, 'Martin Gbolo17', '999', '095308197', '', 'Fiat Ritmo', '', '[]', NULL, 0, NULL, '2025-06-25 21:14:14'),
(31, 'Gabriel Galain', '99', '0994052920', '', 'BMW', 'SDD8965', '[]', NULL, 0, NULL, '2025-06-24 20:52:10'),
(32, 'Laura / Fabian', '999', '096325786', '', 'Corsa', 'SBM6092', '[\"68616c7e5d71f-137de2bd-a6bd-4f1a-829a-33c2e4c3cd19.jpeg\"]', NULL, 0, NULL, '2025-07-07 09:01:48'),
(34, 'Martin Chiffone Moto', '999', '098669973', '', 'Moto', '', '[\"68616cb78c540-462f5238-71e5-41b5-9203-e01a5dab6dcc.jpeg\"]', '', 0, NULL, '2025-10-02 12:56:01'),
(35, 'Carlos Guerra', '', '094801410', '', '', '', '', NULL, 0, NULL, NULL),
(36, 'Marta Bueno', '999', '096576342', '', '', '', '[]', NULL, 0, NULL, '2025-06-25 21:33:43'),
(37, 'Alejandro', '', '098171789', '', 'Toyota', '', '', NULL, 0, NULL, NULL),
(38, 'Antonella', '', '095794847', '', 'Peugeot', '', '', NULL, 0, NULL, NULL),
(39, 'Edgardo', '', '', '', 'Camioneta', '', '', NULL, 0, NULL, NULL),
(41, 'Francisco Sanguinetti', '999', '', '', 'Ford Ka', '', '[]', '', 0, NULL, '2025-08-07 13:08:52'),
(42, 'Valverde', '', '095856424', '', 'Ford Escort', '', '', NULL, 0, NULL, NULL),
(43, 'Raul Pérez Rosado (todos)', '13474169', '', '', 'Jeep', '', '[]', '', 0, NULL, '2025-07-08 15:48:25'),
(44, 'Cristina', '', '094106036', '', 'Suzuki', '', '', NULL, 0, NULL, NULL),
(47, 'Camila Moreira', '999', '92959219', 'moreiracamila1891@gmail.com', '', '', '[]', '', 1, '2025-06-09 19:55:22', '2025-07-08 15:49:00'),
(48, 'Guerrero A Alexis Joel', '', '', '', '', '', '[]', NULL, 1, '2025-06-10 07:54:11', NULL),
(49, 'Camila Perdomo (Magela Mendioroz Gtia)', '12383159', '092476991', '', '', '', '[\"6848ff672b302-CEDULA MAGELA DORSO.jpg\",\"6848ff672b4e0-CEDULA MAGELA FRENTE.jpg\",\"6848ff672b5e5-RECIBO DE SUELDO 04-2025.jpg\",\"6848ff672b745-RECIBOS DE SUELDO 1.jpg\",\"6848ff672b87e-RECIBOS DE SUELDO 05-2025.jpg\"]', NULL, 2, '2025-06-10 23:00:01', '2025-06-25 22:02:13'),
(50, 'Maria Viviana Perez Bandera', '38284692', '94477007', '', '', '', '[]', '', 2, '2025-06-11 00:05:35', '2025-07-08 21:55:59'),
(51, 'Oscar Moreira', '9999', '99651973', '', 'BYD F3', 'SCL2011', '[]', '', 1, '2025-06-24 20:30:35', '2025-07-08 21:56:15'),
(52, 'Raúl Pérez Bandera Jr', '999', '94423423', 'raulperez53@hotmail.com', '', '', '[]', '', 1, '2025-07-04 11:53:44', '2025-07-08 21:55:40'),
(53, 'Álvaro Correa Ferrin', '15764380', '', '', '', '', '[\"686c8608b9176-IMG_2090.png\"]', 'Otra cosa importante hay q hacer el contrato del local 31B y ya debe el mes pasado y ahora ya tiene q pagar este mes\r\n\r\nÁlvaro Correa Ferrin \r\nC.I. 1576438-0\r\nTeatro La gringa \r\nRut 216977150010\r\nA partir del 1/6/25', 1, '2025-07-07 21:44:54', '2025-07-09 15:16:28'),
(54, 'Ariana Bonilla', '999', '', '', 'Tiggo 4', '', '[]', '[15:22, 8/7/2025] Raulo: Hablé con Eduardo de bolognese va a ingresar la hija con una Tiggo 4 , $3600 Ariana Bonilla se llama\r\n[15:22, 8/7/2025] Raulo: Ya va a pagar este mes porque quiere reservar el lugar\r\n[15:23, 8/7/2025] Raulo: La camioneta ingresa a fin de mes se la dan', 1, '2025-07-08 15:12:10', NULL),
(55, 'Aparecida Moto', '999', '', '', 'Moto', '', '[]', '', 1, '2025-07-17 20:47:52', '2025-10-02 12:55:51'),
(56, 'MIGUEL ANGEL ALARCON PEÑA', '48846682', '', '', '', '', '[]', '', 1, '2025-08-09 17:22:31', '2025-08-09 17:25:12'),
(57, 'Ana Paula Gutiérrez Beron', '999', '', '', '', '', '[]', '', 1, '2025-09-01 17:42:04', NULL),
(58, '(Alejandra) Yerardo Rangel Orellanes Reyes', '9999', '', '', '', '', '[]', '', 1, '2025-11-05 19:24:28', '2025-11-05 19:34:20'),
(59, 'YENISSE NOEL FERREIRA LOPEZ (Inquilino Raul)', '999', '', '', '', '', '[]', '', 1, '2025-11-05 19:39:36', '2025-11-05 20:11:56');

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
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `contrato_id`, `usuario_id`, `periodo`, `mes`, `anio`, `fecha`, `fecha_creacion`, `fecha_programada`, `fecha_recibido`, `concepto`, `tipo_pago`, `importe`, `comentario`, `comprobante`, `pagado`, `validado`, `fecha_validacion`, `usuario_validacion_id`) VALUES
(1, 18, NULL, '2025-06', NULL, NULL, '2025-06-05', NULL, NULL, '2025-06-05', 'Pago mensual', 'Transferencia Papá', 3600, 'Agregar pago cochera bolo sarkisian 5/6 transf BROU', '68474c9a23c8d-pago sarkis brou.png', NULL, 0, NULL, NULL),
(2, 23, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 4300, '', '6847731c7f0bb-IMG_1682.jpeg', NULL, 1, '2025-07-14 12:57:43', 1),
(3, 26, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 4200, 'Pago Gabriel galain', '6847772b46e78-IMG_1682.jpeg', NULL, 1, '2025-07-14 12:57:51', 1),
(4, 27, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 3600, 'Corsa', '68477956d15ba-IMG_1682.jpeg', NULL, 1, '2025-07-14 12:57:57', 1),
(5, 35, NULL, '2025-06', NULL, NULL, '2025-06-08', NULL, NULL, '2025-06-08', 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Ford escort', '68477b15bfce3-IMG_1682.jpeg', NULL, 1, '2025-07-14 13:09:18', 1),
(20, 46, NULL, '2025-05', NULL, NULL, '2025-05-06', NULL, NULL, '2025-05-06', 'Pago mensual', 'Depósito Cuenta Lucho', 6500, '', '684782ed5dc57-074bb8cb-d22b-4923-9bfd-2d2fb8a2a798.jpeg', NULL, 0, NULL, NULL),
(35, 47, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 32705, '', '68482b5dccada-RPMPagoJunio2025.pdf', NULL, 0, NULL, NULL),
(36, 14, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 9100, '[10/6/25, 10:49:51] Viviana Pérez: Pago alquiler Local 41 GabyNails Este es el que hay que deducir que hacen con los gastos comunes... queda horrible preguntarle a la tipa si están incluidos o no en esos 9100, imagino quw si porque este local es de 2 x 1 metro, es el pasillo no?\n[10:51, 10/6/2025] Raulo: Si calculo q si\n[10:51, 10/6/2025] Raulo: Paga $2200 ese de gc\n[10:51, 10/6/2025] Raulo: En una galería de mierda\n[10:51, 10/6/2025] Raulo: Son $6800 de alquiler está bien', '6848425773709-8843f0ed-0cf3-4b88-87df-82c0100e6e50.jpeg', NULL, 0, NULL, NULL),
(37, 5, NULL, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 9500, 'Vivi manda por wpp', '6848552446b85-SolLocal27Comprobante_TransferenciaEnElPais_09_06_2025_15_19.pdf', NULL, 0, NULL, NULL),
(38, 2, NULL, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 7500, 'Vivi manda wpp', '6848557959f89-Local13SolTransferencia_a_terceros_2506090446475352.pdf', NULL, 0, NULL, NULL),
(52, 48, NULL, '2025-06', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 31110, 'Quedó paga mensualidad alquiler garage Bolognese a Cristina di cándia', '684857bfbb38f-IMG_1696.png', NULL, 0, NULL, NULL),
(66, 1, NULL, '2025-05', NULL, NULL, '2025-06-09', NULL, NULL, NULL, 'Pago mensual', 'Depósito Cuenta Papá', 12500, '', '684907bd7f784-Alquiler LOCAL 10 del SOL de Mayo.jpg', NULL, 0, NULL, NULL),
(80, 50, NULL, '2025-05', NULL, NULL, '2025-06-11', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 32154, '$ 18 Abril + $ 18 Mayo - $ 3.846 Contribucion Inmobiliaria = $ 32.154.- para quedar al dia', '68490f58e6cf6-PAGO ALQUILER ABRIL Y MAYO 2025 IMPRENTA.jpg', NULL, 0, NULL, NULL),
(81, 8, NULL, '2025-05', NULL, NULL, '2025-06-11', NULL, NULL, NULL, 'Pago mensual', 'Efectivo', 9000, 'Sub contrato nuevo inquilino', '6849e3976dae7-PagoLocal35GalAmericas.jpeg', NULL, 1, '2025-07-14 13:39:17', 1),
(82, 19, NULL, '2025-06', NULL, NULL, '2025-06-14', NULL, NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 3600, 'Raúl avisa por wpp ', '684e14365a2aa-IMG_1737.jpeg', NULL, 1, '2025-07-14 13:34:24', 1),
(83, 36, NULL, '2025-06', NULL, NULL, '2025-06-15', NULL, NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Avisa Raúl por wpp', '684ee64835229-IMG_1742.jpeg', NULL, 1, '2025-07-14 13:38:36', 1),
(84, 15, NULL, '2025-06', NULL, NULL, '2025-06-16', NULL, NULL, NULL, 'Pago mensual', 'Depósito', 40000, 'Raúl avisa por wpp, en noviembre cambia de precio ', '6850186789beb-e4c82e64-cb85-444a-b2aa-5278e21c5a1d.jpeg', NULL, 0, NULL, NULL),
(85, 7, NULL, '2025-06', NULL, NULL, '2025-06-16', NULL, NULL, NULL, 'Pago mensual', 'Efectivo', 8000, 'Avisa raul wpp ', '685047acb2b1b-IMG_1749.jpeg', NULL, 1, '2025-07-14 13:39:54', 1),
(86, 1, NULL, '2025-06', NULL, NULL, '2025-06-16', NULL, NULL, NULL, 'Pago mensual', 'Depósito Cuenta Papá', 5384, 'Local 10 del Sol pago esto que es el saldo del mes, HOY ENTREGA LA LLAVE, pago todos los impuestos y este saldito. Ya di de baja el adicional mercantil que papa me pidió, hay que recibirlo, inspeccionarlo, sacarle fotos y ponerlo a alquilar nuevamente', '68505f7da1c1c-IMG_1750.png', NULL, 0, NULL, NULL),
(87, 46, NULL, '2025-06', NULL, NULL, '2025-06-21', NULL, NULL, NULL, 'Pago mensual', 'Depósito Cuenta Lucho', 500, 'Paga 500 alquiler porque descontamos 6000 del techo. Y agregó 3315 de impuestos que pagué yo de mi cuenta que tenía atrasado.', '6856be0a98368-aae4bd2c-731d-4ec5-a1a9-20ffc18074c6.jpeg', NULL, 0, NULL, NULL),
(88, 46, NULL, '2025-06', NULL, NULL, '2025-06-21', NULL, NULL, NULL, 'Impuestos', 'Depósito Cuenta Lucho', 3400, 'Paga 500 alquiler porque descontamos 6000 del techo. Y agregó 3315 de impuestos que pagué yo de mi cuenta que tenía atrasado.', '6856be48a5836-aae4bd2c-731d-4ec5-a1a9-20ffc18074c6.jpeg', NULL, 0, NULL, NULL),
(89, 6, NULL, '2025-06', NULL, NULL, '2025-06-23', NULL, NULL, NULL, 'Pago mensual', 'Efectivo', 7500, 'Avisa Raúl wpp ', '6859f76a33043-IMG_1847.png', NULL, 1, '2025-07-14 13:40:42', 1),
(90, 51, NULL, '2025-06', NULL, NULL, '2025-06-13', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3600, 'Avisa Raúl por wpp lo encontró en persona ', '685b52041b61b-a25bc35a-aacb-4378-b953-9e3fc9d6950a.jpeg', NULL, 0, NULL, NULL),
(91, 34, NULL, '2025-06', NULL, NULL, '2025-06-06', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 2600, '', '685b56f19e902-02183c38-bf26-4b38-87e8-cd795edc15fe.jpeg', NULL, 0, NULL, NULL),
(92, 29, NULL, '2025-06', NULL, NULL, '2025-06-02', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 6200, 'Revisamos celu papá 25/6', '685ca8f7b937c-0b8e5648-31e8-4be0-af4e-823e55a3bfe8.jpeg', NULL, 0, NULL, NULL),
(93, 28, NULL, '2025-04', NULL, NULL, '2025-05-07', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 1500, 'En mayo pago abril y mayo atrasado ', '685caa5dc21d7-040422c8-e50e-43f3-aae9-0e2d47c79654.jpeg', NULL, 0, NULL, NULL),
(94, 28, NULL, '2025-05', NULL, NULL, '2025-05-07', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 1500, 'Pago atrasado abril y mayo el 7 de mayo ', '685caa9debdfc-040422c8-e50e-43f3-aae9-0e2d47c79654.jpeg', NULL, 0, NULL, NULL),
(95, 25, NULL, '2025-06', NULL, NULL, '2025-06-05', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 2500, 'Barcode 28287336', '685cacc7587ab-b9abe3a6-5c19-4512-b8cd-161f800cb7b5.jpeg', NULL, 0, NULL, NULL),
(96, 30, NULL, '2025-05', NULL, NULL, '2025-06-07', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 5500, 'Se hizo cargo del alquiler Marta Bueno ', '685cb230a719c-ae2c1aff-0864-418b-a87a-a30797d19987.jpeg', NULL, 0, NULL, NULL),
(97, 24, NULL, '2025-06', NULL, NULL, '2025-06-03', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3600, 'Pago por anda transferencia ', '685cb3c2079f8-ab52fcb7-8b16-4f04-a64b-86c7b3ca4676.jpeg', NULL, 0, NULL, NULL),
(98, 22, NULL, '2025-06', NULL, NULL, '2025-06-12', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3500, 'Deja el garage en julio ', '685cb47f9d35f-b85961b3-2a88-4968-83ae-12290b543cf8.jpeg', NULL, 0, NULL, NULL),
(99, 21, NULL, '2025-06', NULL, NULL, '2025-06-10', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3200, '', '685cb52a99cfe-40f5fc08-3364-4b74-bd3c-7dd707a5f433.jpeg', NULL, 0, NULL, NULL),
(100, 20, NULL, '2025-06', NULL, NULL, '2025-06-05', NULL, NULL, NULL, 'Pago mensual', 'Transferencia Papá', 3400, 'Aviso a papá transferencia ', '685cb590802ba-e9c01f1b-0295-42df-a989-3454a30e2f83.jpeg', NULL, 0, NULL, NULL),
(101, 29, 1, '2025-07', NULL, NULL, '2025-07-01', '2025-07-01 07:52:37', NULL, NULL, 'Pago mensual', 'Transferencia', 6200, 'Transfiere a cuenta nuestra', '6863da1522f10-5f135faa-fafb-46ff-b8f8-087bfe812350.jpeg', NULL, 1, '2025-07-23 21:27:18', 1),
(102, 46, 1, '2025-07', NULL, NULL, '2025-07-01', '2025-07-01 12:35:35', NULL, NULL, 'Pago mensual', 'Depósito Cuenta Lucho', 6500, 'Pago mensual ', '68641c67e4552-3f8aec50-1f59-487c-b773-68573a94beca.jpeg', NULL, 1, '2025-07-23 21:45:29', 1),
(103, 4, 1, '2025-07', NULL, NULL, '2025-07-01', '2025-07-01 21:48:47', NULL, NULL, 'Pago mensual', 'Transferencia', 10300, 'Se va a cambiar al local 23', '68649e0fdf677-d32aa4d5-fe49-4845-80a1-27fe3d8070ce.jpeg', NULL, 1, '2025-07-23 21:45:20', 1),
(104, 18, 1, '2025-07', NULL, NULL, '2025-07-02', '2025-07-02 08:32:04', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'Sarkisian gbolo ónix sedan', '686534d43b74a-IMG_2012.png', NULL, 1, '2025-07-23 21:19:46', 1),
(105, 27, 1, '2025-07', NULL, NULL, '2025-07-02', '2025-07-02 21:10:23', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 3600, 'Avisa por wpp a Vivi', '6865e68fe1739-f337eb52-3dda-4054-a12f-a2ec246f4333.jpeg', NULL, 1, '2025-07-14 13:41:37', 1),
(106, 24, 1, '2025-07', NULL, NULL, '2025-07-02', '2025-07-02 21:11:27', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'Avisa por wpp a Vivi', '6865e6cfa9026-944380f4-eb6b-494f-9b34-c46a684d624e.jpeg', NULL, 1, '2025-07-23 21:22:14', 1),
(108, 26, 1, '2025-07', NULL, NULL, '2025-07-03', '2025-07-03 18:19:44', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4200, 'Retira sobre Raúl ', '686710106983f-016b6bc2-bfb4-437a-b2b3-82707fbdcf1e.jpeg', NULL, 1, '2025-07-14 13:41:18', 1),
(109, 35, 1, '2025-07', NULL, NULL, '2025-07-03', '2025-07-03 18:21:43', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Retira sobre Raúl ', '6867108757a36-016b6bc2-bfb4-437a-b2b3-82707fbdcf1e.jpeg', NULL, 1, '2025-07-14 13:40:58', 1),
(110, 20, 1, '2025-07', NULL, NULL, '2025-07-04', '2025-07-04 13:19:27', NULL, NULL, 'Pago mensual', 'Transferencia', 3400, 'Avisa Vivi por wpp mandaron desde otro celular Érica gbolo o dc 099338850', '68681b2f1bee9-6137ff81-293a-4a66-bfd7-73734f4c60a1.jpeg', NULL, 1, '2025-07-23 21:20:19', 1),
(111, 10, 1, '2025-06', NULL, NULL, '2025-06-09', '2025-07-04 20:40:40', NULL, NULL, 'Pago mensual', 'Transferencia Papá', 6500, 'Cargamos atrasado porque no lo habíamos visto en el celular de papá ', '68688298a8110-796509d2-4dec-4e4d-b331-a6b590d931da.jpeg', NULL, 0, NULL, NULL),
(112, 14, 1, '2025-07', NULL, NULL, '2025-07-04', '2025-07-04 20:58:06', NULL, NULL, 'Pago mensual', 'Transferencia', 9100, 'Avisa Vivi por wpp', '686886ae5d141-844acf35-6a1a-4d16-9954-8589ad330862.jpeg', NULL, 1, '2025-07-23 22:00:41', 1),
(113, 17, 1, '2025-05', NULL, NULL, '2025-07-05', '2025-07-05 10:51:03', NULL, NULL, 'Pago mensual', 'Transferencia', 18000, 'Diego Borja punta del este , este corresponde si no estoy mal al alquiler del mes pasado ', '686949e75d961-e437aef3-e121-4c13-8bd2-dce1be39e6e8.jpeg', NULL, 1, '2025-07-23 21:56:53', 1),
(114, 34, 1, '2025-07', NULL, NULL, '2025-07-05', '2025-07-05 15:05:12', NULL, NULL, 'Pago mensual', 'Transferencia', 2600, 'Avisa Vivi por wpp', '68698578d7e1d-cb7646da-f469-4d5f-a3ff-c4d1ec861998.jpeg', NULL, 1, '2025-07-23 21:51:06', 1),
(115, 2, 1, '2025-06', NULL, NULL, '2025-07-07', '2025-07-07 10:45:31', NULL, NULL, 'Pago mensual', 'Transferencia', 7500, 'Caro Local 13 del Sol', '686beb9b5f77a-IMG_2066.png', NULL, 1, '2025-07-23 22:06:01', 1),
(116, 3, 1, '2025-06', NULL, NULL, '2025-07-07', '2025-07-07 16:21:06', NULL, NULL, 'Pago mensual', 'Transferencia', 10420, 'El mes pasado no había mandado pago ', '686c3a42ce410-45c9a43f-9650-4268-8e4d-98d9e7cc2e49.jpeg', NULL, 1, '2025-07-23 22:05:34', 1),
(117, 3, 1, '2025-05', NULL, NULL, '2025-06-03', '2025-07-07 20:37:14', NULL, NULL, 'Pago mensual', 'Transferencia Papá', 7500, 'Encontramos tarde el ticket estaba al día 7/7/2025 cargamos lo del 6', '686c764ad42e6-99bd0d22-44fd-4c2d-8347-db1c8d76b402.jpeg', NULL, 0, NULL, NULL),
(118, 23, 1, '2025-07', NULL, NULL, '2025-07-08', '2025-07-08 09:23:20', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4300, 'Avisa Raúl wpp ', '686d29d805912-d2db8159-78bd-47f9-96fe-b6094b790c48.jpeg', NULL, 1, '2025-07-14 13:42:04', 1),
(119, 21, 1, '2025-07', NULL, NULL, '2025-07-08', '2025-07-08 14:49:41', NULL, NULL, 'Pago mensual', 'Transferencia', 3200, 'Avisa Vivi por wpp ', '686d7655cadd0-5c552bc2-cbfc-4fea-ad2b-eb764143bf1c.jpeg', NULL, 1, '2025-07-23 21:20:39', 1),
(120, 54, 1, '2025-07', NULL, NULL, '2025-07-08', '2025-07-08 15:15:46', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'te envío el comprobante. por favor confírmame si te llegó así ya guardo la plantilla con los datos gracias!\r\nAriana Bonilla Gbolo tiggo 4', '686d7c72eb0e9-Transferencia_a_terceros_2507080464836001.pdf', NULL, 1, '2025-07-23 21:25:41', 1),
(121, 25, 1, '2025-07', NULL, NULL, '2025-07-08', '2025-07-08 21:13:47', NULL, NULL, 'Pago mensual', 'Transferencia', 2500, 'Barcode 31211443', '686dd05bb5cbf-54988b72-a30e-4135-b8da-7f4818652a0e.jpeg', NULL, 1, '2025-07-08 21:19:29', 1),
(122, 49, 1, '2025-07', NULL, NULL, '2025-07-09', '2025-07-09 21:09:06', NULL, NULL, 'Pago mensual', 'Transferencia', 10000, 'Esto es la inq del 7y8 Entrevero, pago 10mil alquiler y 4400 gs cs descontó 343 de la luz que pagó ella completo, le correspondía solo la mitad', '686f20c298f91-ec61fa3f-bfd7-4578-9dd2-4d6168a85cb3.jpeg', NULL, 1, '2025-07-14 21:13:43', 1),
(123, 49, 1, '2025-07', NULL, NULL, '2025-07-09', '2025-07-09 21:09:59', NULL, NULL, 'Gastos comunes', 'Transferencia', 4057, 'Esto es la inq del 7y8 Entrevero, pago 10mil alquiler y 4400 gs cs descontó 343 de la luz que pagó ella completo, le correspondía solo la nutad', '686f20f7bc0fc-ec61fa3f-bfd7-4578-9dd2-4d6168a85cb3.jpeg', NULL, 1, '2025-07-14 21:13:45', 1),
(124, 47, 1, '2025-06', NULL, NULL, '2025-07-10', '2025-07-10 12:21:07', NULL, NULL, 'Pago mensual', 'Transferencia', 32705, 'Pago mes anterior, el mes pasado puse mal el periodo corregir ', '686ff68338bc0-RPMJulio2025.pdf', NULL, 1, '2025-07-14 21:02:43', 1),
(125, 10, 1, '2025-06', NULL, NULL, '2025-07-10', '2025-07-10 14:07:31', NULL, NULL, 'Pago mensual', 'Transferencia', 6500, 'Elvis Parra loc 105 ep', '68700f73260aa-397c82db-666e-4978-b908-d840fe6089cd.jpeg', NULL, 1, '2025-07-10 14:13:16', 1),
(126, 11, 1, '2025-05', NULL, NULL, '2025-07-10', '2025-07-10 14:11:30', NULL, NULL, 'Pago mensual', 'Transferencia', 7862, 'Confirmar a qué periodo corresponde porque en el celular no habían pagos desde mayo 2025', '68701062ccea0-79ba0dab-e337-4e1d-b872-8af6c5f6b34c.jpeg', NULL, 1, '2025-07-23 21:33:00', 1),
(127, 17, 1, '2025-05', NULL, NULL, '2025-07-10', '2025-07-10 18:49:41', NULL, NULL, 'Pago mensual', 'Transferencia', 0, 'Esto es un saldo de una de la deuda que tenía de alquiler el local 116 de Punta Del. Éste debe la mensualidad del mes pasado y la y la de este mes vencida.', '6870519541ee1-7a9168fe-66e5-4827-a872-c8900e063040.jpeg', NULL, 0, NULL, NULL),
(128, 33, 1, '2025-06', NULL, NULL, '2025-07-11', '2025-07-11 08:34:07', NULL, NULL, 'Pago mensual', 'Efectivo', 2500, 'Pago Edgardo DC $2500 junio y $2500 julio efectivo @⁨Lucho⁩  ingresar pago', '687112cfae950-IMG_2132.png', NULL, 1, '2025-07-14 13:45:12', 1),
(129, 33, 1, '2025-07', NULL, NULL, '2025-07-11', '2025-07-11 08:34:47', NULL, NULL, 'Pago mensual', 'Efectivo', 2500, 'Pago Edgardo DC $2500 junio y $2500 julio efectivo @⁨Lucho⁩  ingresar pago', '687112f706808-IMG_2132.png', NULL, 1, '2025-07-14 13:45:10', 1),
(130, 53, 1, '2025-06', NULL, NULL, '2025-07-11', '2025-07-11 08:56:07', NULL, NULL, 'Pago mensual', 'Efectivo', 6300, 'Local 31 b mes junio Gal americas Mañana paga julio', '687117f738888-d0a90769-2234-4544-898b-ec48b304516d.jpeg', NULL, 1, '2025-07-24 10:59:26', 1),
(131, 15, 1, '2025-06', NULL, NULL, '2025-07-11', '2025-07-11 12:32:00', NULL, NULL, 'Pago mensual', 'Transferencia', 40000, 'Rondeau 1524 ', '68714a90d19c1-00b9e20e-7d9c-4ed8-b85a-da5d1e33d813.jpeg', NULL, 1, '2025-07-14 21:01:34', 1),
(132, 30, 1, '2025-06', NULL, NULL, '2025-07-12', '2025-07-12 13:27:57', NULL, NULL, 'Pago mensual', 'Transferencia', 7500, 'Ese es el contrato, LOCAL 30 entiendo que es Tmal de Marta Bueno, no coincide con el importe de la planilla $ 5500.- con el contrato $ 6500 y deposito $ 7500', '6872a92de5991-e454e355-e003-4d73-8972-59a3bed3f0eb.jpeg', NULL, 1, '2025-07-14 21:01:38', 1),
(133, 36, 1, '2025-07', NULL, NULL, '2025-07-12', '2025-07-12 13:29:26', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, '@⁨Lucho⁩  Cristina Dc recibido pago sobre $2500', '6872a986a318a-IMG_2141.png', NULL, 1, '2025-07-14 13:45:32', 1),
(134, NULL, 1, '', NULL, NULL, '2025-07-13', NULL, NULL, NULL, 'Arqueo de Caja (suma)', 'Efectivo', 40950, 'Agrego para quedar igual que Raul', NULL, 1, 1, NULL, NULL),
(135, NULL, 1, '', NULL, NULL, '2025-07-14', '2025-07-14 21:34:01', NULL, NULL, 'Arqueo de Caja (suma)', 'Transferencia', 25050, 'Arqueo para ajustar con CC BROU', NULL, 1, 0, NULL, NULL),
(136, 50, 1, '2025-06', NULL, NULL, '2025-07-15', '2025-07-15 10:54:23', NULL, NULL, 'Pago mensual', 'Transferencia', 16725, 'ALQUILER JUNIO 18000 - 1275 anep', '687679af518d1-ffd6f6ae-293d-438e-92d8-d66b5b416ab1.jpeg', NULL, 1, '2025-07-23 22:14:09', 1),
(137, 13, 1, '2025-07', NULL, NULL, '2025-07-15', '2025-07-15 11:10:41', NULL, NULL, 'Pago mensual', 'Efectivo', 11600, 'Recibido pago en efectivo local 39 galería cristal , Elsa Núñez Paga $11600 gastos comunes incluidos', '68767d8184015-647d7cdb-d361-441a-b72d-a2500d1983c0.jpeg', NULL, 1, '2025-07-23 21:49:15', 1),
(138, 8, 1, '2025-06', NULL, NULL, '2025-07-16', '2025-07-16 10:56:54', NULL, NULL, 'Pago mensual', 'Efectivo', 9000, '@⁨Lucho⁩ registrar pago local 35 galería de las americas $9000', '6877cbc6a99d2-IMG_2217.png', NULL, 1, '2025-07-23 21:29:24', 1),
(139, 7, 1, '2025-07', NULL, NULL, '2025-07-16', '2025-07-16 11:13:25', NULL, NULL, 'Pago mensual', 'Efectivo', 8000, '@⁨Lucho⁩ Registrar pago local 10 galería de las americas $8000 efectivo', '6877cfa5b8de3-IMG_2218.png', NULL, 1, '2025-07-23 21:29:02', 1),
(140, 5, 1, '2025-07', NULL, NULL, '2025-07-16', '2025-07-16 11:46:43', NULL, NULL, 'Pago mensual', 'Transferencia', 9500, 'LOCAL 27 del SOL Esta chica me dijo que ella estaba pagando DIRECTO los gastos comunes... debemos verificarlo con la adm, se supone va al día!', '6877d77364ac4-9fd4a509-7b3f-465b-9202-cc13fef9302c.jpeg', NULL, 1, '2025-07-23 21:46:25', 1),
(141, 53, 1, '2025-07', NULL, NULL, '2025-07-16', '2025-07-16 13:08:48', NULL, NULL, 'Pago mensual', 'Efectivo', 6300, '@⁨Lucho⁩  registrar pago local 31b julio mes corriente', '6877eab0755e3-11004129-97b1-441e-a574-b1021ddaca38.jpeg', NULL, 1, '2025-07-24 10:59:27', 1),
(142, 6, 1, '2025-07', NULL, NULL, '2025-07-17', '2025-07-17 12:26:35', NULL, NULL, 'Pago mensual', 'Efectivo', 7500, '@⁨Lucho⁩ registrar pago local 5 galería de las americas Juan pólvora $7500 efectivo', '6879324bf2065-IMG_2237.png', NULL, 1, '2025-07-23 21:28:55', 1),
(143, 52, 1, '2025-07', NULL, NULL, '2025-07-17', '2025-07-17 15:05:31', NULL, NULL, 'Pago mensual', 'Efectivo', 10000, '@⁨Lucho⁩ ingresa vendí unas butacas q compramos hace mil años con papá para el Jeep las vendí hoy en $10.000 , esa plata me gustaría dejarla tipo para Neptunia o algo así pero es medio lo mismo porque cuando hagamos algún arreglo compramos los materiales de la cuenta en común porque la casa es de todos ', NULL, NULL, 1, '2025-07-23 22:13:50', 1),
(144, 16, 1, '2025-04', NULL, NULL, '2025-04-17', '2025-07-17 20:43:16', NULL, NULL, 'Pago mensual', 'Transferencia', 0, 'Mando captura verificar ', '6879a6b464fc3-1f5d7343-3c89-4fcb-9d96-c8fa2d9c9beb.jpeg', NULL, 0, NULL, NULL),
(145, 16, 1, '2025-05', NULL, NULL, '2025-05-10', '2025-07-17 20:44:13', NULL, NULL, 'Pago mensual', 'Transferencia', 0, 'Mando captura verificar ', '6879a6edbf8b1-1e9179be-496b-4dfa-8fca-3a209621678a.jpeg', NULL, 0, NULL, NULL),
(146, 55, 1, '2025-07', NULL, NULL, '2025-07-17', '2025-07-17 20:49:29', NULL, NULL, 'Pago mensual', 'Transferencia', 750, '@⁨Lucho⁩ agregar pago aparecida moto gbolo $750 prorrateo días julio', '6879a82945972-06e6b0b8-4c75-4684-b903-18c3b159e1af.jpeg', NULL, 1, '2025-07-23 21:25:55', 1),
(147, 28, 1, '2025-06', NULL, NULL, '2025-07-03', '2025-07-23 21:09:21', NULL, NULL, 'Pago mensual', 'Transferencia', 1500, 'Envía dos meses juntos 3000 junio y julio ', '688195d14c7b9-24a13a31-e899-4f87-8939-57885f73d338.jpeg', NULL, 1, '2025-07-23 21:26:52', 1),
(148, 28, 1, '2025-07', NULL, NULL, '2025-07-03', '2025-07-23 21:09:58', NULL, NULL, 'Pago mensual', 'Transferencia', 1500, 'Envía dos meses juntos 3000 junio y julio ', '688195f659b0a-24a13a31-e899-4f87-8939-57885f73d338.jpeg', NULL, 1, '2025-07-23 21:26:50', 1),
(149, 19, 1, '2025-07', NULL, NULL, '2025-07-24', '2025-07-24 09:23:21', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 3600, 'Recibido pago Eduardo Bonilla gbolo', '688241d973363-13ed1752-794d-4d3c-b29d-cf0baf7145db.jpeg', NULL, 0, NULL, NULL),
(150, 11, 1, '2025-07', NULL, NULL, '2025-07-24', '2025-07-24 21:31:03', NULL, NULL, 'Pago mensual', 'Transferencia', 7862, 'PAGO LOCAL  106 EP AMERICAS, AHORA SI QUEDA AL DIA', '6882ec6735198-20217fa0-0b63-4706-8f7e-fdd01b831e07.jpeg', NULL, 1, '2025-08-22 18:31:46', 1),
(151, 17, 1, '2025-06', NULL, NULL, '2025-07-25', '2025-07-25 10:51:27', NULL, NULL, 'Pago mensual', 'Transferencia', 18000, 'Pago julio 25 local Pde diego Borgia', '6883a7ffb2b8b-782e908b-8f0f-42c4-948d-8421c07c69c4.jpeg', NULL, 1, '2025-08-22 18:34:02', 1),
(152, 29, 1, '2025-08', NULL, NULL, '2025-08-01', '2025-08-01 20:31:50', NULL, NULL, 'Pago mensual', 'Transferencia', 6200, 'Pago Carlos depósito', '688d6a86892b1-97576de2-5c66-43b0-815f-46af66fd6ef5.jpeg', NULL, 1, '2025-08-22 18:51:01', 1),
(153, 18, 1, '2025-08', NULL, NULL, '2025-08-04', '2025-08-04 07:24:34', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'Sarkisian gbolo pago', '6890a6829b0f1-48fe5930-4adb-4f23-9a74-bbc4e8fbc18d.jpeg', NULL, 1, '2025-08-22 19:02:45', 1),
(154, 54, 1, '2025-08', NULL, NULL, '2025-08-04', '2025-08-04 10:45:22', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'buen día, cómo estás? te envío comprobante de la transferencia', '6890d59224811-IMG_2525.png', NULL, 1, '2025-08-22 19:02:51', 1),
(155, 20, 1, '2025-08', NULL, NULL, '2025-08-05', '2025-08-05 15:02:04', NULL, NULL, 'Pago mensual', 'Transferencia', 3400, '@⁨Lucho⁩ anotar pago ERIKA Christian SCM1429', '6892633cc8b49-IMG_2545.png', NULL, 1, '2025-08-22 19:06:00', 1),
(156, 55, 1, '2025-08', NULL, NULL, '2025-08-06', '2025-08-06 08:16:20', NULL, NULL, 'Pago mensual', 'Transferencia', 1500, 'Buenos días ,te envío el pago del garage gracias saludos Aparecida moto gbolo', '689355a475504-955b56a2-9162-4bba-85cd-c51c6f7891c4.jpeg', NULL, 1, '2025-08-22 19:08:02', 1),
(157, 46, 1, '2025-08', NULL, NULL, '2025-08-06', '2025-08-06 11:33:16', NULL, NULL, 'Pago mensual', 'Transferencia', 6500, 'Pago mensual ', '689383ccad4ca-b5d3b417-d24d-4da4-904e-d7c13e288cc6.jpeg', NULL, 0, NULL, NULL),
(159, 25, 1, '2025-08', NULL, NULL, '2025-08-06', '2025-08-06 16:51:50', NULL, NULL, 'Pago mensual', 'Transferencia', 2500, '@⁨Lucho⁩ anotar pago Martin Gbolo', '6893ce766e741-504dbb13-24d5-44e0-bb41-4aa4de94a129.jpeg', NULL, 1, '2025-08-22 19:07:25', 1),
(160, 26, 1, '2025-08', NULL, NULL, '2025-08-07', '2025-08-07 11:52:28', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4200, 'hola, te mando comprobante de la transferencia del pago por mi padre walter bonilla. saludos!', '6894d9cc82d16-b7b01323-2080-4a2e-9977-8eef78de8dcb.jpeg', NULL, 0, NULL, NULL),
(161, 23, 1, '2025-08', NULL, NULL, '2025-08-07', '2025-08-07 11:55:04', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4300, 'hola, te mando comprobante de la transferencia del pago por mi padre walter bonilla. saludos!', '6894da6890f80-b7b01323-2080-4a2e-9977-8eef78de8dcb.jpeg', NULL, 0, NULL, NULL),
(162, 19, 1, '2025-08', NULL, NULL, '2025-08-06', '2025-08-07 12:00:29', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'hola, te mando comprobante de la transferencia del pago por mi padre walter bonilla. saludos!', '6894dbad577cc-BonillaTransferencia_a_terceros_2508060484081906.pdf', NULL, 1, '2025-08-22 19:09:06', 1),
(163, 14, 1, '2025-08', NULL, NULL, '2025-08-07', '2025-08-07 13:07:39', NULL, NULL, 'Pago mensual', 'Transferencia', 9100, '@⁨Lucho⁩ anotar pago Gaby Nails Local 41 Entrevero', '6894eb6b9bf51-e9e233e5-f7cd-462e-b0b6-fc8eeca65fc3.jpeg', NULL, 1, '2025-08-22 19:09:37', 1),
(164, 34, 1, '2025-08', NULL, NULL, '2025-08-07', '2025-08-07 13:09:34', NULL, NULL, 'Pago mensual', 'Transferencia', 2600, '@⁨Lucho⁩ anotar pago Francisco Sanguinet DC', '6894ebde1cad8-Comprobante_Scotiabank_1754569589635.pdf', NULL, 1, '2025-08-22 19:10:05', 1),
(165, 35, 1, '2025-08', NULL, NULL, '2025-08-09', '2025-08-09 09:52:18', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, 'Recibido pago Ford rojo Valverde DC @⁨Lucho⁩', '689760a24ebd4-3e31ec88-25f2-4fb7-bf59-52d35f5070d9.jpeg', NULL, 0, NULL, NULL),
(166, 10, 1, '2025-08', NULL, NULL, '2025-08-09', '2025-08-09 17:14:19', NULL, NULL, 'Pago mensual', 'Transferencia', 6500, 'Elvis local 105 galería americas ingresar pago', '6897c83b00216-comprobante_transferencia_itau.pdf', NULL, 1, '2025-08-22 19:12:56', 1),
(167, 56, 1, '2025-08', NULL, NULL, '2025-08-09', '2025-08-09 17:26:37', NULL, NULL, 'Comisiones', 'Transferencia', 11040, 'Comisión ', '6897cb1d7553e-cd22255f-ec6a-475e-b263-0790910cc0cb.jpeg', NULL, 1, '2025-08-22 19:15:19', 1),
(168, 21, 1, '2025-08', NULL, NULL, '2025-08-11', '2025-08-11 10:58:23', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 3200, 'Corina dejo efectivo en Bolo ayer', '689a131fba9ea-3df42889-7a01-4b92-ab6c-a1cb2269bcd0.jpeg', NULL, 0, NULL, NULL),
(169, 24, 1, '2025-08', NULL, NULL, '2025-08-11', '2025-08-11 19:00:13', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'Natacha Gbolo @⁨Lucho⁩  ingresar pago', '689a840d2d6d0-9d1623ac-d704-4729-8b8a-b3009ba249b8.jpeg', NULL, 1, '2025-08-22 19:15:22', 1),
(170, 2, 1, '2025-08', NULL, NULL, '2025-08-12', '2025-08-12 11:59:06', NULL, NULL, 'Pago mensual', 'Transferencia', 7500, 'Local 13 del Sol Alquiler y gastos comunes', '689b72da9ddf6-Transferencia_a_terceros_2508120486497147.pdf', NULL, 1, '2025-08-22 19:15:55', 1),
(171, 51, 1, '2025-07', NULL, NULL, '2025-08-12', '2025-08-12 17:05:27', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'Andres SCL2011', '689bbaa709194-5714707d-f4ea-44ea-9121-5a82c2f723c7.jpeg', NULL, 1, '2025-08-22 19:16:24', 1),
(172, 11, 1, '2025-08', NULL, NULL, '2025-08-12', '2025-08-12 17:07:37', NULL, NULL, 'Pago mensual', 'Transferencia', 7862, 'Local 106 ep', '689bbb291101d-977adc40-c936-487c-869a-047654fae026.jpeg', NULL, 1, '2025-08-22 19:16:50', 1),
(173, 47, 1, '2025-08', NULL, NULL, '2025-08-12', '2025-08-12 22:08:41', NULL, NULL, 'Pago mensual', 'Transferencia', 32705, 'Alquiler RPM 547', '689c01b9c35dd-RPMAgosto.pdf', NULL, 1, '2025-08-22 19:17:09', 1),
(174, 8, 1, '2025-07', NULL, NULL, '2025-08-13', '2025-08-13 14:47:30', NULL, NULL, 'Pago mensual', 'Efectivo', 9000, 'Local 35 galería americas Héctor Pérez pago en efectivo', '689cebd2ae361-c22caeab-728a-4a8c-95a8-c47c01e15b0d.jpeg', NULL, 0, NULL, NULL),
(175, 51, 1, '2025-08', NULL, NULL, '2025-08-13', '2025-08-13 20:26:42', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'Oscar Moreira Gbolo el pago que faltaba', '689d3b528a764-675c941b-f9ee-4c95-b0ce-8cac8b655299.jpeg', NULL, 1, '2025-08-22 19:19:41', 1),
(176, 49, 1, '2025-08', NULL, NULL, '2025-08-14', '2025-08-14 13:36:29', NULL, NULL, 'Pago mensual', 'Transferencia', 10000, 'Local 7 y 8 Entrevero alquiler y Gastos Clmjnes, debe Tributos, ya se los reclamé', '689e2cad60073-9211f3fd-dbd8-4526-ae8b-3163f5d92e6b.jpeg', NULL, 1, '2025-08-22 19:21:24', 1),
(177, 49, 1, '2025-08', NULL, NULL, '2025-08-14', '2025-08-14 13:37:18', NULL, NULL, 'Gastos comunes', 'Transferencia', 4400, 'Cargo separado per hizo una sola transferencia por $14400', '689e2cdeb5cda-9211f3fd-dbd8-4526-ae8b-3163f5d92e6b.jpeg', NULL, 1, '2025-08-22 19:21:27', 1),
(178, 15, 1, '2025-07', NULL, NULL, '2025-08-14', '2025-08-14 20:27:01', NULL, NULL, 'Pago mensual', 'Transferencia', 40000, 'Alquiler Rondeau 1524 ', '689e8ce51f80a-c16b3ec9-cf96-4fc1-86e3-1c059b84f431.jpeg', NULL, 1, '2025-08-22 19:22:37', 1),
(179, 27, 1, '2025-08', NULL, NULL, '2025-08-15', '2025-08-15 17:37:10', NULL, NULL, 'Pago mensual', 'Efectivo', 3600, 'Gbolo ingresar cobro de Laura Fabian $3600 y corina $3200\r\n@⁨Lucho⁩', '689fb6965097a-IMG_2707.png', NULL, 0, NULL, NULL),
(180, 36, 1, '2025-08', NULL, NULL, '2025-08-15', '2025-08-15 17:39:13', NULL, NULL, 'Pago mensual', 'Efectivo', 2500, 'Ingresemar cobro DC Cristina $2500 y Edgardo $2500', '689fb711cf8c1-IMG_2708.png', NULL, 0, NULL, NULL),
(181, 33, 1, '2025-08', NULL, NULL, '2025-08-15', '2025-08-15 17:39:56', NULL, NULL, 'Pago mensual', 'Efectivo', 2500, 'Ingresemar cobro DC Cristina $2500 y Edgardo $2500', '689fb73ccaa73-IMG_2708.png', NULL, 0, NULL, NULL),
(182, 7, 1, '2025-08', NULL, NULL, '2025-08-18', '2025-08-18 13:43:37', NULL, NULL, 'Pago mensual', 'Transferencia', 8000, 'Ingresar pago local 10 depositado en BROU a mi cuenta y yo ya mismo la transferi a la cuenta de alquileres ', '68a37459401cf-94c07b19-42a7-4e46-ae39-1bf5e6028413.jpeg', NULL, 1, '2025-08-22 19:32:59', 1),
(183, 6, 1, '2025-08', NULL, NULL, '2025-08-18', '2025-08-18 15:53:56', NULL, NULL, 'Pago mensual', 'Efectivo', 7500, 'Pago local 5 $ 7500 galería de las americas efectivo Juan pólvora', '68a392e47adfe-IMG_2782.png', NULL, 0, NULL, NULL),
(184, 53, 1, '2025-08', NULL, NULL, '2025-08-22', '2025-08-22 11:25:53', NULL, NULL, 'Pago mensual', 'Efectivo', 6300, '@⁨Lucho⁩ ingresar pago efectivo local 31b galería americas', '68a89a11e3fa0-f6a813bc-ae39-4bb7-8b5a-fb5767a8ad53.jpeg', NULL, 0, NULL, NULL),
(185, 4, 1, '2025-08', NULL, NULL, '2025-08-04', '2025-08-22 19:02:04', NULL, NULL, 'Pago mensual', 'Transferencia', 10400, 'Está Sofía este pago corresponde al mes de julio que pagó ahora en agosto y se mudó al local 23 galería del sol y paga en septiembre el primer alquiler del local 23 ( qué corresponde a agosto)', '68a904fc6b408-b2aa825c-3455-446e-a085-cec247ee9466.jpeg', NULL, 1, '2025-08-22 19:02:21', 1),
(186, 5, 1, '2025-08', NULL, NULL, '2025-08-15', '2025-08-22 19:28:42', NULL, NULL, 'Pago mensual', 'Transferencia', 9500, 'Local 27 galería del sol', '68a90b3aa6c93-5341685d-b3bb-47f0-85ad-d2a27a5d4f1d.jpeg', NULL, 1, '2025-08-22 19:29:04', 1),
(187, 3, 1, '2025-08', NULL, NULL, '2025-08-18', '2025-08-22 19:30:50', NULL, NULL, 'Pago mensual', 'Transferencia', 10420, 'Pago local 18 galería del sol joyería Arcadia', '68a90bba140ec-bae2ddce-25fc-44aa-8f2a-c8d5c03e3c4d.jpeg', NULL, 1, '2025-08-22 19:32:08', 1),
(188, NULL, 1, '', NULL, NULL, '2025-07-14', '2025-08-22 21:56:46', NULL, NULL, 'Arqueo de Caja (suma)', 'Transferencia', 80000, 'Depositamos 80mil en efectivo', NULL, 1, 0, NULL, NULL),
(189, NULL, 1, '', NULL, NULL, '2025-07-25', '2025-08-22 22:20:24', NULL, NULL, 'Arqueo de Caja (suma)', 'Transferencia', 4456, 'Raul deposita por error, devolver', NULL, 1, 0, NULL, NULL),
(190, 29, 1, '2025-09', NULL, NULL, '2025-09-01', '2025-09-01 09:50:46', NULL, NULL, 'Pago mensual', 'Transferencia', 6200, '@⁨Lucho⁩ anotar pago Deposito Américas', '68b5b2c6a89ff-d98374ca-2c20-4c92-92f6-392dd164a54e.jpeg', NULL, 1, '2025-10-30 19:40:04', 1),
(191, 54, 1, '2025-09', NULL, NULL, '2025-09-02', '2025-09-02 09:09:53', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'hola, cómo estás? te envío el comprobante de transferencia mío y de mi padre', '68b6fab11b9eb-Transferencia_a_terceros_2509020493963062.pdf', NULL, 1, '2025-10-30 19:42:12', 1),
(192, 19, 1, '2025-09', NULL, NULL, '2025-09-02', '2025-09-02 09:10:22', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'hola, cómo estás? te envío el comprobante de transferencia mío y de mi padre', '68b6facee1470-Transferencia_a_terceros_2509020493963062.pdf', NULL, 1, '2025-10-30 19:42:13', 1),
(193, 46, 1, '2025-09', NULL, NULL, '2025-09-02', '2025-09-02 14:03:55', NULL, NULL, 'Pago mensual', 'Transferencia', 6500, 'Holaaaa te envío comprobante , quedamos septiembre y octubre cubiertos !!', '68b73f9b681da-d43e5bcb-5e5d-4304-8d04-dd37beaef1e9.jpeg', NULL, 0, NULL, NULL),
(194, 46, 1, '2025-10', NULL, NULL, '2025-09-02', '2025-09-02 14:04:18', NULL, NULL, 'Pago mensual', 'Transferencia', 6500, 'Holaaaa te envío comprobante , quedamos septiembre y octubre cubiertos !!', '68b73fb253728-d43e5bcb-5e5d-4304-8d04-dd37beaef1e9.jpeg', NULL, 0, NULL, NULL),
(195, 18, 1, '2025-09', NULL, NULL, '2025-09-02', '2025-09-02 19:00:37', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, '@⁨Lucho⁩ ingresar pago sarkisian GBolo', '68b78525f4028-e901d8db-4752-4552-8d8e-b6657534ed60.jpeg', NULL, 1, '2025-10-30 19:42:29', 1),
(196, 24, 1, '2025-09', NULL, NULL, '2025-09-03', '2025-09-03 15:22:05', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'Natacha Gbolo @⁨Lucho⁩ anotar pago', '68b8a36d31f1a-5bed6112-edd4-4d06-9b5c-8dc80b12c6e1.jpeg', NULL, 1, '2025-10-30 19:42:57', 1),
(197, 20, 1, '2025-09', NULL, NULL, '2025-09-04', '2025-09-04 16:37:05', NULL, NULL, 'Pago mensual', 'Transferencia', 3400, '@⁨Lucho⁩ anotar pago Erika Gbolo', '68ba068141e13-06c28a86-dc6b-4f54-84d9-8eb0f670f743.jpeg', NULL, 1, '2025-10-30 19:43:09', 1),
(198, 27, 1, '2025-09', NULL, NULL, '2025-09-05', '2025-09-05 09:40:10', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 3600, '@⁨Lucho⁩ ingresar pago gbolo Gabriel galain $4200 , Néstor y Laura $3600 efectivo', '68baf64ab567c-1e2c0ba7-7297-47ab-a3a7-302b697b2918.jpeg', NULL, 0, NULL, NULL),
(199, 26, 1, '2025-09', NULL, NULL, '2025-09-05', '2025-09-05 09:40:50', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4200, '@⁨Lucho⁩ ingresar pago gbolo Gabriel galain $4200 , Néstor y Laura $3600 efectivo', '68baf672d5410-1e2c0ba7-7297-47ab-a3a7-302b697b2918.jpeg', NULL, 0, NULL, NULL),
(200, 34, 1, '2025-09', NULL, NULL, '2025-09-05', '2025-09-05 10:19:34', NULL, NULL, 'Pago mensual', 'Transferencia', 2600, '@⁨Lucho⁩  anotar pago de Francisco DC', '68baff8617981-1032c501-6c27-49e7-b20d-ad1cd46cbe43.jpeg', NULL, 1, '2025-10-30 19:44:16', 1),
(201, 55, 1, '2025-09', NULL, NULL, '2025-09-05', '2025-09-05 11:52:36', NULL, NULL, 'Pago mensual', 'Transferencia', 1500, 'buenas tardes te gire por el garage gracias', '68bb1554d432f-29b781a0-f80b-4628-8042-682ca88d793f.jpeg', NULL, 1, '2025-10-30 19:44:32', 1),
(202, 14, 1, '2025-09', NULL, NULL, '2025-09-05', '2025-09-05 12:51:52', NULL, NULL, 'Pago mensual', 'Transferencia', 9100, '@⁨Lucho⁩  anotar pago GABY NAILS local 41 Entrevero', '68bb23382c8d2-dc00e604-3cae-4ffc-aab9-a4546d7e25fc.jpeg', NULL, 1, '2025-10-30 19:44:55', 1),
(203, 21, 1, '2025-09', NULL, NULL, '2025-09-08', '2025-09-08 12:17:07', NULL, NULL, 'Pago mensual', 'Transferencia', 3200, '@⁨Lucho⁩ ingresar pago gbolo corina', '68bf0f938e33e-Comprobante_Scotiabank_.pdf', NULL, 1, '2025-10-30 19:45:28', 1),
(204, 35, 1, '2025-09', NULL, NULL, '2025-09-08', '2025-09-08 12:18:07', NULL, NULL, 'Pago mensual', 'Efectivo', 2500, 'Ingrese pago efectivo Valverde cochera DC $2500', '68bf0fcfbc847-IMG_3142.png', NULL, 0, NULL, NULL),
(205, 5, 1, '2025-09', NULL, NULL, '2025-09-08', '2025-09-08 18:05:29', NULL, NULL, 'Pago mensual', 'Transferencia', 8240, '@⁨Lucho⁩  anotar pago SOL Local 27, último pago de alquiler, son 8400 porque descontó esas dos facturas quw aparecn ahí que cambio todas las luces porque las que habían ya no alumbraba', '68bf61391d119-Comprobante_TransferenciaEnElPais_08_09_2025_12_13.pdf', NULL, 1, '2025-10-30 19:45:43', 1),
(206, 23, 1, '2025-09', NULL, NULL, '2025-09-09', '2025-09-09 09:32:00', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4300, '@⁨Lucho⁩ ingresar pago efectivo Walter amarok gbolo $4300', '68c03a60f40e6-90f26a60-ef84-4003-919c-540b6487318e.jpeg', NULL, 0, NULL, NULL),
(207, 10, 1, '2025-09', NULL, NULL, '2025-09-09', '2025-09-09 09:33:19', NULL, NULL, 'Pago mensual', 'Transferencia', 6500, '@⁨Lucho⁩ ingresar pago Elvis local 105 americas BROU', '68c03aaf1db25-Elviscomprobante_transferencia_itau.pdf', NULL, 1, '2025-10-30 19:48:16', 1),
(208, 57, 1, '2025-09', NULL, NULL, '2025-09-09', '2025-09-09 09:36:03', NULL, NULL, 'Pago mensual', 'Transferencia', 10000, 'INGRESA A BROU $15000.-\r\n@⁨Lucho⁩  ingresar pago SOFIA LOCAL 23 del sol\r\nes 10mil alquiler $ 3.290.- gastos comunes y $ 1.710 de los tributos', '68c03b53978b2-409528e8-1628-4a04-942c-916aaece51e1.jpeg', NULL, 1, '2025-10-30 19:50:38', 1),
(209, 57, 1, '2025-09', NULL, NULL, '2025-09-09', '2025-09-09 09:36:28', NULL, NULL, 'Gastos comunes', 'Transferencia', 3290, 'INGRESA A BROU $15000.-\r\n@⁨Lucho⁩  ingresar pago SOFIA LOCAL 23 del sol\r\nes 10mil alquiler $ 3.290.- gastos comunes y $ 1.710 de los tributos', '68c03b6c00372-409528e8-1628-4a04-942c-916aaece51e1.jpeg', NULL, 1, '2025-10-30 19:50:40', 1),
(210, 57, 1, '2025-09', NULL, NULL, '2025-09-09', '2025-09-09 09:36:57', NULL, NULL, 'Impuestos', 'Transferencia', 1710, 'INGRESA A BROU $15000.-\r\n@⁨Lucho⁩  ingresar pago SOFIA LOCAL 23 del sol\r\nes 10mil alquiler $ 3.290.- gastos comunes y $ 1.710 de los tributos', '68c03b892a376-409528e8-1628-4a04-942c-916aaece51e1.jpeg', NULL, 1, '2025-10-30 19:50:43', 1),
(211, NULL, 1, '', NULL, NULL, '2025-09-09', '2025-09-09 10:03:45', NULL, NULL, 'Arqueo de Caja (suma)', 'Transferencia', 99000, 'Depósito en banco efectivo 99mil pesos ', NULL, 1, 1, '2025-10-30 19:52:28', 1),
(212, 56, 1, '2025-09', NULL, NULL, '2025-09-09', '2025-09-09 18:49:30', NULL, NULL, 'Pago mensual', 'Transferencia', 12000, '@⁨Lucho⁩ anotar pago Villa Serrana', '68c0bd0a977f4-260b2b20-96c6-44e1-bf47-f68a8286fcb7.jpeg', NULL, 1, '2025-10-30 19:52:43', 1),
(213, 5, 1, '2025-09', NULL, NULL, '2025-09-10', '2025-09-10 12:19:39', NULL, NULL, 'Impuestos', 'Transferencia', 820, '@⁨Lucho⁩  anotar pago es por parte de la inquilina que se fue, nos giro esos $ 820.- que le corresponden a ella y como hicimos el cambio de titular en UTE, vamos a pagar $ 930.-, $ 110 nos corresponden a nosotros', '68c1b32bbf782-be186996-f0a2-4ea7-ab0f-0cd760cfc6b3.jpeg', NULL, 1, '2025-10-30 19:52:53', 1),
(214, 49, 1, '2025-09', NULL, NULL, '2025-09-10', '2025-09-10 17:43:38', NULL, NULL, 'Pago mensual', 'Transferencia', 10000, 'BROU $14400 @⁨Lucho⁩ anotar pago Local 7y8 Emtrevero Alquiler y Gastos Comunes', '68c1ff1adac16-55a0c1cd-1222-4a21-a1f1-547a85ab6b88.jpeg', NULL, 1, '2025-10-30 19:53:20', 1),
(215, 49, 1, '2025-09', NULL, NULL, '2025-09-10', '2025-09-10 17:44:01', NULL, NULL, 'Gastos comunes', 'Transferencia', 4400, 'BROU $14400 @⁨Lucho⁩ anotar pago Local 7y8 Emtrevero Alquiler y Gastos Comunes', '68c1ff31b1ec1-55a0c1cd-1222-4a21-a1f1-547a85ab6b88.jpeg', NULL, 1, '2025-10-30 19:53:20', 1),
(216, 2, 1, '2025-09', NULL, NULL, '2025-09-12', '2025-09-12 18:20:07', NULL, NULL, 'Pago mensual', 'Transferencia', 7500, '@⁨Lucho⁩ anotar pago Local 13 del Sol', '68c4aaa77a0b8-63232ae5-c434-4590-9a6e-021db1d1da2a.jpeg', NULL, 1, '2025-10-30 19:55:17', 1),
(217, 47, 1, '2025-08', NULL, NULL, '2025-09-13', '2025-09-13 09:05:16', NULL, NULL, 'Pago mensual', 'Transferencia', 0, '@⁨Lucho⁩ ingresar pago Alex RPM 547. No ingresó al banco se reclamó y mandó uno nuevo.', '68c57a1ccaf4c-RPM2025-09-13.pdf', NULL, 1, '2025-11-05 20:26:36', 1),
(218, 15, 1, '2025-09', NULL, NULL, '2025-09-13', '2025-09-13 10:57:51', NULL, NULL, 'Pago mensual', 'Transferencia', 40000, '@⁨Lucho⁩ ingresar pago Rondeau 1524', '68c5947f11c7d-819c3f4f-adbe-41fd-a133-571cab5e150b.jpeg', NULL, 1, '2025-10-30 19:57:03', 1),
(219, 3, 1, '2025-09', NULL, NULL, '2025-09-15', '2025-09-15 18:36:46', NULL, NULL, 'Pago mensual', 'Transferencia', 10420, '@⁨Lucho⁩ anotar pago Mateo Local 18 del Sol', '68c8a30ecd278-3edfc5f6-7ba3-4c37-b929-ed3a8cc5e5f2.jpeg', NULL, 1, '2025-10-30 19:58:07', 1),
(220, 36, 1, '2025-09', NULL, NULL, '2025-09-16', '2025-09-16 09:49:45', NULL, NULL, 'Pago mensual', 'Efectivo', 2500, '@⁨Lucho⁩  ingresar pago $2500 efectivo Cristina cochera DC', '68c9790958d6b-IMG_3311.png', NULL, 0, NULL, NULL),
(221, 8, 1, '2025-08', NULL, NULL, '2025-09-16', '2025-09-16 11:30:53', NULL, NULL, 'Pago mensual', 'Efectivo', 9000, '@⁨Lucho⁩ ingresar pago local 35 americas efectivo', '68c990bd22933-ef35b4a9-2be5-40c9-b900-d641305f8435.jpeg', NULL, 0, NULL, NULL),
(222, 6, 1, '2025-09', NULL, NULL, '2025-09-19', '2025-09-19 16:13:13', NULL, NULL, 'Pago mensual', 'Efectivo', 7500, '@⁨Lucho⁩ ingresar pago local 5 galería de las americas Juan pólvora en efectivo', '68cdc769ab02f-7f4bfc82-7b1a-4208-80af-4bc3d763cb86.jpeg', NULL, 0, NULL, NULL),
(223, 53, 1, '2025-09', NULL, NULL, '2025-09-22', '2025-09-22 15:51:08', NULL, NULL, 'Pago mensual', 'Efectivo', 6300, '@⁨Lucho⁩ ingresar pago local 31B efectivo', '68d1b6bc8a4d1-863fbd2c-4012-425c-9840-a96bc0bdb8a2.jpeg', NULL, 0, NULL, NULL),
(224, 7, 1, '2025-09', NULL, NULL, '2025-09-23', '2025-09-23 13:43:55', NULL, NULL, 'Pago mensual', 'Efectivo', 8000, '@⁨Lucho⁩ ingresar pago local 10 galería de las americas', '68d2ea6b52f42-a6dc83ec-0f33-4b62-8ff9-89c591288925.jpeg', NULL, 0, NULL, NULL),
(225, 50, 1, '2025-07', NULL, NULL, '2025-09-24', '2025-09-24 18:41:58', NULL, NULL, 'Pago mensual', 'Transferencia', 14048, '@⁨Lucho⁩  anotar ingreso $ 14.048.-\r\nALQUILER IMPRENTA JULIO\r\n$ 18.000 menos $ 3952.- Contribucion', '68d481c6aac77-7e57f9ca-df6d-409e-93b2-ad182813090d.jpeg', NULL, 1, '2025-10-30 20:02:48', 1),
(226, 20, 1, '2025-10', NULL, NULL, '2025-10-02', '2025-10-02 15:14:10', NULL, NULL, 'Pago mensual', 'Transferencia', 3400, 'Christian Erika @⁨Lucho⁩ anotar pago', '68dedd12912a1-5df7cfbc-7972-42e5-97d7-851354579a58.jpeg', NULL, 1, '2025-10-30 20:04:54', 1),
(227, 29, 1, '2025-10', NULL, NULL, '2025-10-02', '2025-10-02 15:15:37', NULL, NULL, 'Pago mensual', 'Transferencia', 6200, '@⁨Lucho⁩ anotar pago Deposito Americas Carlos Guerra', '68dedd696a344-d8abe1e5-ed61-4aaa-a93c-55c5041f123d.jpeg', NULL, 1, '2025-10-30 20:04:46', 1),
(228, 47, 1, '2025-09', NULL, NULL, '2025-10-03', '2025-10-03 09:45:05', NULL, NULL, 'Pago mensual', 'Transferencia', 32705, '@⁨Lucho⁩  ingresar pago RPM547', '68dfe1718e204-RPMComprobante_TransferenciaEnElPais_3_10_2025_10_45.pdf', NULL, 1, '2025-10-30 20:05:51', 1),
(229, 24, 1, '2025-10', NULL, NULL, '2025-10-05', '2025-10-05 20:24:50', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, '@⁨Lucho⁩ anotar pago Natacha Gbolo', '68e31a6250568-ff1f29e8-0ae8-44bc-8a12-b74533eba501.jpeg', NULL, 1, '2025-10-30 20:06:06', 1),
(230, 55, 1, '2025-10', NULL, NULL, '2025-10-05', '2025-10-05 20:25:53', NULL, NULL, 'Pago mensual', 'Transferencia', 1500, '@⁨Lucho⁩ ingresar pago aparecida  gbolo', '68e31aa1c3b1d-681092b2-8945-4d5e-850e-457735fa8c79.jpeg', NULL, 1, '2025-10-30 20:06:14', 1),
(231, 14, 1, '2025-10', NULL, NULL, '2025-10-05', '2025-10-05 20:27:02', NULL, NULL, 'Pago mensual', 'Transferencia', 9100, '@⁨Lucho⁩ ingresar pago de Local 41 Entrevero Gaby', '68e31ae661b5a-cd5f00e8-c8ca-408c-bd05-d77de7d694b3.jpeg', NULL, 1, '2025-10-30 20:06:33', 1),
(232, 18, 1, '2025-10', NULL, NULL, '2025-10-05', '2025-10-05 20:31:50', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, '@lu anotar pago Sebastian Gbolo', '68e31c06160f4-Sarkis Transferencia_a_terceros_2510040508135469.pdf', NULL, 1, '2025-10-30 20:06:21', 1),
(233, 35, 1, '2025-10', NULL, NULL, '2025-10-06', '2025-10-06 17:38:42', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 2500, '@⁨Lucho⁩  ingresar pago Valverde $2500 efectivo DC', '68e444f29157e-4a0c1b66-ec42-405c-966f-e89e9d950770.jpeg', NULL, 0, NULL, NULL),
(234, 26, 1, '2025-10', NULL, NULL, '2025-10-06', '2025-10-06 17:39:27', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4200, '@⁨Lucho⁩  ingresar pago Gabriel galain efectivo $4200 GBOLO', '68e4451f5273c-33f42f37-ac91-46b8-9560-3d96bddbd928.jpeg', NULL, 0, NULL, NULL),
(235, 34, 1, '2025-10', NULL, NULL, '2025-10-07', '2025-10-07 08:06:44', NULL, NULL, 'Pago mensual', 'Transferencia', 2600, '@⁨Lucho⁩ ingresar pago Francisco Sanguinet DC. Cambio de auto , recién pasé por ahí hay un Fiat mobi blanco', '68e51064b5898-FSComprobante_Scotiabank_1759831133434.pdf', NULL, 1, '2025-10-30 20:06:55', 1),
(236, 19, 1, '2025-10', NULL, NULL, '2025-10-08', '2025-10-08 12:58:15', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'hola, cómo estás?  te envío comprobante por mi h por mi padre', '68e6a6370b026-Transferencia_a_terceros_2510080510234043.pdf', NULL, 1, '2025-10-30 20:07:36', 1),
(237, 54, 1, '2025-10', NULL, NULL, '2025-10-08', '2025-10-08 12:58:45', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, 'hola, cómo estás?  te envío comprobante por mi h por mi padre', '68e6a6558b19a-Transferencia_a_terceros_2510080510234043.pdf', NULL, 1, '2025-10-30 20:07:35', 1),
(238, 56, 1, '2025-10', NULL, NULL, '2025-10-08', '2025-10-08 18:15:23', NULL, NULL, 'Pago mensual', 'Transferencia', 12000, '@⁨Lucho⁩ ingresar pago Villa Serrana', '68e6f08b0c024-ea8eda52-560c-40ca-bb3c-ec26ba432b61.jpeg', NULL, 1, '2025-10-30 20:08:26', 1),
(239, 10, 1, '2025-10', NULL, NULL, '2025-10-10', '2025-10-10 20:22:26', NULL, NULL, 'Pago mensual', 'Transferencia', 6500, '@⁨Lucho⁩ ingresar pago local 105 americas elvis', '68e9b15233152-comprobante_transferencia_itau.pdf', NULL, 1, '2025-10-30 20:09:27', 1),
(241, 58, 1, '2025-10', NULL, NULL, '2025-10-10', '2025-10-10 20:31:15', NULL, NULL, 'Impuestos', 'Transferencia', 7311, '@lu ingresar pago Torre Maldonado con Saldo uTE que le.correspkndia a ella y pagamos total nosotros', '68e9b363d0527-ae3ec232-1d5c-4dc8-a8c3-c18ea7a1bc81.jpeg', NULL, 1, '2025-10-30 20:09:41', 1),
(242, 3, 1, '2025-10', NULL, NULL, '2025-10-10', '2025-10-10 20:33:17', NULL, NULL, 'Pago mensual', 'Transferencia', 10420, '@⁨Lucho⁩  ingresar pago Mateo Local 18 del Sol', '68e9b3dd88515-Comprobante_.pdf', NULL, 1, '2025-10-30 20:09:49', 1),
(243, 21, 1, '2025-10', NULL, NULL, '2025-10-11', '2025-10-11 19:43:33', NULL, NULL, 'Pago mensual', 'Transferencia', 3200, '@⁨Lucho⁩ ingresar pago corina gbolo', '68eaf9b5e3ff8-CorinaComprobante_Scotiabank_.pdf', NULL, 1, '2025-10-30 20:10:04', 1),
(244, 15, 1, '2025-10', NULL, NULL, '2025-10-11', '2025-10-11 19:44:32', NULL, NULL, 'Pago mensual', 'Transferencia', 40000, '@⁨Lucho⁩ ingresar pago Rondeau', '68eaf9f0f414d-d11a81ee-0d20-4e66-99c7-5060bc5c630f.jpeg', NULL, 1, '2025-10-30 20:10:07', 1),
(245, 8, 1, '2025-09', NULL, NULL, '2025-10-13', '2025-10-13 18:41:13', NULL, NULL, 'Pago mensual', 'Efectivo', 9000, '@⁨Lucho⁩ ingresar pago local 35 galería americas efectivo', '68ed8e19eb2f6-25d22d68-1578-46cd-921f-8e0f0c199d03.jpeg', NULL, 0, NULL, NULL),
(246, 23, 1, '2025-10', NULL, NULL, '2025-10-13', '2025-10-13 18:42:03', NULL, NULL, 'Pago mensual', 'Efectivo', 4300, '@⁨Lucho⁩  ingresar pago Walter amarok efectivo $4300 gbolo', NULL, NULL, 0, NULL, NULL),
(247, 36, 1, '2025-10', NULL, NULL, '2025-10-13', '2025-10-13 18:42:56', NULL, NULL, 'Pago mensual', 'Efectivo', 2500, '@⁨Lucho⁩ ingresar pago Cristina $2500 efectivo DC', '68ed8e80af2bd-IMG_3595.png', NULL, 0, NULL, NULL),
(248, NULL, 1, '', NULL, NULL, '2025-10-13', '2025-10-13 18:44:31', NULL, NULL, 'Arqueo de Caja (suma)', 'Transferencia', 80000, '@⁨Viviana Pérez⁩ @⁨Lucho⁩ hice depósito en la cuenta de alquileres $80.000 de el efectivo recaudado , queda en la caja $1.614', NULL, 1, 1, '2025-10-30 20:16:21', 1),
(249, 2, 1, '2025-10', NULL, NULL, '2025-10-13', '2025-10-13 18:46:11', NULL, NULL, 'Pago mensual', 'Transferencia', 7500, 'HOla Viviana, adjunto pago de alquiler, local 13 galeria del sol. muchas gracias, perdon la demora @⁨Lucho⁩  ingresar pago LOCAL 13 del SOL', '68ed8f43b8d13-Transferencia_a_terceros_2510130512307537.pdf', NULL, 1, '2025-10-30 20:16:29', 1),
(250, 33, 1, '2025-09', NULL, NULL, '2025-10-13', '2025-10-13 18:47:09', NULL, NULL, 'Pago mensual', 'Efectivo', 2500, '@⁨Lucho⁩ ingresar pago Edgardo DC 2 meses $2500 + $2500 efectivo total $5000', '68ed8f7d4de08-IMG_3597.png', NULL, 0, NULL, NULL),
(251, 33, 1, '2025-10', NULL, NULL, '2025-10-13', '2025-10-13 18:47:33', NULL, NULL, 'Pago mensual', 'Efectivo', 2500, '@⁨Lucho⁩ ingresar pago Edgardo DC 2 meses $2500 + $2500 efectivo total $5000', '68ed8f954333f-IMG_3597.png', NULL, 0, NULL, NULL),
(252, 28, 1, '2025-08', NULL, NULL, '2025-10-17', '2025-10-17 14:11:18', NULL, NULL, 'Pago mensual', 'Transferencia', 1500, '@⁨Lucho⁩  ingresar pago de Martin Moto Bolo Agosto Setiembre y Octubre mas control', '68f294d606a28-comprobante_transferencia_itau.pdf', NULL, 1, '2025-10-30 20:18:47', 1),
(253, 28, 1, '2025-09', NULL, NULL, '2025-10-17', '2025-10-17 14:11:39', NULL, NULL, 'Pago mensual', 'Transferencia', 1500, '@⁨Lucho⁩  ingresar pago de Martin Moto Bolo Agosto Setiembre y Octubre mas control', '68f294ebcbf59-comprobante_transferencia_itau.pdf', NULL, 1, '2025-10-30 20:18:46', 1),
(254, 28, 1, '2025-10', NULL, NULL, '2025-10-17', '2025-10-17 14:12:06', NULL, NULL, 'Pago mensual', 'Transferencia', 1500, '@⁨Lucho⁩  ingresar pago de Martin Moto Bolo Agosto Setiembre y Octubre mas control', '68f2950698c82-comprobante_transferencia_itau.pdf', NULL, 1, '2025-10-30 20:18:45', 1),
(255, 28, 1, '2025-10', NULL, NULL, '2025-10-17', '2025-10-17 14:13:13', NULL, NULL, 'Gastos comunes', 'Transferencia', 500, 'Control ', '68f29549e94e4-comprobante_transferencia_itau.pdf', NULL, 1, '2025-10-30 20:18:45', 1),
(256, 53, 1, '2025-10', NULL, NULL, '2025-10-20', '2025-10-20 13:39:34', NULL, NULL, 'Pago mensual', 'Efectivo', 6300, '@⁨Lucho⁩ ingresar pago local 31B Álvaro teatro la gringa *EFECTIVO* El mes q viene vence contrato y deja el local', '68f681e6998f0-7ba80590-f8cd-4e01-a5b5-b647fb90b88a.jpeg', NULL, 0, NULL, NULL),
(257, 57, 1, '2025-10', NULL, NULL, '2025-10-20', '2025-10-20 16:12:05', NULL, NULL, 'Pago mensual', 'Transferencia', 10000, '@lu ingresar pago Local 23 del Sol alquiler + GC', '68f6a5a51bcd9-Comprobante_Scotiabank_1760974576370.pdf', NULL, 1, '2025-10-30 20:19:17', 1);
INSERT INTO `pagos` (`id`, `contrato_id`, `usuario_id`, `periodo`, `mes`, `anio`, `fecha`, `fecha_creacion`, `fecha_programada`, `fecha_recibido`, `concepto`, `tipo_pago`, `importe`, `comentario`, `comprobante`, `pagado`, `validado`, `fecha_validacion`, `usuario_validacion_id`) VALUES
(258, 57, 1, '2025-10', NULL, NULL, '2025-10-20', '2025-10-20 16:12:40', NULL, NULL, 'Gastos comunes', 'Transferencia', 3400, '@lu ingresar pago Local 23 del Sol GASTOR COMUNES', '68f6a5c8de75f-Comprobante_Scotiabank_1760974576370.pdf', NULL, 1, '2025-10-30 20:19:17', 1),
(259, 49, 1, '2025-10', NULL, NULL, '2025-10-20', '2025-10-20 16:13:56', NULL, NULL, 'Pago mensual', 'Transferencia', 10000, '@⁨Lucho⁩ ingresar pago Local 7y8 Entrevero ALQUILER Y GC', '68f6a6144f9de-Comprobante_TransferenciaEnElPais_17_10_2025_09_18.pdf', NULL, 1, '2025-10-30 20:20:43', 1),
(260, 49, 1, '2025-10', NULL, NULL, '2025-10-20', '2025-10-20 16:14:33', NULL, NULL, 'Gastos comunes', 'Transferencia', 4400, '@⁨Lucho⁩ ingresar pago Local 7y8 Entrevero GASTOS COMUNES', '68f6a639c257e-Comprobante_TransferenciaEnElPais_17_10_2025_09_18.pdf', NULL, 1, '2025-10-30 20:20:42', 1),
(261, 7, 1, '2025-10', NULL, NULL, '2025-10-22', '2025-10-22 11:55:11', NULL, NULL, 'Pago mensual', 'Efectivo', 8000, '@⁨Lucho⁩ anotar ingreso alquiler local 10 galería americas efectivo', '68f90c6f90ea9-c2766121-6d8c-4705-b767-ecc1dd1aece8.jpeg', NULL, 0, NULL, NULL),
(262, 6, 1, '2025-10', NULL, NULL, '2025-10-22', '2025-10-22 11:56:04', NULL, NULL, 'Pago mensual', 'Efectivo', 7500, '@⁨Lucho⁩ anotar ingreso local 5 galería americas $7500 alquiler efectivo', '68f90ca4ded17-9040b3f4-c6a5-4c09-8d69-44c97c3e2459.jpeg', NULL, 0, NULL, NULL),
(263, 13, 1, '2025-08', NULL, NULL, '2025-10-23', '2025-10-23 18:32:03', NULL, NULL, 'Pago mensual', 'Efectivo', 11600, '@⁨Lucho⁩ agregar pago Elsa Núñez local 39 galería cristal efectivo\r\nSe lo acredito a Agosto **', '68fabaf3b583e-827946e9-383f-4d1b-9ebe-30a914b095eb.jpeg', NULL, 0, NULL, NULL),
(264, 20, 1, '2025-11', NULL, NULL, '2025-10-31', '2025-10-31 11:42:45', NULL, NULL, 'Pago mensual', 'Transferencia', 3400, '@⁨Lucho⁩ ingresar pago Erica Gbolo para noviembre ', '6904e705cd213-recibo_transferencia.pdf', NULL, 1, '2025-11-05 20:16:37', 1),
(265, 29, 1, '2025-11', NULL, NULL, '2025-11-01', '2025-11-01 10:02:28', NULL, NULL, 'Pago mensual', 'Transferencia', 6200, '@⁨Lucho⁩ ingresar psgo Carlos Deposito Americas', '69062104d11d3-dcd6fcf6-f12e-402b-9231-0d86e2aae3d3.jpeg', NULL, 1, '2025-11-05 20:16:54', 1),
(266, 47, 1, '2025-08', NULL, NULL, '2025-11-04', '2025-11-04 09:33:53', NULL, NULL, 'Pago mensual', 'Transferencia', 32705, 'Éste es el pago que hizo en septiembre que no ingresó', '690a1ce1c58cc-SeptiembreRPM.pdf', NULL, 1, '2025-11-05 20:17:41', 1),
(267, 18, 1, '2025-11', NULL, NULL, '2025-11-04', '2025-11-04 09:35:13', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, '@⁨Lucho⁩  ingresar pago Sarkisian', '690a1d31d0441-Transferencia_a_terceros_2511040523391231.pdf', NULL, 1, '2025-11-05 20:17:54', 1),
(268, 25, 1, '2025-11', NULL, NULL, '2025-11-04', '2025-11-04 13:09:22', NULL, NULL, 'Pago mensual', 'Transferencia', 2500, 'Barcode:40426136\r\n@⁨Lucho⁩ ingresar pago Martin Gbolo', '690a4f62926fd-IMG_3825.png', NULL, 1, '2025-11-05 20:18:08', 1),
(269, 10, 1, '2025-11', NULL, NULL, '2025-11-04', '2025-11-04 13:12:13', NULL, NULL, 'Pago mensual', 'Transferencia', 6500, '@⁨Lucho⁩ ingresar pago local 105 galería americas', '690a500de6b4f-105comprobante_transferencia_itau.pdf', NULL, 1, '2025-11-05 20:18:12', 1),
(270, 24, 1, '2025-11', NULL, NULL, '2025-11-04', '2025-11-04 19:02:41', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, '@⁨Lucho⁩ ingresar pago Natacha Gbolo', '690aa2314ebfd-comprobante-1762303793335.pdf', NULL, 1, '2025-11-05 20:18:46', 1),
(271, 25, 1, '2025-10', NULL, NULL, '2025-10-06', '2025-11-05 17:51:05', NULL, NULL, 'Pago mensual', 'Transferencia', 2500, 'Registro pago atrasado ', '690be2e9908a5-083062b4-c879-4aab-a964-67b08e03a61d.jpeg', NULL, 1, '2025-11-05 19:43:41', 1),
(272, 25, 1, '2025-09', NULL, NULL, '2025-09-05', '2025-11-05 17:52:02', NULL, NULL, 'Pago mensual', 'Transferencia', 2500, 'Cargo pago atrasado de septiembre ', '690be3225d700-54bb9637-e248-41b3-b8b7-11eb7abfab42.jpeg', NULL, 1, '2025-11-05 19:44:48', 1),
(273, 5, 1, '2025-08', NULL, NULL, '2025-08-27', '2025-11-05 19:17:28', NULL, NULL, 'Gastos comunes', 'Transferencia', 4110, 'BSCH-Gcomunes local 27-ANA KAREN FERNANDEZ PEREZ', NULL, NULL, 1, '2025-11-05 19:44:58', 1),
(274, 59, 1, '2025-10', NULL, NULL, '2025-10-21', '2025-11-05 19:29:15', NULL, NULL, 'Comisiones', 'Transferencia', 7000, 'TRANSFERENCIA RECIBIDA SPI		SPI_PREX16759910	ECON-null-DANIELA DORANTES\r\nComisión alquiler local 21', NULL, NULL, 1, '2025-11-05 19:43:07', 1),
(275, 60, 1, '2025-08', NULL, NULL, '2025-08-27', '2025-11-05 19:41:39', NULL, NULL, 'Comisiones', 'Transferencia', 7800, 'SPI - BCU TRASPASO DE DINERO		000020071117	ITAU-leslie Sartorio   local galer-SARTORIO FERREIRA LESLIE JUAN	199 - Casa Matriz\r\nComision alquiler transferir a Vivi', NULL, NULL, 0, NULL, NULL),
(276, 49, 1, '2025-11', NULL, NULL, '2025-11-06', '2025-11-06 08:17:17', NULL, NULL, 'Impuestos', 'Transferencia', 5785, '@⁨Lucho⁩ ingresa este pago que son los tributos del Local 7y8, ayer le reclame y le dije que sino tocabamos la garantia y me dijo que no sabe como pagarlos ??‍♀️ nos paso la plata y ya mande a habilitar las facturas para pagarlas yo... Así que entro la plata y cuando estén habilitadas las pago de la cuenta con ese mismo dinero', '690caded55eaf-040a9afe-cd76-430e-bbd0-c1f797d20821.jpeg', NULL, 0, NULL, NULL),
(277, 23, 1, '2025-11', NULL, NULL, '2025-11-06', '2025-11-06 09:17:48', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4300, '@⁨Lucho⁩  ingresar pago Walter amarok GBOLO $4300 efectivo', '690cbc1c80fa3-1fe97d05-6aaa-4f07-8cbf-66baed846e63.jpeg', NULL, 0, NULL, NULL),
(278, 26, 1, '2025-11', NULL, NULL, '2025-11-06', '2025-11-06 09:18:34', NULL, NULL, 'Pago mensual', 'Efectivo (Sobre)', 4200, '@⁨Lucho⁩  ingresar pago Gabriel galain GBOLO $4200 efectivo', '690cbc4a579b0-df3b5e3b-9f7d-4858-aec1-a2858a30eed6.jpeg', NULL, 0, NULL, NULL),
(279, 54, 1, '2025-11', NULL, NULL, '2025-11-06', '2025-11-06 09:19:37', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, '@⁨Lucho⁩  ingresar pago Ariana y Eduardo Bonilla GBOLo', '690cbc89e21e1-Transferencia_a_terceros_2511060524904201.pdf', NULL, 0, NULL, NULL),
(280, 19, 1, '2025-11', NULL, NULL, '2025-11-06', '2025-11-06 09:20:08', NULL, NULL, 'Pago mensual', 'Transferencia', 3600, '@⁨Lucho⁩  ingresar pago Ariana y Eduardo Bonilla GBOLo', '690cbca8820c8-Transferencia_a_terceros_2511060524904201.pdf', NULL, 0, NULL, NULL),
(281, 14, 1, '2025-11', NULL, NULL, '2025-11-06', '2025-11-06 18:26:17', NULL, NULL, 'Pago mensual', 'Transferencia', 9100, '@⁨Lucho⁩ ingresar pago Gaby NAILS Local 41 del Entrevero', '690d3ca99899d-10fae515-46b2-4528-ad1c-d6f253c0340e.jpeg', NULL, 0, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id`, `nombre`, `tipo`, `direccion`, `galeria`, `local`, `precio`, `incluye_gc`, `gastos_comunes`, `estado`, `propietario_id`, `anep`, `ose`, `ute`, `padron`, `contribucion_inmobiliaria`, `imm_tasa_general`, `imm_tarifa_saneamiento`, `imm_instalaciones`, `imm_adicional_mercantil`, `convenios`, `comentarios`, `link_mercadolibre`, `link_otras`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`, `imagenes`, `documentos`) VALUES
(1, 'Galeria del Sol Local 10', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 10', 9000.00, 0, 3900.00, 'libre', 1, '', '', '', '6198', '0.00', '68352', '', '', '', '', 'alquilado a Patricia en $9000', 'https://inmueble.mercadolibre.com.uy/MLU-761468886-alquilo-excelente-local-en-galeria-del-sol-local-10-_JM', '', 1, NULL, '2025-09-16 20:58:03', '[]', '[]'),
(2, 'Galeria del Sol Local 13', 'Local', 'Convencion 1328 / 18 de Julio 918', 'Galeria del Sol', 'Local 13', 7500.00, 0, 0.00, 'alquilado', 1, '', '', '', '6198', '0.00', '', '', '', '5094084', '', 'solo dice Carolina $7500 mas gastos comunes. por otro lado aprovecho para comentarte lo siguiente: yo estuve comentándole a Raul que la empresa no tuvo andamiento, por lo tanto no estoy yendo al local, se me esta dificultando poder pagar el alquiler, hay alguna forma de poder rescindir el contrato aunque sea pagando multa?\r\ntambien podria ser traspaso del alquiler, pero yo no consigo alguien que quiera alquilar, si ustedes saben de alguien o si lo publican y esto les lleva gastos de comision o los que sea yo me hago cargo de los mismos. Te agradezco tu ayuda. Saludos. Carolina.', 'https://inmueble.mercadolibre.com.uy/MLU-760923170-alquilo-local-chico-en-galeria-del-sol-local-13-_JM', '', 1, NULL, '2025-07-02 21:49:32', '[]', '[]'),
(3, 'Galeria del Sol Local 18', 'Local', 'Convencion 1328 / 18 de Julio 918', 'Galeria del Sol', 'Local 18', 10420.00, 1, 0.00, 'alquilado', 1, '', '', '', '6198', '240950', '657110', '', '', '', '5433182', 'Local &amp;quot;Libre&amp;quot; $7500 mas gastos comunes $10420', '', '', 1, NULL, '2025-10-10 20:33:56', '[]', '[]'),
(4, 'Galeria del Sol Local 21', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 21', 7000.00, 0, 3500.00, 'alquilado', 1, '5094088', '', '5593995653', '6198', '240953', '2143431', '', '', '658371', '', 'Alquilado a &amp;quot;Sofia&amp;quot; en $12100 gastos comunes incluidos\r\n\r\nLocal 21 $ 7.000 + $ 3.500.- Gastos Comunes + $ 800.- Agua\r\n\r\nA nombre de Viviana:\r\nUTE Galería del Sol Local 21\r\n5593995653\r\nVence los 22', '', '', 1, NULL, '2025-09-16 21:01:42', '[]', '[]'),
(5, 'Galeria del Sol Local 23', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 23', 9000.00, 0, 0.00, 'alquilado', 1, '1884062', '', '', '6198', '240255', '657123', '', '', '214432', '', 'Local Libre $9000 mas gastos comunes tiene agua e instalacion de peluqueria. \r\nConsultar a Vivi dice que está alquilado \r\nArmado para peluquería $ 11.000.- y sin las cosas $ 9.000.- seria\r\n\r\nhttps://inmueble.mercadolibre.com.uy/MLU-711075574-alquilo-local-en-galeria-del-sol-l-23-_JM', 'https://inmueble.mercadolibre.com.uy/MLU-711075574-alquilo-local-en-galeria-del-sol-l-23-_JM', '', 1, NULL, '2025-08-28 21:18:22', '[]', '[]'),
(6, 'Galeria del Sol Local 27', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 27', 9500.00, 0, 4110.00, 'libre', 1, '', NULL, NULL, '6198', '2002262', '658355', NULL, NULL, '5094108', NULL, 'Alquilado a \"Marcia\" , garantia de porto $9500 mas $4110 de gastos counes  mas impuestos', NULL, NULL, 0, NULL, NULL, '', ''),
(7, 'Galeria de las Americas Local 5', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 5', 7500.00, 0, 0.00, 'alquilado', 1, '1997049', NULL, NULL, '8665', '253666', '665608', NULL, NULL, '665604', NULL, 'alquilado juan polvora ( el tatuador) alquiler $7500 lo paga efectivo en mi local a mes vencido mas gastos comunes', NULL, NULL, 0, NULL, NULL, '', ''),
(8, 'Galeria de las Americas Local 10', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 10', 8000.00, 0, 0.00, 'alquilado', 1, '', '', '', '8665', '253671', '', '', '', '', '', 'alqulado EXAFIX sin garantia contrato de palabra con raulito alquiler $8000 paga efectivo en mi local paga a mes corriente , mas gastos comunes e impuestos', '', '', 2, NULL, '2025-07-14 21:01:11', '[]', '[]'),
(9, 'Galeria de las Americas Local 31B', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 31B', 6500.00, 0, 0.00, 'alquilado', 1, '1997189', '', '3355441000', '8665', '253692', '665622', '', '', '665626', '', 'esta libre , es un local chiquito que papa dividio su oficina y lo alquila $6500 luz y gastos comunes incluidos', '', '', 1, NULL, '2025-07-08 21:17:11', '[]', '[\"doc_686d2b8ee9376.jpeg\"]'),
(10, 'Galeria de las Americas Local 35', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 35', 9000.00, 0, 0.00, 'alquilado', 1, '1997329', '', '', '8665', '253696', '665651', '', '', '665634', '', 'alquilado a Yasmani y Sheylan alquiler $9000 mas gastos comunes e impuestos', NULL, NULL, 1, NULL, '2025-07-01 10:35:33', '[]', '[\"doc_6864004536f3d.png\"]'),
(11, 'Galeria de las Americas Local 103', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 103', 11000.00, 0, 0.00, 'libre', 1, '', '', '8211066909', '8665', '253704', '665654', '', '', '66639', '5662868', 'alquilado a &amp;amp;quot;Claudia&amp;amp;quot; $11000 mas gastos comunes e impuestos garantia ANDA y anda deposita en cta brou de papa\r\n\r\nA nombre de Raúl:\r\nUTE Galería de las Américas \r\nLocal 103 EP\r\n8211066909', '', '', 1, NULL, '2025-09-04 16:42:08', '[]', '[\"doc_68ba07b01ac50.jpeg\"]'),
(12, 'Galeria de las Americas Local 105', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 105', 6500.00, 0, 0.00, 'alquilado', 1, '', '', '', '8665', '2003472', '665656', '', '', '', '', 'alquilado a Elvis en $6500 mas gastos comunes ,deposita a papa en BROU\r\nPADRON 8665 UNIDAD 105 PLANTA EP / VALOR IMPONIBLE 00000941522.00 / CARPETA CATASTRAL 331 SOLAR 11', '', '', 1, NULL, '2025-07-04 20:44:53', '[]', '[]'),
(13, 'Galeria de las Americas Local 106', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 106', 7862.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, '8665', '253710', '665630', NULL, NULL, NULL, NULL, 'alquilado a Juan Carlos Petit tel 099244504 en $7862', NULL, NULL, 0, NULL, NULL, '', ''),
(15, 'Galeria Cristal Local 39', 'Local', 'Galeria Cristal', 'Galeria Cristal', 'Local 39', 7000.00, 0, 0.00, 'alquilado', 1, '', '', '', '5373', '236999', '672529', '', '', '2186501', '', 'alquilado a Elsa 094800635 $7000', '', '', 1, NULL, '2025-07-03 21:23:47', '[\"685ff7076b568.jpeg\",\"685ff7076b99f.jpeg\"]', '[]'),
(16, 'Local Figueroa Local 6', 'Local', 'Local Figueroa', '', 'Local 6', 0.00, 0, 0.00, 'libre', 6, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, 'es el local 6 esta vacio es de Marta', NULL, NULL, 1, NULL, '2025-06-18 09:17:23', '[\"6852ca735d737.jpeg\",\"6852ca735da07.jpeg\",\"6852ca735db92.jpeg\",\"6852ca735dcd7.jpeg\",\"6852ca735de4d.jpeg\",\"6852ca735dfd9.jpeg\",\"6852ca735e154.jpeg\",\"6852ca735e2ab.jpeg\",\"6852ca735e439.jpeg\",\"6852ca735e5dc.jpeg\",\"6852ca735e71d.jpeg\",\"6852ca735e89e.jpeg\",\"6852ca735ea5d.jpeg\",\"6852ca735ec34.jpeg\",\"6852ca735ee44.jpeg\"]', '[]'),
(17, 'Galeria Entrevero Local 7y8', 'Local', '18 de Julio 1020 Galeria Entrevero', 'Galeria Entrevero', 'Local 7 / 8', 10000.00, 0, 4400.00, 'alquilado', 1, '', '', '0841699157', '6562', '0.00', '5522753', '', '', '', 'cc5627448 cv2805979 Fatima', '', '', '', 1, NULL, '2025-11-06 17:58:19', '[\"684901da10d77.jpeg\",\"684901da1100e.jpeg\",\"684901da11198.jpeg\",\"684901da112d2.jpeg\",\"684901da113e1.jpeg\",\"684901da115c2.jpeg\"]', '[]'),
(18, 'Galeria Entrevero Local 41', 'Local', 'Galeria Entrevero', 'Galeria Entrevero', 'Local 41', 9100.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, '6562', '0.00', '660198', NULL, NULL, NULL, NULL, 'alquilado a \"nails\" ', NULL, NULL, 0, NULL, NULL, '', ''),
(19, 'Local Rondeau', 'Local', 'Rondeau 1524', '', 'Local Rondeau', 40000.00, 0, 0.00, 'alquilado', 2, '', '', '', '7171', '245682', '676148', '', '', '676149', 'cc5881645 cv2878525 - $15039 juicio contribucion inm cc5881649 cv2878528 - $7722 juicio tributos dom', 'Local a medias C/ R Jr , el inquilino paga $40.000 a cta a medias', '', '', 1, NULL, '2025-11-06 17:52:41', '[]', '[\"doc_68920f3718634.pdf\"]'),
(20, 'Villa Serrana', 'Apartamento', 'Villa Serrana', '', 'Villa Serrana', 12000.00, 0, 0.00, 'alquilado', 2, '', '', '', '', '0.00', '', '', '', '', '', 'casa a medias c/R Jr actualmente alquilada a punto de terminar contrato paga $12000 deposita en cuenta a medias', '', '', 1, NULL, '2025-08-09 17:17:10', '[]', '[]'),
(21, 'Apto 116B PDE', 'Apartamento', 'Apto 116B PDE', '', 'Apto 116B PDE', 18000.00, 0, 0.00, 'libre', 2, '', '', '', '', '0.00', '', '', '', '', '', 'local a medias c/ R Jr actualmente alquilado a &quot;porte?o&quot;&quot; tiene una deuda congelada q paga el titulas y el alquiler lo paga el &quot;inquilino&quot; mes a mes', '', '', 1, NULL, '2025-07-10 19:55:07', '[]', '[]'),
(22, 'Apto Galeria Caracol', 'Apartamento', 'El Foque 3 Caracol 106SS', 'Galeria Caracol', '106SS', 0.00, 0, 0.00, 'en venta', 1, '', '', '', '338', '', '', '', '', '', '', 'es de uso propio', '', '', 1, NULL, '2025-07-13 14:35:10', '[\"68740a6ea62b8.jpeg\",\"68740a6ea6b1a.jpeg\",\"68740a6ea6d17.jpeg\",\"68740a6ea715a.jpeg\",\"68740a6ea7505.jpeg\",\"68740a6ea76c3.jpeg\",\"68740a6ea7848.jpeg\"]', '[]'),
(23, 'Bolo 01', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '0.00', '', '', '', '', '', '', NULL, NULL, 1, NULL, '2025-06-30 21:22:09', '[]', '[]'),
(24, 'Bolo 02', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(25, 'Bolo 03', 'Cochera', 'Bolo', '', '', 3400.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(26, 'Bolo 04', 'Cochera', 'Bolo', '', '', 3200.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(27, 'Bolo 05', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '0.00', '', '', '', '', '', 'Estaba Alejandra Ancheta dejó libre a fin de junio 2025', '', '', 1, NULL, '2025-07-08 16:11:28', '[]', '[]'),
(28, 'Bolo 06', 'Cochera', 'Bolo', '', '', 4300.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(29, 'Bolo 07', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(30, 'Bolo 08', 'Cochera', 'Bolo', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(31, 'Bolo 09', 'Cochera', 'Bolo', '', '', 4200.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(32, 'Bolo 10', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'libre', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(33, 'Bolo Apto', 'Apartamento', 'Bolo', '', 'Apartamento', 0.00, 0, 0.00, 'libre', 1, '', '', '', '', '0.00', '', '', '', '', '', 'https://apartamento.mercadolibre.com.uy/MLU-760936286-alquilo-apartamento-en-el-interior-de-un-garage-_JM', NULL, NULL, 1, NULL, '2025-06-29 10:22:36', '[]', '[]'),
(34, 'Bolo Moto', 'Cochera', 'Bolo', '', '', 1500.00, 0, 0.00, 'alquilado', 1, '7/5 brou', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(35, 'Deposito GA', 'Deposito', 'Galeria de las Americas', 'Galeria de las Americas', 'D1', 6200.00, 0, 0.00, 'alquilado', 1, '2/5 brou', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(36, 'Tmal Torre Maldonado Local 30', 'Local', 'VENTURA ALEGRE ESQ SARANDI UNIDAD 030, MALDONADO.', 'Terminal', 'Local 030', 7500.00, 0, 0.00, 'alquilado', 1, '6998682', '', '8074805933', '160', '0.00', '', '', '', '', '', 'alquilado a Mariana 094511313 , garantia de porto $5500 gastos comunes inlcuidos pq son muy baratos paga en brou a papa\r\n\r\nA nombre de Viviana:\r\nUTE Torre Maldonado Local 30 (Para la UTE figura como 26)\r\n8074805933\r\nVence los 1eros', '', 'https://share.google/jgsaWEcdg1uWTJvFo', 1, NULL, '2025-08-13 20:35:22', '[\"687a81f471fc8.jpeg\",\"687a81f472891.jpeg\",\"687a81f472bcc.jpeg\",\"687a81f47312c.jpeg\",\"687a81f4733b1.jpeg\",\"687a81f4736fa.jpeg\",\"687a81f473bfa.jpeg\"]', '[\"doc_6872aa06aed8d.jpeg\"]'),
(37, 'dc2', 'Cochera', 'Dionisio Coronel', '', '', 2400.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, '37744', '355822', '1056584', NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(38, 'dc3', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'libre', 1, '', '', '', '', '0.00', '', '', '', '', '', '', NULL, NULL, 1, NULL, '2025-06-24 20:50:01', '[]', '[]'),
(39, 'dc4', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '13/5 sob', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(40, 'dc5', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'libre', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(41, 'dc6', 'Cochera', 'Dionisio Coronel', '', '', 2600.00, 0, 0.00, 'alquilado', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(42, 'dc7', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '7/5 sob', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(43, 'dc9', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'uso propio', 1, '', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(44, 'dc10', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 1, '13/5 sob', NULL, NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0, NULL, NULL, '', ''),
(48, 'Elysee local 11 Lucho', 'Local', 'San Jose 1029 Local 11 Elysee', 'Elysee', '11', 6500.00, 0, 0.00, 'alquilado', 3, '4478918', '', '9680131000 a nombre de ella', '409234 unidad 11', '2036342', '659818', '', '', '', '', 'Tributos domiciliarios Tasa General cuenta 659818\r\nContribución inmobiliaria cuenta 2036342\r\n(6300) SAN JOSE 1029 /11 / CARPETA CATASTRAL 235 PADRON 409234 SOLAR 24 CARPETA PH 18834', '', '', 1, '2025-06-09 19:35:42', '2025-09-16 16:59:47', '[\"6852c9dc08424.jpeg\"]', '[\"doc_684ae16402f5f.jpeg\",\"doc_684ae16403bf5.jpeg\"]'),
(49, 'Ruperto Pérez Martínez', 'Casa', 'Ruperto Perez Martinez 547', '', '', 32705.00, 0, 0.00, 'alquilado', 1, '2675931', '', '', '36982', '', '', '', '', '', '', '', '', '', 1, '2025-06-10 07:53:27', '2025-07-05 20:48:16', '[\"68630c4703719.jpeg\"]', '[]'),
(50, 'Bolognese Garage Completo', 'Garage', 'Bolognese', '', '', 31110.00, 0, 0.00, 'alquilado', 5, 'NO', '32338646', '6248041675', '40538', '', '1062617', '2776128', '5913400', '1062618', '', 'Esto lo alquilamos a Cristina Di Candia (propietaria)… se le hace pago mensual\r\nCuenta $ 000155113-00002', '', '', 1, '2025-06-10 11:04:11', '2025-11-06 18:31:49', '[]', '[\"doc_685eae251de80.png\",\"doc_68c84d8f2e305.pdf\"]'),
(51, 'Imprenta', 'Local', 'Cerrito 564', '', '', 18000.00, 1, 0.00, 'alquilado', 1, '6373802', '', '', '', '228933.00', '', '', '', '', '', 'DEL PRECIO DEL ALQUILER SE DESCUENTA ANEP Y CONTRIBUCION.\r\nPADRÓN N° 3350', '', '', 1, '2025-06-11 00:04:37', '2025-07-15 10:58:44', '[]', '[\"doc_68767ab47edc8.jpeg\"]'),
(52, 'Bolo 11', 'Cochera', 'Bolognese', '', '', 3600.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, 1, '2025-06-24 20:29:55', NULL, '[]', '[]'),
(53, 'Solanas Tiempo Compartido', 'Apartamento', 'Solanas', '', '', 1.00, 0, 0.00, 'libre', 1, '', '', '', '', '', '', '', '', '', '', 'Averiguar\r\nExpensas extraordinarias 2025 https://solanasvacation.com.ar/mailings/expensas-extraordinarias/', 'https://apartamento.mercadolibre.com.uy/MLU-731343182-tiempo-compartido-en-solanas-2-aptos-y-6-personas-_JM#origin%3Dshare%26sid%3Dshare', '', 1, '2025-06-26 10:01:55', '2025-10-24 18:38:23', '[]', '[\"doc_68a7d3ddc0fad.jpeg\",\"doc_68a7d3ddc182d.jpeg\",\"doc_68a7d3ddc2049.jpeg\",\"doc_68b7a31cbd6d6.jpeg\",\"doc_68b7a31cbdc03.jpeg\",\"doc_68b7a31cbdd94.jpeg\",\"doc_68b7a31cbdf37.jpeg\",\"doc_68fc0def53198.docx\"]'),
(54, 'Galería del Sol Local 29', 'Local', 'Galería del Sol', 'Galeria del Sol', '29', 1.00, 0, 0.00, 'libre', 7, '', '', '', '', '', '', '', '', '', '', '', 'https://inmueble.mercadolibre.com.uy/MLU-761741210-alquilo-local-en-galeria-del-sol-local-29-_Jm', '', 1, '2025-07-03 20:34:15', NULL, '[]', '[]'),
(55, 'Galería del Sol local 17', 'Local', 'Galería del Sol', 'Galería del Sol', '17', 6000.00, 0, 3500.00, 'libre', 8, '', '', '', '', '', '', '', '', '', '', '', 'https://inmueble.mercadolibre.com.uy/MLU-713447896-alquilo-excelente-local-en-galeria-del-sol-l-17-_JM', '', 1, '2025-07-03 20:37:03', '2025-09-16 21:00:13', '[]', '[]'),
(56, 'Dionisio Coronel Garage', 'Garage', 'Dionisio Coronel', '', '', 1.00, 0, 0.00, 'uso propio', 1, '', '', '5421541000', '36992', '334707', '1047951', '', '', '', '', '', '', '', 1, '2025-07-04 10:30:57', '2025-07-05 20:30:10', '[]', '[]'),
(57, 'Luis Battle Berres', 'Casa', 'Luis Battle Berres 4137', '', '', 1.00, 0, 0.00, 'uso propio', 1, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '2025-07-04 10:35:37', '2025-07-05 20:30:02', '[]', '[]'),
(58, 'Neptunia', 'Casa', 'Neptunia', '', '', 1.00, 0, 0.00, 'uso propio', 1, '', '33093931', '0788181000', '', '', '', '', '', '', '', '', '', '', 1, '2025-07-04 10:37:11', '2025-08-22 22:00:03', '[]', '[]'),
(59, 'Galería de las Americas Local 34', 'Local', '18 de Julio 1240', 'Galería de las Americas', 'Local 34', 1.00, 0, 0.00, 'uso propio', 1, '', '', '', '8665', '253695', '665650', '', '', '4183770', '', '', '', '', 1, '2025-07-04 11:55:49', '2025-07-17 15:06:29', '[]', '[]'),
(60, 'Elysee local 12 Raul', 'Local', 'Galería Elysee', 'Galería Elysee', '12', 1.00, 0, 0.00, 'alquilado', 9, '', '', '', '', '', '', '', '', '', '', '', '', 'https://www.infocasas.com.uy/alquilo-local-en-galeria-elysee/191666650', 1, '2025-07-07 11:17:35', '2025-07-11 14:26:46', '[\"686bf31f88c59.jpeg\",\"686bf31f89215.jpeg\",\"686bf31f89a85.jpeg\",\"686bf31f89f84.jpeg\",\"686bf31f8ab29.jpeg\",\"686bf31f8af80.jpeg\"]', '[]'),
(61, 'Bolo Moto 2', 'Cochera', 'Bolognese', '', '', 1500.00, 0, 0.00, 'alquilado', 1, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '2025-07-17 20:45:12', NULL, '[]', '[]');

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
(1, 'Raul Pérez Rosado (TODOS)', '', 'fasterworks@gmail.com, vivianaperezbandera@gmail.com, raulperez53@hotmail.com'),
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
