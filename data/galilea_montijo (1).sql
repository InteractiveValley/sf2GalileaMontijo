-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-04-2013 a las 07:36:40
-- Versión del servidor: 5.5.29
-- Versión de PHP: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `galilea_montijo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_galeria`
--

CREATE TABLE IF NOT EXISTS `categorias_galeria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(255) DEFAULT NULL,
  `tipo_categoria` int(11) NOT NULL,
  `posicion` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `categorias_galeria`
--

INSERT INTO `categorias_galeria` (`id`, `categoria`, `tipo_categoria`, `posicion`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'Galeria Oficial 1', 3, 1, 1, '2013-03-10 21:57:34', '2013-03-10 21:57:34'),
(6, 'Tus Fotos 1', 4, 2, 1, '2013-03-10 21:57:34', '2013-03-10 21:57:34'),
(7, 'Lo que estoy viendo 1', 1, 3, 1, '2013-03-10 21:57:34', '2013-03-10 21:57:34'),
(8, 'Decora tu pantalla 1', 2, 4, 1, '2013-03-10 21:57:34', '2013-03-10 21:57:34'),
(9, 'Nueva categoria lo que estoy viendo', 1, 5, 1, '2013-03-18 09:27:13', '2013-03-18 09:27:13'),
(10, 'prueba de categoria Tus fotos', 4, 6, 1, '2013-04-07 13:02:48', '2013-04-07 13:02:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_galeria_votaciones`
--

CREATE TABLE IF NOT EXISTS `categorias_galeria_votaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semana` date DEFAULT NULL,
  `tema` varchar(255) DEFAULT NULL,
  `posicion` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `categorias_galeria_votaciones`
--

INSERT INTO `categorias_galeria_votaciones` (`id`, `semana`, `tema`, `posicion`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2013-03-18', 'Prueba de semana inicial', 1, 1, '2013-03-21 10:00:55', '2013-03-21 23:20:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clubs_fans`
--

CREATE TABLE IF NOT EXISTS `clubs_fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club` varchar(255) DEFAULT NULL,
  `presidente` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `direccion` longtext NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fans`
--

CREATE TABLE IF NOT EXISTS `fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_mostrar_datos` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `fans`
--

INSERT INTO `fans` (`id`, `nombre`, `twitter`, `facebook`, `email`, `is_active`, `created_at`, `updated_at`, `is_mostrar_datos`) VALUES
(1, 'Ricardo Alcantara Gomez', '@richpolis', 'www.facebook.com/richpolis', 'richpolis@gmail.com', 1, '2013-03-11 23:42:07', '2013-03-11 23:42:07', 0),
(3, 'Ricardo Alcantara Gomez', NULL, NULL, 'richpolis@hotmail.com', 1, '2013-04-07 09:52:08', '2013-04-07 09:52:08', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galerias`
--

CREATE TABLE IF NOT EXISTS `galerias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) DEFAULT NULL,
  `fan_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `posicion` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8FF3E45E3397707A` (`categoria_id`),
  KEY `IDX_8FF3E45E89C48F0B` (`fan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `galerias`
--

INSERT INTO `galerias` (`id`, `categoria_id`, `fan_id`, `titulo`, `imagen`, `thumbnail`, `posicion`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 9, 1, 'prueba de imagen', '51558857217b8.jpeg', '51558857217b8.jpeg', 1, 1, '2013-03-29 06:25:59', '2013-04-07 15:56:22'),
(3, 9, 1, 'prueba de imagen2', '515588fc28401.jpeg', '515588fc28401.jpeg', 2, 1, '2013-03-29 06:28:44', '2013-04-07 15:56:23'),
(4, 8, 1, 'Imagen 1', '5158fd35e6bea.jpeg', '5158fd35e6bea.jpeg', 3, 1, '2013-03-31 21:21:25', '2013-03-31 21:21:25'),
(5, 8, 1, 'Imagen 2', '5158fd4eabdbc.jpeg', '5158fd4eabdbc.jpeg', 4, 1, '2013-03-31 21:21:50', '2013-03-31 21:21:50'),
(7, 5, 1, 'Imagen 1', '5159000f76ddb.jpeg', '5159000f76ddb.jpeg', 5, 1, '2013-03-31 21:33:35', '2013-03-31 21:33:35'),
(8, 5, 1, 'Imagen 2', '51590024404d1.jpeg', '51590024404d1.jpeg', 6, 1, '2013-03-31 21:33:56', '2013-03-31 21:33:56'),
(12, 9, 3, NULL, '516189438bd79.jpeg', '516189438bd79.jpeg', 4, 1, '2013-04-07 09:57:07', '2013-04-07 15:56:23'),
(14, 10, 1, 'imagen1', '5161b6855fa07.jpeg', '5161b6855fa07.jpeg', 9, 1, '2013-04-07 13:10:13', '2013-04-07 13:10:13'),
(16, 9, 3, NULL, '5161dbee39112.jpeg', '5161dbee39112.jpeg', 11, 0, '2013-04-07 15:49:50', '2013-04-07 15:49:50'),
(17, 9, 3, NULL, '5161dc4320786.jpeg', '5161dc4320786.jpeg', 12, 0, '2013-04-07 15:51:15', '2013-04-07 15:51:15'),
(18, 9, 3, NULL, '5161dca38ee5c.jpeg', '5161dca38ee5c.jpeg', 13, 0, '2013-04-07 15:52:51', '2013-04-07 15:52:51'),
(19, 9, 3, NULL, '5161dd323c968.jpeg', '5161dd323c968.jpeg', 3, 1, '2013-04-07 15:55:14', '2013-04-07 15:56:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galerias_votaciones`
--

CREATE TABLE IF NOT EXISTS `galerias_votaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semana_id` int(11) DEFAULT NULL,
  `fan_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `posicion` int(11) NOT NULL,
  `votacion` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_26FE1E4CA27DF1D3` (`semana_id`),
  KEY `IDX_26FE1E4C89C48F0B` (`fan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE IF NOT EXISTS `publicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `publicacion` longtext NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `link_video` varchar(255) DEFAULT NULL,
  `posicion` int(11) NOT NULL,
  `tipo_publicacion` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `titulo`, `publicacion`, `imagen`, `link_video`, `posicion`, `tipo_publicacion`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'preuba', '<p>Prueba de publicacion algun contenido para poner</p>', '51526639c78e1.jpeg', NULL, 1, 1, 1, '2013-03-11 00:38:42', '2013-03-27 14:13:04'),
(3, 'otra publicacion', '<p>otra publicacion</p>', '51406c22eed34.jpg', NULL, 3, 0, 1, '2013-03-13 06:08:02', '2013-03-27 14:07:44'),
(4, 'prueba2', '<p>prueba de publicacion</p>', '5152661d37936.jpeg', NULL, 2, 1, 1, '2013-03-13 06:09:19', '2013-03-27 14:13:04'),
(5, 'nueva publicacion', '<p>prueba de publiacion</p>', '514d57cbde215.jpeg', 'http://richpolis.phrenesis.net', 3, 1, 1, '2013-03-23 01:20:43', '2013-03-27 14:13:00'),
(6, 'prueba de publiacion', '<p>prueba de publicacion</p>', '5153b9d00b8e6.jpeg', NULL, 4, 1, 1, '2013-03-27 21:32:32', '2013-03-27 21:32:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicidad`
--

CREATE TABLE IF NOT EXISTS `publicidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `archivo` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `posicion` int(11) NOT NULL,
  `tipo_publicidad` int(11) NOT NULL,
  `actived_at` datetime NOT NULL,
  `inatived_at` datetime NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `publicidad`
--

INSERT INTO `publicidad` (`id`, `archivo`, `thumbnail`, `link`, `posicion`, `tipo_publicidad`, `actived_at`, `inatived_at`, `is_active`, `created_at`, `updated_at`) VALUES
(3, '515913541ad73.swf', NULL, 'http://richpolis.phrenesis.net', 1, 1, '2013-03-27 00:00:00', '2013-03-27 00:00:00', 1, '2013-03-27 21:56:17', '2013-03-31 22:55:48'),
(4, '515917f6957f8.swf', NULL, 'http://richpolis.phrenesis.net', 2, 2, '2013-03-31 00:00:00', '2013-03-31 00:00:00', 1, '2013-03-31 23:15:34', '2013-03-31 23:16:06'),
(5, '51591af941bee.jpeg', NULL, 'http://richpolis.phrenesis.net', 1, 3, '2013-03-31 00:00:00', '2013-04-08 00:00:00', 1, '2013-03-31 23:28:25', '2013-04-07 08:47:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `username`, `salt`, `password`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Ricardo Alcantara Gomez', 'Richpolis', 'f0cab76aa1f3627d6804c1c8ea7e85c5', 'EjuZhVHHMjwUnZqVPLIMgvCXr9unF0Gc8Tx5IAAbpbynSaXDHE8v45/WE8Mu6rpWyTYo4+2ByHe2Rpga7rfy5A==', 'richpolis@gmail.com', 1, '2013-03-10 21:57:34', '2013-03-10 21:57:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video` varchar(255) DEFAULT NULL,
  `posicion` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`id`, `video`, `posicion`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'https://www.youtube.com/watch?v=rRoy6I4gKWU', 1, 1, '2013-03-22 12:48:02', '2013-03-22 12:48:02'),
(2, 'https://www.youtube.com/watch?v=rRoy6I4gKWU', 2, 1, '2013-03-28 19:33:17', '2013-03-28 19:33:17');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `galerias`
--
ALTER TABLE `galerias`
  ADD CONSTRAINT `FK_8FF3E45E3397707A` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_galeria` (`id`),
  ADD CONSTRAINT `FK_8FF3E45E89C48F0B` FOREIGN KEY (`fan_id`) REFERENCES `fans` (`id`);

--
-- Filtros para la tabla `galerias_votaciones`
--
ALTER TABLE `galerias_votaciones`
  ADD CONSTRAINT `FK_26FE1E4C89C48F0B` FOREIGN KEY (`fan_id`) REFERENCES `fans` (`id`),
  ADD CONSTRAINT `FK_26FE1E4CA27DF1D3` FOREIGN KEY (`semana_id`) REFERENCES `categorias_galeria_votaciones` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
