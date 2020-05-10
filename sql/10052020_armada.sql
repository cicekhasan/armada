-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `armada` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_turkish_ci */;
USE `armada`;

DROP TABLE IF EXISTS `grup`;
CREATE TABLE `grup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `izin` text COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

INSERT INTO `grup` (`id`, `isim`, `izin`) VALUES
(1,	'Normal Üye',	''),
(2,	'Admin',	'{\"admin\":1, \"yazar\":2}');

DROP TABLE IF EXISTS `uyeler`;
CREATE TABLE `uyeler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kullanici_adi` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `parola` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `salt` varchar(250) COLLATE utf8_turkish_ci DEFAULT NULL,
  `isim` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `uyelik_tarihi` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `grup` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;


DROP TABLE IF EXISTS `uye_session`;
CREATE TABLE `uye_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kullanici_id` int(11) NOT NULL,
  `hash` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;


-- 2020-05-10 20:08:27
