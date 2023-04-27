-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2022 a las 20:03:34
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mk`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotejo_sfp`
--

CREATE TABLE `cotejo_sfp` (
  `id_cot` int(11) NOT NULL,
  `ip1` varchar(99) NOT NULL,
  `mk_s` varchar(99) NOT NULL,
  `fibra_s` varchar(99) NOT NULL,
  `tx_s` varchar(999) NOT NULL,
  `rx_s` varchar(999) NOT NULL,
  `dif` varchar(99) NOT NULL,
  `link` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cotejo_sfp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip`
--

CREATE TABLE `ip` (
  `id_ip` int(11) NOT NULL,
  `ip_mk` varchar(99) NOT NULL,
  `nombre` varchar(99) NOT NULL,
  `ip` varchar(99) DEFAULT NULL,
  `network` varchar(99) DEFAULT NULL,
  `interface` varchar(99) NOT NULL,
  `tipo` varchar(99) DEFAULT NULL,
  `repetido` int(11) DEFAULT NULL,
  `lugar_rep` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ip`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ospf`
--

CREATE TABLE `ospf` (
  `id_ospf` int(11) NOT NULL,
  `ip_mk` varchar(99) NOT NULL,
  `interface` varchar(99) NOT NULL,
  `costo` int(11) NOT NULL,
  `prioridad` int(11) NOT NULL,
  `estado` varchar(99) NOT NULL,
  `instancia` varchar(99) NOT NULL,
  `ip_ospf` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ospf`
--


--
-- Estructura de tabla para la tabla `pass`
--

CREATE TABLE `pass` (
  `id_pass` int(11) NOT NULL,
  `user` varchar(99) NOT NULL,
  `pass` varchar(99) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pass`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `principal`
--

CREATE TABLE `principal` (
  `id_p` int(11) NOT NULL,
  `nombre` varchar(99) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `ip_mk` varchar(99) NOT NULL,
  `puertos` varchar(99) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `version` varchar(99) DEFAULT NULL,
  `firmware` varchar(99) DEFAULT NULL,
  `manual` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `principal`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puerto`
--

CREATE TABLE `puerto` (
  `ip_puerto` int(11) NOT NULL,
  `ip_mk` varchar(99) NOT NULL,
  `nombre_mk` varchar(99) NOT NULL,
  `puerto` varchar(99) NOT NULL,
  `comentario` varchar(99) NOT NULL,
  `velocidad` varchar(99) NOT NULL,
  `tx_sfp` double DEFAULT NULL,
  `rx_sfp` double DEFAULT NULL,
  `link_down` int(11) DEFAULT NULL,
  `last` varchar(255) DEFAULT NULL,
  `link` varchar(20) DEFAULT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puerto`
--
-

--
-- Estructura de tabla para la tabla `sfp`
--

CREATE TABLE `sfp` (
  `id_sfp` int(11) NOT NULL,
  `ip_mk` varchar(99) NOT NULL,
  `nombre` varchar(99) NOT NULL,
  `tx_sfp` varchar(99) NOT NULL,
  `rx_sfp` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sfp`
--


--
-- Estructura de tabla para la tabla `torres`
--

CREATE TABLE `torres` (
  `id_torre` int(11) NOT NULL,
  `nombre` varchar(99) NOT NULL,
  `ip` varchar(99) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_us` int(11) NOT NULL,
  `nombre` varchar(99) NOT NULL,
  `pass` varchar(99) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cotejo_sfp`
--
ALTER TABLE `cotejo_sfp`
  ADD PRIMARY KEY (`id_cot`);

--
-- Indices de la tabla `ip`
--
ALTER TABLE `ip`
  ADD PRIMARY KEY (`id_ip`);

--
-- Indices de la tabla `ip_public`
--
ALTER TABLE `ip_public`
  ADD PRIMARY KEY (`id_public`);

--
-- Indices de la tabla `ospf`
--
ALTER TABLE `ospf`
  ADD PRIMARY KEY (`id_ospf`);

--
-- Indices de la tabla `pass`
--
ALTER TABLE `pass`
  ADD PRIMARY KEY (`id_pass`);

--
-- Indices de la tabla `principal`
--
ALTER TABLE `principal`
  ADD PRIMARY KEY (`id_p`),
  ADD UNIQUE KEY `ip_mk` (`ip_mk`),
  ADD UNIQUE KEY `nombre` (`nombre`,`ip_mk`,`puertos`,`tipo`),
  ADD UNIQUE KEY `nombre_2` (`nombre`),
  ADD UNIQUE KEY `nombre_3` (`nombre`),
  ADD UNIQUE KEY `nombre_4` (`nombre`,`ip_mk`,`puertos`,`tipo`);

--
-- Indices de la tabla `puerto`
--
ALTER TABLE `puerto`
  ADD PRIMARY KEY (`ip_puerto`);

--
-- Indices de la tabla `sfp`
--
ALTER TABLE `sfp`
  ADD PRIMARY KEY (`id_sfp`);

--
-- Indices de la tabla `torres`
--
ALTER TABLE `torres`
  ADD PRIMARY KEY (`id_torre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_us`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cotejo_sfp`
--
ALTER TABLE `cotejo_sfp`
  MODIFY `id_cot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6528;

--
-- AUTO_INCREMENT de la tabla `ip`
--
ALTER TABLE `ip`
  MODIFY `id_ip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16100;

--
-- AUTO_INCREMENT de la tabla `ip_public`
--
ALTER TABLE `ip_public`
  MODIFY `id_public` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=781;

--
-- AUTO_INCREMENT de la tabla `ospf`
--
ALTER TABLE `ospf`
  MODIFY `id_ospf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10125;

--
-- AUTO_INCREMENT de la tabla `pass`
--
ALTER TABLE `pass`
  MODIFY `id_pass` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `principal`
--
ALTER TABLE `principal`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1249;

--
-- AUTO_INCREMENT de la tabla `puerto`
--
ALTER TABLE `puerto`
  MODIFY `ip_puerto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16871;

--
-- AUTO_INCREMENT de la tabla `sfp`
--
ALTER TABLE `sfp`
  MODIFY `id_sfp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `torres`
--
ALTER TABLE `torres`
  MODIFY `id_torre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1855;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_us` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
