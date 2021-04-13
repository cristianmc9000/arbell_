-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2017 a las 22:40:08
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `almacen`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `CI` varchar(11) DEFAULT NULL,
  `nombre` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(15) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `CI`, `nombre`, `apellidos`, `telefono`, `estado`) VALUES
(1, '7216904', 'Cristian', 'Mamani Cardozo', 76191403, 1),
(2, '7654321', 'Jose', 'Rodriguez', NULL, 1),
(3, '4574711', 'Omar', 'Canaza', NULL, 1),
(4, '1231233', 'Raul', 'Torrez', NULL, 1),
(5, '5487714', 'Raul', 'Torrez', NULL, 0),
(6, '5487741', 'Luis Miguel', 'Davalos', NULL, 1),
(7, '4587414', 'Oberyn', 'Martel', NULL, 1),
(8, '7458854', 'SerArthur', 'Dayne', NULL, 1),
(9, '7548874', 'John', 'Wick', NULL, 1),
(10, '7445587', 'Carlos', 'Cordero', NULL, 1),
(13, '7788987', 'Lidia', 'Gueiler Tejada', NULL, 0),
(17, '7788987', 'Lidia', 'Gueiler Tejada', NULL, 1),
(19, '', 'Steve', 'Rogers', NULL, 1),
(20, '', 'Rodrigo', 'gonzales', NULL, 1),
(21, '', 'yrene ', 'dolz', NULL, 1),
(22, '', 'xxxx', 'xxxxx', NULL, 0),
(23, '', 'jose', 'torrejon', NULL, 1),
(24, '', 'tutuy', 'fdgfd', 0, 0),
(25, '721005', 'iiiiii', 'iiiiiii', 0, 0),
(26, '7210055', 'rrrrrr', 'rrrrrr', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id_venta` int(11) NOT NULL,
  `idpro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`id_venta`, `idpro`, `cantidad`, `estado`) VALUES
(17, 81, 1, 1),
(17, 80, 1, 1),
(17, 79, 1, 1),
(17, 78, 1, 1),
(17, 77, 1, 1),
(17, 76, 1, 1),
(17, 75, 1, 1),
(17, 1, 1, 1),
(18, 87, 1, 1),
(18, 86, 1, 1),
(18, 85, 1, 1),
(18, 84, 1, 1),
(18, 83, 1, 1),
(18, 82, 1, 1),
(19, 71, 5, 1),
(19, 70, 5, 1),
(19, 67, 5, 1),
(19, 65, 5, 1),
(20, 71, 25, 1),
(21, 70, 5, 1),
(21, 66, 5, 1),
(21, 65, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `modelo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `precio_ref` float NOT NULL,
  `cantidad` int(11) DEFAULT '0',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `codigo` varchar(15) NOT NULL,
  `sucursal` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `modelo`, `precio_ref`, `cantidad`, `estado`, `codigo`, `sucursal`) VALUES
(1, 'GELATINA RIQ. DURAZNO', 3.28, 14, 1, 'GRD40', 2),
(35, 'GELATINA RIQ. FRESA', 3.6, 20, 1, 'GRF20', 1),
(36, 'GELATINA RIQ. LIMON', 3.26, 40, 1, 'GRL40', 1),
(37, 'GELATINA RIQ. MANZANA', 3.24, 40, 1, 'GRM40', 1),
(38, 'GELATINA RIQ. NARANJA', 3.29, 40, 1, 'GRNA40', 1),
(39, 'GELATINA RIQ. PIÃ‘A', 3.39, 40, 1, 'GRP40', 1),
(40, 'GELATINA RIQ. SURTIDO', 3.6, 20, 1, 'GRS20', 1),
(41, 'GELATINA RIQ. UVA', 3.23, 40, 1, 'GRU40', 1),
(42, 'GELATINA RIQ. DURAZNO', 3.28, 40, 1, 'GRD40', 1),
(43, 'GELATINA DAMI FRESA 250 GR', 3.25, 20, 1, 'GDF20', 1),
(44, 'GELATINA DAMI LIMON 250 GR.', 3.5, 20, 1, 'GDL20', 1),
(45, 'GELATINA DAMI NARANJA 250 GR', 3.5, 20, 1, 'GDN20', 1),
(46, 'GELATINA DAMI 250 GR', 3.28, 20, 1, 'GDP20', 1),
(47, 'GELATINA DAMI SURTIDO 250 GR', 3.25, 20, 1, 'GDS20', 1),
(48, 'GELATINA DE PATA 1 KG', 28, 10, 1, 'GP1', 1),
(49, 'FLAN DAMI DE 1 KG', 16.5, 10, 1, 'FD1', 1),
(50, 'FLAN DAMI CHOCOLATE DE 120 GR', 2.02, 120, 1, 'FDC120', 1),
(51, 'FLAN DAMI FRES DE 120 GR', 2.3, 120, 1, 'FDF120', 1),
(52, 'FLAN DAMI VAINILLA DE 120 GR', 1.89, 120, 1, 'FDV120', 1),
(53, 'GELATINA SIN SABOR DE 45GR.', 4.08, 45, 1, 'GSS4524', 1),
(54, 'AZUCAR DAMI DE 100GR.', 0.5, 100, 1, 'AZD100', 1),
(55, 'AZUCAR DAMI DE 12UND.', 4.22, 12, 1, 'AZD12', 1),
(56, 'REFRESCO TOMAY MANGO', 0.35, 150, 1, 'RTMA150', 1),
(57, 'REFRESCO TOMAY COCO', 0.36, 25, 1, 'RTCO150', 1),
(58, 'REFRESCO TOMAY DURAZNO', 0.34, 225, 1, 'RTD150', 1),
(59, 'REFRESCO TOMAY FRESA', 0.32, 150, 1, 'RTF150', 1),
(60, 'REFRSCO TOMAY FRAMBUESA', 0.32, 150, 1, 'RFTFR150', 1),
(61, 'RERESCO TOMAY MARACUYA', 0.33, 150, 1, 'RFTMAR150', 1),
(62, 'REFRESCO TOMAY NARANJA', 0.34, 150, 1, 'RTN150', 1),
(63, 'REFRESCO TOMAY SURTIDO', 0.33, 150, 1, 'RTS150', 1),
(64, 'REFRESCO TOMAY UVA', 0.39, 150, 1, 'RTU150', 1),
(65, 'ALCOHOL BOTELLA 1LT', 8.1, 470, 1, 'AL1L', 1),
(66, 'ALCOHOL BOTELLA 5LT', 56.25, 275, 1, 'AL5L', 1),
(67, 'ALCOHOL BOTELLA 1/8LT', 1.4, 331, 1, 'AL90', 1),
(68, 'GELATINA DE PATA VAINILLA', 3.79, 24, 1, 'GP24', 1),
(69, 'MAIZENA TOMAY 200GR.', 3, 255, 1, 'MT200', 1),
(70, 'ALCOHOL ALCOFORTE BOTELLA 1/4L', 1.44, 240, 1, 'ALF250', 1),
(71, 'ALCHOHOL s/MARCA BOTELLA 1/4L', 1.05, 0, 1, 'ALS250', 1),
(72, 'CALDO AILLIN GALLINA', 0.28, 90, 1, 'CAG', 1),
(73, 'CALDO AILLIN CARNE', 0.28, 120, 1, 'CAC', 1),
(74, 'CALDO AILLIN COSTILLA', 0.28, 110, 1, 'CACO', 1),
(75, 'GELATINA RIQ. FRESA', 3.6, 19, 1, 'GRF20', 2),
(76, 'GELATINA RIQ. LIMON', 3.26, 39, 1, 'GRL40', 2),
(77, 'GELATINA RIQ. MANZANA', 3.24, 39, 1, 'GRM40', 2),
(78, 'GELATINA RIQ. NARANJA', 3.29, 39, 1, 'GRNA', 2),
(79, 'GELATINA RIQ. PIÃ‘A', 3.29, 39, 1, 'GRP40', 2),
(80, 'GELATINA RIQ. SURTIDO', 3.6, 19, 1, 'GRS20', 2),
(81, 'GELATINA RIQ. UVA', 3.23, 39, 1, 'GRU40', 2),
(82, 'GELATINA DAMI FRESA 250 GR', 3.25, 19, 1, 'GDF20', 3),
(83, 'GELATINA DAMI LIMON 250 GR.', 3.5, 19, 1, 'GDL20', 3),
(84, 'GELATINA DAMI NARANJA 250 GR', 3.5, 19, 1, 'GDN20', 3),
(85, 'GELATINA DAMI PIÃ‘A 250GR.', 3.28, 79, 1, 'GDP20', 3),
(86, 'GELATINA DAMI SURTIDO 250 GR', 3.25, 99, 1, 'GDS20', 3),
(87, 'GELATINA DE PATA 1 KG', 28, 9, 1, 'GP1', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `CI` int(10) NOT NULL,
  `nombre` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(40) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL,
  `telefono` int(20) DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `sucursal` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`CI`, `nombre`, `apellidos`, `telefono`, `password`, `estado`, `sucursal`) VALUES
(1000000, 'Alejandra', 'Aguilar', 77894488, '1111', 1, 1),
(2000000, 'Ana', 'Montaño', 7771727, '2222', 1, 2),
(3000000, 'Leticia', 'Auza', 77458866, '3333', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `id_cli` int(11) NOT NULL,
  `ci_cli` int(11) DEFAULT NULL,
  `nombre_cli` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos_cli` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `total` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sucursal` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `id_cli`, `ci_cli`, `nombre_cli`, `apellidos_cli`, `total`, `fecha`, `sucursal`, `estado`) VALUES
(1, 9, 7548874, 'John', 'Wick', 3.29, '2017-12-03 23:33:05', 2, 1),
(2, 7, 4587414, 'Oberyn', 'Martel', 47.57, '2017-12-03 23:33:27', 2, 1),
(3, 8, 7458854, 'SerArthur', 'Dayne', 0.28, '2017-12-03 23:46:32', 2, 1),
(4, 10, 7445587, 'Carlos', 'Cordero', 33.9, '2017-12-04 02:53:39', 1, 1),
(5, 9, 7548874, 'John', 'Wick', 16.95, '2017-12-04 03:20:02', 1, 1),
(6, 7, 4587414, 'Oberyn', 'Martel', 6.78, '2017-12-03 03:28:17', 1, 1),
(7, 19, 0, 'Steve', 'Rogers', 37.29, '2017-12-04 03:36:38', 1, 1),
(8, 20, 0, 'Rodrigo', 'gonzales', 40.4, '2017-12-04 12:09:31', 1, 1),
(9, 20, 0, 'Rodrigo', 'gonzales', 6.78, '2017-12-04 12:11:02', 1, 1),
(10, 13, 7788987, 'Lidia', 'Gueiler Tejada', 16.95, '2017-12-04 12:11:51', 1, 1),
(11, 10, 7445587, 'Carlos', 'Cordero', 3.39, '2017-12-04 12:38:02', 1, 1),
(12, 21, 0, 'yrene ', 'dolz', 266.08, '2017-12-04 14:34:49', 1, 0),
(13, 22, 0, 'xxxx', 'xxxxx', 6.89, '2017-12-04 14:46:43', 2, 1),
(14, 23, 0, 'jose', 'torrejon', 218.13, '2017-12-04 14:59:03', 2, 0),
(15, 7, 4587414, 'Oberyn', 'Martel', 300.83, '2017-12-04 21:05:24', 2, 1),
(16, 8, 7458854, 'SerArthur', 'Dayne', 127.31, '2017-12-04 21:20:58', 2, 1),
(17, 23, 0, 'jose', 'torrejon', 26.79, '2017-12-05 11:28:13', 2, 1),
(18, 1, 7216904, 'Cristian', 'Mamani Cardozo', 44.78, '2017-12-05 11:36:40', 3, 1),
(19, 23, 0, 'jose', 'torrejon', 59.95, '2017-12-05 11:50:29', 1, 1),
(20, 9, 7548874, 'John', 'Wick', 26.25, '2017-12-05 11:53:38', 1, 1),
(21, 10, 7445587, 'Carlos', 'Cordero', 328.95, '2017-12-05 14:12:45', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`CI`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
