-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 27 2015 г., 23:58
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `surname` text CHARACTER SET utf32 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=23 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `surname`) VALUES
(1, 'Sergey1', 'Bakaev1'),
(2, 'Sergey1', 'Bakaev1'),
(3, 'Sergey1', 'Bakaev1'),
(4, 'Sergey1', 'Bakaev1'),
(5, 'Sergey1', 'Bakaev1'),
(6, 'Sergey1', 'Bakaev1'),
(7, '', ''),
(8, '', ''),
(9, '', ''),
(10, '', ''),
(11, '', ''),
(12, '', ''),
(13, '1', '1'),
(14, 'Anastasiya', 'Bakaeva'),
(15, 'test1', 'Bakaeva'),
(20, 'asdfa', 'asfad'),
(21, 'test1', 'Bakaeva'),
(22, '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='This table keep settings of the user.' AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `userPreference`
--

INSERT INTO `userPreference` (`id`, `timeFormat24`, `firstDayWeek`, `isAdmin`, `idUser`) VALUES
(1, 1, 1, 1, 2),
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
(12, 0, 0, 0, 12),
(13, 1, 1, 0, 13),
(14, 1, 1, 0, 14),
(15, 1, 1, 0, 15),
(16, 1, 1, 0, 21),
(17, 0, 0, 0, 22);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
