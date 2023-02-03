-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-01-2023 a las 18:35:48
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `veterinaria`
--
CREATE DATABASE IF NOT EXISTS `veterinaria` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `veterinaria`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animales`
--

CREATE TABLE `animales` (
  `NumHistorial` int(50) NOT NULL,
  `NomAnimal` varchar(50) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `animales`
--

INSERT INTO `animales` (`NumHistorial`, `NomAnimal`, `idTipo`, `idCliente`) VALUES
(1, 'África', 1, 1),
(2, 'Samba', 1, 2),
(3, 'Coronel', 3, 8),
(4, 'Lluvia', 3, 2),
(5, 'Manchado', 3, 10),
(6, 'Tod', 2, 9),
(7, 'Greñas', 3, 8),
(8, 'Selva', 1, 3),
(9, 'Tranquilo', 1, 4),
(10, 'Brandy', 2, 4),
(11, 'Bolita', 1, 7),
(12, 'Jazz', 1, 7),
(13, 'Granadina', 3, 4),
(14, 'Loco', 5, 10),
(15, 'Flaco', 2, 6),
(16, 'Blas', 2, 5),
(17, 'Homer', 1, 2),
(18, 'Peleón', 1, 8),
(19, 'Rubio', 2, 9),
(20, 'Tequila', 3, 10),
(21, 'Sirio', 4, 6),
(22, 'Bicho', 1, 7),
(23, 'Bruno', 1, 7),
(24, 'Kara', 2, 2),
(25, 'Tormenta', 5, 6),
(26, 'Miel', 5, 4),
(27, 'Lola', 4, 7),
(28, 'Pepa', 4, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `fecha` date NOT NULL,
  `idIntervalo` int(11) NOT NULL,
  `NumHistorial` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`fecha`, `idIntervalo`, `NumHistorial`) VALUES
('2023-01-02', 1, 1),
('2023-01-03', 1, 1),
('2023-01-04', 1, 1),
('2023-01-10', 1, 1),
('2023-01-09', 2, 1),
('2023-01-02', 3, 1),
('2023-01-06', 7, 1),
('2023-01-03', 2, 2),
('2023-01-02', 4, 2),
('2023-01-04', 7, 2),
('2023-01-11', 10, 2),
('2022-04-18', 1, 3),
('2023-01-03', 8, 4),
('2023-01-05', 4, 11),
('2023-01-04', 5, 11),
('2023-01-11', 6, 11),
('2022-04-18', 8, 12),
('2022-04-19', 3, 13),
('2022-04-21', 6, 16),
('2023-01-04', 3, 17),
('2022-04-21', 8, 18),
('2023-01-13', 10, 22),
('2023-01-03', 6, 24),
('2023-01-05', 8, 24),
('2023-01-05', 10, 26),
('2023-01-06', 1, 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `NIF` varchar(50) DEFAULT NULL,
  `NomCliente` varchar(50) NOT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `foto` varchar(256) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `token` varchar(255) DEFAULT 'nada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `NIF`, `NomCliente`, `Apellidos`, `foto`, `Correo`, `activo`, `token`) VALUES
(1, '03805585-M', 'ANA', 'FERNÁNDEZ CARRASCOSO', '1.jpg', 'ana@gmail.com', 1, 'nada'),
(2, '05240102-N ', 'MANUEL', 'JIMÉNEZ GARCÍA', '2.jpg', 'manuel@gmail.com', 1, 'nada'),
(3, '50035977-Y ', 'LUIS', 'FERNÁNDEZ OLIVA', '3.jpg', 'luis@gmail.com', 1, 'nada'),
(4, '50717522-S ', 'PILAR ', 'ALBERT GARCÍA', '4.jpg', 'pilar@gmail.com', 1, 'nada'),
(5, '50303441-A', 'TOMÁS ', 'ALCUDIA MONTES', '5.jpg', 'tomas@gmail.com', 1, 'nada'),
(6, '50675608-F', 'CARMEN', 'MAQUEDANO GARRIDO', '6.jpg', 'carmen@gmail.com', 1, 'nada'),
(7, '50851663-C ', 'ROSARIO', 'MIRANZO HUERTA', '7.jpg', 'rosario@gmail.com', 1, 'nada'),
(8, '51907931-J ', 'MILAGROS', 'MONTES PÉREZ', '8.jpg', 'milagros@gmail.com', 1, 'nada'),
(9, '11909049-V', 'MIGUEL', 'RÍOS SÁNZ', '9.jpg', 'miguel@gmail.com', 1, 'nada'),
(10, '12360532-X', 'FRANCISCO', 'CABALLERO TALAVERA', '10.jpg', 'francisco@gmail.com', 1, 'nada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotosani`
--

CREATE TABLE `fotosani` (
  `idfoto` int(11) NOT NULL,
  `NumHistorial` int(50) NOT NULL,
  `nombreFoto` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `fotosani`
--

INSERT INTO `fotosani` (`idfoto`, `NumHistorial`, `nombreFoto`) VALUES
(1, 1, 'africa1.jpg'),
(2, 1, 'africa2.jpg'),
(3, 1, 'africa3.jpg'),
(4, 14, 'loco1.jpg'),
(5, 14, 'loco2.jpg'),
(6, 15, 'flaco2.jpg'),
(7, 15, 'flaco1.jpg'),
(8, 28, 'pepa1.jpg'),
(9, 22, 'bicho1.jpg'),
(10, 16, 'blas1.jpg'),
(11, 11, 'bolita1.jpg'),
(12, 3, 'coronel1.jpg'),
(13, 13, 'granadina1.jpg'),
(14, 7, 'grennas1.jpg'),
(15, 17, 'homer1.jpg'),
(16, 12, 'jazz1.jpg'),
(17, 24, 'kara1.jpg'),
(18, 27, 'lola1.jpg'),
(19, 4, 'lluvia1.jpg'),
(20, 5, 'manchado1.jpg'),
(21, 26, 'miel1.jpg'),
(22, 18, 'peleon1.jpg'),
(23, 19, 'rubio1.jpg'),
(24, 20, 'tequila1.jpg'),
(25, 2, 'samba1.jpg'),
(26, 6, 'tod1.jpg'),
(27, 8, 'selva1.jpg'),
(28, 9, 'tranquilo1.jpg'),
(29, 10, 'brandy1.jpg'),
(30, 21, 'sirio1.jpg'),
(31, 23, 'bruno1.jpg'),
(32, 26, 'miel2.jgp'),
(33, 25, 'tormenta1.jpg'),
(34, 25, 'tormenta2.jpg'),
(35, 19, 'rubio1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervalos`
--

CREATE TABLE `intervalos` (
  `idIntervalo` int(11) NOT NULL,
  `texto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `intervalos`
--

INSERT INTO `intervalos` (`idIntervalo`, `texto`) VALUES
(1, '10:00 - 10:30'),
(2, '10:30 - 11:00'),
(3, '11:00 - 11:30'),
(4, '11:30 - 12:00'),
(5, '12:00 - 12:30'),
(6, '13:00 - 13:30'),
(7, '13:30 - 14:00'),
(8, '16:00 - 16:30'),
(9, '17:00 - 17:30'),
(10, '17:30 - 18:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoanimal`
--

CREATE TABLE `tipoanimal` (
  `idTipo` int(11) NOT NULL,
  `NombreTipo` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tipoanimal`
--

INSERT INTO `tipoanimal` (`idTipo`, `NombreTipo`) VALUES
(1, 'Perro'),
(2, 'Gato'),
(3, 'Caballo'),
(4, 'Conejo'),
(5, 'Pájaro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `validar`
--

CREATE TABLE `validar` (
  `idcliente` int(11) NOT NULL,
  `clave` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `alias` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `validar`
--

INSERT INTO `validar` (`idcliente`, `clave`, `alias`) VALUES
(1, '$2y$10$sOaXP.tCjNLA2h0RGwxTDeoLclq.la4h/dASLhH.B.pjjqCb9vIPm', 'uno'),
(2, '$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu', 'dos'),
(3, '$2y$10$MZGP/jqD/qrRirIw0bWG8OdUcXPTbcVbQa4vC7r8bFkE7NR6RrLWK', 'tres'),
(4, '$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu', 'cuatro'),
(5, '$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu', 'cinco'),
(6, '$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu', 'seis'),
(7, '$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu', 'siete'),
(8, '$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu', 'ocho'),
(9, '$2y$10$FfPT4XkJRwc5qDRYeiJUduUEzd74fmxtPAi68V16PUP0VsIdMhWm2', 'nueve'),
(10, '$2y$10$7s94vYzxYDI1Qk8TPbCGvOK8jbqCA6H4pB4TJLRgBVEj6YsDvVkNC', 'diez');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `animales`
--
ALTER TABLE `animales`
  ADD PRIMARY KEY (`NumHistorial`),
  ADD KEY `idTipo` (`idTipo`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`idIntervalo`,`fecha`) USING BTREE,
  ADD KEY `numHistorial` (`NumHistorial`),
  ADD KEY `idIntervalo` (`idIntervalo`),
  ADD KEY `numHistorial_2` (`NumHistorial`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `fotosani`
--
ALTER TABLE `fotosani`
  ADD PRIMARY KEY (`idfoto`),
  ADD KEY `numhistorial` (`NumHistorial`);

--
-- Indices de la tabla `intervalos`
--
ALTER TABLE `intervalos`
  ADD PRIMARY KEY (`idIntervalo`);

--
-- Indices de la tabla `tipoanimal`
--
ALTER TABLE `tipoanimal`
  ADD PRIMARY KEY (`idTipo`),
  ADD KEY `idTipo` (`idTipo`);

--
-- Indices de la tabla `validar`
--
ALTER TABLE `validar`
  ADD PRIMARY KEY (`idcliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `animales`
--
ALTER TABLE `animales`
  MODIFY `NumHistorial` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `fotosani`
--
ALTER TABLE `fotosani`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `intervalos`
--
ALTER TABLE `intervalos`
  MODIFY `idIntervalo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipoanimal`
--
ALTER TABLE `tipoanimal`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animales`
--
ALTER TABLE `animales`
  ADD CONSTRAINT `animales_ibfk_1` FOREIGN KEY (`idTipo`) REFERENCES `tipoanimal` (`idTipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `animales_ibfk_2` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`idIntervalo`) REFERENCES `intervalos` (`idIntervalo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`NumHistorial`) REFERENCES `animales` (`NumHistorial`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fotosani`
--
ALTER TABLE `fotosani`
  ADD CONSTRAINT `fotosAnimales_ibfk_1` FOREIGN KEY (`NumHistorial`) REFERENCES `animales` (`NumHistorial`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `validar`
--
ALTER TABLE `validar`
  ADD CONSTRAINT `validar_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
