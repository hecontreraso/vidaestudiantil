-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-06-2015 a las 00:16:39
-- Versión del servidor: 5.5.44-MariaDB
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
-- Estructura de tabla para la tabla `pais (reserva)`
--

CREATE TABLE IF NOT EXISTS `pais (reserva)` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Volcado de datos para la tabla `pais (reserva)`
--

INSERT INTO `pais (reserva)` (`id`, `nombre`) VALUES
(1, 'Argentina'),
(2, 'Bolivia'),
(3, 'Brasil'),
(4, 'Chile'),
(5, 'Colombia'),
(6, 'Costa Rica'),
(7, 'Cuba'),
(8, 'Ecuador'),
(9, 'El Salvador'),
(10, 'Guayana Francesa'),
(11, 'Grenada'),
(12, 'Guatemala'),
(13, 'Guayana'),
(14, 'Haití'),
(15, 'Honduras'),
(16, 'Jamaica'),
(18, 'Nicaragua'),
(19, 'Paraguay'),
(20, 'Panamá'),
(21, 'Perú'),
(22, 'Puerto Rico'),
(23, 'República Dominicana'),
(24, 'Surinam'),
(25, 'Uruguay'),
(26, 'Venezuela'),
(27, 'Antigua y Barbuda'),
(28, 'Belice'),
(29, 'Bahamas'),
(30, 'Barbados'),
(31, 'Dominica'),
(32, 'St. Kitts and Nevis '),
(33, 'St. Lucia '),
(34, 'St. Vicente y Granadines '),
(35, 'Trinidad y Tobago '),
(36, 'Aruba'),
(37, 'Guadalupe'),
(38, 'Islas Caimán'),
(39, 'Islas Turcas y Caicos'),
(40, 'Islas Vírgenes'),
(41, 'Martinica'),
(42, 'San Bartolomé'),
(43, 'San Cristóbal y Nieves'),
(44, 'México'),
(45, 'Estados Unidos'),
(46, 'Otro país no de LAC');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
