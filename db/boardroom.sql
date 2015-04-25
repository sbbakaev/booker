-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 26 2015 г., 00:18
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
  `recurrent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=88 ;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`id`, `user_id`, `description`, `room_id`, `date_start`, `date_end`, `date_create_event`, `recurrent_id`) VALUES
(58, 1, '    ц', 1, '2015-04-09 08:05:00', '2015-04-09 08:05:00', '2015-04-25 19:52:22', 58),
(65, 1, '    uygf', 3, '2015-04-10 07:04:00', '2015-04-10 08:04:00', '2015-04-09 21:04:56', 65),
(66, 1, '    dfgh', 3, '2015-04-12 01:08:00', '2015-04-12 02:08:00', '2015-04-09 21:09:03', 66),
(67, 1, '    dfgh', 1, '2015-04-14 01:11:00', '2015-04-14 02:11:00', '2015-04-09 21:11:21', 67),
(68, 1, '    ', 3, '2015-04-16 03:12:00', '2015-04-16 06:12:00', '2015-04-09 21:13:01', 68),
(69, 1, '    sfg', 1, '2015-04-10 10:13:00', '2015-04-10 10:13:00', '2015-04-09 21:18:57', 69),
(70, 1, '    dfghjk', 3, '2015-04-17 01:19:00', '2015-04-17 01:20:00', '2015-04-09 21:19:24', 70),
(71, 1, '    ', 1, '2015-04-20 01:22:00', '2015-04-20 10:22:00', '2015-04-09 21:23:16', 71),
(73, 1, '    ', 3, '2015-04-10 16:23:00', '2015-04-10 05:23:00', '2015-04-09 21:25:51', 73),
(74, 1, '    ', 1, '2015-04-12 17:25:00', '2015-04-12 18:25:00', '2015-04-09 21:26:10', 74),
(76, 1, '    12', 3, '2015-04-17 13:27:00', '2015-04-17 13:27:00', '2015-04-09 21:27:18', 76),
(77, 1, '    12', 3, '2015-04-24 13:27:00', '2015-04-24 13:27:00', '2015-04-09 21:27:18', 76),
(78, 1, '    12', 3, '2015-05-01 13:27:00', '2015-05-01 13:27:00', '2015-04-09 21:27:19', 76),
(79, 1, '    12', 3, '2015-05-08 13:27:00', '2015-05-08 13:27:00', '2015-04-09 21:27:19', 76),
(80, 1, '    rftgyhj', 2, '2015-04-10 02:39:00', '2015-04-10 02:39:00', '2015-04-09 23:39:14', 80),
(81, 1, '    rftgyhj', 2, '2015-04-17 02:39:00', '2015-04-17 02:39:00', '2015-04-09 23:39:14', 80),
(82, 1, '    qwerty', 2, '2015-04-11 02:39:00', '2015-04-11 02:39:00', '2015-04-09 23:39:28', 82),
(83, 1, '    qwerty', 2, '2015-04-25 02:39:00', '2015-04-25 02:39:00', '2015-04-09 23:39:28', 82),
(84, 1, '    qwerty', 2, '2015-05-09 02:39:00', '2015-05-09 02:39:00', '2015-04-09 23:39:28', 82),
(85, 1, '    qwerty', 2, '2015-05-23 02:39:00', '2015-05-23 02:39:00', '2015-04-09 23:39:28', 82),
(86, 1, '    rtryrtyrt', 1, '2015-04-25 21:36:00', '2015-04-25 21:36:00', '2015-04-25 18:37:12', 86),
(87, 1, '    hfjgkgkjjkjk', 1, '2015-04-25 21:37:00', '2015-04-25 22:37:00', '2015-04-25 18:37:33', 87);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=56 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `password`, `username`, `mail`) VALUES
(1, 'Sergey1', 'admin', '056eafe7cf52220de2df36845b8ed170c67e23e3', 'admin', 'admin@mail.ru'),
(2, 'Sergey1', 'Bakaev1', '', '', 'sbbakaev@mail.ru'),
(52, 'Nastya', 'djhd', '056eafe7cf52220de2df36845b8ed170c67e23e3', 'sah`', 'ss@mail.ru'),
(53, 'test', 'test', '056eafe7cf52220de2df36845b8ed170c67e23e3', 'testov', 't@test.ru'),
(55, '<script>alert(a', '123', '1e3897d693aaaeb6574337d1e795a3313862e6f8', '234', '234');

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
  PRIMARY KEY (`id`,`idUser`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='This table keep settings of the user.' AUTO_INCREMENT=56 ;

--
-- Дамп данных таблицы `userPreference`
--

INSERT INTO `userPreference` (`id`, `timeFormat24`, `firstDayWeek`, `isAdmin`, `idUser`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 1, 2),
(52, 1, 1, 1, 52),
(53, 1, 0, 0, 53),
(55, 0, 0, 0, 55);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `userPreference`
--
ALTER TABLE `userPreference`
  ADD CONSTRAINT `userpreference_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
