SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `dukephp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `dukephp`;

CREATE TABLE `project` (
  `PROJECT_ID` smallint(5) UNSIGNED NOT NULL,
  `PROJECT_NAME` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `USER_ID` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `project` (`PROJECT_ID`, `PROJECT_NAME`, `USER_ID`) VALUES
(1, 'Входящие', 3),
(2, 'Учеба', 3),
(3, 'Работа', 3),
(4, 'Домашние дела', 3),
(5, 'Авто', 3),
(6, 'Тестирование БД', 4);

CREATE TABLE `task` (
  `TASK_ID` smallint(5) UNSIGNED NOT NULL,
  `CREATION_DATE` DATETIME NOT NULL,
  `TASK_STATUS` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `TASKNAME` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FILEREF` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ENDTIME` date DEFAULT NULL,
  `PROJECT_ID` smallint(5) UNSIGNED NOT NULL,
  `USER_ID` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `task` (`TASK_ID`, `CREATION_DATE`, `TASK_STATUS`, `TASKNAME`, `FILEREF`, `ENDTIME`, `PROJECT_ID`, `USER_ID`) VALUES
(1, '2019-01-01 19:58:00', '0', 'Собеседование в IT компании', 'Home.psd', '2020-06-10', 3, 3),
(2, '2019-01-01 19:58:00', '0', 'Выполнить тестовое задание', 'Home.psd', '2019-12-25', 3, 3),
(3, '2019-01-01 19:58:00', '1', 'Сделать задание первого раздела', 'Home.psd', '2019-12-21', 2, 3),
(4, '2019-01-01 19:58:00', '0', 'Встреча с другом', 'Home.psd', '2019-12-22', 1, 3),
(5, '2019-01-01 19:58:00', '0', 'Купить корм для кота', 'Home.psd', NULL, 4, 3),
(6, '2019-01-01 19:58:00', '0', 'Заказать пиццу', 'Home.psd', NULL, 4, 3),
(7, '2019-01-01 19:58:00', '0', 'Протестировать страницу на другом пользователе', 'Tester.psd', '2020-09-13', 6, 4),
(8, '2019-01-01 19:58:00', '0', 'Протестировать страницу на другом пользователе второй раз', 'Tester.psd', '2020-09-13', 6, 4);

CREATE TABLE `user` (
  `USER_ID` smallint(5) UNSIGNED NOT NULL,
  `REG_DATE` datetime NOT NULL,
  `EMAIL` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `USERNAME` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PASSWORD` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LAST_NAME` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FIRST_NAME` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`USER_ID`, `REG_DATE`, `EMAIL`, `USERNAME`, `PASSWORD`, `LAST_NAME`, `FIRST_NAME`) VALUES
(3, '2020-09-13 12:54:34', 'Konstantin1995@mail.com', 'KostyaTester', 'KostyaTester1995', 'Иванов', 'Константин'),
(4, '2020-09-13 17:30:55', 'NewTesterPetya@mail.com', 'PetyaTester', 'PetyaTester2020', 'Иванов', 'Петр');


ALTER TABLE `project`
  ADD PRIMARY KEY (`PROJECT_ID`),
  ADD KEY `FK_USER_ID` (`USER_ID`),
  ADD KEY `PROJECT_NAME` (`PROJECT_NAME`);

ALTER TABLE `task`
  ADD PRIMARY KEY (`TASK_ID`),
  ADD KEY `FK_PROJECT_ID` (`PROJECT_ID`),
  ADD KEY `FK_USERS_ID` (`USER_ID`),
  ADD KEY `TASKNAME` (`TASKNAME`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD UNIQUE KEY `USERNAME` (`USERNAME`);


ALTER TABLE `project`
  MODIFY `PROJECT_ID` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `task`
  MODIFY `TASK_ID` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `user`
  MODIFY `USER_ID` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `project`
  ADD CONSTRAINT `FK_USER_ID` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `task`
  ADD CONSTRAINT `FK_PROJECT_ID` FOREIGN KEY (`PROJECT_ID`) REFERENCES `project` (`PROJECT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USERS_ID` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
