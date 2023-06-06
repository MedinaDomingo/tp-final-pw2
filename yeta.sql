-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
<<<<<<< HEAD
-- Tiempo de generación: 06-06-2023 a las 22:23:36
=======
-- Tiempo de generación: 29-05-2023 a las 21:22:52
>>>>>>> d6a49ea08151b0272da06a01b132ee77d02bdfd7
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

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
<<<<<<< HEAD
=======
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `descripcion`) VALUES
(1, 'cliente'),
(2, 'administrador');

-- --------------------------------------------------------

--
>>>>>>> d6a49ea08151b0272da06a01b132ee77d02bdfd7
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
<<<<<<< HEAD
  `id_usuario` int(11) NOT NULL,
  `nombre_u` varchar(30) NOT NULL,
  `cod_verif` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `puntaje` int(11) NOT NULL DEFAULT 0,
  `fecha_nac` date NOT NULL,
  `id_rol` smallint(6) DEFAULT 1,
  `id_resultado` int(11) DEFAULT NULL,
  `id_partida` int(11) DEFAULT NULL,
  `id_nivel` smallint(6) DEFAULT NULL,
  `id_trampa` int(11) DEFAULT NULL,
  `is_active` bit(1) NOT NULL,
  `activation_hash` varchar(32) NOT NULL,
  `apellido` text NOT NULL,
  `foto_perfil` text NOT NULL,
  `pais` text NOT NULL,
  `provincia` text NOT NULL,
  `password` text NOT NULL,
  `rol` int(11) NOT NULL DEFAULT 1
=======
  `id` int(11) NOT NULL,
  `cod_verif` int(11) NOT NULL,
  `nombre_u` text NOT NULL,
  `email` text NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `sexo` text NOT NULL,
  `puntaje` int(11) NOT NULL DEFAULT 0,
  `fecha_nac` date NOT NULL,
  `password` text NOT NULL,
  `foto_perfil` longblob NOT NULL,
  `pais` text NOT NULL,
  `provincia` text NOT NULL,
  `rol` int(11) NOT NULL DEFAULT 1,
  `isActivo` tinyint(1) NOT NULL DEFAULT 0
>>>>>>> d6a49ea08151b0272da06a01b132ee77d02bdfd7
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

<<<<<<< HEAD
INSERT INTO `usuario` (`id_usuario`, `nombre_u`, `cod_verif`, `email`, `nombre`, `sexo`, `puntaje`, `fecha_nac`, `id_rol`, `id_resultado`, `id_partida`, `id_nivel`, `id_trampa`, `is_active`, `activation_hash`, `apellido`, `foto_perfil`, `pais`, `provincia`, `password`, `rol`) VALUES
(5, 'a', 0, 'biez591@gmail.com', 'a', 'Masculino', 0, '2023-05-31', 1, NULL, NULL, NULL, NULL, b'1', '40468', 'a', 'public/2 (1).png', 'argentina', 'Inglaterra', '$2y$10$QM/Z2hnNuq0JaSg1xURsC.iv2Lh1g7PrI7.bKUYJ7YLGhG/RBt8xq', 1),
(6, 'b', 0, 'biez591@gmail.com', 'a', 'Masculino', 12, '2023-05-31', 1, NULL, NULL, NULL, NULL, b'1', '40468', 'a', 'public/2 (1).png', 'argentina', 'Inglaterra', '$2y$10$QM/Z2hnNuq0JaSg1xURsC.iv2Lh1g7PrI7.bKUYJ7YLGhG/RBt8xq', 1),
(7, 'c', 0, 'biez591@gmail.com', 'a', 'Masculino', 0, '2023-05-31', 1, NULL, NULL, NULL, NULL, b'1', '40468', 'a', 'public/2 (1).png', 'argentina', 'Inglaterra', '$2y$10$QM/Z2hnNuq0JaSg1xURsC.iv2Lh1g7PrI7.bKUYJ7YLGhG/RBt8xq', 1);
=======
INSERT INTO `usuario` (`id`, `cod_verif`, `nombre_u`, `email`, `nombre`, `apellido`, `sexo`, `puntaje`, `fecha_nac`, `password`, `foto_perfil`, `pais`, `provincia`, `rol`, `isActivo`) VALUES
(14, 0, 'alf', 'alf@alf.com', 'alf', 'alf', 'Masculino', 0, '2023-05-08', '$2y$10$r0HEwfjYLWCMQGnZTQVvzeaFycVS7acu5y4cCVfbnu56wXx9Nr/wi', 0x4172726179, 'argentina', 'Inglaterra', 1, 1);
>>>>>>> d6a49ea08151b0272da06a01b132ee77d02bdfd7

--
-- Índices para tablas volcadas
--

--
<<<<<<< HEAD
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`,`nombre_u`),
  ADD KEY `FK_usuario_resultado` (`id_resultado`),
  ADD KEY `FK_usuario_nivel` (`id_nivel`),
  ADD KEY `FK_usuario_trampa` (`id_trampa`);
=======
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`);
>>>>>>> d6a49ea08151b0272da06a01b132ee77d02bdfd7

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
<<<<<<< HEAD
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
=======
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
>>>>>>> d6a49ea08151b0272da06a01b132ee77d02bdfd7

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
<<<<<<< HEAD
  ADD CONSTRAINT `FK_usuario_nivel` FOREIGN KEY (`id_nivel`) REFERENCES `nivel` (`id_nivel`);
=======
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`) ON DELETE CASCADE;
>>>>>>> d6a49ea08151b0272da06a01b132ee77d02bdfd7
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
