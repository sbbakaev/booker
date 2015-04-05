-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 05 2015 г., 23:35
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
