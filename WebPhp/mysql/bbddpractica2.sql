-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-05-2019 a las 18:48:38
-- Versión del servidor: 5.7.24-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bbddpractica2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`idAdmin`) VALUES
(21),
(32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `idAlumno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`idAlumno`) VALUES
(22),
(23),
(28),
(29),
(30),
(31),
(33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_matriculados`
--

CREATE TABLE `alumnos_matriculados` (
  `idAlumno` int(11) NOT NULL,
  `idMatriculados` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `alumnos_matriculados`
--

INSERT INTO `alumnos_matriculados` (`idAlumno`, `idMatriculados`) VALUES
(22, 1),
(23, 1),
(29, 1),
(30, 1),
(22, 2),
(23, 2),
(29, 2),
(30, 2),
(22, 3),
(23, 3),
(29, 3),
(30, 3),
(22, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE `asignatura` (
  `idAsignatura` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idProfesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`idAsignatura`, `nombre`, `idProfesor`) VALUES
(3, 'Aplicaciones Web', 25),
(4, 'Redes', 27),
(5, 'Ingenieria Web', 25),
(6, 'Ampliación de Bases de Datos', 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correccionalumno`
--

CREATE TABLE `correccionalumno` (
  `idCorreccionAlumno` int(11) NOT NULL,
  `idPractica` int(11) NOT NULL,
  `idAlumnoCorrector` int(11) NOT NULL,
  `Comentario` text NOT NULL,
  `Nota` double(4,2) NOT NULL,
  `idEnunciado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `correccionalumno`
--

INSERT INTO `correccionalumno` (`idCorreccionAlumno`, `idPractica`, `idAlumnoCorrector`, `Comentario`, `Nota`, `idEnunciado`) VALUES
(1, 12, 22, '', 0.00, 18),
(2, 11, 30, '', 0.00, 18),
(3, 16, 22, '', 0.00, 19),
(4, 14, 30, '', 0.00, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correccionprofesor`
--

CREATE TABLE `correccionprofesor` (
  `idCorreccionProfesor` int(11) NOT NULL,
  `idPractica` int(11) NOT NULL,
  `idProfesor` int(11) NOT NULL,
  `Comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enunciado`
--

CREATE TABLE `enunciado` (
  `idEnunciado` int(11) NOT NULL,
  `idTema` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `entregaFinalizada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `enunciado`
--

INSERT INTO `enunciado` (`idEnunciado`, `idTema`, `nombre`, `FechaInicio`, `FechaFin`, `entregaFinalizada`) VALUES
(18, 7, 'Primera2', '2019-05-18', '2019-05-18', 1),
(19, 9, 'enun1', '2019-05-03', '2019-05-17', 1),
(21, 14, 'enun1', '2019-05-09', '2019-05-25', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculados`
--

CREATE TABLE `matriculados` (
  `idMatriculados` int(11) NOT NULL,
  `idAsignatura` int(11) NOT NULL,
  `cantidadAlumnos` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `matriculados`
--

INSERT INTO `matriculados` (`idMatriculados`, `idAsignatura`, `cantidadAlumnos`) VALUES
(1, 3, 0),
(2, 4, 0),
(3, 5, 0),
(6, 6, 0),
(7, 6, 0),
(8, 6, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `practicas`
--

CREATE TABLE `practicas` (
  `idPractica` int(11) NOT NULL,
  `idTema` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `idAlumno` int(11) NOT NULL,
  `idEnunciado` int(11) NOT NULL,
  `Nota` double(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `practicas`
--

INSERT INTO `practicas` (`idPractica`, `idTema`, `nombre`, `idAlumno`, `idEnunciado`, `Nota`) VALUES
(11, 7, 'practica.c', 22, 18, 8.50),
(12, 7, 'prueba.c', 30, 18, 8.00),
(14, 9, 'prueba.c', 22, 19, 0.00),
(16, 9, 'practicaGuille.c', 30, 19, 0.00),
(17, 14, 'prueba2.c', 30, 21, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `idProfesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`idProfesor`) VALUES
(24),
(25),
(26),
(27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `idTema` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `idAsignatura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`idTema`, `nombre`, `idAsignatura`) VALUES
(7, 'Tema 1', 3),
(9, 'Tema 1 IW', 5),
(10, 'Tema 2', 3),
(14, 'Tema 4', 3),
(12, 'Tema nuevo', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `nick` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `pwd` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `rol` enum('profesor','alumno','admin') COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `nick`, `pwd`, `rol`, `correo`) VALUES
(21, 'admin', 'admin', '$2y$10$StTdpa2hWcFz1YwSKyJVouzhmnF9UlvtxyeI2VLQ5jiBrOQukkLhu', 'admin', 'admin@ucm.es'),
(22, 'Daniel', 'Daniel', '$2y$10$hWQliNQP4gtgtn6nwxfCFusINDbPLjIRhetdl2tZTZE8Sp01GbIqW', 'alumno', 'daniel@ucm.es'),
(23, 'Mario Sánchez', 'Mario', '$2y$10$CLrk.Kp4bdCIqbzGQNSagejHIoyrL5qxLIasUpO/A9lz7fJz4Jj/2', 'alumno', 'mario@ucm.es'),
(24, 'pruebaProfe', 'pruebaProfe', '$2y$10$772iy/M1bqo/F21rnaArCesGDVkAEg98VNS5mhseraMp33c.6Vz3G', 'profesor', 'pruebaProfe@ucm.es'),
(25, 'Juan Pavon', 'Juan Pavon', '$2y$10$fANAuyQ6S0qAL2lKwlOTkeZVX0uswaP19KlXtZFp3O6TQKQmtDn2a', 'profesor', 'jpavon@ucm.es'),
(26, 'Manuel Freire', 'Manuel', '$2y$10$hpNKxYAwo0PXoEgG8iLNhOxhAXnTujCiOgBbkX.AQ1Dr2dx8T0jke', 'profesor', 'manuelf@ucm.es'),
(27, 'Julio Septien', 'Julio', '$2y$10$fNOdDHDoIdH4aaCCzVgHQu4zeHaycIMlMoJPYcsgMilptj2Sjpib6', 'profesor', 'julioseptien@ucm.es'),
(28, 'Mario', 'marios', '$2y$10$S5h1TCqinpKiPp24OhohjuTf1L3zyFH.K3Vv7mVgrbcCDHUMYDh1u', 'alumno', 'marios@ucm.es'),
(29, 'Gabriel Garcia', 'gabgarar', '$2y$10$LzijZwBjXhn/mt5Y0/mWKu562mdXwz6cyhla9CNGZC1/xTY8J0lBC', 'alumno', 'gabgar04@ucm.es'),
(30, 'Guille', 'Guille', '$2y$10$uA.sHZcz5imFIqS2SE0ht.fCydJEDlBX8FOS9jb19ZB13hb8sk9f2', 'alumno', 'guills@ucm.es'),
(31, 'Francisco', 'francis', '$2y$10$wmNGVGyKPbFZlWOnwWlDUeZlHHYbnC89h0hzo6xOYdTPvcQhTDcii', 'alumno', 'fran@ucm.es'),
(32, 'aespaña', 'aespaña', '$2y$10$VAsFqId8zrCqGci3POZKP.9N8AV7UoW6k1Dy87Z8O6e2OVZPvtS8i', 'admin', 'caraculo@ucm.es'),
(33, 'nuevo', 'nuevo', '$2y$10$TcXL.VIwUJOIoIVK4ZyC3uwadq7krwsaa/3SGfavXX2lbBrWmKGWm', 'alumno', 'nuevo@ucm.es');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`idAlumno`);

--
-- Indices de la tabla `alumnos_matriculados`
--
ALTER TABLE `alumnos_matriculados`
  ADD PRIMARY KEY (`idAlumno`,`idMatriculados`),
  ADD KEY `idMatriculados` (`idMatriculados`);

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`idAsignatura`),
  ADD KEY `idProfesor` (`idProfesor`);

--
-- Indices de la tabla `correccionalumno`
--
ALTER TABLE `correccionalumno`
  ADD PRIMARY KEY (`idCorreccionAlumno`),
  ADD UNIQUE KEY `idPractica` (`idPractica`,`idAlumnoCorrector`),
  ADD KEY `idAlumnoCorrector` (`idAlumnoCorrector`),
  ADD KEY `idEnunciado` (`idEnunciado`);

--
-- Indices de la tabla `correccionprofesor`
--
ALTER TABLE `correccionprofesor`
  ADD PRIMARY KEY (`idCorreccionProfesor`),
  ADD UNIQUE KEY `idPractica` (`idPractica`,`idProfesor`),
  ADD KEY `idProfesor` (`idProfesor`);

--
-- Indices de la tabla `enunciado`
--
ALTER TABLE `enunciado`
  ADD PRIMARY KEY (`idEnunciado`,`nombre`),
  ADD KEY `enunciado_ibfk_1` (`idTema`);

--
-- Indices de la tabla `matriculados`
--
ALTER TABLE `matriculados`
  ADD PRIMARY KEY (`idMatriculados`),
  ADD KEY `idAsignatura` (`idAsignatura`);

--
-- Indices de la tabla `practicas`
--
ALTER TABLE `practicas`
  ADD PRIMARY KEY (`idPractica`),
  ADD KEY `idAlumno` (`idAlumno`),
  ADD KEY `idTema` (`idTema`),
  ADD KEY `idEnunciado` (`idEnunciado`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`idProfesor`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`idTema`),
  ADD UNIQUE KEY `nombre` (`nombre`,`idAsignatura`),
  ADD KEY `idAsignatura` (`idAsignatura`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `nick` (`nick`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `idAsignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `correccionalumno`
--
ALTER TABLE `correccionalumno`
  MODIFY `idCorreccionAlumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `correccionprofesor`
--
ALTER TABLE `correccionprofesor`
  MODIFY `idCorreccionProfesor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enunciado`
--
ALTER TABLE `enunciado`
  MODIFY `idEnunciado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `matriculados`
--
ALTER TABLE `matriculados`
  MODIFY `idMatriculados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `practicas`
--
ALTER TABLE `practicas`
  MODIFY `idPractica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `idTema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idAdmin`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alumnos_matriculados`
--
ALTER TABLE `alumnos_matriculados`
  ADD CONSTRAINT `alumnos_matriculados_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `alumnos` (`idAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnos_matriculados_ibfk_2` FOREIGN KEY (`idMatriculados`) REFERENCES `matriculados` (`idMatriculados`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `asignatura_ibfk_2` FOREIGN KEY (`idProfesor`) REFERENCES `profesor` (`idProfesor`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `correccionalumno`
--
ALTER TABLE `correccionalumno`
  ADD CONSTRAINT `correccionalumno_ibfk_1` FOREIGN KEY (`idPractica`) REFERENCES `practicas` (`idPractica`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `correccionalumno_ibfk_2` FOREIGN KEY (`idAlumnoCorrector`) REFERENCES `alumnos` (`idAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `correccionalumno_ibfk_3` FOREIGN KEY (`idEnunciado`) REFERENCES `enunciado` (`idEnunciado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `correccionprofesor`
--
ALTER TABLE `correccionprofesor`
  ADD CONSTRAINT `correccionprofesor_ibfk_1` FOREIGN KEY (`idPractica`) REFERENCES `practicas` (`idPractica`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `correccionprofesor_ibfk_2` FOREIGN KEY (`idProfesor`) REFERENCES `asignatura` (`idProfesor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `enunciado`
--
ALTER TABLE `enunciado`
  ADD CONSTRAINT `enunciado_ibfk_1` FOREIGN KEY (`idTema`) REFERENCES `tema` (`idTema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `matriculados`
--
ALTER TABLE `matriculados`
  ADD CONSTRAINT `matriculados_ibfk_1` FOREIGN KEY (`idAsignatura`) REFERENCES `asignatura` (`idAsignatura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `practicas`
--
ALTER TABLE `practicas`
  ADD CONSTRAINT `practicas_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `alumnos` (`idAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `practicas_ibfk_2` FOREIGN KEY (`idTema`) REFERENCES `tema` (`idTema`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `practicas_ibfk_3` FOREIGN KEY (`idEnunciado`) REFERENCES `enunciado` (`idEnunciado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `profesor_ibfk_1` FOREIGN KEY (`idProfesor`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `tema_ibfk_1` FOREIGN KEY (`idAsignatura`) REFERENCES `asignatura` (`idAsignatura`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
