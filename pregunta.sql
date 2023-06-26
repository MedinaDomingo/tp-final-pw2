-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2023 a las 18:59:26
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
-- Base de datos: `yeta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id_pregunta` int(11) NOT NULL,
  `descripción` varchar(50) NOT NULL,
  `id_categoria` smallint(6) DEFAULT NULL,
  `id_estado` smallint(6) DEFAULT NULL,
  `opcion_a` varchar(32) NOT NULL,
  `opcion_b` varchar(32) NOT NULL,
  `opcion_c` varchar(32) NOT NULL,
  `opcion_d` varchar(32) NOT NULL,
  `opcion_correcta` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id_pregunta`, `descripción`, `id_categoria`, `id_estado`, `opcion_a`, `opcion_b`, `opcion_c`, `opcion_d`, `opcion_correcta`) VALUES
(2, '¿Cuál es el número atómico del oxígeno?', 10, 2, '6', '8', '10', '12', '8'),
(3, '¿Cuál es la fórmula química del agua?', 10, 2, 'H2O', 'CO2', 'NaCl', 'C6H12O6', 'H2O'),
(4, '¿Cuál es la ley de gravitación universal?', 10, 2, 'Ley de Ohm', 'Ley de Newton', 'Ley de Coulomb', 'Ley de Boyle-Mariotte', 'Ley de Boyle-Mariotte'),
(5, '¿En qué deporte se utiliza la expresión \"strike\"?', 6, 2, 'Fútbol americano', 'Golf', 'Béisbol', 'Tenis', 'Béisbol'),
(6, '¿Cuál es el deporte más popular a nivel mundial?', 6, 2, 'Fútbol', 'Baloncesto', 'Críquet', 'Tenis', 'Fútbol'),
(7, '¿Cuál es el río más largo del mundo?', 4, 2, 'Amazonas', 'Nilo', 'Misisipi', 'Yangtsé', 'Nilo'),
(8, '¿Cuál es la capital de Australia?', 4, 2, 'Sídney', 'Melbourne', 'Brisbane', 'Canberra', 'Canberra'),
(9, '¿Cuál es el país más grande del mundo en términos ', 4, 2, 'Rusia', 'China', 'Estados Unidos', 'Canadá', 'Rusia'),
(10, '¿Cuál es el deporte más popular en Estados Unidos?', 6, 2, 'Fútbol', 'Baloncesto', 'Béisbol', 'Hockey', 'Béisbol');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `FK_pregunta_categoria` (`id_categoria`),
  ADD KEY `FK_pregunta_estado` (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `FK_pregunta_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `FK_pregunta_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
