-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2023 a las 22:45:25
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
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` smallint(6) NOT NULL,
  `descripción` varchar(30) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `descripción`, `id_estado`) VALUES
(4, 'Geografia', 2),
(6, 'Deporte', 2),
(10, 'Ciencia', 2),
(11, 'Entretenimiento', 2),
(12, 'Patata', 3),
(13, 'sss', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `descripción` varchar(30) NOT NULL,
  `id_pais` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` smallint(6) NOT NULL,
  `descripción` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `descripción`) VALUES
(1, 'en_revision'),
(2, 'aprobada'),
(3, 'pendiente_aprobacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

CREATE TABLE `nivel` (
  `id_nivel` smallint(6) NOT NULL,
  `descripción` varchar(30) NOT NULL,
  `puntaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`id_nivel`, `descripción`, `puntaje`) VALUES
(1, 'Noob', 10),
(2, 'Medium', 30),
(3, 'Pro', 660);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id_pais` smallint(6) NOT NULL,
  `descripción` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id_partida` int(11) NOT NULL,
  `id_user1` int(11) NOT NULL,
  `id_user2` int(11) DEFAULT NULL,
  `result_user1` int(11) NOT NULL,
  `result_user2` int(11) NOT NULL,
  `result_final` int(11) NOT NULL,
  `fecha_registro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`id_partida`, `id_user1`, `id_user2`, `result_user1`, `result_user2`, `result_final`, `fecha_registro`) VALUES
(0, 14, NULL, 12, 0, 12, '2023-05-29'),
(1, 14, NULL, 12, 0, 12, '2023-06-29'),
(43, 7, NULL, 12, 0, 12, '2023-06-29'),
(44, 14, NULL, 12, 0, 12, '2023-01-02'),
(45, 9, NULL, 12, 0, 12, '2023-03-29'),
(46, 9, NULL, 12, 0, 12, '2023-03-29'),
(47, 9, NULL, 12, 0, 12, '2023-05-01'),
(48, 14, NULL, 12, 0, 12, '2023-04-09'),
(49, 14, NULL, 12, 0, 12, '2023-04-02'),
(50, 14, NULL, 12, 0, 12, '2023-06-29'),
(51, 7, NULL, 12, 0, 12, '2023-05-09'),
(52, 14, NULL, 12, 0, 12, '2023-05-09'),
(53, 9, NULL, 12, 0, 12, '2023-06-29'),
(54, 9, NULL, 12, 0, 12, '2023-06-02'),
(55, 9, NULL, 12, 0, 12, '2023-06-09'),
(56, 14, NULL, 12, 0, 12, '2023-06-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id_pregunta` int(11) NOT NULL,
  `descripción` varchar(50) NOT NULL,
  `id_categoria` smallint(6) DEFAULT NULL,
  `id_estado` smallint(6) DEFAULT 3,
  `opcion_a` varchar(32) NOT NULL,
  `opcion_b` varchar(32) NOT NULL,
  `opcion_c` varchar(32) NOT NULL,
  `opcion_d` varchar(32) NOT NULL,
  `opcion_correcta` varchar(32) NOT NULL,
  `reportes` int(11) NOT NULL DEFAULT 0,
  `dificultad` int(11) NOT NULL DEFAULT 1,
  `fecha_registro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id_pregunta`, `descripción`, `id_categoria`, `id_estado`, `opcion_a`, `opcion_b`, `opcion_c`, `opcion_d`, `opcion_correcta`, `reportes`, `dificultad`, `fecha_registro`) VALUES
(2, '¿Cuál es el número atómico del oxígeno?', 10, 1, '6', '8', '10', '12', '8', 21, 1, '2023-06-26'),
(3, '¿Cuál es la fórmula química del agua?', 10, 1, 'H2O', 'CO2', 'NaCl', 'C6H12O6', 'H2O', 21, 1, '2023-06-26'),
(4, '¿Cuál es la ley de gravitación universal?', 10, 2, 'Ley de Boyle-Mariotte', 'Ley de Newton', 'Ley de Coulomb', 'Ley de Boyle-Mariotte', 'Ley de Boyle-Mariotte', 0, 3, '2023-06-26'),
(5, '¿En qué deporte se utiliza la expresión \"strike\"?', 6, 2, 'Fútbol americano', 'Golf', 'Béisbol', 'Tenis', 'Béisbol', 0, 2, '2023-06-26'),
(6, '¿Cuál es el deporte más popular a nivel mundial?', 6, 1, 'Fútbol', 'Baloncesto', 'Críquet', 'Tenis', 'Fútbol', 18, 1, '2023-06-26'),
(7, '¿Cuál es el río más largo del mundo?', 4, 2, 'Amazonas', 'Nilo', 'Misisipi', 'Yangtsé', 'Nilo', 0, 2, '2023-06-26'),
(8, '¿Cuál es la capital de Australia?', 4, 2, 'Sídney', 'Melbourne', 'Brisbane', 'Canberra', 'Canberra', 0, 3, '2023-06-26'),
(9, '¿Cuál es el país más grande del mundo en términos ', 4, 2, 'Rusia', 'China', 'Estados Unidos', 'Canadá', 'Rusia', 18, 2, '2023-06-26'),
(10, '¿Cuál es el deporte más popular en Estados Unidos?', 6, 1, 'Fútbol', 'Baloncesto', 'Béisbol', 'Hockey', 'Béisbol', 21, 1, '2023-06-26'),
(30, '¿Cuál es el número atómico del oxígeno?', 10, 2, '6', '8', '10', '12', '8', 14, 0, '2023-06-25'),
(32, '¿Cuál es la fórmula química del agua?', 10, 2, 'H2O', 'CO2', 'NaCl', 'C6H12O6', 'H2O', 13, 0, '2023-06-25'),
(33, '¿Cuál es la ley de gravitación universal?', 10, 2, 'Ley de Ohm', 'Ley de Newton', 'Ley de Coulomb', 'Ley de Boyle-Mariotte', 'Ley de Newton', 10, 0, '2023-06-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` smallint(6) NOT NULL,
  `descripción` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `descripción`) VALUES
(1, 'cliente'),
(2, 'editor'),
(3, 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trampa`
--

CREATE TABLE `trampa` (
  `id_trampa` int(11) NOT NULL,
  `descripción` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
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
  `qr` text NOT NULL,
  `rol` int(11) NOT NULL DEFAULT 1,
  `fecha_registro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_u`, `cod_verif`, `email`, `nombre`, `sexo`, `puntaje`, `fecha_nac`, `id_rol`, `id_resultado`, `id_partida`, `id_nivel`, `id_trampa`, `is_active`, `activation_hash`, `apellido`, `foto_perfil`, `pais`, `provincia`, `password`, `qr`, `rol`, `fecha_registro`) VALUES
(5, 'alf', 0, 'alanaumente@gmail.com', 'gordon', 'Femenino', 30, '1950-06-01', 1, NULL, NULL, 1, NULL, b'1', '09050', 'alf', '/public/profilePictures/693633d4e21e801929d731c1608fd5ef (1).png', 'Perú', 'Buenos Aires', '$2y$10$7U8wP2kOhuOyR9oKr9XSJeWEXPbvPXQBFcDNcliBMjVw2WgKDjdB2', 'alf_qr.png', 1, '2023-05-01'),
(6, 'Genti', 0, 'alanaumente@gmail.com', 'Genti', 'Masculino', 837, '2023-06-07', 2, NULL, NULL, 2, NULL, b'1', '21667', 'Genti', '/public/profilePictures/693633d4e21e801929d731c1608fd5ef (1).png', 'Polonia', 'Buenos Aires', '$2y$10$/2wJBZ62jYS5aIrumi9ll.tqC/A1pWYQ5OJStuYdwOgnPK.IlG/M6', 'Genti_qr.png', 1, '2023-06-24'),
(7, 'Charmander', 0, 'asd@asd.com', 'Charmander', 'Masculino', 1300, '1997-11-13', 1, NULL, NULL, 1, NULL, b'0', '90751', 'Char Char', '/public/profilePictures/pokemon-6895600_1280.webp', 'Argentina', 'Buenos Aires', '$2y$10$O8Eps7sPuekP4Lt2ux5eZ.8yq/1tOvtY/c5AJxs7hiLlUCSbVedjm', 'Charmander_qr.png', 1, '2023-06-24'),
(8, 'Bulbasaur', 0, 'asd@asd.com', 'Bulbasaur', 'Masculino', 900, '1998-12-03', 1, NULL, NULL, 3, NULL, b'0', '07041', 'Bulbasaur', '/public/profilePictures/images.png', 'Argentina', 'Buenos Aires', '$2y$10$SKuvpQz0ni.4HvuXTE5AWuzQwB4Drez26yARgmfqyaYUc.RKF6CoK', 'Bulbasaur_qr.png', 1, '2023-06-24'),
(9, 'Squirtle', 0, 'asd@asd.com', 'Squirtle', 'Masculino', 1500, '1999-11-11', 1, NULL, NULL, 1, NULL, b'0', '91680', 'Squirtle', '/public/profilePictures/afb9abe634d79fc11a43f909164006e8.jpg', 'Argentina', 'Buenos Aires', '$2y$10$.YaNnE9E7B6m3RUZckg7vOVPoX0xvrgyBt63EsqCHqSkJMXAiBB2u', 'Squirtle_qr.png', 1, '2023-06-24'),
(10, 'DonRamon', 0, 'alanaumente@gmail.com', 'DonRamon', 'Masculino', 837, '2023-06-07', 3, NULL, NULL, 3, NULL, b'1', '21667', 'Genti', '/public/profilePictures/693633d4e21e801929d731c1608fd5ef (1).png', 'Argentina', 'Buenos Aires', '$2y$10$/2wJBZ62jYS5aIrumi9ll.tqC/A1pWYQ5OJStuYdwOgnPK.IlG/M6', 'Genti_qr.png', 1, '2023-06-24'),
(14, 'sampaoli', 0, 'biez591@gmail.com', 'asd', 'Masculino', 0, '2023-05-28', 1, NULL, NULL, 1, NULL, b'1', '57431', 'asd', '/public/profilePictures/2dam.png', 'Alemania', 'Baja Sajonia', '$2y$10$ol986A4D3CaK/Q8s/sE0R.qd564r0rjkl0aMSo9yWuvICg/NlmQCK', 'sampaoli_qr.png', 1, '2023-06-26');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`),
  ADD KEY `FK_ciudad_pais` (`id_pais`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id_partida`),
  ADD KEY `FK_partida_usuario` (`id_user1`),
  ADD KEY `FK_partida_usuario2` (`id_user2`) USING BTREE;

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `FK_pregunta_categoria` (`id_categoria`),
  ADD KEY `FK_pregunta_estado` (`id_estado`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `trampa`
--
ALTER TABLE `trampa`
  ADD PRIMARY KEY (`id_trampa`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`,`nombre_u`),
  ADD KEY `FK_usuario_resultado` (`id_resultado`),
  ADD KEY `FK_usuario_nivel` (`id_nivel`),
  ADD KEY `FK_usuario_trampa` (`id_trampa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id_nivel` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id_pais` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `trampa`
--
ALTER TABLE `trampa`
  MODIFY `id_trampa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `FK_ciudad_pais` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id_pais`);

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `FK_partida_usuario` FOREIGN KEY (`id_user1`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`id_user2`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `FK_pregunta_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `FK_pregunta_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_usuario_nivel` FOREIGN KEY (`id_nivel`) REFERENCES `nivel` (`id_nivel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
