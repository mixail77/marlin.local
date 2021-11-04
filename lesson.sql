-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 04 2021 г., 13:55
-- Версия сервера: 5.7.33
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `marlin`
--

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  `CODE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`ID`, `NAME`, `CODE`) VALUES
(1, 'Администратор', 'admin'),
(2, 'Пользователь', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) DEFAULT NULL,
  `CODE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`ID`, `NAME`, `CODE`) VALUES
(1, 'Онлайн', 'success'),
(2, 'Отошел', 'warning'),
(3, 'Не беспокоить', 'danger'),
(4, 'Не установлен', 'none');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `PROFILE` int(11) DEFAULT NULL,
  `SOCIAL` int(11) DEFAULT NULL,
  `STATUS` int(11) DEFAULT NULL,
  `ROLE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`ID`, `EMAIL`, `PASSWORD`, `PROFILE`, `SOCIAL`, `STATUS`, `ROLE`) VALUES
(74, 'yaca1@yandex.ru', '$2y$10$hDNjdCKWweP0CxzmDDC/gOhXl2NDTmLXudSPDv0kRNaURoeh8IlBS', 46, 39, 1, 2),
(75, 'yaca2@yandex.ru', '$2y$10$tBnzG7e46PDZHe3gCvi.QeJhFketM4n94JRfPUhJvoo4ejPf593Dy', 47, 40, 4, 2),
(76, 'yaca3@yandex.ru', '$2y$10$sAFlCCCFWETnHsWHruHvJOK07zJy/.T9ameMrWSfkFqrG.WUJoejW', 48, 41, 4, 2),
(77, 'admin@yandex.ru', '$2y$10$EtYEYtbkZkfoI3Gd4K8U6Ogd28ZURlwcB43of44JpxWjBlM1F1n/W', 49, 42, 4, 1),
(78, 'yaca5@yandex.ru', '$2y$10$TGKaD.xz1npKl87gnnaqaeaVBU7o0lnJFBLMp0oh0r8VBHvPQI0yi', 50, 43, 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `user_profile`
--

CREATE TABLE `user_profile` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `NAME` varchar(255) DEFAULT NULL,
  `LAST_NAME` varchar(255) DEFAULT NULL,
  `SECOND_NAME` varchar(255) DEFAULT NULL,
  `PHONE` varchar(255) DEFAULT NULL,
  `ADDRESS` varchar(255) DEFAULT NULL,
  `JOB` varchar(255) DEFAULT NULL,
  `PHOTO` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_profile`
--

INSERT INTO `user_profile` (`ID`, `USER_ID`, `NAME`, `LAST_NAME`, `SECOND_NAME`, `PHONE`, `ADDRESS`, `JOB`, `PHOTO`) VALUES
(46, 74, 'yaca1@yandex.ru', '', '', 'yaca1@yandex.ru', 'yaca1@yandex.ru', 'yaca1@yandex.ru', ''),
(47, 75, 'yaca2@yandex.ru', '', '', 'yaca2@yandex.ru', 'yaca2@yandex.ru', 'yaca2@yandex.ru', ''),
(48, 76, 'yaca3@yandex.ru', '', '', 'yaca3@yandex.ru', 'yaca3@yandex.ru', 'yaca3@yandex.ru', ''),
(49, 77, 'admin@yandex.ru', '', '', 'admin@yandex.ru', 'admin@yandex.ru', 'admin@yandex.ru', ''),
(50, 78, 'yaca5@yandex.ru', '', '', 'yaca5@yandex.ru', 'yaca5@yandex.ru', 'yaca5@yandex.ru', '');

-- --------------------------------------------------------

--
-- Структура таблицы `user_social`
--

CREATE TABLE `user_social` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `VK` varchar(255) DEFAULT NULL,
  `INSTAGRAM` varchar(255) DEFAULT NULL,
  `TELEGRAM` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_social`
--

INSERT INTO `user_social` (`ID`, `USER_ID`, `VK`, `INSTAGRAM`, `TELEGRAM`) VALUES
(39, 74, 'yaca1@yandex.ru', 'yaca1@yandex.ru', 'yaca1@yandex.ru'),
(40, 75, 'yaca2@yandex.ru', 'yaca2@yandex.ru', 'yaca2@yandex.ru'),
(41, 76, 'yaca3@yandex.ru', 'yaca3@yandex.ru', 'yaca3@yandex.ru'),
(42, 77, 'admin@yandex.ru', 'admin@yandex.ru', 'admin@yandex.ru'),
(43, 78, 'yaca5@yandex.ru', 'yaca5@yandex.ru', 'yaca5@yandex.ru');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `user_social`
--
ALTER TABLE `user_social`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT для таблицы `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `user_social`
--
ALTER TABLE `user_social`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
