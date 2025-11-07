-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-06-2025 a las 19:39:21
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 8.1.32

SET FOREIGN_KEY_CHECKS=0;
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
  `propiedad_id` int(11) NOT NULL,
  `inquilino_id` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `renta_mensual` decimal(10,2) NOT NULL,
  `estado` enum('Activo','Finalizado','Cancelado') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `propiedad_id`, `inquilino_id`, `fecha_inicio`, `fecha_fin`, `renta_mensual`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-05-19', '2027-05-19', 9000.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(2, 2, 2, '2025-05-19', '2027-05-19', 7500.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(3, 4, 3, '2025-05-19', '2027-05-19', 12100.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(4, 6, 4, '2025-05-19', '2027-05-19', 9500.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(5, 7, 5, '2025-05-19', '2027-05-19', 7500.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(6, 8, 6, '2025-05-19', '2027-05-19', 8000.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(7, 10, 7, '2025-05-19', '2027-05-19', 9000.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(8, 11, 8, '2025-05-19', '2027-05-19', 11000.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(9, 12, 9, '2025-05-19', '2027-05-19', 6500.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(10, 13, 10, '2025-05-19', '2027-05-19', 7862.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(11, 14, 11, '2025-05-19', '2027-05-19', 5500.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(12, 15, 12, '2025-05-19', '2027-05-19', 7000.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(13, 18, 13, '2025-05-19', '2027-05-19', 9100.00, 'Activo', '2025-05-20 05:27:18', '2025-05-20 05:27:18'),
(14, 19, 25, '2024-06-01', '2027-05-31', 3600.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(15, 20, 26, '2024-06-01', '2027-05-31', 3600.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(16, 21, 27, '2024-06-01', '2027-05-31', 3400.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(17, 22, 28, '2024-06-01', '2027-05-31', 3200.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(18, 23, 29, '2024-06-01', '2027-05-31', 3400.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(19, 24, 30, '2024-06-01', '2027-05-31', 4300.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(20, 25, 31, '2024-06-01', '2027-05-31', 3600.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(21, 26, 32, '2024-06-01', '2027-05-31', 2500.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(22, 27, 33, '2024-06-01', '2027-05-31', 4200.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(23, 28, 34, '2024-06-01', '2027-05-31', 3600.00, 'Activo', '2025-05-20 08:34:32', '2025-05-20 08:34:32'),
(24, 29, 35, '2024-06-01', '2027-05-31', 1500.00, 'Activo', '2025-05-20 08:34:33', '2025-05-20 08:34:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inquilinos`
--

CREATE TABLE IF NOT EXISTS `inquilinos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `documento` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `telefono` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `vehiculo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `matricula` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `documento` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `inquilinos`
--

INSERT INTO `inquilinos` (`id`, `nombre`, `documento`, `email`, `telefono`, `vehiculo`, `matricula`, `created_at`, `updated_at`) VALUES
(1, 'Patricia', 'pendiente-001', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(2, 'Carolina', 'pendiente-002', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(3, 'Sofia', 'pendiente-003', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(4, 'Marcia', 'pendiente-004', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(5, 'Juan Polonio', 'pendiente-005', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(6, 'Exafix', 'pendiente-006', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(7, 'Yasmani y Sheylan', 'pendiente-007', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(8, 'Claudia', 'pendiente-008', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(9, 'Elvis', 'pendiente-009', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(10, 'Juan Carlos Petit', '099244504', 'pendiente@email.com', '099244504', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(11, 'Mariana', '094511313', 'pendiente@email.com', '094511313', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(12, 'Elsa', '094800635', 'pendiente@email.com', '094800635', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(13, 'Gaby Nails', 'pendiente-010', 'pendiente@email.com', 'pendiente', NULL, NULL, '2025-05-20 05:12:10', '2025-05-20 05:12:10'),
(25, 'Sarkisian', 'pendiente-011', 'pendiente@email.com', '099647878', 'Onix Sedan', 'SDC5513', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(26, 'Eduardo', 'pendiente-012', 'pendiente@email.com', '095199525', 'Geely', 'SDF2678', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(27, 'Cristian', 'pendiente-013', 'pendiente@email.com', '099764804', 'Fiat Mobi', '', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(28, 'Corina', 'pendiente-014', 'pendiente@email.com', '095277483', 'Hyundai i10', 'SBM1892', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(29, 'Alejandra ancheta', 'pendiente-015', 'pendiente@email.com', '095860816', 'Onix Hatch', 'SCS2773', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(30, 'Walter', 'pendiente-016', 'pendiente@email.com', '097089289', 'Amarok', 'SCG3263', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(31, 'Natacha', 'pendiente-017', 'pendiente@email.com', '099415432', 'Golf', '', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(32, 'Martin', 'pendiente-018', 'pendiente@email.com', '095038197', 'Fiat Ritmo', '', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(33, 'Gabriel', 'pendiente-019', 'pendiente@email.com', '099405290', 'BMW', 'SBD8965', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(34, 'Lau / Fabian', 'pendiente-020', 'pendiente@email.com', '096325786', 'Corsa', 'SBM6092', '2025-05-20 08:33:12', '2025-05-20 08:33:12'),
(35, 'Martin', 'pendiente-021', 'pendiente@email.com', '098669973', 'Moto', '', '2025-05-20 08:33:12', '2025-05-20 08:33:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE IF NOT EXISTS `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contrato_id` int(11) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `monto_pagado` decimal(10,2) DEFAULT NULL,
  `comprobante` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` enum('Pendiente','Pagado','Vencido') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

CREATE TABLE IF NOT EXISTS `propiedades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` enum('Departamento','Casa','Local','Cochera') COLLATE utf8_unicode_ci NOT NULL,
  `galeria` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `local` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` enum('Disponible','Alquilado') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Disponible',
  `caracteristicas` text COLLATE utf8_unicode_ci,
  `gastos_comunes` decimal(10,2) DEFAULT '0.00',
  `contribucion_inmobiliaria_cc` int(11) DEFAULT '0',
  `contribucion_inmobiliaria_padron` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id`, `direccion`, `tipo`, `galeria`, `local`, `precio`, `estado`, `caracteristicas`, `gastos_comunes`, `contribucion_inmobiliaria_cc`, `contribucion_inmobiliaria_padron`, `created_at`, `updated_at`) VALUES
(1, 'Galeria del Sol - Local 10', 'Local', 'Galeria del Sol', 'Local 10', 9000.00, 'Alquilado', 'alquilado a \"Patricia\" en $9000', 0.00, 0, 0, '2025-05-20 05:26:53', '2025-05-20 05:26:53'),
(2, 'Galeria del Sol - Local 13', 'Local', 'Galeria del Sol', 'Local 13', 7500.00, 'Alquilado', 'solo dice \"Carolina\" $7500 mas gastos comunes', 0.00, 0, 0, '2025-05-20 05:26:53', '2025-05-20 05:26:53'),
(3, 'Galeria del Sol - Local 18', 'Local', 'Galeria del Sol', 'Local 18', 7500.00, 'Alquilado', 'Local \"Libre\" $7500 mas gastos comunes. Dice Vivi que está alquilado a joyero corregir…', 0.00, 0, 0, '2025-05-20 05:26:53', '2025-05-25 20:13:03'),
(4, 'Galeria del Sol - Local 21', 'Local', 'Galeria del Sol', 'Local 21', 12100.00, 'Alquilado', 'Alquilado a \"Sofia\" en $12100 gastos comunes incluidos', 0.00, 0, 0, '2025-05-20 05:26:53', '2025-05-20 05:26:53'),
(5, 'Galeria del Sol - Local 23', 'Local', 'Galeria del Sol', 'Local 23', 9000.00, 'Disponible', 'Local \"Libre\" $9000 mas gastos comunes tiene agua a instalacion de peluqueria', 0.00, 0, 0, '2025-05-20 05:26:53', '2025-05-20 05:55:17'),
(6, 'Galeria del Sol - Local 27', 'Local', 'Galeria del Sol', 'Local 27', 9500.00, 'Alquilado', 'Alquilado a \"Marcia\", garantia de porto $9500 mas $4110 de gastos comunes mas impuestos', 0.00, 0, 0, '2025-05-20 05:26:53', '2025-05-20 05:26:53'),
(7, 'Galeria de las Americas - Local 5', 'Local', 'Galeria de las Americas', 'Local 5', 7500.00, 'Alquilado', 'alquilado (juan polonio y el tatuador) alquiler $7500 lo paga efectivo en mi local a mes vencido mas gastos comunes', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(8, 'Galeria de las Americas - Local 10', 'Local', 'Galeria de las Americas', 'Local 10', 8000.00, 'Alquilado', 'alquilado EXAFIX sin garantia contrato de palabra con raulito alquiler $8000 paga efectivo en mi local paga a mes corriente , mas gastos comunes e impuestos', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(9, 'Galeria de las Americas - Local 31B', 'Local', 'Galeria de las Americas', 'Local 31B', 6500.00, 'Disponible', 'esta libre , es un local chiquito que paga dividio oficina y lo alquila $6500 luz y gastos comunes incluidos', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:55:03'),
(10, 'Galeria de las Americas - Local 35', 'Local', 'Galeria de las Americas', 'Local 35', 9000.00, 'Alquilado', 'alquilado a Yasmani y Sheylan alquiler $9000 mas gastos comunes e impuestos', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(11, 'Galeria de las Americas - Local 103', 'Local', 'Galeria de las Americas', 'Local 103', 11000.00, 'Alquilado', 'alquilado a \"Claudia\" $11000 mas gastos comunes e impuestos garantia ANDA y paga deposita en cta brou de papa', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(12, 'Galeria de las Americas - Local 105', 'Local', 'Galeria de las Americas', 'Local 105', 6500.00, 'Alquilado', 'alquilado a Elvis en $6500 mas gastos comunes deposita a papa en BROU', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(13, 'Galeria de las Americas - Local 106', 'Local', 'Galeria de las Americas', 'Local 106', 7862.00, 'Alquilado', 'alquilado a Juan Carlos Petit tel 099244504 en $7862', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(14, 'Torre Maldonado - Local 030', 'Local', 'Torre Maldonado', 'Local 030', 5500.00, 'Alquilado', 'alquilado a \"Mariana\" 094511313, garantia de porto $5500 gastos comunes incluidos son muy baratos paga muy bien paga a papa', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(15, 'Galeria Cristal - Local 39', 'Local', 'Galeria Cristal', 'Local 39', 7000.00, 'Alquilado', 'alquilado a \"Elsa\" 094800635 $7000', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(16, 'Local Figueroa - Local 6', 'Local', 'Local Figueroa', 'Local 6', 0.00, 'Disponible', 'es el local 6 esta vacio', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(17, 'Galeria Entrevero - Local 7/8', 'Local', 'Galeria Entrevero', 'Local 7/8', 9000.00, 'Disponible', 'vacio esta para alquilar \"economico\" paga $4400 de alquiler', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(18, 'Galeria Entrevero - Local 41', 'Local', 'Galeria Entrevero', 'Local 41', 9100.00, 'Alquilado', 'alquilado a \"nails\"', 0.00, 0, 0, '2025-05-20 05:26:54', '2025-05-20 05:26:54'),
(19, 'Bolo 001', 'Cochera', NULL, NULL, 3600.00, 'Alquilado', '5/5 brou', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(20, 'Bolo 002', 'Cochera', NULL, NULL, 3600.00, 'Alquilado', '14/5 sob', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(21, 'Bolo 003', 'Cochera', NULL, NULL, 3400.00, 'Alquilado', '2/5 brou', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(22, 'Bolo 004', 'Cochera', NULL, NULL, 3200.00, 'Alquilado', '7/5 brou', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(23, 'Bolo 005', 'Cochera', NULL, NULL, 3400.00, 'Alquilado', 'brou', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(24, 'Bolo 006', 'Cochera', NULL, NULL, 4300.00, 'Alquilado', '5/5 sob', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(25, 'Bolo 007', 'Cochera', NULL, NULL, 3600.00, 'Alquilado', '5/5 brou', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(26, 'Bolo 008', 'Cochera', NULL, NULL, 2500.00, 'Alquilado', '5/5 sob', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(27, 'Bolo 009', 'Cochera', NULL, NULL, 4200.00, 'Alquilado', '5/5 brou', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(28, 'Bolo 010', 'Cochera', NULL, NULL, 3600.00, 'Alquilado', '5/5 sob', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(29, 'Bolo 011', 'Cochera', NULL, NULL, 1500.00, 'Alquilado', '7/5 brou', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02'),
(30, 'Bolo Apto', 'Departamento', NULL, NULL, 0.00, 'Disponible', 'Apartamento', 0.00, 0, 0, '2025-05-20 08:23:02', '2025-05-20 08:23:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedad_imagenes`
--

CREATE TABLE IF NOT EXISTS `propiedad_imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `propiedad_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `propiedad_id` (`propiedad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
