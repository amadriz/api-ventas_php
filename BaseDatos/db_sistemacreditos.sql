-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-01-2024 a las 20:53:08
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_sistemacreditos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `idcliente` bigint(20) NOT NULL,
  `identificacion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombres` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` bigint(20) DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nit` varchar(20) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nombrefiscal` varchar(200) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `direccionfiscal` varchar(200) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

DROP TABLE IF EXISTS `cuenta`;
CREATE TABLE IF NOT EXISTS `cuenta` (
  `idcuenta` bigint(20) NOT NULL,
  `clienteid` bigint(20) NOT NULL,
  `productoid` bigint(20) NOT NULL,
  `frecuenciaid` bigint(20) NOT NULL,
  `monto` decimal(10,0) NOT NULL,
  `cuotas` int(11) NOT NULL,
  `monto_cuotas` decimal(10,0) NOT NULL,
  `cargo` decimal(10,0) NOT NULL,
  `saldo` decimal(10,0) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frecuencia`
--

DROP TABLE IF EXISTS `frecuencia`;
CREATE TABLE IF NOT EXISTS `frecuencia` (
  `idfrecuencia` bigint(20) NOT NULL,
  `frecuencia` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

DROP TABLE IF EXISTS `movimiento`;
CREATE TABLE IF NOT EXISTS `movimiento` (
  `idmovimiento` int(11) NOT NULL,
  `cuentaid` bigint(20) NOT NULL,
  `tipomovimientoid` bigint(20) NOT NULL,
  `monto` decimal(10,0) NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `idproducto` bigint(20) NOT NULL,
  `codigo` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_movimiento`
--

DROP TABLE IF EXISTS `tipo_movimiento`;
CREATE TABLE IF NOT EXISTS `tipo_movimiento` (
  `idtipomovimiento` bigint(20) NOT NULL,
  `movimiento` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo_movimiento` int(11) NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
