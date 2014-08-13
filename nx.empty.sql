-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2013 a las 18:43:10
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `nexcon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE DATABASE IF NOT EXISTS `nexcon`;

USE `nexcon`;

CREATE TABLE IF NOT EXISTS `clients` (
  `id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients_groups`
--

CREATE TABLE IF NOT EXISTS `clients_groups` (
  `client` varchar(10) NOT NULL,
  `group` int(11) NOT NULL,
  KEY `client` (`client`,`group`),
  KEY `group` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients_info`
--

CREATE TABLE IF NOT EXISTS `clients_info` (
  `client` varchar(10) NOT NULL,
  `phones` varchar(100) NOT NULL,
  `web` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `cp` varchar(10) NOT NULL,
  KEY `client` (`client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients_users`
--

CREATE TABLE IF NOT EXISTS `clients_users` (
  `client` varchar(10) NOT NULL,
  `user` int(11) NOT NULL,
  KEY `client` (`client`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `document` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user` int(11) NOT NULL,
  `direction` tinyint(1) NOT NULL,
  `version` int(4) NOT NULL,
  KEY `document` (`document`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents_path`
--

CREATE TABLE IF NOT EXISTS `documents_path` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(750) NOT NULL,
  `client` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `path` (`path`),
  KEY `client` (`client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8786 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents_type`
--

CREATE TABLE IF NOT EXISTS `documents_type` (
  `id` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form`
--

CREATE TABLE IF NOT EXISTS `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form_elements`
--

CREATE TABLE IF NOT EXISTS `form_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `form` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form_requests`
--

CREATE TABLE IF NOT EXISTS `form_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `element` int(11) NOT NULL,
  `data` varchar(255) NOT NULL,
  `fuid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form_user`
--

CREATE TABLE IF NOT EXISTS `form_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client` varchar(10) NOT NULL,
  `form` int(11) NOT NULL,
  `limit_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `navigation_log`
--

CREATE TABLE IF NOT EXISTS `navigation_log` (
  `user` int(11) NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `added` datetime NOT NULL,
  `cheked` datetime NOT NULL,
  `sended` datetime NOT NULL,
  `client` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification_type`
--

CREATE TABLE IF NOT EXISTS `notification_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reset_pass`
--

CREATE TABLE IF NOT EXISTS `reset_pass` (
  `user` int(11) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `date` datetime NOT NULL,
  `used` tinyint(1) NOT NULL,
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(16) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `type` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;


INSERT INTO users (
    user,
    pass,
    type
) VALUES(
    'admin',
    '80bb8645778a3f6a20a208f9ce23edf7',
    1
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_info`
--

CREATE TABLE IF NOT EXISTS `users_info` (
  `user` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clients_groups`
--
ALTER TABLE `clients_groups`
  ADD CONSTRAINT `clients_groups_ibfk_2` FOREIGN KEY (`group`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `clients_groups_ibfk_3` FOREIGN KEY (`client`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `clients_info`
--
ALTER TABLE `clients_info`
  ADD CONSTRAINT `clients_info_ibfk_1` FOREIGN KEY (`client`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `clients_users`
--
ALTER TABLE `clients_users`
  ADD CONSTRAINT `clients_users_ibfk_3` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `clients_users_ibfk_4` FOREIGN KEY (`client`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`document`) REFERENCES `documents_path` (`id`);

--
-- Filtros para la tabla `documents_path`
--
ALTER TABLE `documents_path`
  ADD CONSTRAINT `documents_path_ibfk_1` FOREIGN KEY (`client`) REFERENCES `clients` (`id`);

--
-- Filtros para la tabla `navigation_log`
--
ALTER TABLE `navigation_log`
  ADD CONSTRAINT `navigation_log_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reset_pass`
--
ALTER TABLE `reset_pass`
  ADD CONSTRAINT `reset_pass_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users_info`
--
ALTER TABLE `users_info`
  ADD CONSTRAINT `users_info_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
