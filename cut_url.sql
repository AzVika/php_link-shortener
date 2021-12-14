-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 14 2021 г., 15:37
-- Версия сервера: 5.7.29
-- Версия PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cut_url`
--

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `long_link` varchar(250) DEFAULT NULL,
  `short_link` varchar(20) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `links`
--

INSERT INTO `links` (`id`, `user_id`, `long_link`, `short_link`, `views`) VALUES
(1, 3, 'https://google.com', 'gdfdsd', 18),
(2, 3, 'https://www.facebook.com', 'gdfsd', 15),
(4, 3, 'https://codepen.io', 'fsw3a0', 2),
(5, 4, 'https://spichca.ru/', '4cn-i6', 0),
(6, 4, 'https://www.youtube.com/', '5wxuam', 4),
(9, 4, 'https://github.com/', 'rh03pw', 0),
(15, 3, 'https://console.firebase.google.com', '9gbqio', 1),
(25, 5, 'http://prostovix.info/xxx', 'e57wib', 2),
(27, 9, 'https://github.com', 'rnvt5d', 23),
(28, 9, 'http://www.spichca.ru', 't35fwj', 1),
(29, 9, 'https://www.google.com/search?client=firefox-b-d&q=php+filter_var', 'iobu06', 0),
(33, 10, 'https://github.com/', '2bdkf5', 0),
(35, 10, 'https://2domains.ru/', 'gf0dba', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(3, 'user3', '$2y$10$wdpDraOq0vCL78XS6Yu0ouvkhvM/tyaB4WVtXDUt8dNJiZxchYSYq'),
(4, 'user5', '$2y$10$MMEQKiYaf5pf/Vl/XyKaROeXsl/OIQJ2uxpnMkCySUvtSlhdXDgqa'),
(5, 'user7', '$2y$10$jTO.4PtOXex5k79y/7zMX.dGHyrypYWpIU79XMAKW7dKgnSg70K.e'),
(8, 'user10', '$2y$10$t.Rzmo2847w4qeJZJsI8P.eSOzqP1aRBNK095Kza.w8LF/P3C2AgK'),
(9, 'user12', '$2y$10$cLY.JRX6v6sgdVVA2PPQf.BmCouqAFQP7PlzrYYhUf67zm4A2we5y'),
(10, 'user15', '$2y$10$54FwmWHFnaE6vbXq5vIo4OCTUqKvvPCVMpOzM0DD78FWcAOWTkxDu');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `short_link` (`short_link`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
