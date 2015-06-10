-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-06-2015 a las 12:17:02
-- Versión del servidor: 5.5.43-MariaDB
-- Versión de PHP: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `slm2015_inscripciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `inscripciones`
--
CREATE TABLE IF NOT EXISTS `inscripciones` (
`pasaporte` varchar(20)
,`nombre` varchar(30)
,`apellido` varchar(30)
,`pais` varchar(45)
,`horario` tinyint(4)
,`Taller` smallint(5) unsigned
,`nombreTaller` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
  `id` smallint(6) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais (reserva)`
--

CREATE TABLE IF NOT EXISTS `pais (reserva)` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `pasaporte` varchar(20) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `apellido` varchar(30) DEFAULT NULL,
  `paisId` smallint(5) unsigned NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pasaporte`),
  KEY `fk_persona_pais1_idx` (`paisId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taller`
--

CREATE TABLE IF NOT EXISTS `taller` (
  `tallerId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tallerista` varchar(200) NOT NULL,
  `ubicacion` varchar(150) NOT NULL,
  `capacidad` int(11) NOT NULL,
  PRIMARY KEY (`tallerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `talleresform`
--
CREATE TABLE IF NOT EXISTS `talleresform` (
`tallerhorario_id` smallint(5) unsigned
,`tallerId` smallint(5) unsigned
,`nombre` varchar(255)
,`descripcion` varchar(1000)
,`disponibles` bigint(22)
,`horario` tinyint(4)
,`idioma` enum('es','en','pt')
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleresinscritos`
--

CREATE TABLE IF NOT EXISTS `talleresinscritos` (
  `pasaporte` varchar(20) NOT NULL,
  `tallerhorario_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`pasaporte`,`tallerhorario_id`),
  KEY `fk_persona_has_tallerhorario_tallerhorario1_idx` (`tallerhorario_id`),
  KEY `fk_persona_has_tallerhorario_persona1_idx` (`pasaporte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `tallereslista`
--
CREATE TABLE IF NOT EXISTS `tallereslista` (
`tallerId` smallint(5) unsigned
,`nombre` varchar(255)
,`descripcion` varchar(1000)
,`capacidad` int(11)
,`ubicacion` varchar(150)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallerhorario`
--

CREATE TABLE IF NOT EXISTS `tallerhorario` (
  `tallerhorario_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tallerId` smallint(5) unsigned NOT NULL,
  `horario` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`tallerhorario_id`),
  KEY `fk_tallerhorario_taller1_idx` (`tallerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taller_nombre`
--

CREATE TABLE IF NOT EXISTS `taller_nombre` (
  `taller_nombre_id` int(11) NOT NULL AUTO_INCREMENT,
  `tallerId` smallint(5) unsigned NOT NULL,
  `idioma` enum('es','en','pt') DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`taller_nombre_id`),
  KEY `fk_taller_nombre_taller1_idx` (`tallerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `inscripciones`
--
DROP TABLE IF EXISTS `inscripciones`;

CREATE ALGORITHM=UNDEFINED DEFINER=`slm2015`@`localhost` SQL SECURITY DEFINER VIEW `inscripciones` AS select `ti`.`pasaporte` AS `pasaporte`,`p`.`nombre` AS `nombre`,`p`.`apellido` AS `apellido`,`pa`.`nombre` AS `pais`,`th`.`horario` AS `horario`,`tn`.`tallerId` AS `Taller`,`tn`.`nombre` AS `nombreTaller` from ((((`talleresinscritos` `ti` join `tallerhorario` `th` on((`ti`.`tallerhorario_id` = `th`.`tallerhorario_id`))) join `taller_nombre` `tn` on((`tn`.`tallerId` = `th`.`tallerId`))) join `persona` `p` on((`ti`.`pasaporte` = `p`.`pasaporte`))) join `pais` `pa` on((`p`.`paisId` = `pa`.`id`))) where (`tn`.`idioma` = 'es');

-- --------------------------------------------------------

--
-- Estructura para la vista `talleresform`
--
DROP TABLE IF EXISTS `talleresform`;

CREATE ALGORITHM=UNDEFINED DEFINER=`slm2015`@`localhost` SQL SECURITY DEFINER VIEW `talleresform` AS select `th`.`tallerhorario_id` AS `tallerhorario_id`,`t`.`tallerId` AS `tallerId`,`tn`.`nombre` AS `nombre`,`tn`.`descripcion` AS `descripcion`,(`t`.`capacidad` - (select count(0) from `talleresinscritos` `ti` where (`ti`.`tallerhorario_id` = `th`.`tallerhorario_id`))) AS `disponibles`,`th`.`horario` AS `horario`,`tn`.`idioma` AS `idioma` from ((`taller` `t` join `tallerhorario` `th` on((`t`.`tallerId` = `th`.`tallerId`))) join `taller_nombre` `tn` on((`t`.`tallerId` = `tn`.`tallerId`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `tallereslista`
--
DROP TABLE IF EXISTS `tallereslista`;

CREATE ALGORITHM=UNDEFINED DEFINER=`slm2015`@`localhost` SQL SECURITY DEFINER VIEW `tallereslista` AS select `t`.`tallerId` AS `tallerId`,`tn`.`nombre` AS `nombre`,`tn`.`descripcion` AS `descripcion`,`t`.`capacidad` AS `capacidad`,`t`.`ubicacion` AS `ubicacion` from (`taller` `t` join `taller_nombre` `tn` on((`t`.`tallerId` = `tn`.`tallerId`)));

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_persona_pais1` FOREIGN KEY (`paisId`) REFERENCES `pais (reserva)` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `talleresinscritos`
--
ALTER TABLE `talleresinscritos`
  ADD CONSTRAINT `fk_persona_has_tallerhorario_persona1` FOREIGN KEY (`pasaporte`) REFERENCES `persona` (`pasaporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_persona_has_tallerhorario_tallerhorario1` FOREIGN KEY (`tallerhorario_id`) REFERENCES `tallerhorario` (`tallerhorario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tallerhorario`
--
ALTER TABLE `tallerhorario`
  ADD CONSTRAINT `fk_tallerhorario_taller1` FOREIGN KEY (`tallerId`) REFERENCES `taller` (`tallerId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `taller_nombre`
--
ALTER TABLE `taller_nombre`
  ADD CONSTRAINT `fk_taller_nombre_taller1` FOREIGN KEY (`tallerId`) REFERENCES `taller` (`tallerId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
