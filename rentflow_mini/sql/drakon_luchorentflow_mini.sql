-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2025 a las 23:07:13
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `drakon_luchorentflow_mini`
--
CREATE DATABASE IF NOT EXISTS `drakon_luchorentflow_mini` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `drakon_luchorentflow_mini`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id` int(11) NOT NULL,
  `inquilino_id` int(11) DEFAULT NULL,
  `propiedad_id` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `garantia` varchar(100) DEFAULT NULL,
  `corredor` varchar(100) DEFAULT NULL,
  `estado` enum('activo','finalizado') DEFAULT NULL,
  `documentos` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `inquilino_id`, `propiedad_id`, `fecha_inicio`, `fecha_fin`, `importe`, `garantia`, `corredor`, `estado`, `documentos`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 1, 1, '2025-01-01', '2026-02-01', 9000.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(2, 2, 2, '2025-01-01', '2026-02-01', 7500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(3, 3, 3, '2025-01-01', '2026-02-01', 7500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(4, 4, 4, '2025-01-01', '2026-02-01', 12100.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(5, 6, 6, '2025-01-01', '2026-02-01', 9500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(6, 7, 7, '2025-01-01', '2026-02-01', 7500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(7, 8, 8, '2025-01-01', '2026-02-01', 8000.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
(8, 10, 10, '2025-01-01', '2026-02-01', 9000.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL),
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
(36, 44, 44, '2025-01-01', '2026-02-01', 2500.00, NULL, NULL, 'activo', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inquilinos`
--

CREATE TABLE `inquilinos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `vehiculo` varchar(100) DEFAULT NULL,
  `matricula` varchar(50) DEFAULT NULL,
  `documentos` text NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `inquilinos`
--

INSERT INTO `inquilinos` (`id`, `nombre`, `telefono`, `vehiculo`, `matricula`, `documentos`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Patricia', '', '', '', '', 0, NULL, NULL),
(2, 'Carolina', '', '', '', '', 0, NULL, NULL),
(3, 'Inquilino 3', '', '', '', '', 0, NULL, NULL),
(4, 'Sofia', '', '', '', '', 0, NULL, NULL),
(6, 'Marcia', '', '', '', '', 0, NULL, NULL),
(7, 'Juan Polvera', '', '', '', '', 0, NULL, NULL),
(8, 'Exafix', '', '', '', '', 0, NULL, NULL),
(10, 'Yasmani y Sheylan', '', '', '', '', 0, NULL, NULL),
(11, 'Claudia', '', '', '', '', 0, NULL, NULL),
(12, 'Elvis', '', '', '', '', 0, NULL, NULL),
(13, 'Juan Carlos Petit', '099244504', '', '', '', 0, NULL, NULL),
(14, 'Mariana', '094511313', '', '', '', 0, NULL, NULL),
(15, 'Elsa', '094800635', '', '', '', 0, NULL, NULL),
(18, 'Gaby Nails', '', '', '', '', 0, NULL, NULL),
(19, 'Inquilino 1', '', '', '', '', 0, NULL, NULL),
(20, 'Inquilino 2', '', '', '', '', 0, NULL, NULL),
(21, 'Porteño', '', '', '', '', 0, NULL, NULL),
(23, 'Sarkisian', '099647878', 'Onix Sedan', 'SDC5513', '', 0, NULL, NULL),
(24, 'Eduardo', '095199525', 'Geely', 'SDF2678', '', 0, NULL, NULL),
(25, 'Cristian', '099764804', 'Fiat Mobi', '', '', 0, NULL, NULL),
(26, 'Corina', '095277483', 'Hyundai i10', 'SBM1892', '', 0, NULL, NULL),
(27, 'Alejandra ancheta', '095860816', 'Onix Hatch', 'SCS2773', '', 0, NULL, NULL),
(28, 'Walter', '097089289', 'Amarok', 'SCG3263', '', 0, NULL, NULL),
(29, 'Natacha', '099415432', 'Golf', '', '', 0, NULL, NULL),
(30, 'Martin', '095308197', 'Fiat Ritmo', '', '', 0, NULL, NULL),
(31, 'Gabriel', '0994052920', 'BMW', 'SDD8965', '', 0, NULL, NULL),
(32, 'Lau / Fabian', '096325786', 'Corsa', 'SBM6092', '', 0, NULL, NULL),
(34, 'Martin', '098669973', 'Moto', '', '', 0, NULL, NULL),
(35, 'Carlos Guerra', '094801410', '', '', '', 0, NULL, NULL),
(36, 'mariana', '094511313', '', '', '', 0, NULL, NULL),
(37, 'Alejandro', '098171789', 'Toyota', '', '', 0, NULL, NULL),
(38, 'Antonella', '095794847', 'Peugeot', '', '', 0, NULL, NULL),
(39, 'Edgardo', '', 'Camioneta', '', '', 0, NULL, NULL),
(41, 'Francisco', '', 'Ford Ka', '', '', 0, NULL, NULL),
(42, 'Valverde', '095856424', 'Ford Escort', '', '', 0, NULL, NULL),
(43, 'Raul Pérez', '', 'Jeep', '', '', 0, NULL, NULL),
(44, 'Cristina', '094106036', 'Suzuki', '', '', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `contrato_id` int(11) DEFAULT NULL,
  `periodo` varchar(7) NOT NULL,
  `mes` int(11) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_programada` date DEFAULT NULL,
  `fecha_recibido` date DEFAULT NULL,
  `concepto` varchar(50) NOT NULL,
  `importe` decimal(10,0) NOT NULL,
  `comentario` varchar(250) NOT NULL,
  `comprobante` text DEFAULT NULL,
  `pagado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `contrato_id`, `periodo`, `mes`, `anio`, `fecha`, `fecha_programada`, `fecha_recibido`, `concepto`, `importe`, `comentario`, `comprobante`, `pagado`) VALUES
(1, 18, '2025-06', NULL, NULL, NULL, NULL, '2025-06-05', 'Pago mensual', 1, 'Agregar pago cochera bolo sarkisian 5/6 transf BROU', '68474c9a23c8d-pago sarkis brou.png', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

CREATE TABLE `propiedades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `galeria` text DEFAULT NULL,
  `local` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `incluye_gc` tinyint(1) DEFAULT NULL,
  `gastos_comunes` decimal(10,2) DEFAULT NULL,
  `estado` enum('alquilado','libre','en venta','uso propio') DEFAULT NULL,
  `garantia` decimal(10,2) DEFAULT NULL,
  `corredor` varchar(100) DEFAULT NULL,
  `anep` varchar(100) DEFAULT NULL,
  `contribucion_inmobiliaria` decimal(10,2) DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `imagenes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id`, `nombre`, `tipo`, `direccion`, `galeria`, `local`, `precio`, `incluye_gc`, `gastos_comunes`, `estado`, `garantia`, `corredor`, `anep`, `contribucion_inmobiliaria`, `comentarios`, `usuario_id`, `fecha_creacion`, `fecha_modificacion`, `imagenes`) VALUES
(1, 'Galeria del Sol Local 10', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 10', 9000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"Patricia\" en $9000', 0, NULL, NULL, ''),
(2, 'Galeria del Sol Local 13', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 13', 7500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'solo dice \"Carolina\" $7500 mas gastos comunes', 0, NULL, NULL, ''),
(3, 'Galeria del Sol Local 18', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 18', 7500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'Local \"Libre\" $7500 mas gastos comunes', 0, NULL, NULL, ''),
(4, 'Galeria del Sol Local 21', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 21', 12100.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'Alquilado a \"Sofia\" en $12100 gastos comunes incluidos', 0, NULL, NULL, ''),
(5, 'Galeria del Sol Local 23', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 23', 9000.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, 'Local \"Libre\" $9000 mas gastos comunes tiene agua e instalacion de peluqueria ', 0, NULL, NULL, ''),
(6, 'Galeria del Sol Local 27', 'Local', 'Galeria del Sol', 'Galeria del Sol', 'Local 27', 9500.00, 0, 4110.00, 'alquilado', 0.00, '', '', 0.00, 'Alquilado a \"Marcia\" , garantia de porto $9500 mas $4110 de gastos counes  mas impuestos', 0, NULL, NULL, ''),
(7, 'Galeria de las Americas Local 5', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 5', 7500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado juan polvora ( el tatuador) alquiler $7500 lo paga efectivo en mi local a mes vencido mas gastos comunes', 0, NULL, NULL, ''),
(8, 'Galeria de las Americas Local 10', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 10', 8000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alqulado EXAFIX sin garantia contrato de palabra con raulito alquiler $8000 paga efectivo en mi local paga a mes corriente , mas gastos comunes e impuestos', 0, NULL, NULL, ''),
(9, 'Galeria de las Americas Local 31B ', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 31B ', 6500.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, 'esta libre , es un local chiquito que papa dividio su oficina y lo alquila $6500 luz y gastos comunes incluidos', 0, NULL, NULL, ''),
(10, 'Galeria de las Americas Local 35', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 35', 9000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a Yasmani y Sheylan alquiler $9000 mas gastos comunes e impuestos', 0, NULL, NULL, ''),
(11, 'Galeria de las Americas Local 103', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 103', 11000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"Claudia\" $11000 mas gastos comunes e impuestos garantia ANDA y anda deposita en cta brou de papa', 0, NULL, NULL, ''),
(12, 'Galeria de las Americas Local 105', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 105', 6500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a Elvis en $6500 mas gastos comunes ,deposita a papa en BROU', 0, NULL, NULL, ''),
(13, 'Galeria de las Americas Local 106', 'Local', 'Galeria de las Americas', 'Galeria de las Americas', 'Local 106', 7862.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a Juan Carlos Petit tel 099244504 en $7862', 0, NULL, NULL, ''),
(14, 'Torre Maldonado Local 030', 'Local', 'Torre Maldonado', 'Torre Maldonado', 'Local 030', 5500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"Mariana\" 094511313 , garantia de porto $5500 gastos comunes inlcuidos pq son muy baratos paga en brou a papa', 0, NULL, NULL, ''),
(15, 'Galeria Cristal Local 39', 'Local', 'Galeria Cristal', 'Galeria Cristal', 'Local 39', 7000.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"Elsa\" 094800635 $7000', 0, NULL, NULL, ''),
(16, 'Local Figueroa Local 6', 'Local', 'Local Figueroa', '', 'Local 6', 0.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, 'es el local 6 esta vacio', 0, NULL, NULL, ''),
(17, 'Galeria Entrevero Local 7 / 8', 'Local', 'Galeria Entrevero', 'Galeria Entrevero', 'Local 7 / 8', 9000.00, 0, 4400.00, 'libre', 0.00, '', '', 0.00, 'vacio esta para alquilar \"economico\" paga $4400 de alquiler', 0, NULL, NULL, ''),
(18, 'Galeria Entrevero Local 41', 'Local', 'Galeria Entrevero', 'Galeria Entrevero', 'Local 41', 9100.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'alquilado a \"nails\" ', 0, NULL, NULL, ''),
(19, 'Local Rondeau ', 'Local', 'Local Rondeau ', '', 'Local Rondeau ', 0.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'Local a medias C/ R Jr , el inquilino paga $40.000 a cta a medias', 0, NULL, NULL, ''),
(20, 'Villa Serrana', 'Apto', 'Villa Serrana', '', 'Villa Serrana', 0.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'casa a medias c/R Jr actualmente alquilada a punto de terminar contrato paga $12000 deposita en cuenta a medias', 0, NULL, NULL, ''),
(21, 'Apto 116B PDE', 'Apto', 'Apto 116B PDE', '', 'Apto 116B PDE', 0.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, 'local a medias c/ R Jr actualmente alquilado a \"porte?o\"\" tiene una deuda congelada q paga el titulas y el alquiler lo paga el \"inquilino\" mes a mes', 0, NULL, NULL, ''),
(22, 'Apto Galeria Caracol', 'Apto', 'Apto Galeria Caracol', 'Galeria Caracol', 'Apto Galeria Caracol', 0.00, 0, 0.00, 'en venta', 0.00, '', '', 0.00, ' es de uso propio ', 0, NULL, NULL, ''),
(23, 'Bolo 01', 'Cochera', 'Bolo', '', '', 0.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(24, 'Bolo 02', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(25, 'Bolo 03', 'Cochera', 'Bolo', '', '', 3400.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(26, 'Bolo 04', 'Cochera', 'Bolo', '', '', 3200.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(27, 'Bolo 05', 'Cochera', 'Bolo', '', '', 3400.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(28, 'Bolo 06', 'Cochera', 'Bolo', '', '', 4300.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(29, 'Bolo 07', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(30, 'Bolo 08', 'Cochera', 'Bolo', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(31, 'Bolo 09', 'Cochera', 'Bolo', '', '', 4200.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(32, 'Bolo 10', 'Cochera', 'Bolo', '', '', 3600.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(33, 'Bolo Apto', 'Apto', 'Bolo', '', 'Apartamento', 0.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(34, 'Bolo Moto', 'Cochera', 'Bolo', '', '', 1500.00, 0, 0.00, 'alquilado', 0.00, '', '7/5 brou', 0.00, '', 0, NULL, NULL, ''),
(35, 'Deposito GA', 'Deposito', 'Galeria de las Americas', 'Galeria de las Americas', 'D1', 6200.00, 0, 0.00, 'alquilado', 0.00, '', '2/5 brou', 0.00, '', 0, NULL, NULL, ''),
(36, 'Tmal', 'Local', 'Terminal', 'Terminal', 'Local 030', 5500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(37, 'dc2', 'Cochera', 'Dionisio Coronel', '', '', 2400.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(38, 'dc3', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(39, 'dc4', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '13/5 sob', '13/5 sob', 0.00, '', 0, NULL, NULL, ''),
(40, 'dc5', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'libre', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(41, 'dc6', 'Cochera', 'Dionisio Coronel', '', '', 2600.00, 0, 0.00, 'alquilado', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(42, 'dc7', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '', '7/5 sob', 0.00, '', 0, NULL, NULL, ''),
(43, 'dc9', 'Cochera', 'Dionisio Coronel', '', '', 0.00, 0, 0.00, 'uso propio', 0.00, '', '', 0.00, '', 0, NULL, NULL, ''),
(44, 'dc10', 'Cochera', 'Dionisio Coronel', '', '', 2500.00, 0, 0.00, 'alquilado', 0.00, '', '13/5 sob', 0.00, '', 0, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario_normal') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `rol`) VALUES
(1, 'adminlucho', '$2y$10$abyePc/p1B5wCEkBuT9ZJOG5lZRffcq7f5lLuFkz.ZOgTZxsA1yz.', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inquilinos`
--
ALTER TABLE `inquilinos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `inquilinos`
--
ALTER TABLE `inquilinos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
