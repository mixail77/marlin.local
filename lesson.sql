-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.33 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.3.0.6366
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дамп данных таблицы marlin.role: ~2 rows (приблизительно)
INSERT INTO `role` (`ID`, `NAME`, `CODE`) VALUES
	(1, 'Администратор', 'admin'),
	(2, 'Пользователь', 'user');

-- Дамп данных таблицы marlin.status: ~4 rows (приблизительно)
INSERT INTO `status` (`ID`, `NAME`, `CODE`) VALUES
	(1, 'Онлайн', 'success'),
	(2, 'Отошел', 'warning'),
	(3, 'Не беспокоить', 'danger'),
	(4, 'Не установлен', 'none');

-- Дамп данных таблицы marlin.user: ~0 rows (приблизительно)
INSERT INTO `user` (`ID`, `EMAIL`, `PASSWORD`, `PROFILE`, `SOCIAL`, `STATUS`, `ROLE`) VALUES
	(74, 'yaca1@yandex.ru', '$2y$10$hDNjdCKWweP0CxzmDDC/gOhXl2NDTmLXudSPDv0kRNaURoeh8IlBS', 46, 39, 4, 2),
	(75, 'yaca2@yandex.ru', '$2y$10$tBnzG7e46PDZHe3gCvi.QeJhFketM4n94JRfPUhJvoo4ejPf593Dy', 47, 40, 4, 2),
	(76, 'yaca3@yandex.ru', '$2y$10$sAFlCCCFWETnHsWHruHvJOK07zJy/.T9ameMrWSfkFqrG.WUJoejW', 48, 41, 4, 2),
	(77, 'admin@yandex.ru', '$2y$10$EtYEYtbkZkfoI3Gd4K8U6Ogd28ZURlwcB43of44JpxWjBlM1F1n/W', 49, 42, 4, 1);

-- Дамп данных таблицы marlin.user_profile: ~0 rows (приблизительно)
INSERT INTO `user_profile` (`ID`, `USER_ID`, `NAME`, `LAST_NAME`, `SECOND_NAME`, `PHONE`, `ADDRESS`, `JOB`, `PHOTO`) VALUES
	(46, 74, '', '', '', '', '', '', ''),
	(47, 75, '', '', '', '', '', '', ''),
	(48, 76, '', '', '', '', '', '', ''),
	(49, 77, '', '', '', '', '', '', '');

-- Дамп данных таблицы marlin.user_social: ~0 rows (приблизительно)
INSERT INTO `user_social` (`ID`, `USER_ID`, `VK`, `INSTAGRAM`, `TELEGRAM`) VALUES
	(39, 74, '', '', ''),
	(40, 75, '', '', ''),
	(41, 76, '', '', ''),
	(42, 77, '', '', '');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
