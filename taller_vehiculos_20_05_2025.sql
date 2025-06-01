-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2025 a las 03:06:38
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taller_vehiculos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_completo`, `documento`, `direccion`, `telefono`, `correo`, `fecha_creacion`) VALUES
(1, 'Creando Cliente Número 1', '12345678', 'Cra 1 123', '123123123', 'creandocliente1@email.com', '2025-03-11 13:24:57'),
(2, 'Creando Cliente Número dos', '1234567', 'Cra 12 123', '1111111111', 'creandocliente2@email.com', '2025-04-03 19:30:34'),
(3, 'Creando Cliente Número tres', '123456', 'Cra 12 123', '1111111111', 'creandocliente3@email.com', '2025-04-03 19:33:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_vehiculos`
--

CREATE TABLE `historial_vehiculos` (
  `id_historial` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_trabajo` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuestos_utilizados`
--

CREATE TABLE `repuestos_utilizados` (
  `id_repuesto` int(11) NOT NULL,
  `id_trabajo` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` enum('Administrador','Asesor','Operario') NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `fecha_creacion`) VALUES
(1, 'Administrador', '2025-03-06 19:34:08'),
(2, 'Asesor', '2025-03-06 19:34:08'),
(3, 'Operario', '2025-03-06 19:34:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos`
--

CREATE TABLE `trabajos` (
  `id_trabajo` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_usuario_modifica` int(11) DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `solicitud` text NOT NULL,
  `trabajos_realizados` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `correo_corporativo` varchar(100) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_completo`, `correo_corporativo`, `nombre_usuario`, `contrasena`, `id_rol`, `fecha_creacion`) VALUES
(4, 'Prueba Primer Nombre', 'prueba@email.com', 'prueba_usuario', '123456', 1, '2025-03-06 19:42:05'),
(5, 'Edwin Mejía', 'edwin@prueba.com', 'emejia', '$2y$10$0OdEHozubqjD/w067ZiPAeq7QkJB3RzVYPVbHzAVX9W34.2y9IPfK', 1, '2025-03-06 23:18:45'),
(7, 'Prueba Uno Nombre', 'emejia@prueba.com', 'eamejia', '$2y$10$Hg2nSZSbTXKqHoLV6/RPD.73tidIA6o9/Qk95jGaQQam1A9Eaqt4C', 2, '2025-03-06 23:37:28'),
(8, 'Prueba Segundo Nombre', 'prueba2@email.com', 'prueba2_usuario', '$2y$10$9U03nJzxTNE0HoqaTzdMseeqhXfDVM/CW296GlLjaA8EkdiRFeieK', 2, '2025-03-08 20:49:42'),
(9, 'Usuario Operario', 'usuariooperario@email.com', 'usuariooperario1', '$2y$10$5dhOkGLbgokMSaY4Vi6bsur0IZXEag8X0/m6hbmJoZWQA8mcy0BcC', 3, '2025-03-11 14:57:37'),
(10, 'Prueba Tercer Nombre', 'prueba3@email.com', 'prueba3_usuario', '$2y$10$wN4zHF4293hbbyIktkFWyO35rZBkzUo3Oaj33uwfmTfUo1wCzJCcm', 1, '2025-04-02 00:08:07'),
(11, 'Prueba Cuarto Nombre', 'prueba4@email.com', 'prueba4_usuario', '$2y$10$Z4eLds97tTSsteR47sJa3OQWdpicwXM2r.HI7k0ycIU6G3uVnVvs2', 1, '2025-04-02 01:09:07'),
(12, 'Prueba Quinto Nombre', 'prueba5@email.com', 'prueba5_usuario', '$2y$10$sW8w7qieovHcyVu/Qbe5nOwhbBAMWsPoJWsHRclkNTD.CTaBTW92.', 2, '2025-04-02 01:16:44'),
(13, 'Prueba Sexto Nombre', 'prueba6@email.com', 'prueba6_usuario', '$2y$10$q4PeUW7n7NdKMU10ZyumJeDbOkHZU6z.O.D5sevNGYi5i.MoSM9VG', 1, '2025-04-02 01:46:29'),
(14, 'Prueba Siete Nombre', 'prueba7@email.com', 'prueba7_usuario', '$2y$10$MyKF4hK55lJgP1YkiuGRGuaHwP0oli47xVfUf0JsPvZeDBeepbYBS', 1, '2025-04-02 01:51:50'),
(15, 'Prueba Ocho Nombre', 'prueba8@email.com', 'prueba8_usuario', '$2y$10$bVcti..TVPIkUWJSqqN8le8b.wXKbKnSDqwLqHT6aHRj4gGMnJR.q', 1, '2025-04-02 01:56:38'),
(16, 'Prueba Nueve Nombre', 'prueba9@email.com', 'prueba9_usuario', '$2y$10$zWJaOpJtgpm4j4FRA9klZuCVJbbsRCu.Wl.WqvvzTgRbreToWiUfO', 1, '2025-04-02 02:06:02'),
(17, 'Prueba Diez Nombre', 'prueba10@email.com', 'prueba10_usuario', '$2y$10$0GVxplE7YoEPvxrBsRIpOe9zEcRgYMiRMY9CgqH05eBYEdiGIbu7C', 1, '2025-04-02 02:12:00'),
(18, 'Prueba Doce Nombre', 'prueba12@email.com', 'prueba12_usuario', '$2y$10$pDsJJ/glT8Xj08fB0AAGcePQ0SaFHlkTDY9I9IE.gSBoW0f7KlCsG', 1, '2025-04-02 02:18:07'),
(19, 'Prueba Trece Nombre', 'prueba13@email.com', 'prueba13_usuario', '$2y$10$lo.BKvsg8GynalJVKjtIS.xDUAOyxanBL4J36oo14OqbTuFNsgqxu', 1, '2025-04-02 02:25:53'),
(20, 'Prueba Catorce Nombre', 'prueba14@email.com', 'prueba14_usuario', '$2y$10$t67.yx4SugGtlDuCI4i7auOvrS86cK/.uV/Aowv7qSJsNzmNlZ9IK', 2, '2025-04-03 17:16:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `chasis` varchar(50) NOT NULL,
  `motor` varchar(50) NOT NULL,
  `cilindrada` varchar(20) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `clase` varchar(50) DEFAULT NULL,
  `modelo` varchar(10) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `placa`, `chasis`, `motor`, `cilindrada`, `marca`, `clase`, `modelo`, `id_cliente`, `fecha_creacion`) VALUES
(1, 'ABC123', '1GATHHGGFSSDSDSFFDAA', '123456', '1000', 'Chevrolet', 'Onix Turbo', '2024', 1, '2025-03-11 16:28:35'),
(2, 'ABC321', '1GATHHGGFSSDSDSFFDAB', '1234567', '2400', 'Chevrolet', 'CAPTIVA SPORT', '2011', 1, '2025-04-03 19:49:16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- Indices de la tabla `historial_vehiculos`
--
ALTER TABLE `historial_vehiculos`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_vehiculo` (`id_vehiculo`),
  ADD KEY `id_trabajo` (`id_trabajo`);

--
-- Indices de la tabla `repuestos_utilizados`
--
ALTER TABLE `repuestos_utilizados`
  ADD PRIMARY KEY (`id_repuesto`),
  ADD KEY `id_trabajo` (`id_trabajo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  ADD PRIMARY KEY (`id_trabajo`),
  ADD KEY `id_vehiculo` (`id_vehiculo`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_usuario_modifica` (`id_usuario_modifica`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo_corporativo` (`correo_corporativo`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD UNIQUE KEY `chasis` (`chasis`),
  ADD UNIQUE KEY `motor` (`motor`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historial_vehiculos`
--
ALTER TABLE `historial_vehiculos`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `repuestos_utilizados`
--
ALTER TABLE `repuestos_utilizados`
  MODIFY `id_repuesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  MODIFY `id_trabajo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_vehiculos`
--
ALTER TABLE `historial_vehiculos`
  ADD CONSTRAINT `historial_vehiculos_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`),
  ADD CONSTRAINT `historial_vehiculos_ibfk_2` FOREIGN KEY (`id_trabajo`) REFERENCES `trabajos` (`id_trabajo`);

--
-- Filtros para la tabla `repuestos_utilizados`
--
ALTER TABLE `repuestos_utilizados`
  ADD CONSTRAINT `repuestos_utilizados_ibfk_1` FOREIGN KEY (`id_trabajo`) REFERENCES `trabajos` (`id_trabajo`);

--
-- Filtros para la tabla `trabajos`
--
ALTER TABLE `trabajos`
  ADD CONSTRAINT `trabajos_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`),
  ADD CONSTRAINT `trabajos_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `trabajos_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `trabajos_ibfk_4` FOREIGN KEY (`id_usuario_modifica`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
