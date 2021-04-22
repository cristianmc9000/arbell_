-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-04-2021 a las 15:16:33
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base_arbell`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(7) NOT NULL,
  `CA` int(7) NOT NULL,
  `CI` varchar(11) DEFAULT NULL,
  `nombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(15) DEFAULT NULL,
  `lugar` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `nivel` varchar(10) NOT NULL,
  `fecha_alta` date NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `CA`, `CI`, `nombre`, `apellidos`, `telefono`, `lugar`, `correo`, `nivel`, `fecha_alta`, `estado`) VALUES
(1, 12223, '8827712', 'EMILY', 'SANTOS', 1239789, 'YACUIBA', 'emily@gmail.com', 'experta', '2021-04-16', 1),
(2, 63896, '7216903', 'LITZI NATALI', 'LEON HERRERA', 71192771, 'Santa Cruz', 'litzileoncarmina@gmail.com', 'experta', '2021-04-16', 1),
(3, 70882, '7541125', 'MARIA EUGENIA', 'AGUILAR', 65322127, 'Tarija', 'mariaaguilarcarmina@gmail.com', 'lider', '2021-04-16', 1),
(4, 74522, '7852258', 'MARIELA', 'FLORES', 76198552, 'YACUIBA', 'marielaflorescarmina@gmail.com', 'lider', '2021-04-17', 1),
(5, 81743, '7452258', 'WILMA', 'AGRADA TORREZ DE ICHAZO', 71891837, 'YACUIBA', 'wilmaagradacarmina@gmail.com', 'experta', '2021-04-16', 1),
(6, 82698, '7548525', 'JHONATHAN PAUL', 'IRIARTE AVILES', 76185441, 'Santa Cruz', 'jhonathanavilescarmina@gmail.com', 'experta', '2021-04-16', 1),
(82699, 74758, '7255548', 'SHEILA MARIA LUZ', 'AGUILERA VEGA', 70215360, 'SANTA CRUZ', 'sheilavegacarmina@gmail.com', 'lider', '2021-04-18', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id_venta` int(11) NOT NULL,
  `idpro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
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
-- Estructura de tabla para la tabla `lineas`
--

CREATE TABLE `lineas` (
  `codli` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lineas`
--

INSERT INTO `lineas` (`codli`, `nombre`, `estado`) VALUES
(1, 'Orígenes', 1),
(2, '\0Inspiraciones', 1),
(3, 'Premium', 1),
(4, 'Juvenne', 1),
(5, 'Luxury', 1),
(7, 'Urbana', 1),
(8, 'Rainbow', 1),
(9, 'Aeon', 1),
(10, 'Ordeñe', 1),
(11, 'TratamientoPlus', 1),
(12, 'Gardenair', 1),
(13, 'Brizes', 1),
(14, 'Sanity', 1),
(15, 'Vitabell', 1),
(16, 'AuxiliaresDeVenta', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `linea` int(11) NOT NULL,
  `descripcion` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pupesos` float NOT NULL,
  `pubs` float NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fechav` date DEFAULT NULL,
  `fechareg` date NOT NULL DEFAULT current_timestamp(),
  `periodo` tinyint(4) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `foto`, `linea`, `descripcion`, `pupesos`, `pubs`, `cantidad`, `fechav`, `fechareg`, `periodo`, `estado`) VALUES
('0853', 'images/fotos_prod/500_F_259309839_MZkcptTSdHy6kbC43HJ9TBJgEL1ZQM3c.jpg', 1, 'Kit de lanzamiento periodo 2 - 2021', 3057.14, 227.13, 90, '2022-05-20', '2021-04-19', 2, 1),
('1205', 'images/fotos_prod/240_F_297700653_fymwdSCtRARRg8qfX1IN1HVYUjyjzasV.jpg', 1, 'Crema corporal enebro 100g', 700, 52, 49, '0000-00-00', '2021-04-19', 2, 1),
('1206', 'images/fotos_prod/500_F_259310839_Q5JnPPkcLhP6KeUXjsybAHG0KVsxGSqW.jpg', 1, 'Spray eucalivia 60ml', 700, 52, 49, '0000-00-00', '2021-04-19', 2, 1),
('1207', 'images/fotos_prod/68e70582d0eb22449e3f81b1419f48bb.jpg', 1, 'Unguento tomillo 12g', 550, 40.9, 31, '0000-00-00', '2021-04-19', 2, 1),
('1212', 'images/fotos_prod/defecto.png', 1, 'Lavanda bruma para almohada 75ml', 600, 44.6, 49, NULL, '2021-04-19', 2, 1),
('121212', 'images/fotos_prod/descarga.jfif', 1, 'prueba foto', 12, 0.84, 12, '0000-00-00', '2021-04-21', 2, 1),
('121212121212', 'images/fotos_prod/encuesta.jpg', 1, 'foto2', 122, 8.54, 122, '0000-00-00', '2021-04-21', 2, 1),
('1213', 'images/fotos_prod/defecto.png', 1, 'Lavanda crema corporal para masajes 200g', 600, 44.6, 49, NULL, '2021-04-19', 2, 1),
('1214', 'images/fotos_prod/defecto.png', 1, 'Castaña y almendra crema para manos 600g', 300, 22.3, 21, NULL, '2021-04-19', 2, 1),
('1215', 'images/fotos_prod/defecto.png', 1, 'Castañas y almendras aceite corporal 125ml', 800, 59.5, 56, NULL, '2021-04-19', 2, 1),
('1216', 'images/fotos_prod/defecto.png', 1, 'Jabón almendras y castañas 100g', 300, 22.3, 21, NULL, '2021-04-19', 2, 1),
('1217', 'images/fotos_prod/defecto.png', 1, 'Jabón lavanda y melisa 100g', 300, 22.3, 21, NULL, '2021-04-19', 2, 1),
('1218', 'images/fotos_prod/defecto.png', 1, 'Aloe vera gel corporal 180g', 700, 52, 49, NULL, '2021-04-19', 2, 1),
('1219', 'images/fotos_prod/defecto.png', 1, 'Hydra crema gel con aloe vera 50g', 400, 29.7, 28, NULL, '2021-04-19', 2, 1),
('1220', 'images/fotos_prod/defecto.png', 1, 'Óleo 33 aceites esenciales de 33 hierbas 20ml', 1790, 133, 125, NULL, '2021-04-19', 2, 1),
('229', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil angel o demonio 50ml', 500, 35, 12, '0000-00-00', '2021-04-20', 2, 1),
('AX00200', 'images/fotos_prod/defecto.png', 2, 'Inspiraciones 15ml', 100, 7, 50, '2022-06-09', '2021-04-19', 2, 1),
('F200', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch 212 carola 50ml', 500, 37.1, 35, '2022-07-19', '2021-04-19', 2, 1),
('F201', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch carola 50ml', 500, 37.1, 35, '2022-07-19', '2021-04-19', 2, 1),
('F202', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil chanel NÂ°5 50ml', 500, 37.1, 35, '2022-07-19', '2021-04-19', 2, 1),
('F203', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch 212 sex 50ml', 500, 37.1, 35, '2022-10-19', '2021-04-19', 2, 1),
('F204', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil hellowen 50ml', 500, 35, 35, '2022-10-19', '2021-04-19', 2, 1),
('F206', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil cabotin 50ml', 500, 35, 35, '2022-11-19', '2021-04-19', 2, 1),
('F207', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil Elen 50ml', 500, 35, 35, '2022-10-19', '2021-04-19', 2, 1),
('F208', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil flores de kanzai 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F209', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil kanzai  amour 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F210', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil nina 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F211', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch ch 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F214', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil black xs 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F221', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil tom girl 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F222', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil amor 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F225', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil isse mishake 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F233', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil acqua clio 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F249', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil miss chery 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F256', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch 212 vip 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F258', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil mujer millon 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F268', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil la vida es bella 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F269', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch 212 carola glow 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F271', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil d&g dolce blue 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F273', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch 212 vip rosa 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F275', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil kanzai juego de amor 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F280', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil la vida es bella rosa 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F281', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil posion girl 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F284', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch buena chica 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F286', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil mujer pillon privada 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F288', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch privada 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F289', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil black xs los angeles 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F290', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil rock 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F291', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil chanel coco madame 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F292', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil milagro 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F293', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil placeres 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F294', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil secreto tentacion 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F295', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil channel grabiella 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F296', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil i am 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F297', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil escandal 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F298', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil blue seduccion 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F299', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil blue 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F300', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil golden secret 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F301', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil miss queen 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F302', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil one millon lucky 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F303', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil vs b tease 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F304', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil vs b bombs 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F306', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil guchi bloom', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F307', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil olimpia legend', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F308', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil la bella jpg 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F309', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil ch vip rose red 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('F310', 'images/fotos_prod/defecto.png', 2, 'Fragancia femenina simil libre 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M200', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil ch 212 carola men 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M201', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil ck one 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M202', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil kanzai 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M203', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil polo black 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M204', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil acqua clio 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M205', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil simil paco 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M2071', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil invictus legend 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M208', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil ch herrera for men 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M210', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil polo 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M218', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil ch 212 sex men 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M222', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil tom 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M225', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil isse mishake 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M226', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil polo blue 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M232', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil one millon lingote 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M237', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil blue chanel 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M238', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil vos 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M239', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil ch 212 vip men 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M243', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil polo red 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M244', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil blaxk xs excess 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M245', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil invicto 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M248', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil boss diferent 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M249', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil polo red intenso 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M250', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil acqua profundo 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M251', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil culpable 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M252', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil invicto acua 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M253', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil salvaje 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M254', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil kevil 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M255', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil buscado 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M256', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil ch privado 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M257', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil xs black los angeles 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M258', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil blue seduccion 50ml', 500, 35, 35, '0000-00-00', '2021-04-20', 2, 1),
('M259', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil invictus intenso 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M260', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil ch 212 vip black 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M261', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil secreto 50ml', 500, 35, 212, '0000-00-00', '2021-04-20', 2, 1),
('M264', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil farenheit 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M265', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil polo ultra blue 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M266', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil one millon lucky 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M267', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil power seduccion 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M268', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil golden hombre 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M269', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil poder extr. 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M270', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil pure nigth 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M272', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil  50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M273', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil el bello jpg 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M274', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil ch vip black red 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1),
('M275', 'images/fotos_prod/defecto.png', 2, 'Fragancia masculina simil blue label 50ml', 500, 35, 1212, '0000-00-00', '2021-04-20', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `rol`, `descripcion`) VALUES
(1, 'Administrador', 'Tiene acceso a todos los modulos del sistema'),
(2, 'Vendedor', 'Tiene acceso a los modulos de ventas y reportes');

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
  `estado` tinyint(1) NOT NULL DEFAULT 1,
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
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sucursal` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
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
-- Indices de la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`codli`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `linea` (`linea`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

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
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82700;

--
-- AUTO_INCREMENT de la tabla `lineas`
--
ALTER TABLE `lineas`
  MODIFY `codli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`linea`) REFERENCES `lineas` (`codli`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
