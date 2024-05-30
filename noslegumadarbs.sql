-- --------------------------------------------------------
-- Хост:                         localhost
-- Версия сервера:               8.0.32 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных noslegumadarbs
CREATE DATABASE IF NOT EXISTS `noslegumadarbs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `noslegumadarbs`;

-- Дамп структуры для таблица noslegumadarbs.laukumi
CREATE TABLE IF NOT EXISTS `laukumi` (
  `ID` int NOT NULL,
  `adrese` varchar(50) DEFAULT NULL,
  `apraksts` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `bildes` blob,
  `rajons` int DEFAULT NULL,
  `pilseta` int DEFAULT NULL,
  `izmers` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_laukumi_rajoni` (`rajons`),
  KEY `FK_laukumi_pilseta` (`pilseta`),
  KEY `FK_laukumi_laukumu_izmers` (`izmers`),
  CONSTRAINT `FK_laukumi_laukumu_izmers` FOREIGN KEY (`izmers`) REFERENCES `laukumu_izmers` (`ID`),
  CONSTRAINT `FK_laukumi_pilseta` FOREIGN KEY (`pilseta`) REFERENCES `pilseta` (`ID`),
  CONSTRAINT `FK_laukumi_rajoni` FOREIGN KEY (`rajons`) REFERENCES `rajoni` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы noslegumadarbs.laukumi: ~8 rows (приблизительно)
INSERT INTO `laukumi` (`ID`, `adrese`, `apraksts`, `bildes`, `rajons`, `pilseta`, `izmers`) VALUES
	(1, 'invalidu iela 6', 'Lielisks moderns sporta laukums ', NULL, 9, 1, 2),
	(2, 'Grostonas iela 12', 'Mazs vingrošanas laukums, kurš ir aprīkots ar 3 stieņiem cilvēkiem ar dažādu augumu.', NULL, 39, NULL, 4),
	(3, '', 'mazs vecs vingrošanas trienažieris "trepes", kuru var izmantot ka stieņu.', NULL, 39, 1, NULL),
	(4, 'ausekļa iela 3', 'Vecs trenažieru komplekss, kurā ietilps 2 dažada augstuma stieņi un trenažieris "trepes".', NULL, 12, 1, 4),
	(5, '', 'imba turniki', NULL, 1, 1, 1),
	(6, 'Biba iela 2', 'labošanas tests', NULL, 4, 1, 2),
	(7, 'Atpūtas iela', '', NULL, 28, 1, 3),
	(8, '', '', NULL, 1, 1, 1);

-- Дамп структуры для таблица noslegumadarbs.laukumu_izmers
CREATE TABLE IF NOT EXISTS `laukumu_izmers` (
  `ID` int NOT NULL,
  `izmers` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы noslegumadarbs.laukumu_izmers: ~4 rows (приблизительно)
INSERT INTO `laukumu_izmers` (`ID`, `izmers`) VALUES
	(1, 'Liela'),
	(2, 'Vidēja'),
	(3, 'Maza'),
	(4, 'Ļoti maza');

-- Дамп структуры для таблица noslegumadarbs.pilseta
CREATE TABLE IF NOT EXISTS `pilseta` (
  `ID` int NOT NULL,
  `nosaukums` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы noslegumadarbs.pilseta: ~2 rows (приблизительно)
INSERT INTO `pilseta` (`ID`, `nosaukums`) VALUES
	(1, 'Rīga'),
	(2, 'Daugavpils');

-- Дамп структуры для таблица noslegumadarbs.rajoni
CREATE TABLE IF NOT EXISTS `rajoni` (
  `ID` int NOT NULL,
  `nosaukums` varchar(50) DEFAULT NULL,
  `pilseta` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_rajoni_pilseta` (`pilseta`),
  CONSTRAINT `FK_rajoni_pilseta` FOREIGN KEY (`pilseta`) REFERENCES `pilseta` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы noslegumadarbs.rajoni: ~46 rows (приблизительно)
INSERT INTO `rajoni` (`ID`, `nosaukums`, `pilseta`) VALUES
	(1, 'Āgenskalns', 1),
	(2, 'Atgāzene', 1),
	(3, 'Avotu iela', 1),
	(4, 'Beberbeķi', 1),
	(5, 'Berģi', 1),
	(6, 'Bieriņi', 1),
	(7, 'Bišumuiža', 1),
	(8, 'Bolderāja', 1),
	(9, 'Brasa', 1),
	(10, 'Brekši', 1),
	(11, 'Bukulti', 1),
	(12, 'Centrs', 1),
	(13, 'Čiekurkalns', 1),
	(14, 'Daugavgrīva', 1),
	(15, 'Dzirciems', 1),
	(16, 'Dārzciems', 1),
	(17, 'Dārziņi', 1),
	(18, 'Grīziņkalns', 1),
	(19, 'Iļģuciems', 1),
	(20, 'Imanta', 1),
	(21, 'Jugla', 1),
	(22, 'Katlakalns', 1),
	(23, 'Kengarags', 1),
	(24, 'Ķīpsala', 1),
	(25, 'Kleisti', 1),
	(26, 'Kundziņsala', 1),
	(27, 'Mangaļsala', 1),
	(28, 'Mežaparks', 1),
	(29, 'Mežciems', 1),
	(30, 'Mīlgrāvis', 1),
	(31, 'Mūkupurvs', 1),
	(32, 'Pleskodāle', 1),
	(33, 'Pļavnieki', 1),
	(34, 'Purvciems', 1),
	(35, 'Rītabuļļi', 1),
	(36, 'Rumbula', 1),
	(37, 'Salas', 1),
	(38, 'Sarkandaugava', 1),
	(39, 'Skanste', 1),
	(40, 'Spilve', 1),
	(41, 'Suntaži', 1),
	(42, 'Teika', 1),
	(43, 'Torņakalns', 1),
	(44, 'Trīsciems', 1),
	(45, 'Vekši', 1),
	(46, 'Vecdaugava', 1),
	(47, 'Vecmīlgrāvis', 1),
	(48, 'Vecpilsēta', 1),
	(49, 'Vecāķi', 1),
	(50, 'Zasulauks', 1),
	(51, 'Ziepniekkalns', 1),
	(52, 'Zolitūde', 1);

-- Дамп структуры для таблица noslegumadarbs.user
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Дамп данных таблицы noslegumadarbs.user: ~0 rows (приблизительно)
INSERT INTO `user` (`username`, `password`) VALUES
	('admin', '12345');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
