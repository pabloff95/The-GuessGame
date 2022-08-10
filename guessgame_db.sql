-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-08-2022 a las 07:09:28
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `guess`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user` varchar(20) NOT NULL,
  `passw` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(15) NOT NULL,
  `salt` varchar(8) NOT NULL,
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Disparadores `user`
--
DROP TRIGGER IF EXISTS `Prevent script Insert`;
DELIMITER $$
CREATE TRIGGER `Prevent script Insert` BEFORE INSERT ON `user` FOR EACH ROW BEGIN

IF NEW.user like "%<script>%"
	THEN
    SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "Text not allowed";
END IF;

IF NEW.passw like "%<script>%"
	THEN
    SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "Text not allowed";
END IF;

IF NEW.email like "%<script>%"
	THEN
    SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "Text not allowed";
END IF;

IF NEW.name like "%<script>%"
	THEN
    SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "Text not allowed";
END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Prevent script Update`;
DELIMITER $$
CREATE TRIGGER `Prevent script Update` BEFORE UPDATE ON `user` FOR EACH ROW BEGIN

IF NEW.user like "%<script>%"
	THEN
    SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "Text not allowed";
END IF;

IF NEW.passw like "%<script>%"
	THEN
    SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "Text not allowed";
END IF;

IF NEW.email like "%<script>%"
	THEN
    SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "Text not allowed";
END IF;

IF NEW.name like "%<script>%"
	THEN
    SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = "Text not allowed";
END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Validate input Insert`;
DELIMITER $$
CREATE TRIGGER `Validate input Insert` BEFORE INSERT ON `user` FOR EACH ROW BEGIN

IF NEW.email NOT LIKE "%_@__%.__%"
	THEN
    SIGNAL SQLSTATE '02001' SET MESSAGE_TEXT = "Incorrect data format";
END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Validate input Update`;
DELIMITER $$
CREATE TRIGGER `Validate input Update` BEFORE UPDATE ON `user` FOR EACH ROW BEGIN

IF NEW.email NOT LIKE "%_@__%.__%"
	THEN
    SIGNAL SQLSTATE '02001' SET MESSAGE_TEXT = "Incorrect data format";
END IF;

END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
