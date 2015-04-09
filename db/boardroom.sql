-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 09 2015 г., 23:54
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `boardroom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `date_event`
--

DROP TABLE IF EXISTS `date_event`;
CREATE TABLE IF NOT EXISTS `date_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recurrent_id` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `room_id` int(10) unsigned NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `date_create_event` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `recurrent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=63 ;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`id`, `user_id`, `description`, `room_id`, `date_start`, `date_end`, `date_create_event`, `recurrent_id`) VALUES
(58, 1, '    ', 1, '2015-04-09 08:05:00', '2015-04-09 08:05:00', '2015-04-09 17:05:17', 58);

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `description`) VALUES
(1, 'Boardroom 1', 'Boardroom 1'),
(2, 'Boardroom 2', 'Boardroom 2'),
(3, 'Boardroom 3', 'Boardroom 3');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `surname` text CHARACTER SET utf32 NOT NULL,
  `password` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `mail` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=53 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `password`, `username`, `mail`) VALUES
(1, 'Sergey1', 'admin', '056eafe7cf52220de2df36845b8ed170c67e23e3', 'admin', 'admin@mail.ru'),
(2, 'Sergey1', 'Bakaev1', '', '', 'sbbakaev@mail.ru'),
(52, 'Nastya', 'djhd', '056eafe7cf52220de2df36845b8ed170c67e23e3', 'sah`', 'ss@mail.ru');

-- --------------------------------------------------------

--
-- Структура таблицы `userPreference`
--

DROP TABLE IF EXISTS `userPreference`;
CREATE TABLE IF NOT EXISTS `userPreference` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timeFormat24` tinyint(1) NOT NULL COMMENT 'If true user use 24 time format, ealse 12',
  `firstDayWeek` int(10) unsigned NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'If true user is an administrator',
  `idUser` int(10) unsigned NOT NULL COMMENT 'Field for synchronization with user table',
  PRIMARY KEY (`id`,`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='This table keep settings of the user.' AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `userPreference`
--

INSERT INTO `userPreference` (`id`, `timeFormat24`, `firstDayWeek`, `isAdmin`, `idUser`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 1, 0),
(3, 1, 1, 1, 0),
(8, 0, 0, 0, 8),
(9, 0, 0, 0, 9),
(10, 0, 0, 0, 10),
(11, 0, 0, 0, 11),
(17, 0, 0, 0, 22),
(27, 1, 1, 1, 52);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
