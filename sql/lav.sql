-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2025 a las 23:37:36
-- Versión del servidor: 10.6.15-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lav`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_administrativos`
--

CREATE TABLE `permisos_administrativos` (
  `id` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `cargo_funcion` varchar(100) NOT NULL,
  `run` varchar(20) NOT NULL,
  `anios_servicio` int(11) NOT NULL,
  `fecha_desde` date NOT NULL,
  `fecha_hasta` date NOT NULL,
  `numero_dias` int(11) NOT NULL,
  `motivo` text NOT NULL,
  `dias_ocupados` int(11) NOT NULL,
  `dias_restantes` int(11) NOT NULL,
  `firma_encargado` varchar(100) NOT NULL,
  `fecha_autorizacion` date NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado` enum('pendiente','aceptado','rechazado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos_administrativos`
--

INSERT INTO `permisos_administrativos` (`id`, `fecha_solicitud`, `nombre_completo`, `cargo_funcion`, `run`, `anios_servicio`, `fecha_desde`, `fecha_hasta`, `numero_dias`, `motivo`, `dias_ocupados`, `dias_restantes`, `firma_encargado`, `fecha_autorizacion`, `id_usuario`, `estado`) VALUES
(6, '2025-05-12', 'oooooooqqqq', 'vvvvv', '888777', 3, '2025-05-14', '2025-05-19', 2, 'otro', 2, 3, 'iopp', '2025-05-14', NULL, 'aceptado'),
(9, '2025-05-13', 'ya', 'profe', '73728', 2, '2025-05-16', '2025-05-20', 2, 'owppw', 2, 3, 'aiiee', '2025-05-13', NULL, 'aceptado'),
(10, '2025-05-13', 'wwww', 'cl', '32211111', 4, '2025-05-14', '2025-05-16', 2, '0', 2, 3, 'profe', '2025-05-13', NULL, 'aceptado'),
(11, '2025-05-14', 'aiee', 'uru', '83883883', 2, '2025-05-15', '2025-05-16', 1, '0', 1, 4, 'kgkgkkg', '2025-05-13', NULL, 'rechazado'),
(12, '2025-05-29', 'miguel', 'Auxiliar', '21742434-8', 1, '2025-05-30', '2025-05-31', 2, 'permisomedico', 2, 0, '0', '2025-05-20', 11, 'rechazado'),
(13, '2025-06-04', 'miguel', 'Auxiliar', '21742434-8', 2, '2025-06-04', '2025-06-12', 9, 'permisomedico', 9, 0, '0', '2025-06-11', 11, 'rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(100) DEFAULT NULL,
  `rut` varchar(12) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `rol` enum('admin','usuario','asistente','profesor(a)','auxiliar') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `rut`, `contrasena`, `rol`) VALUES
(1, 'Administrador', '11111111-1', '1234', 'admin'),
(2, 'Usuario Normal', '22222222-2', '1234', 'usuario'),
(9, 'carla', '221133', '1234', 'usuario'),
(11, 'miguel', '21742434-8', '1234', 'auxiliar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `permisos_administrativos`
--
ALTER TABLE `permisos_administrativos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permisos_administrativos`
--
ALTER TABLE `permisos_administrativos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
