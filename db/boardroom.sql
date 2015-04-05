-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 05 2015 г., 23:41
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
CREATE DATABASE IF NOT EXISTS `boardroom` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `boardroom`;

-- --------------------------------------------------------

--
-- Структура таблицы `date_event`
--

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

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `room_id` int(10) unsigned NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `date_create_event` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=103 ;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`id`, `user_id`, `description`, `room_id`, `date_start`, `date_end`, `date_create_event`) VALUES
(1, 159, 'test1', 1, '2016-01-01 01:01:00', '2016-01-01 01:01:00', '2015-04-05 18:38:38'),
(91, 21, '0000-00-00 00:00:00', 1, '2014-01-15 02:20:00', '2014-01-15 03:20:00', '2015-04-05 20:14:44'),
(92, 21, '999999999999999            ', 1, '2014-01-15 01:19:00', '2014-01-15 01:20:00', '0000-00-00 00:00:00'),
(93, 21, '999999999999999            ', 1, '2014-01-29 01:19:00', '2014-01-29 01:20:00', '0000-00-00 00:00:00'),
(94, 21, '999999999999999            ', 1, '2014-02-12 01:19:00', '2014-02-12 01:20:00', '0000-00-00 00:00:00'),
(95, 1, '            ', 1, '2014-01-01 01:01:00', '2014-01-01 01:01:00', '0000-00-00 00:00:00'),
(96, 1, '            ', 1, '2014-01-01 03:01:00', '2014-01-01 04:01:00', '0000-00-00 00:00:00'),
(97, 1, '            ', 1, '2014-01-01 07:01:00', '2014-01-01 07:02:00', '0000-00-00 00:00:00'),
(98, 1, '            ', 1, '2014-01-02 01:01:00', '2014-01-02 01:01:00', '0000-00-00 00:00:00'),
(99, 1, 'fg5', 1, '2015-04-01 00:02:00', '2015-04-01 00:00:00', '2015-04-05 15:19:41'),
(102, 1, '          gg  ', 1, '2014-01-01 01:06:00', '2014-01-01 01:10:00', '2015-04-05 20:33:02');

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `description`) VALUES
(1, 'Boadroom 1', 'boadroom 1'),
(2, 'Boadroom 1', 'boadroom 1');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `surname` text CHARACTER SET utf32 NOT NULL,
  `password` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `mail` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=23 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `password`, `username`, `mail`) VALUES
(1, 'Sergey1', 'admin', '056eafe7cf52220de2df36845b8ed170c67e23e3', 'admin', 'admin@mail.ru'),
(2, 'Sergey1', 'Bakaev1', '', '', ''),
(3, 'Sergey1', 'Bakaev1', '', '', ''),
(4, 'Sergey1', 'Bakaev1', '', '', ''),
(5, 'Sergey1', 'Bakaev1', '', '', ''),
(6, 'Sergey1', 'Bakaev1', '', '', ''),
(7, '', '', '', '', ''),
(8, '', '', '', '', ''),
(9, '', '', '', '', ''),
(10, '', '', '', '', ''),
(11, '', '', '', '', ''),
(14, 'Anastasiya', 'Bakaeva', '', '', ''),
(15, 'test1', 'Bakaeva', '', '', ''),
(20, 'asdfa', 'asfad', '', '', ''),
(21, 'test1', 'Bakaeva', '', '', ''),
(22, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `userPreference`
--

CREATE TABLE IF NOT EXISTS `userPreference` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timeFormat24` tinyint(1) NOT NULL COMMENT 'If true user use 24 time format, ealse 12',
  `firstDayWeek` int(10) unsigned NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'If true user is an administrator',
  `idUser` int(10) unsigned NOT NULL COMMENT 'Field for synchronization with user table',
  PRIMARY KEY (`id`,`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='This table keep settings of the user.' AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `userPreference`
--

INSERT INTO `userPreference` (`id`, `timeFormat24`, `firstDayWeek`, `isAdmin`, `idUser`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 1, 0),
(3, 1, 1, 1, 0),
(4, 1, 1, 1, 4),
(5, 1, 1, 1, 5),
(6, 1, 1, 1, 6),
(7, 0, 0, 0, 7),
(8, 0, 0, 0, 8),
(9, 0, 0, 0, 9),
(10, 0, 0, 0, 10),
(11, 0, 0, 0, 11),
(14, 1, 1, 0, 14),
(15, 1, 1, 0, 15),
(16, 1, 1, 0, 21),
(17, 0, 0, 0, 22);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
