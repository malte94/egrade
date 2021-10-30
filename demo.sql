-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `absences`
--

CREATE TABLE `absences` (
  `PK_Absences` int NOT NULL,
  `FK_User` int NOT NULL,
  `FK_School` int DEFAULT NULL,
  `Reason` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Date_From` date DEFAULT NULL,
  `Date_To` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `absences`
--

INSERT INTO `absences` (`PK_Absences`, `FK_User`, `FK_School`, `Reason`, `Date_From`, `Date_To`) VALUES
(6, 3, 2, 'Erkältung', '2020-06-11', '2020-06-12'),
(7, 3, 2, 'Grippe', '2020-05-11', '2020-05-19'),
(11, 3, 2, 'Grippe', '2020-06-16', '2020-06-20');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `class`
--

CREATE TABLE `class` (
  `PK_Class` int UNSIGNED NOT NULL,
  `FK_School` int UNSIGNED NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Enrollment` smallint UNSIGNED DEFAULT NULL,
  `Level` tinyint(1) NOT NULL DEFAULT '1',
  `Is_Halfyear` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `class`
--

INSERT INTO `class` (`PK_Class`, `FK_School`, `Name`, `Enrollment`, `Level`, `Is_Halfyear`) VALUES
(54, 1, '1a', 2016, 1, 0),
(62, 2, '1a', 2021, 1, 0),
(63, 2, '4b', 2021, 4, 0),
(64, 1, '4a', 2016, 4, 0),
(67, 2, '3c', 2021, 3, 0),
(70, 1, '3b', 2016, 3, 1),
(78, 2, '2a', 2016, 2, 0),
(79, 3, '1a', 2020, 1, 0),
(80, 4, '1a', 2016, 1, 0),
(81, 4, '4a', 2016, 4, 0),
(82, 4, '3a', 2016, 3, 0),
(83, 3, '2a', 2019, 2, 0),
(84, 1, '3c', 2017, 3, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `class_template_settings`
--

CREATE TABLE `class_template_settings` (
  `PK_Class_Template_Settings` int UNSIGNED NOT NULL,
  `FK_Class` int UNSIGNED NOT NULL,
  `FK_Template_Settings_Value` int UNSIGNED NOT NULL,
  `FK_School_Template` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `class_template_settings`
--

INSERT INTO `class_template_settings` (`PK_Class_Template_Settings`, `FK_Class`, `FK_Template_Settings_Value`, `FK_School_Template`) VALUES
(13, 54, 35, 1),
(14, 54, 36, 1),
(11, 62, 33, 1),
(12, 62, 34, 1),
(15, 79, 47, 3),
(16, 79, 48, 3),
(17, 79, 49, 3),
(18, 79, 50, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `modules_deleteme`
--

CREATE TABLE `modules_deleteme` (
  `PK_Modules` int NOT NULL,
  `Module_Name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `modules_deleteme`
--

INSERT INTO `modules_deleteme` (`PK_Modules`, `Module_Name`) VALUES
(1, 'RLP_C1_1_V1'),
(2, 'RLP_C1_1_V2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pinboard`
--

CREATE TABLE `pinboard` (
  `PK_Pinboard` int UNSIGNED NOT NULL,
  `FK_School` int UNSIGNED NOT NULL,
  `vertretungsplan` text,
  `ankuendigung` text,
  `infos` text,
  `board_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `pinboard`
--

INSERT INTO `pinboard` (`PK_Pinboard`, `FK_School`, `vertretungsplan`, `ankuendigung`, `infos`, `board_id`) VALUES
(60, 1, '<table style=\"border-collapse: collapse; width: 100%; height: 189px;\" border=\"1\">\r\n<tbody>\r\n<tr style=\"height: 21px;\">\r\n<td style=\"width: 14.2857%; height: 21px;\"><strong>Montag</strong></td>\r\n<td style=\"width: 14.2857%; height: 21px;\"><strong>Dienstag</strong></td>\r\n<td style=\"width: 14.2857%; height: 21px;\"><strong>Mittwoch</strong></td>\r\n<td style=\"width: 14.2857%; height: 21px;\"><strong>Donnerstag</strong></td>\r\n<td style=\"width: 14.2857%; height: 21px;\"><strong>Freitag</strong></td>\r\n</tr>\r\n<tr style=\"height: 21px;\">\r\n<td style=\"width: 14.2857%; height: 21px; text-align: center;\">ASdf</td>\r\n<td style=\"width: 14.2857%; height: 21px; text-align: center;\">Lalala</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 21px;\">\r\n<td style=\"width: 14.2857%; height: 21px;\">ffasdfdsdf</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 21px;\">\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 21px;\">\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 21px;\">\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 21px;\">\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 21px;\">\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n</tr>\r\n<tr style=\"height: 21px;\">\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n<td style=\"width: 14.2857%; height: 21px;\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'sasdasdalskdjlasdasasdasdasd', 'Br&ouml;tchenpreise in der Kantine werden zum.<br />Halloi Welt', '4480882'),
(61, 2, '<p class=\"MsoNormal\" style=\"text-align: center;\" align=\"center\"><strong>10. Juli - 15. Juli 2021</strong></p>\r\n<table class=\"MsoTable15Grid1Light\" style=\"border-collapse: collapse; border: none; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; mso-yfti-tbllook: 1184; mso-padding-alt: 0cm 5.4pt 0cm 5.4pt;\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr style=\"mso-yfti-irow: -1; mso-yfti-firstrow: yes; mso-yfti-lastfirstrow: yes;\">\r\n<td style=\"width: 90.6pt; border: solid #999999 1.0pt; mso-border-themecolor: text1; mso-border-themetint: 102; border-bottom: solid #666666 1.5pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 153; mso-border-alt: solid #999999 .5pt; mso-border-bottom-alt: solid #666666 1.5pt; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal; mso-yfti-cnfc: 5;\" align=\"center\"><strong>Montag</strong></p>\r\n</td>\r\n<td style=\"width: 90.6pt; border-top: solid #999999 1.0pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; border-left: none; border-bottom: solid #666666 1.5pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 153; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; mso-border-bottom-alt: solid #666666 1.5pt; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal; mso-yfti-cnfc: 1;\" align=\"center\"><strong>Dienstag</strong></p>\r\n</td>\r\n<td style=\"width: 90.6pt; border-top: solid #999999 1.0pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; border-left: none; border-bottom: solid #666666 1.5pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 153; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; mso-border-bottom-alt: solid #666666 1.5pt; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal; mso-yfti-cnfc: 1;\" align=\"center\"><strong>Mittwoch</strong></p>\r\n</td>\r\n<td style=\"width: 90.65pt; border-top: solid #999999 1.0pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; border-left: none; border-bottom: solid #666666 1.5pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 153; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; mso-border-bottom-alt: solid #666666 1.5pt; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal; mso-yfti-cnfc: 1;\" align=\"center\"><strong>Donnerstag</strong></p>\r\n</td>\r\n<td style=\"width: 90.65pt; border-top: solid #999999 1.0pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; border-left: none; border-bottom: solid #666666 1.5pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 153; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; mso-border-bottom-alt: solid #666666 1.5pt; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: normal; mso-yfti-cnfc: 1;\" align=\"center\"><strong>Freitag</strong></p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 0;\">\r\n<td style=\"width: 90.6pt; border: solid #999999 1.0pt; mso-border-themecolor: text1; mso-border-themetint: 102; border-top: none; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-alt: solid #999999 .5pt; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal; mso-yfti-cnfc: 4;\"><strong>&nbsp;</strong></p>\r\n</td>\r\n<td style=\"width: 90.6pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n<td style=\"width: 90.6pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n<td style=\"width: 90.65pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n<td style=\"width: 90.65pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 1;\">\r\n<td style=\"width: 90.6pt; border: solid #999999 1.0pt; mso-border-themecolor: text1; mso-border-themetint: 102; border-top: none; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-alt: solid #999999 .5pt; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal; mso-yfti-cnfc: 4;\"><strong>&nbsp;</strong></p>\r\n</td>\r\n<td style=\"width: 90.6pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n<td style=\"width: 90.6pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n<td style=\"width: 90.65pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n<td style=\"width: 90.65pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n</tr>\r\n<tr style=\"mso-yfti-irow: 2; mso-yfti-lastrow: yes;\">\r\n<td style=\"width: 90.6pt; border: solid #999999 1.0pt; mso-border-themecolor: text1; mso-border-themetint: 102; border-top: none; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-alt: solid #999999 .5pt; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal; mso-yfti-cnfc: 4;\"><strong>&nbsp;</strong></p>\r\n</td>\r\n<td style=\"width: 90.6pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n<td style=\"width: 90.6pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n<td style=\"width: 90.65pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n<td style=\"width: 90.65pt; border-top: none; border-left: none; border-bottom: solid #999999 1.0pt; mso-border-bottom-themecolor: text1; mso-border-bottom-themetint: 102; border-right: solid #999999 1.0pt; mso-border-right-themecolor: text1; mso-border-right-themetint: 102; mso-border-top-alt: solid #999999 .5pt; mso-border-top-themecolor: text1; mso-border-top-themetint: 102; mso-border-left-alt: solid #999999 .5pt; mso-border-left-themecolor: text1; mso-border-left-themetint: 102; mso-border-alt: solid #999999 .5pt; mso-border-themecolor: text1; mso-border-themetint: 102; padding: 0cm 5.4pt 0cm 5.4pt;\" valign=\"top\" width=\"121\">\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; line-height: normal;\">&nbsp;</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p class=\"MsoNormal\">&nbsp;</p>', 'Morgen ist <strong>schulfrei!</strong>', 'Am 31. Juli 2021 findet eine Chorauff&uuml;hrung der vierten Klasse statt.', '3144228'),
(62, 4, '', '', '', '8626762'),
(63, 3, 'asdfasdasdasdasdasd', 'asdf', '', '485242');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE `role` (
  `PK_Role` int UNSIGNED NOT NULL,
  `id` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `role`
--

INSERT INTO `role` (`PK_Role`, `id`) VALUES
(1, 'Administrator'),
(2, 'Lehrer');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `school`
--

CREATE TABLE `school` (
  `PK_School` int UNSIGNED NOT NULL,
  `id` varchar(5) CHARACTER SET utf8 NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Federal` tinyint UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `school`
--

INSERT INTO `school` (`PK_School`, `id`, `Name`, `Federal`) VALUES
(1, 'KWGHX', 'König-Wilhelm-Gymnasium', 11),
(2, 'GSN', 'Grundschule Nolze', 11),
(3, 'HSHX', 'Auf der Insel Augustdorf', 10),
(4, 'DEMO', 'Grundschule Demo', 11);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `school_templates`
--

CREATE TABLE `school_templates` (
  `PK_School_Template` int UNSIGNED NOT NULL,
  `Module_Name` varchar(45) NOT NULL,
  `ID_Federal` tinyint NOT NULL,
  `Class_Level` tinyint(1) NOT NULL,
  `Half_Year` tinyint(1) NOT NULL DEFAULT '0',
  `Display_Name` varchar(128) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `school_templates`
--

INSERT INTO `school_templates` (`PK_School_Template`, `Module_Name`, `ID_Federal`, `Class_Level`, `Half_Year`, `Display_Name`, `Active`) VALUES
(1, 'RLP_C1_1', 11, 1, 0, 'RLP, textorientiert, Halbjahr', 1),
(2, 'RLP_C1_2', 11, 2, 0, 'RLP, textorientiert, Ganzjahr', 1),
(3, 'NRW_C1_1', 10, 1, 0, 'NRW Grundschule Klasse 1', 1),
(4, 'RLP_C4_1', 11, 4, 0, 'RLP, kompetenzorientiert, Halbjahr', 1),
(5, 'RLP_C3_1', 11, 3, 0, 'RLP, notenorientiert, Halbjahr', 1),
(6, 'NRW_C2_1', 10, 2, 0, 'NRW, textorientiert mit Noten Klasse 2', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `school_template_settings`
--

CREATE TABLE `school_template_settings` (
  `PK_School_Template_Settings` int UNSIGNED NOT NULL,
  `FK_School` int UNSIGNED NOT NULL,
  `FK_Template_Settings_Value` int UNSIGNED NOT NULL,
  `FK_School_Template` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `school_template_settings`
--

INSERT INTO `school_template_settings` (`PK_School_Template_Settings`, `FK_School`, `FK_Template_Settings_Value`, `FK_School_Template`) VALUES
(23, 1, 23, 1),
(24, 1, 24, 1),
(27, 1, 29, 2),
(25, 2, 25, 1),
(26, 2, 28, 1),
(28, 2, 30, 2),
(31, 3, 42, 3),
(32, 3, 43, 3),
(33, 3, 44, 3),
(34, 3, 45, 3),
(29, 4, 40, 1),
(30, 4, 41, 1),
(35, 4, 46, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `school_template_to_school`
--

CREATE TABLE `school_template_to_school` (
  `PK_School_Template_To_School` int UNSIGNED NOT NULL,
  `FK_School` int UNSIGNED NOT NULL,
  `FK_School_Template` int UNSIGNED NOT NULL,
  `Class_Level` tinyint UNSIGNED NOT NULL,
  `Is_Halfyear` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `school_template_to_school`
--

INSERT INTO `school_template_to_school` (`PK_School_Template_To_School`, `FK_School`, `FK_School_Template`, `Class_Level`, `Is_Halfyear`) VALUES
(1, 2, 2, 1, 1),
(16, 1, 1, 1, 0),
(17, 1, 2, 1, 1),
(18, 1, 1, 2, 0),
(19, 2, 1, 1, 0),
(20, 2, 5, 3, 0),
(21, 2, 1, 2, 0),
(22, 3, 3, 1, 0),
(23, 1, 2, 2, 1),
(24, 2, 4, 4, 0),
(25, 1, 4, 4, 0),
(26, 1, 5, 3, 0),
(27, 1, 5, 3, 1),
(28, 1, 4, 4, 1),
(29, 2, 4, 2, 1),
(30, 3, 3, 1, 1),
(31, 4, 1, 1, 0),
(32, 4, 2, 1, 1),
(33, 4, 1, 2, 0),
(34, 4, 2, 2, 1),
(36, 4, 5, 3, 0),
(38, 4, 4, 4, 0),
(39, 3, 6, 2, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `school_template_vars`
--

CREATE TABLE `school_template_vars` (
  `PK_School_Template_Vars` int UNSIGNED NOT NULL,
  `FK_School_Template` int UNSIGNED NOT NULL,
  `Datatype` tinyint UNSIGNED NOT NULL,
  `Varname` varchar(255) NOT NULL,
  `Displayname` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `school_template_vars`
--

INSERT INTO `school_template_vars` (`PK_School_Template_Vars`, `FK_School_Template`, `Datatype`, `Varname`, `Displayname`, `Description`) VALUES
(1, 1, 1, 'RLP_1_C1_ConferenceDate', 'Konferenzdatum', 'An diesem Datum findet die Konferenz statt.'),
(2, 1, 1, 'RLP_1_C1_IssueDate', 'Ausgabedatum', 'Ausgabedatum des Zeugnisses.'),
(4, 2, 1, 'RLP_1_C2_IssueDate', 'Besprechung', 'Description'),
(5, 3, 3, 'NRW_GLOB_Current_Schoolyear', 'Aktuelles Schuljahr', 'Aktuelles Schuljahr als Text, z.B. 2020/2021'),
(8, 3, 1, 'NRW_1_C1_ConferenceDate', 'Konferenzdatum', 'An diesem Datum findet/fand die Konferenz statt'),
(9, 3, 1, 'NRW_1_C1_IssueDate', 'Ausgabedatum', 'Ausgabedatum des Zeugnisses'),
(10, 3, 1, 'NRW_1_C1_Restart_School', 'Wiederbeginn Unterricht', 'Wiederbeginn des Unterrichts');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `session`
--

CREATE TABLE `session` (
  `PK_Session` int UNSIGNED NOT NULL,
  `FK_User` int UNSIGNED NOT NULL,
  `FK_School` int UNSIGNED NOT NULL,
  `sessionID` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `session`
--

INSERT INTO `session` (`PK_Session`, `FK_User`, `FK_School`, `sessionID`, `created`) VALUES
(625, 1, 1, '418991dd0141d39bda2dd0af3a6bc6b0', '2020-05-14 21:18:21'),
(626, 3, 2, 'aea283d2e5f033ed16b7a32e48ba14a9', '0000-00-00 00:00:00'),
(627, 1, 1, '08870c54b9c87d3f48be65e66ac9d22b', '2020-05-14 21:51:54'),
(628, 1, 1, '3d8707cd804ba3ce6fc1d74a23361cbc', '2020-05-14 22:25:50'),
(629, 3, 2, 'cfa69032150a80c8bb863c13015ccd14', '2020-05-15 10:13:53'),
(631, 1, 1, '64c69a79e7f5a2716f803d206d81e0c9', '2020-05-15 10:57:11'),
(632, 1, 1, '53d243194dcce21070d064f6f658da3c', '2020-05-15 11:29:20'),
(633, 1, 1, 'f0697d85b4cff3cdee2f1e4d6dd3331b', '2020-05-15 13:02:31'),
(636, 1, 1, 'fe3e246d456fae9806acdeddab387c3b', '2020-05-15 22:44:12'),
(638, 3, 2, '9100013abbbf2f0520d74bde9506c34b', '2020-05-16 10:21:45'),
(640, 1, 1, '8f1cb59d34c2b058ee195d1a102b2fd8', '2020-05-16 15:49:18'),
(642, 3, 2, '193d75e39cac84930d3b836ae76c74c1', '2020-05-17 12:23:59'),
(644, 1, 1, '25a2bf28da9a5414f81ba98a51cbf275', '2020-05-17 21:49:25'),
(645, 3, 2, '87d10ad06dad136288f3ebf877d79e1c', '2020-05-18 10:07:00'),
(647, 1, 1, '015e366b02214f84b322bc7019cccf9d', '2020-05-18 11:17:03'),
(648, 1, 1, '0efd9a1f39b0c65e2da0853eb0fc22ee', '2020-05-18 11:35:10'),
(649, 1, 1, '5ed2b73fed22d7b94a2212361a26ab69', '2020-05-18 14:47:54'),
(651, 1, 1, 'a982da19c69549dfb2aad87c3945dd50', '2020-05-18 16:04:47'),
(652, 1, 1, 'd36666d1689bfc07459151516d228f6f', '2020-05-18 16:06:27'),
(653, 1, 1, '46e8d4a1ccae48d99adf96f1e38e8a33', '2020-05-18 16:06:38'),
(654, 3, 2, 'd544780e387e89b0db704df5d286d308', '2020-05-18 16:10:56'),
(655, 1, 1, '8f17fdc84218eb5e389ba5b99ec02115', '2020-05-18 16:27:11'),
(656, 1, 1, 'd5c8e672547ad4eca4afc0bad5fe2dc9', '2020-05-18 18:46:22'),
(657, 1, 1, 'ff1aa2c1eb815ffd06e32b7e6efe00d7', '2020-05-18 18:46:38'),
(658, 1, 1, 'fcb2e8ee6055f1d104bd89a3391ee652', '2020-05-18 18:49:48'),
(660, 1, 1, '5eb58dcfdfda0ab7143b3e01d0b5afe0', '2020-05-18 22:22:04'),
(661, 1, 1, '98f8fc037a507c22bbbf0654378539ea', '2020-05-18 22:38:35'),
(662, 3, 2, 'af00d27dcd00947152ef872353dbee5e', '2020-05-18 23:30:08'),
(663, 1, 1, 'b55a1e40b6dcb20abeef52a961efbd69', '2020-05-19 08:08:54'),
(664, 3, 2, '750bf295bd84da478feb15a24aafd4f9', '2020-05-19 08:27:04'),
(665, 1, 1, 'c5200a38fca05be4af72bf7ec9e1bb8f', '2020-05-19 08:30:54'),
(666, 3, 2, '2b12a0f4c1e2be8e34c7f42bdf3294a5', '2020-05-19 13:19:50'),
(667, 1, 1, '17892c5850489a7487dec3e21fa70098', '2020-05-19 20:52:27'),
(668, 1, 1, '86ed1356142e776207399d9206c1f479', '2020-05-19 22:00:41'),
(671, 3, 2, 'ce0afd1a2c087f07d4d165780582c57a', '2020-05-20 08:29:41'),
(672, 3, 2, 'd5972b95b4ce268cbb8a4abcc3618c80', '2020-05-20 11:14:42'),
(673, 1, 1, 'cd8f3f38b49f8caadbdba0ad3d0c2303', '2020-05-20 20:36:34'),
(674, 3, 2, '3acecf8852e788574da75f0842e66ee9', '2020-05-20 21:01:45'),
(675, 1, 1, '7fa0a0d57d2087d0e1517171b2ca62b4', '2020-05-20 21:16:49'),
(676, 3, 2, 'a053758256e6dcab5f088b7905f7450c', '2020-05-21 09:23:06'),
(679, 1, 1, 'f3733bd6789fc612230a9d23912ec6d5', '2020-05-21 15:04:22'),
(680, 1, 1, 'c94e7bc93133692dfaf9a28bb9977f4c', '2020-05-21 15:17:49'),
(681, 5, 1, 'bbda81be85d48adbf1cce643fd9c96e8', '2020-05-21 15:25:04'),
(682, 3, 2, '7783efaca79ec3b07d66b06485bd5b13', '2020-05-22 15:25:08'),
(684, 1, 1, '1d29ff7cc9c092b2de3ba413abc64583', '2020-05-23 11:04:16'),
(685, 3, 2, 'f7aacc9a632629182f58241a1582dc47', '2020-05-23 11:40:59'),
(686, 1, 1, '34c6ba7f56aa38ff6fc92e45dbc5f4fd', '2020-05-23 18:34:11'),
(687, 1, 1, 'bf1c281e115988d0bb3540a6a812e3b7', '2020-05-23 21:06:16'),
(688, 3, 2, '5b994e03e15ef4ca0d85da5e4d58961b', '2020-05-23 21:07:40'),
(689, 1, 1, '24ec24b5499d3e6bebb9e1aee5202b97', '2020-05-23 21:09:36'),
(690, 1, 1, '1be78f694b96852eb23b50aee6af6297', '2020-05-23 21:10:21'),
(691, 1, 1, 'fd52eb2c20c4fea946180c309d185eb8', '2020-05-23 22:18:08'),
(693, 3, 2, '5258a22901b0fe319a401062f6bd05e9', '2020-05-23 23:38:37'),
(695, 1, 1, '892068355ef04eed6641e12402de4f02', '2020-05-24 12:25:54'),
(696, 1, 1, '1e075c58641bc13855553782d11ba097', '2020-05-24 18:57:05'),
(697, 1, 1, '3e634592c874ffaad2f172bcaa7aad1b', '2020-05-24 22:21:56'),
(699, 1, 1, '4845de55c8a8ab17ee5ad37510534777', '2020-05-25 09:48:06'),
(700, 1, 1, '77360dea45c19a7e649ead3fbfc00284', '2020-05-25 09:59:11'),
(701, 1, 1, '858f4ada1048ee10ba6ffe714dceb426', '2020-05-25 10:15:25'),
(702, 3, 2, '4e9e98b4a99634b740697f5417cd9721', '2020-05-25 10:52:51'),
(703, 1, 1, 'd800b655a8869159319f3e280ab5ddb2', '2020-05-25 11:20:15'),
(704, 1, 1, '38fc2088b6cd8b997f9d8ce71b35f8ae', '2020-05-25 11:37:45'),
(705, 1, 1, 'd0d80fd17b8bad18c2f2cc5a5283a966', '2020-05-25 12:23:19'),
(706, 1, 1, '17d5905fdb2bb668b6929be76412c152', '2020-05-25 12:31:15'),
(707, 1, 1, '36585dedd60c9182412519b67151e19b', '2020-05-25 12:43:34'),
(708, 1, 1, 'b9f49b8a5d3388fe0005ba465dccedd7', '2020-05-25 14:39:05'),
(709, 3, 2, '281b53946e2d764ac6c299b97f200b76', '2020-05-25 23:38:47'),
(710, 3, 2, '697e8bee2d5e5da238f8290b5d4bbaaf', '2020-05-26 11:40:46'),
(711, 1, 1, 'f136a32a0d60eafccbd694dd8c85a68e', '2020-05-26 12:25:11'),
(713, 4, 3, '6d62e3c91adb014400f4fec4b03b09ad', '2020-05-26 20:38:27'),
(716, 6, 4, '9b6bdc85b6cbd4f44248a00f25224d2f', '2020-05-26 22:07:46'),
(718, 4, 3, '4dd3cda566bac26dc405dc3512cc36cc', '2020-05-27 15:29:51'),
(719, 4, 3, '7712cbe573ccd6336e93efa6df72affa', '2020-05-27 21:30:22'),
(720, 3, 2, '568acc3822b41b0b03d52fc68c308eb8', '2020-05-28 16:52:05'),
(721, 6, 4, 'eef3a459c047ddf2a9c5fc2ba2cd7653', '2020-05-28 16:52:16'),
(722, 3, 2, '7ba4fbf98f823bb21b27cd7032912b71', '2020-05-29 15:15:58'),
(723, 3, 2, '5d559509c9071a69ff06c684f88823c8', '2020-05-31 11:00:56'),
(724, 1, 1, 'cfc5bb73c4aa5e02e1edcdc33085455e', '2020-05-31 23:03:13'),
(725, 1, 1, '09757b88e86da3cede94ed771d18da10', '2020-06-01 14:54:32'),
(726, 1, 1, '328c74645526719eb59097dcf4937aaf', '2020-06-03 22:09:20'),
(728, 4, 3, '6b4b11700aae9780850f6381a0fd435c', '2020-06-04 22:03:05'),
(729, 3, 2, '84eaa424ba82663c24bed4f3cdbae1e8', '2020-06-05 23:22:53'),
(730, 3, 2, 'fa24fe220fbf8626d8154c6f68280b46', '2020-06-07 22:42:14'),
(731, 6, 4, '233dfdce52eb8e7c6376c28621ebbd13', '2020-06-07 22:42:55'),
(732, 4, 3, 'ae7139b08d1014891f1dbb3e92ffb37b', '2020-06-09 10:34:49'),
(733, 3, 2, 'eb618645ac7f3bc48f715c5f96414251', '2020-06-09 19:36:35'),
(734, 4, 3, '167986782eb8df4752893d8e9aeee30b', '2020-06-09 21:15:02'),
(735, 1, 1, 'b6449fcfff5546fa29a31fd25838555d', '2020-06-09 21:32:33'),
(737, 1, 1, '5f3b1f9622cadaf8ffebee49350747d6', '2020-06-11 13:16:14'),
(738, 4, 3, '12354fbfb1aa7e4808950759d99eae47', '2020-06-11 13:22:46'),
(740, 3, 2, 'b50e4d6674a343295358d5b1ac68c5b5', '2020-06-12 21:45:43'),
(741, 4, 3, '8d78c5e9095106d504ee48a6b68c45b6', '2020-06-12 21:49:46'),
(742, 4, 3, '5c48a76a811d4a65c38d32b65fdf9147', '2020-06-12 22:04:25'),
(743, 1, 1, '8f4654b028fb75bf697540693d5ec673', '2020-06-12 22:07:09'),
(744, 1, 1, '592bcdec941e954ca4f3d771b5a0c030', '2020-06-12 22:27:09'),
(745, 3, 2, '96dacfdbfac550b4b9c0b15300cda177', '2020-06-13 22:03:40'),
(746, 3, 2, 'ca9dfca0c78f8b08ea1189c337ca3b1d', '2020-06-14 15:22:23'),
(748, 6, 4, '700a8fdffd26074325ba4ede1967610a', '2020-06-14 15:33:13'),
(749, 3, 2, '1174b4f2d56e918db855f866bade495c', '2020-06-15 10:04:38'),
(750, 3, 2, '9109c61c6aaf20b111c40c837d28ac5d', '2020-06-17 21:06:07'),
(751, 6, 4, '5ff526a8e2cf87614dfe4add780614fe', '2020-07-18 13:11:18'),
(752, 6, 4, '793c5d332153530a877c24c1bfa75f49', '2020-08-06 21:48:24'),
(753, 6, 4, 'a12c8f35fea7e8fb0780517c7b4a1a43', '2020-08-24 14:39:11'),
(754, 1, 1, 'ad7af035e52f37a0151083a40001057e', '2020-08-25 20:39:17'),
(755, 6, 4, 'dfdd56b38de646c9bfca4cc3ffd5f65b', '2020-09-01 10:49:25'),
(757, 6, 4, '2feb760602a78f5120f12f3236f13c36', '2020-09-01 10:50:13'),
(758, 6, 4, '9269b085a576587a8bf6b103895b3878', '2020-09-01 10:52:14'),
(759, 6, 4, '37ad517c340821e58260a0d1e2cefaea', '2020-09-01 10:53:16'),
(762, 1, 1, 'd7f65349fc7dc34f70f110bd965f6367', '2020-11-03 22:19:11'),
(763, 6, 4, '172993bd14371d7b88d29cce485731f1', '2020-11-09 20:53:42'),
(764, 6, 4, '109a2330f106824a3c7a1571faf1d140', '2020-11-14 10:55:19'),
(765, 6, 4, '81b9625c5c9a21377b2b93c9ef0bdd20', '2020-12-01 21:08:49'),
(766, 1, 1, '6c25154744e75a8dff464769e7805cec', '2020-12-05 17:21:27'),
(768, 4, 3, '90c02be8fa87bb43086ed1ec034d9fa7', '2020-12-13 19:55:51'),
(769, 4, 3, '6be8ecd95d7ef93131663b3d52a83881', '2020-12-13 19:57:11'),
(770, 1, 1, 'dd0c1ae8b1ff7a15ad06b00940f0ef8d', '2021-06-15 08:57:56'),
(771, 6, 4, 'f0f54ffebe1f4f7419415dcde7abe642', '2021-08-07 18:55:27'),
(772, 6, 4, '380655304ed1dc445c06022e7374b188', '2021-08-14 10:26:51');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `student`
--

CREATE TABLE `student` (
  `PK_Student` int UNSIGNED NOT NULL,
  `FK_School` int UNSIGNED NOT NULL,
  `FK_Class` int UNSIGNED NOT NULL,
  `Firstname` varchar(255) DEFAULT NULL,
  `Lastname` varchar(255) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Gender` int NOT NULL,
  `Notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `student`
--

INSERT INTO `student` (`PK_Student`, `FK_School`, `FK_Class`, `Firstname`, `Lastname`, `Birthday`, `Gender`, `Notes`) VALUES
(3, 1, 54, 'Klaus', 'Peter', '2008-01-01', 0, ''),
(13, 2, 62, 'Anna', 'Ast', '2014-06-10', 0, ''),
(14, 2, 62, 'Bernd', 'Brot', '2014-03-01', 0, ''),
(15, 2, 62, 'Christian', 'Christ', '2015-10-23', 0, ''),
(16, 2, 62, 'Doreen', 'Dach', '2014-01-31', 0, ''),
(17, 2, 62, 'Eva', 'Esel', '2014-10-15', 0, ''),
(18, 2, 62, 'Fabian', 'Fuchs', '2015-07-05', 0, ''),
(19, 2, 62, 'Gus', 'Groß', '2014-10-20', 0, ''),
(20, 2, 62, 'Henrietta', 'Henkel', '2015-09-09', 0, ''),
(21, 2, 62, 'Justin', 'Just', '2014-12-21', 0, ''),
(22, 2, 62, 'Kevin', 'Klein', '2015-04-10', 0, ''),
(23, 2, 62, 'Luna', 'Luchs', '2014-07-12', 0, ''),
(24, 2, 62, 'Markus', 'Mann', '2015-09-10', 0, ''),
(25, 2, 62, 'Nina', 'Nuhr', '2015-07-17', 0, ''),
(27, 2, 62, 'Peter', 'Pfanne', '2014-12-12', 0, ''),
(28, 2, 62, 'Randolf', 'Rast', '2015-05-23', 0, ''),
(31, 2, 63, 'Amir', 'Voß', '2015-09-03', 0, ''),
(32, 1, 64, 'Peter', 'Maffay', '1909-01-22', 0, ''),
(33, 1, 64, 'Allahu', 'Agba', '2009-05-01', 0, ''),
(34, 2, 63, 'Bernd', 'Brot', '2015-04-03', 0, ''),
(35, 2, 63, 'Cornelius', 'Christ', '2015-12-05', 0, ''),
(36, 2, 67, 'Thomas', 'Tanne', '2014-12-03', 0, ''),
(37, 2, 67, 'Fabian', 'Fuchs', '2014-09-12', 0, ''),
(38, 2, 67, 'Jan', 'Junge', '2012-01-15', 0, ''),
(41, 2, 62, 'Sebastian', 'See', '2016-05-04', 0, ''),
(44, 2, 62, 'Thomas', 'Tanne', '2016-12-03', 0, ''),
(45, 2, 62, 'Waldemar', 'Wald', '2016-04-04', 0, ''),
(46, 1, 70, 'Eray', 'Erol', '2012-04-03', 0, ''),
(47, 1, 70, 'Klaus', 'Schröder', '2009-02-01', 0, ''),
(48, 2, 62, 'Nick', 'Nuss', '2016-01-13', 0, ''),
(49, 2, 62, 'Uwe', 'Usedom', '2016-03-21', 0, ''),
(54, 2, 78, 'Anton', 'Amsel', '2012-05-20', 0, ''),
(55, 1, 54, 'asdf', 'asdf', '1993-01-01', 0, ''),
(56, 1, 54, 'Klaus', 'Dieter', '2005-02-03', 0, ''),
(57, 1, 70, 'Lisa', 'Lustig', '2009-01-01', 0, ''),
(58, 3, 79, 'Paul', 'Panther', '2005-01-01', 0, ''),
(59, 3, 79, 'Klaus', 'Dieter', '1990-03-01', 0, ''),
(60, 3, 79, 'Klaus', 'Dieter', '2009-01-01', 0, ''),
(61, 4, 81, 'Bernd', 'Brot', '2014-05-04', 0, ''),
(62, 4, 80, 'Alice', 'Wunderland', '2014-10-01', 0, ''),
(63, 4, 82, 'Christian', 'Christ', '2014-09-12', 0, ''),
(64, 3, 83, 'Eray', 'Erol', '2007-01-01', 0, ''),
(65, 3, 83, 'Peter', 'Lustig', '1999-02-01', 0, ''),
(66, 1, 84, 'Peter', 'Lustig', '1993-01-01', 0, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `student_template_settings`
--

CREATE TABLE `student_template_settings` (
  `PK_Student_Template_Settings` int UNSIGNED NOT NULL,
  `FK_Student` int UNSIGNED NOT NULL,
  `FK_Template_Settings_Value` int UNSIGNED NOT NULL,
  `FK_School_Template` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `student_template_settings`
--

INSERT INTO `student_template_settings` (`PK_Student_Template_Settings`, `FK_Student`, `FK_Template_Settings_Value`, `FK_School_Template`) VALUES
(1, 54, 31, 1),
(2, 55, 37, 1),
(3, 55, 38, 1),
(4, 13, 39, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `templates`
--

CREATE TABLE `templates` (
  `PK_Templates` int UNSIGNED NOT NULL,
  `FK_Student` int UNSIGNED NOT NULL,
  `FK_Class` int UNSIGNED NOT NULL,
  `FK_School` int UNSIGNED NOT NULL,
  `Template_c` blob,
  `Template_json` blob,
  `Date_Changed` datetime DEFAULT NULL,
  `Class_Level` tinyint(1) NOT NULL DEFAULT '1',
  `Is_Halfyear` tinyint(1) NOT NULL DEFAULT '0',
  `FK_School_Template` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `templates`
--

INSERT INTO `templates` (`PK_Templates`, `FK_Student`, `FK_Class`, `FK_School`, `Template_c`, `Template_json`, `Date_Changed`, `Class_Level`, `Is_Halfyear`, `FK_School_Template`) VALUES
(361, 34, 63, 2, 0x613a373a7b693a303b693a3336313b693a313b733a36303a224265726e64206861742065696e656e20736f7a69616c656e20556d67616e67206d6974207365696e656e204d69747363682675756d6c3b6c65726e2e223b693a323b733a33303a224265726e6420656e747769636b656c74207369636820706f73697469762e223b693a333b693a313b693a343b693a323b693a353b613a33393a7b733a33303a22646575747363685f726563687473636872656962756e675f726567656c6e223b733a313a2233223b733a33353a22646575747363685f726563687473636872656962756e675f68696c66736d697474656c223b733a313a2234223b733a33323a22646575747363685f726563687473636872656962756e675f666f726d6b6c6172223b733a313a2233223b733a32393a22646575747363685f726563687473636872656962756e675f746166656c223b733a313a2234223b733a33343a22646575747363685f73707261636867656272617563685f666f726d756c696572656e223b733a313a2234223b733a33333a22646575747363685f73707261636867656272617563685f67657370726165636865223b733a313a2234223b733a34303a22646575747363685f73707261636867656272617563685f736974756174696f6e7367657265636874223b733a313a2233223b733a32333a22646575747363685f6c6573656e5f766f7274726167656e223b733a313a2234223b733a32373a22646575747363685f6c6573656e5f696e666f726d6174696f6e656e223b733a313a2234223b733a32353a22646575747363685f6c6573656e5f616e77656973756e67656e223b733a313a2233223b733a32373a226d617468655f616e616c7974697363685f7374726174656769656e223b733a313a2233223b733a32393a226d617468655f616e616c7974697363685f7361636876657268616c7465223b733a313a2234223b733a32383a226d617468655f616e616c7974697363685f66616368776f6572746572223b733a313a2233223b733a32323a226d617468655f7a61686c656e5f6d696c6c696f6e656e223b733a313a2233223b733a32353a226d617468655f7a61686c656e5f6265726563686e756e67656e223b733a313a2234223b733a32323a226d617468655f7a61686c656e5f65696e68656974656e223b733a313a2234223b733a32343a226d617468655f7a61686c656e5f6b6f7066726563686e656e223b733a313a2232223b733a32343a226d617468655f67656f6d65747269655f62656e656e6e656e223b733a313a2234223b733a32343a226d617468655f67656f6d65747269655f666c61656368656e223b733a313a2233223b733a33313a226d617468655f67656f6d65747269655f7261756d766f727374656c6c756e67223b733a313a2233223b733a33373a2273616368756e74657272696368745f696e666f726d6174696f6e656e5f62657a696568656e223b733a313a2234223b733a32383a2273616368756e74657272696368745f7468656d656e67656269657465223b733a313a2233223b733a32373a2273616368756e74657272696368745f617262656974736d61707065223b733a313a2232223b733a32333a22657468696b5f6f6666656e5f72657370656b74766f6c6c223b733a313a2233223b733a33313a22657468696b5f6661656869676b656974656e5f65696e7363686165747a656e223b733a313a2232223b733a32313a22657468696b5f6d65696e756e675f616e6465726572223b733a313a2232223b733a32363a22657468696b5f756e74657272696368745f67657374616c74656e223b733a313a2231223b733a32333a22657468696b5f616e646572655f65696e667565686c656e223b733a313a2233223b733a32333a226b756e73745f617566676162656e5f756d7365747a656e223b733a313a2232223b733a32303a226b756e73745f696465656e5f756d7365747a656e223b733a313a2231223b733a31363a226b756e73745f6265676569737465726e223b733a313a2231223b733a31343a226d7573696b5f72687974686d7573223b733a313a2232223b733a32313a226d7573696b5f6d7573696b7269636874756e67656e223b733a313a2231223b733a32373a226d7573696b5f6b75656e73746c65725f696e737472756d656e7465223b733a313a2231223b733a31363a226d7573696b5f6461727374656c6c656e223b733a313a2231223b733a31323a2273706f72745f726567656c6e223b733a313a2234223b733a33303a2273706f72745f616e737472656e67756e6773626572656974736368616674223b733a313a2234223b733a31353a2273706f72745f6b6f6e646974696f6e223b733a313a2234223b733a32353a2273706f72745f6265776567756e67737265706572746f697265223b733a313a2234223b7d693a363b613a373a7b733a31333a2267726164655f64657574736368223b733a313a2232223b733a31313a2267726164655f6d61746865223b733a313a2232223b733a32303a2267726164655f73616368756e7465727269636874223b733a313a2234223b733a31313a2267726164655f657468696b223b733a313a2231223b733a31313a2267726164655f6b756e7374223b733a313a2231223b733a31313a2267726164655f6d7573696b223b733a313a2236223b733a31313a2267726164655f73706f7274223b733a313a2231223b7d7d, NULL, '2020-06-15 10:25:30', 4, 0, 4),
(362, 13, 62, 2, 0x613a31363a7b693a303b693a3336323b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a33363a22617364663c212d2d2070616765627265616b202d2d3e3c6272202f3e6c6b266f756d6c3b223b693a383b733a33363a22416e6e61206973742073696368657220696e20576f727420756e6420536368726966742e223b693a393b733a37323a22416e6e61207a6569677420566572737426616d703b61756d6c3b6e646e6973206626616d703b75756d6c3b72206d617468656d61746973636865205361636876657268616c74652e223b693a31303b733a36353a22416e6e61207a6569677420496e7465726573736520616e2065746869736368656e20756e642072656c69676926616d703b6f756d6c3b73656e205468656d656e2e223b693a31313b733a31393a22416e6e61206973742073706f72746c6963682e223b693a31323b733a34393a22416e6e61206e696d6d7420616d20556e746572726963687420646572207a77656974656e204b6c61737365207465696c2e223b693a31333b733a32393a22416e6e6120656e747769636b656c74207369636820706f73697469762e223b693a31343b693a333b693a31353b693a353b7d, NULL, '2020-06-17 21:07:16', 1, 0, 1),
(363, 35, 63, 2, 0x613a373a7b693a303b693a3336333b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a33393a7b733a33303a22646575747363685f726563687473636872656962756e675f726567656c6e223b693a2d313b733a33353a22646575747363685f726563687473636872656962756e675f68696c66736d697474656c223b693a2d313b733a33323a22646575747363685f726563687473636872656962756e675f666f726d6b6c6172223b693a2d313b733a32393a22646575747363685f726563687473636872656962756e675f746166656c223b693a2d313b733a33343a22646575747363685f73707261636867656272617563685f666f726d756c696572656e223b693a2d313b733a33333a22646575747363685f73707261636867656272617563685f67657370726165636865223b693a2d313b733a34303a22646575747363685f73707261636867656272617563685f736974756174696f6e7367657265636874223b693a2d313b733a32333a22646575747363685f6c6573656e5f766f7274726167656e223b693a2d313b733a32373a22646575747363685f6c6573656e5f696e666f726d6174696f6e656e223b693a2d313b733a32353a22646575747363685f6c6573656e5f616e77656973756e67656e223b693a2d313b733a32373a226d617468655f616e616c7974697363685f7374726174656769656e223b693a2d313b733a32393a226d617468655f616e616c7974697363685f7361636876657268616c7465223b693a2d313b733a32383a226d617468655f616e616c7974697363685f66616368776f6572746572223b693a2d313b733a32323a226d617468655f7a61686c656e5f6d696c6c696f6e656e223b693a2d313b733a32353a226d617468655f7a61686c656e5f6265726563686e756e67656e223b693a2d313b733a32323a226d617468655f7a61686c656e5f65696e68656974656e223b693a2d313b733a32343a226d617468655f7a61686c656e5f6b6f7066726563686e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f62656e656e6e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f666c61656368656e223b693a2d313b733a33313a226d617468655f67656f6d65747269655f7261756d766f727374656c6c756e67223b693a2d313b733a33373a2273616368756e74657272696368745f696e666f726d6174696f6e656e5f62657a696568656e223b693a2d313b733a32383a2273616368756e74657272696368745f7468656d656e67656269657465223b693a2d313b733a32373a2273616368756e74657272696368745f617262656974736d61707065223b693a2d313b733a32333a22657468696b5f6f6666656e5f72657370656b74766f6c6c223b693a2d313b733a33313a22657468696b5f6661656869676b656974656e5f65696e7363686165747a656e223b693a2d313b733a32313a22657468696b5f6d65696e756e675f616e6465726572223b693a2d313b733a32363a22657468696b5f756e74657272696368745f67657374616c74656e223b693a2d313b733a32333a22657468696b5f616e646572655f65696e667565686c656e223b693a2d313b733a32333a226b756e73745f617566676162656e5f756d7365747a656e223b693a2d313b733a32303a226b756e73745f696465656e5f756d7365747a656e223b693a2d313b733a31363a226b756e73745f6265676569737465726e223b693a2d313b733a31343a226d7573696b5f72687974686d7573223b693a2d313b733a32313a226d7573696b5f6d7573696b7269636874756e67656e223b693a2d313b733a32373a226d7573696b5f6b75656e73746c65725f696e737472756d656e7465223b693a2d313b733a31363a226d7573696b5f6461727374656c6c656e223b693a2d313b733a31323a2273706f72745f726567656c6e223b693a2d313b733a33303a2273706f72745f616e737472656e67756e6773626572656974736368616674223b693a2d313b733a31353a2273706f72745f6b6f6e646974696f6e223b693a2d313b733a32353a2273706f72745f6265776567756e67737265706572746f697265223b693a2d313b7d693a363b613a373a7b733a31333a2267726164655f64657574736368223b693a2d313b733a31313a2267726164655f6d61746865223b693a2d313b733a32303a2267726164655f73616368756e7465727269636874223b693a2d313b733a31313a2267726164655f657468696b223b693a2d313b733a31313a2267726164655f6b756e7374223b693a2d313b733a31313a2267726164655f6d7573696b223b693a2d313b733a31313a2267726164655f73706f7274223b693a2d313b7d7d, NULL, '2020-05-26 20:05:43', 4, 0, 4),
(365, 37, 67, 2, 0x613a363a7b693a303b693a3336353b693a313b733a33323a2246616269616e20766572682661756d6c3b6c74207369636820736f7a69616c2e223b693a323b733a32313a2246616269616e2069737420656e676167696572742e223b693a333b693a333b693a343b693a323b693a353b613a393a7b733a31313a2267726164655f6d61746865223b733a313a2233223b733a31333a2267726164655f64657574736368223b733a313a2232223b733a31343a2267726164655f656e676c69736368223b733a313a2233223b733a31313a2267726164655f657468696b223b733a313a2235223b733a32303a2267726164655f73616368756e7465727269636874223b733a313a2234223b733a31313a2267726164655f6d7573696b223b733a313a2236223b733a31313a2267726164655f73706f7274223b733a313a2231223b733a31313a2267726164655f6b756e7374223b733a313a2232223b733a31333a2267726164655f73636872696674223b733a313a2233223b7d7d, NULL, '2020-06-17 21:06:32', 3, 0, 4),
(366, 38, 67, 2, 0x613a363a7b693a303b693a3336363b693a313b733a31353a224a616e2069737420736f7a69616c2e223b693a323b733a32343a224a616e20656e747769636b656c742073696368206775742e223b693a333b693a313b693a343b693a303b693a353b613a393a7b733a31313a2267726164655f6d61746865223b733a313a2231223b733a31333a2267726164655f64657574736368223b733a313a2232223b733a31343a2267726164655f656e676c69736368223b733a313a2233223b733a31313a2267726164655f657468696b223b733a313a2235223b733a32303a2267726164655f73616368756e7465727269636874223b733a313a2234223b733a31313a2267726164655f6d7573696b223b733a313a2233223b733a31313a2267726164655f73706f7274223b733a313a2231223b733a31313a2267726164655f6b756e7374223b733a313a2232223b733a31333a2267726164655f73636872696674223b733a313a2233223b7d7d, NULL, '2020-05-22 15:37:37', 3, 0, 4),
(367, 14, 62, 2, 0x613a31363a7b693a303b693a3336373b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:07', 1, 0, 1),
(373, 21, 62, 2, 0x613a31363a7b693a303b693a3337333b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:08', 1, 0, 1),
(374, 22, 62, 2, 0x613a31363a7b693a303b693a3337343b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:08', 1, 0, 1),
(383, 54, 78, 2, 0x613a31363a7b693a303b693a3338333b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a343a2261736466223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-06-14 15:32:14', 2, 0, 1),
(384, 54, 78, 2, 0x613a373a7b693a303b693a3338343b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a33393a7b733a33303a22646575747363685f726563687473636872656962756e675f726567656c6e223b693a2d313b733a33353a22646575747363685f726563687473636872656962756e675f68696c66736d697474656c223b693a2d313b733a33323a22646575747363685f726563687473636872656962756e675f666f726d6b6c6172223b693a2d313b733a32393a22646575747363685f726563687473636872656962756e675f746166656c223b693a2d313b733a33343a22646575747363685f73707261636867656272617563685f666f726d756c696572656e223b693a2d313b733a33333a22646575747363685f73707261636867656272617563685f67657370726165636865223b693a2d313b733a34303a22646575747363685f73707261636867656272617563685f736974756174696f6e7367657265636874223b693a2d313b733a32333a22646575747363685f6c6573656e5f766f7274726167656e223b693a2d313b733a32373a22646575747363685f6c6573656e5f696e666f726d6174696f6e656e223b693a2d313b733a32353a22646575747363685f6c6573656e5f616e77656973756e67656e223b693a2d313b733a32373a226d617468655f616e616c7974697363685f7374726174656769656e223b693a2d313b733a32393a226d617468655f616e616c7974697363685f7361636876657268616c7465223b693a2d313b733a32383a226d617468655f616e616c7974697363685f66616368776f6572746572223b693a2d313b733a32323a226d617468655f7a61686c656e5f6d696c6c696f6e656e223b693a2d313b733a32353a226d617468655f7a61686c656e5f6265726563686e756e67656e223b693a2d313b733a32323a226d617468655f7a61686c656e5f65696e68656974656e223b693a2d313b733a32343a226d617468655f7a61686c656e5f6b6f7066726563686e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f62656e656e6e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f666c61656368656e223b693a2d313b733a33313a226d617468655f67656f6d65747269655f7261756d766f727374656c6c756e67223b693a2d313b733a33373a2273616368756e74657272696368745f696e666f726d6174696f6e656e5f62657a696568656e223b693a2d313b733a32383a2273616368756e74657272696368745f7468656d656e67656269657465223b693a2d313b733a32373a2273616368756e74657272696368745f617262656974736d61707065223b693a2d313b733a32333a22657468696b5f6f6666656e5f72657370656b74766f6c6c223b693a2d313b733a33313a22657468696b5f6661656869676b656974656e5f65696e7363686165747a656e223b693a2d313b733a32313a22657468696b5f6d65696e756e675f616e6465726572223b693a2d313b733a32363a22657468696b5f756e74657272696368745f67657374616c74656e223b693a2d313b733a32333a22657468696b5f616e646572655f65696e667565686c656e223b693a2d313b733a32333a226b756e73745f617566676162656e5f756d7365747a656e223b693a2d313b733a32303a226b756e73745f696465656e5f756d7365747a656e223b693a2d313b733a31363a226b756e73745f6265676569737465726e223b693a2d313b733a31343a226d7573696b5f72687974686d7573223b693a2d313b733a32313a226d7573696b5f6d7573696b7269636874756e67656e223b693a2d313b733a32373a226d7573696b5f6b75656e73746c65725f696e737472756d656e7465223b693a2d313b733a31363a226d7573696b5f6461727374656c6c656e223b693a2d313b733a31323a2273706f72745f726567656c6e223b693a2d313b733a33303a2273706f72745f616e737472656e67756e6773626572656974736368616674223b693a2d313b733a31353a2273706f72745f6b6f6e646974696f6e223b693a2d313b733a32353a2273706f72745f6265776567756e67737265706572746f697265223b693a2d313b7d693a363b613a373a7b733a31333a2267726164655f64657574736368223b693a2d313b733a31313a2267726164655f6d61746865223b693a2d313b733a32303a2267726164655f73616368756e7465727269636874223b693a2d313b733a31313a2267726164655f657468696b223b693a2d313b733a31313a2267726164655f6b756e7374223b693a2d313b733a31313a2267726164655f6d7573696b223b693a2d313b733a31313a2267726164655f73706f7274223b693a2d313b7d7d, NULL, '2020-05-20 12:07:53', 2, 1, 4),
(387, 17, 62, 2, 0x613a31363a7b693a303b693a3338373b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:07', 1, 0, 1),
(388, 41, 62, 2, 0x613a31363a7b693a303b693a3338383b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:09', 1, 0, 1),
(389, 44, 62, 2, 0x613a31363a7b693a303b693a3338393b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:10', 1, 0, 1),
(391, 15, 62, 2, 0x613a31363a7b693a303b693a3339313b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:07', 1, 0, 1),
(392, 16, 62, 2, 0x613a31363a7b693a303b693a3339323b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:07', 1, 0, 1),
(393, 18, 62, 2, 0x613a31363a7b693a303b693a3339333b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:07', 1, 0, 1),
(394, 19, 62, 2, 0x613a31363a7b693a303b693a3339343b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:08', 1, 0, 1),
(395, 20, 62, 2, 0x613a31363a7b693a303b693a3339353b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:08', 1, 0, 1),
(396, 23, 62, 2, 0x613a31363a7b693a303b693a3339363b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:08', 1, 0, 1),
(397, 24, 62, 2, 0x613a31363a7b693a303b693a3339373b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:08', 1, 0, 1),
(398, 25, 62, 2, 0x613a31363a7b693a303b693a3339383b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:09', 1, 0, 1),
(399, 48, 62, 2, 0x613a31363a7b693a303b693a3339393b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:09', 1, 0, 1),
(400, 27, 62, 2, 0x613a31363a7b693a303b693a3430303b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:09', 1, 0, 1),
(401, 28, 62, 2, 0x613a31363a7b693a303b693a3430313b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:09', 1, 0, 1),
(402, 49, 62, 2, 0x613a31363a7b693a303b693a3430323b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:10', 1, 0, 1),
(403, 45, 62, 2, 0x613a31363a7b693a303b693a3430333b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 11:32:10', 1, 0, 1),
(404, 31, 63, 2, 0x613a373a7b693a303b693a3430343b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a33393a7b733a33303a22646575747363685f726563687473636872656962756e675f726567656c6e223b733a313a2234223b733a33353a22646575747363685f726563687473636872656962756e675f68696c66736d697474656c223b693a2d313b733a33323a22646575747363685f726563687473636872656962756e675f666f726d6b6c6172223b693a2d313b733a32393a22646575747363685f726563687473636872656962756e675f746166656c223b693a2d313b733a33343a22646575747363685f73707261636867656272617563685f666f726d756c696572656e223b693a2d313b733a33333a22646575747363685f73707261636867656272617563685f67657370726165636865223b693a2d313b733a34303a22646575747363685f73707261636867656272617563685f736974756174696f6e7367657265636874223b693a2d313b733a32333a22646575747363685f6c6573656e5f766f7274726167656e223b693a2d313b733a32373a22646575747363685f6c6573656e5f696e666f726d6174696f6e656e223b693a2d313b733a32353a22646575747363685f6c6573656e5f616e77656973756e67656e223b693a2d313b733a32373a226d617468655f616e616c7974697363685f7374726174656769656e223b693a2d313b733a32393a226d617468655f616e616c7974697363685f7361636876657268616c7465223b693a2d313b733a32383a226d617468655f616e616c7974697363685f66616368776f6572746572223b693a2d313b733a32323a226d617468655f7a61686c656e5f6d696c6c696f6e656e223b693a2d313b733a32353a226d617468655f7a61686c656e5f6265726563686e756e67656e223b693a2d313b733a32323a226d617468655f7a61686c656e5f65696e68656974656e223b693a2d313b733a32343a226d617468655f7a61686c656e5f6b6f7066726563686e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f62656e656e6e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f666c61656368656e223b693a2d313b733a33313a226d617468655f67656f6d65747269655f7261756d766f727374656c6c756e67223b693a2d313b733a33373a2273616368756e74657272696368745f696e666f726d6174696f6e656e5f62657a696568656e223b693a2d313b733a32383a2273616368756e74657272696368745f7468656d656e67656269657465223b693a2d313b733a32373a2273616368756e74657272696368745f617262656974736d61707065223b693a2d313b733a32333a22657468696b5f6f6666656e5f72657370656b74766f6c6c223b693a2d313b733a33313a22657468696b5f6661656869676b656974656e5f65696e7363686165747a656e223b693a2d313b733a32313a22657468696b5f6d65696e756e675f616e6465726572223b693a2d313b733a32363a22657468696b5f756e74657272696368745f67657374616c74656e223b693a2d313b733a32333a22657468696b5f616e646572655f65696e667565686c656e223b693a2d313b733a32333a226b756e73745f617566676162656e5f756d7365747a656e223b693a2d313b733a32303a226b756e73745f696465656e5f756d7365747a656e223b693a2d313b733a31363a226b756e73745f6265676569737465726e223b693a2d313b733a31343a226d7573696b5f72687974686d7573223b693a2d313b733a32313a226d7573696b5f6d7573696b7269636874756e67656e223b693a2d313b733a32373a226d7573696b5f6b75656e73746c65725f696e737472756d656e7465223b693a2d313b733a31363a226d7573696b5f6461727374656c6c656e223b693a2d313b733a31323a2273706f72745f726567656c6e223b693a2d313b733a33303a2273706f72745f616e737472656e67756e6773626572656974736368616674223b693a2d313b733a31353a2273706f72745f6b6f6e646974696f6e223b693a2d313b733a32353a2273706f72745f6265776567756e67737265706572746f697265223b693a2d313b7d693a363b613a373a7b733a31333a2267726164655f64657574736368223b733a323a222d31223b733a31313a2267726164655f6d61746865223b733a323a222d31223b733a32303a2267726164655f73616368756e7465727269636874223b733a323a222d31223b733a31313a2267726164655f657468696b223b733a323a222d31223b733a31313a2267726164655f6b756e7374223b733a323a222d31223b733a31313a2267726164655f6d7573696b223b733a323a222d31223b733a31313a2267726164655f73706f7274223b733a323a222d31223b7d7d, NULL, '2020-05-26 11:29:05', 4, 0, 4),
(407, 36, 67, 2, 0x613a363a7b693a303b693a3430373b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a393a7b733a31313a2267726164655f6d61746865223b733a323a222d31223b733a31333a2267726164655f64657574736368223b733a323a222d31223b733a31343a2267726164655f656e676c69736368223b733a323a222d31223b733a31313a2267726164655f657468696b223b733a323a222d31223b733a32303a2267726164655f73616368756e7465727269636874223b733a323a222d31223b733a31313a2267726164655f6d7573696b223b733a323a222d31223b733a31313a2267726164655f73706f7274223b733a323a222d31223b733a31313a2267726164655f6b756e7374223b733a323a222d31223b733a31333a2267726164655f73636872696674223b733a323a222d31223b7d7d, NULL, '2020-05-25 12:42:06', 3, 0, 4),
(409, 55, 54, 1, 0x613a31313a7b693a303b693a3430393b693a313b733a303a22223b693a323b733a3132373a224b6c617573204469657465722076657268266f756d6c3b6c7420736963682073746568747320756e617566662661756d6c3b6c6c69672e3c6272202f3e3c7370616e207374796c653d22666f6e742d73697a653a20313870743b223e45722067656874206e696520616c6c65696e2061756673204b6c6f3c2f7370616e3e2e223b693a333b733a343a2261736466223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b693a303b693a31303b693a303b7d, NULL, '2020-06-12 22:27:26', 1, 0, 1),
(410, 59, 79, 3, 0x613a363a7b693a303b693a3431303b693a313b733a303a22223b693a323b733a303a22223b693a333b733a313139303a223c646976207374796c653d22746578742d616c69676e3a206a7573746966793b223e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e4c6175726120662675756d6c3b67746520736963682067757420696e20646965204b6c617373656e67656d65696e7363686166742065696e2e205369652062656765676e65746520696872656e203c6272202f3e4d69747363682675756d6c3b6c6572696e6e656e203c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e756e64204d69747363682675756d6c3b6c65726e206f6666656e20756e6420667265756e646c6963682c20736965206b6f6e6e746520616e646572656e207a7568266f756d6c3b72656e20756e6420646572656e204d65696e756e6720616b3c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e7a657074696572656e2c206162657220617563682073656c627374626577757373742069687265204d65696e756e672076657274726574656e2e204c61757261207a65696774652073696368206c65726e77696c6c696720756e64203c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e736568722062656d2675756d6c3b6874206968726520417566676162656e20676577697373656e68616674207a752065726c65646967656e2e20526567656c6d2661756d6c3b26737a6c69673b69672c2065696672696720756e64206d697420496e74657265737365203c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e6e61686d2073696520616d20556e74657272696368747367657363686568656e207465696c2e205369652062726163687465204b656e6e746e6973736520696e2064656e20556e74657272696368742065696e2c2064696520736965203c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e617526737a6c69673b657268616c622064657220536368756c65206765776f6e6e656e2068617474652e2056657265696e626172756e67656e206f64657220536368756c2d20756e64204b6c617373656e6f72646e756e67206869656c74203c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e7369652073746574732065696e2e204e65756520556e746572726963687473696e68616c746520756e64205361636876657268616c7465206661737374652073696520696e2064657220526567656c206c6569636874206175662e203c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e4c617572612066726167746520766f6e207369636820617573206e616368205a757361747a696e666f726d6174696f6e656e2c2077656e6e207369652067656c6567656e746c6963682065696e6520417566676162656e3c2f7370616e3e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e7374656c6c756e67206e696368742061756620416e68696562207665727374616e64656e2068617474652e3c2f7370616e3e3c2f6469763e223b693a343b733a313031363a223c646976207374796c653d22746578742d616c69676e3a206a7573746966793b223e3c7370616e207374796c653d22666f6e742d73697a653a20313270743b223e4c6175726120686174206d69742048696c66652064657220416e6c617574746162656c6c6520646965204275636873746162656e20756e64206469652064617a75676568266f756d6c3b726e64656e204c61757465207265636874207a2675756d6c3b6769672067656c65726e742e20536965206b616e6e20696e7a7769736368656e2065696e666163686520546578746520666c696526737a6c69673b656e6420756e64206265746f6e7420766f726c6573656e2c20772661756d6c3b6872656e642073696520626569207363687769657269676572656e2057266f756d6c3b727465726e206d616e63686d616c2065747761732073746f636b742e204c617574676574726575652057266f756d6c3b7274657220756e6420532661756d6c3b747a6520736368726569627420736965207363686f6e206f6674206f686e204665686c65722e2045696e6967652067656c65726e746520526563687473636872656962726567656c6e2077656e64657420736965206265726569747320616e2e20496872205363687269667462696c6420697374206d616e63686d616c206e6f636820657477617320756e676c656963686d2661756d6c3b26737a6c69673b69672e2053696520682661756d6c3b6c742064696520536368726569626c696e69656e206e6963687420696d6d65722067656e61752067656e75672065696e2e204c6175726120766572662675756d6c3b6774202675756d6c3b6265722065696e656e20756d66616e677265696368656e20576f727473636861667420756e6420736965206b616e6e206d6974207669656c2046616e746173696520656967656e6520476573636869636874656e2073636872656962656e2e3c6272202f3e496e204d617468656d6174696b2062656865727273636874204c617572612064656e205a61686c656e7261756d206269732032302e2053696520726563686e65742073696368657220756e6420696e20616e67656d657373656e656d2054656d6f2064696520506c75732d2c20756e64204d696e75732d20756e64204572672661756d6c3b6e7a756e6773617566676162656e2e3c6272202f3e44656d2053616368756e746572726963687420666f6c6774204c61757261206d697420496e746572657373652e205369652065726b656e6e74207363686e656c6c205a7573616d6d656e682661756d6c3b6e676520756e64206265682661756d6c3b6c7420617563682045696e7a656c6568656974656e20696d204765642661756d6c3b6368746e69732e3c6272202f3e3c2f7370616e3e3c2f6469763e223b693a353b733a363a222d2d2d2d2d2d223b7d, NULL, '2020-12-13 20:33:31', 1, 0, 1),
(411, 62, 80, 4, 0x613a31363a7b693a303b693a3431313b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2021-08-14 10:29:13', 1, 0, 1),
(412, 61, 81, 4, 0x613a373a7b693a303b693a3431323b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a33393a7b733a33303a22646575747363685f726563687473636872656962756e675f726567656c6e223b693a2d313b733a33353a22646575747363685f726563687473636872656962756e675f68696c66736d697474656c223b693a2d313b733a33323a22646575747363685f726563687473636872656962756e675f666f726d6b6c6172223b693a2d313b733a32393a22646575747363685f726563687473636872656962756e675f746166656c223b693a2d313b733a33343a22646575747363685f73707261636867656272617563685f666f726d756c696572656e223b693a2d313b733a33333a22646575747363685f73707261636867656272617563685f67657370726165636865223b693a2d313b733a34303a22646575747363685f73707261636867656272617563685f736974756174696f6e7367657265636874223b693a2d313b733a32333a22646575747363685f6c6573656e5f766f7274726167656e223b693a2d313b733a32373a22646575747363685f6c6573656e5f696e666f726d6174696f6e656e223b693a2d313b733a32353a22646575747363685f6c6573656e5f616e77656973756e67656e223b693a2d313b733a32373a226d617468655f616e616c7974697363685f7374726174656769656e223b693a2d313b733a32393a226d617468655f616e616c7974697363685f7361636876657268616c7465223b693a2d313b733a32383a226d617468655f616e616c7974697363685f66616368776f6572746572223b693a2d313b733a32323a226d617468655f7a61686c656e5f6d696c6c696f6e656e223b693a2d313b733a32353a226d617468655f7a61686c656e5f6265726563686e756e67656e223b693a2d313b733a32323a226d617468655f7a61686c656e5f65696e68656974656e223b693a2d313b733a32343a226d617468655f7a61686c656e5f6b6f7066726563686e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f62656e656e6e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f666c61656368656e223b693a2d313b733a33313a226d617468655f67656f6d65747269655f7261756d766f727374656c6c756e67223b693a2d313b733a33373a2273616368756e74657272696368745f696e666f726d6174696f6e656e5f62657a696568656e223b693a2d313b733a32383a2273616368756e74657272696368745f7468656d656e67656269657465223b693a2d313b733a32373a2273616368756e74657272696368745f617262656974736d61707065223b693a2d313b733a32333a22657468696b5f6f6666656e5f72657370656b74766f6c6c223b693a2d313b733a33313a22657468696b5f6661656869676b656974656e5f65696e7363686165747a656e223b693a2d313b733a32313a22657468696b5f6d65696e756e675f616e6465726572223b693a2d313b733a32363a22657468696b5f756e74657272696368745f67657374616c74656e223b693a2d313b733a32333a22657468696b5f616e646572655f65696e667565686c656e223b693a2d313b733a32333a226b756e73745f617566676162656e5f756d7365747a656e223b693a2d313b733a32303a226b756e73745f696465656e5f756d7365747a656e223b693a2d313b733a31363a226b756e73745f6265676569737465726e223b693a2d313b733a31343a226d7573696b5f72687974686d7573223b693a2d313b733a32313a226d7573696b5f6d7573696b7269636874756e67656e223b693a2d313b733a32373a226d7573696b5f6b75656e73746c65725f696e737472756d656e7465223b693a2d313b733a31363a226d7573696b5f6461727374656c6c656e223b693a2d313b733a31323a2273706f72745f726567656c6e223b693a2d313b733a33303a2273706f72745f616e737472656e67756e6773626572656974736368616674223b693a2d313b733a31353a2273706f72745f6b6f6e646974696f6e223b693a2d313b733a32353a2273706f72745f6265776567756e67737265706572746f697265223b693a2d313b7d693a363b613a373a7b733a31333a2267726164655f64657574736368223b733a313a2231223b733a31313a2267726164655f6d61746865223b733a323a222d31223b733a32303a2267726164655f73616368756e7465727269636874223b733a323a222d31223b733a31313a2267726164655f657468696b223b733a323a222d31223b733a31313a2267726164655f6b756e7374223b733a323a222d31223b733a31313a2267726164655f6d7573696b223b733a323a222d31223b733a31313a2267726164655f73706f7274223b733a323a222d31223b7d7d, NULL, '2021-08-07 18:55:48', 4, 0, 4),
(413, 63, 82, 4, 0x613a363a7b693a303b693a3431333b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a393a7b733a31313a2267726164655f6d61746865223b733a323a222d31223b733a31333a2267726164655f64657574736368223b733a323a222d31223b733a31343a2267726164655f656e676c69736368223b733a323a222d31223b733a31313a2267726164655f657468696b223b733a323a222d31223b733a32303a2267726164655f73616368756e7465727269636874223b733a323a222d31223b733a31313a2267726164655f6d7573696b223b733a323a222d31223b733a31313a2267726164655f73706f7274223b733a323a222d31223b733a31313a2267726164655f6b756e7374223b733a323a222d31223b733a31333a2267726164655f73636872696674223b733a323a222d31223b7d7d, NULL, '2021-08-14 10:27:34', 3, 0, 4),
(414, 62, 80, 4, 0x613a31363a7b693a303b693a3431343b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b693a363b733a303a22223b693a373b733a303a22223b693a383b733a303a22223b693a393b733a303a22223b693a31303b733a303a22223b693a31313b733a303a22223b693a31323b733a303a22223b693a31333b733a303a22223b693a31343b693a303b693a31353b693a303b7d, NULL, '2020-05-26 22:09:02', 1, 1, 2),
(416, 60, 79, 3, 0x613a363a7b693a303b693a3431363b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b7d, NULL, '2020-12-13 19:58:44', 1, 0, 1),
(417, 58, 79, 3, 0x613a363a7b693a303b693a3431373b693a313b733a303a22223b693a323b733a303a22223b693a333b733a303a22223b693a343b733a303a22223b693a353b733a303a22223b7d, NULL, '2020-12-13 19:58:43', 1, 0, 1),
(418, 33, 64, 1, 0x613a373a7b693a303b693a3431383b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a33393a7b733a33303a22646575747363685f726563687473636872656962756e675f726567656c6e223b693a2d313b733a33353a22646575747363685f726563687473636872656962756e675f68696c66736d697474656c223b693a2d313b733a33323a22646575747363685f726563687473636872656962756e675f666f726d6b6c6172223b693a2d313b733a32393a22646575747363685f726563687473636872656962756e675f746166656c223b693a2d313b733a33343a22646575747363685f73707261636867656272617563685f666f726d756c696572656e223b693a2d313b733a33333a22646575747363685f73707261636867656272617563685f67657370726165636865223b693a2d313b733a34303a22646575747363685f73707261636867656272617563685f736974756174696f6e7367657265636874223b693a2d313b733a32333a22646575747363685f6c6573656e5f766f7274726167656e223b693a2d313b733a32373a22646575747363685f6c6573656e5f696e666f726d6174696f6e656e223b693a2d313b733a32353a22646575747363685f6c6573656e5f616e77656973756e67656e223b693a2d313b733a32373a226d617468655f616e616c7974697363685f7374726174656769656e223b693a2d313b733a32393a226d617468655f616e616c7974697363685f7361636876657268616c7465223b693a2d313b733a32383a226d617468655f616e616c7974697363685f66616368776f6572746572223b693a2d313b733a32323a226d617468655f7a61686c656e5f6d696c6c696f6e656e223b693a2d313b733a32353a226d617468655f7a61686c656e5f6265726563686e756e67656e223b693a2d313b733a32323a226d617468655f7a61686c656e5f65696e68656974656e223b693a2d313b733a32343a226d617468655f7a61686c656e5f6b6f7066726563686e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f62656e656e6e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f666c61656368656e223b693a2d313b733a33313a226d617468655f67656f6d65747269655f7261756d766f727374656c6c756e67223b693a2d313b733a33373a2273616368756e74657272696368745f696e666f726d6174696f6e656e5f62657a696568656e223b693a2d313b733a32383a2273616368756e74657272696368745f7468656d656e67656269657465223b693a2d313b733a32373a2273616368756e74657272696368745f617262656974736d61707065223b693a2d313b733a32333a22657468696b5f6f6666656e5f72657370656b74766f6c6c223b693a2d313b733a33313a22657468696b5f6661656869676b656974656e5f65696e7363686165747a656e223b693a2d313b733a32313a22657468696b5f6d65696e756e675f616e6465726572223b693a2d313b733a32363a22657468696b5f756e74657272696368745f67657374616c74656e223b693a2d313b733a32333a22657468696b5f616e646572655f65696e667565686c656e223b693a2d313b733a32333a226b756e73745f617566676162656e5f756d7365747a656e223b693a2d313b733a32303a226b756e73745f696465656e5f756d7365747a656e223b693a2d313b733a31363a226b756e73745f6265676569737465726e223b693a2d313b733a31343a226d7573696b5f72687974686d7573223b693a2d313b733a32313a226d7573696b5f6d7573696b7269636874756e67656e223b693a2d313b733a32373a226d7573696b5f6b75656e73746c65725f696e737472756d656e7465223b693a2d313b733a31363a226d7573696b5f6461727374656c6c656e223b693a2d313b733a31323a2273706f72745f726567656c6e223b693a2d313b733a33303a2273706f72745f616e737472656e67756e6773626572656974736368616674223b693a2d313b733a31353a2273706f72745f6b6f6e646974696f6e223b693a2d313b733a32353a2273706f72745f6265776567756e67737265706572746f697265223b693a2d313b7d693a363b613a373a7b733a31333a2267726164655f64657574736368223b693a2d313b733a31313a2267726164655f6d61746865223b693a2d313b733a32303a2267726164655f73616368756e7465727269636874223b693a2d313b733a31313a2267726164655f657468696b223b693a2d313b733a31313a2267726164655f6b756e7374223b693a2d313b733a31313a2267726164655f6d7573696b223b693a2d313b733a31313a2267726164655f73706f7274223b693a2d313b7d7d, NULL, '2020-12-05 17:27:44', 4, 0, 4),
(420, 66, 84, 1, 0x613a363a7b693a303b693a3432303b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a393a7b733a31313a2267726164655f6d61746865223b733a313a2234223b733a31333a2267726164655f64657574736368223b733a323a222d31223b733a31343a2267726164655f656e676c69736368223b733a313a2235223b733a31313a2267726164655f657468696b223b733a313a2232223b733a32303a2267726164655f73616368756e7465727269636874223b733a323a222d31223b733a31313a2267726164655f6d7573696b223b733a313a2236223b733a31313a2267726164655f73706f7274223b733a323a222d31223b733a31313a2267726164655f6b756e7374223b733a323a222d31223b733a31333a2267726164655f73636872696674223b733a323a222d31223b7d7d, NULL, '2020-06-11 14:28:07', 3, 0, 4),
(421, 64, 83, 3, 0x613a363a7b693a303b693a3432313b693a313b733a373a2261736466617364223b693a323b613a31303a7b733a31343a2267726164655f72656c6967696f6e223b733a313a2233223b733a32303a2267726164655f73616368756e7465727269636874223b733a323a222d31223b733a31333a2267726164655f64657574736368223b733a313a2233223b733a31363a2267726164655f6d617468656d6174696b223b733a323a222d31223b733a32383a2267726164655f646575747363685f7370726163686765627261756368223b733a313a2234223b733a31313a2267726164655f73706f7274223b733a323a222d31223b733a31393a2267726164655f646575747363685f6c6573656e223b733a313a2232223b733a31313a2267726164655f6d7573696b223b733a323a222d31223b733a32383a2267726164655f646575747363685f726563687473636872656962656e223b733a313a2233223b733a31383a2267726164655f6b756e64737474657874696c223b733a323a222d31223b7d693a333b693a303b693a343b693a303b693a353b733a303a22223b7d, NULL, '2020-06-12 22:54:58', 2, 0, 6),
(422, 46, 70, 1, 0x613a363a7b693a303b693a3432323b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a393a7b733a31313a2267726164655f6d61746865223b733a313a2233223b733a31333a2267726164655f64657574736368223b733a323a222d31223b733a31343a2267726164655f656e676c69736368223b733a313a2231223b733a31313a2267726164655f657468696b223b733a323a222d31223b733a32303a2267726164655f73616368756e7465727269636874223b733a323a222d31223b733a31313a2267726164655f6d7573696b223b733a323a222d31223b733a31313a2267726164655f73706f7274223b733a323a222d31223b733a31313a2267726164655f6b756e7374223b733a323a222d31223b733a31333a2267726164655f73636872696674223b733a323a222d31223b7d7d, NULL, '2020-12-05 17:26:26', 3, 1, 4),
(423, 57, 70, 1, 0x613a363a7b693a303b693a3432333b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a393a7b733a31313a2267726164655f6d61746865223b733a323a222d31223b733a31333a2267726164655f64657574736368223b733a323a222d31223b733a31343a2267726164655f656e676c69736368223b733a323a222d31223b733a31313a2267726164655f657468696b223b733a323a222d31223b733a32303a2267726164655f73616368756e7465727269636874223b733a323a222d31223b733a31313a2267726164655f6d7573696b223b733a323a222d31223b733a31313a2267726164655f73706f7274223b733a323a222d31223b733a31313a2267726164655f6b756e7374223b733a323a222d31223b733a31333a2267726164655f73636872696674223b733a323a222d31223b7d7d, NULL, '2020-11-03 22:20:05', 3, 1, 4),
(424, 32, 64, 1, 0x613a373a7b693a303b693a3432343b693a313b733a303a22223b693a323b733a303a22223b693a333b693a303b693a343b693a303b693a353b613a33393a7b733a33303a22646575747363685f726563687473636872656962756e675f726567656c6e223b693a2d313b733a33353a22646575747363685f726563687473636872656962756e675f68696c66736d697474656c223b693a2d313b733a33323a22646575747363685f726563687473636872656962756e675f666f726d6b6c6172223b693a2d313b733a32393a22646575747363685f726563687473636872656962756e675f746166656c223b693a2d313b733a33343a22646575747363685f73707261636867656272617563685f666f726d756c696572656e223b693a2d313b733a33333a22646575747363685f73707261636867656272617563685f67657370726165636865223b693a2d313b733a34303a22646575747363685f73707261636867656272617563685f736974756174696f6e7367657265636874223b693a2d313b733a32333a22646575747363685f6c6573656e5f766f7274726167656e223b693a2d313b733a32373a22646575747363685f6c6573656e5f696e666f726d6174696f6e656e223b693a2d313b733a32353a22646575747363685f6c6573656e5f616e77656973756e67656e223b693a2d313b733a32373a226d617468655f616e616c7974697363685f7374726174656769656e223b693a2d313b733a32393a226d617468655f616e616c7974697363685f7361636876657268616c7465223b693a2d313b733a32383a226d617468655f616e616c7974697363685f66616368776f6572746572223b693a2d313b733a32323a226d617468655f7a61686c656e5f6d696c6c696f6e656e223b693a2d313b733a32353a226d617468655f7a61686c656e5f6265726563686e756e67656e223b693a2d313b733a32323a226d617468655f7a61686c656e5f65696e68656974656e223b693a2d313b733a32343a226d617468655f7a61686c656e5f6b6f7066726563686e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f62656e656e6e656e223b693a2d313b733a32343a226d617468655f67656f6d65747269655f666c61656368656e223b693a2d313b733a33313a226d617468655f67656f6d65747269655f7261756d766f727374656c6c756e67223b693a2d313b733a33373a2273616368756e74657272696368745f696e666f726d6174696f6e656e5f62657a696568656e223b693a2d313b733a32383a2273616368756e74657272696368745f7468656d656e67656269657465223b693a2d313b733a32373a2273616368756e74657272696368745f617262656974736d61707065223b693a2d313b733a32333a22657468696b5f6f6666656e5f72657370656b74766f6c6c223b693a2d313b733a33313a22657468696b5f6661656869676b656974656e5f65696e7363686165747a656e223b693a2d313b733a32313a22657468696b5f6d65696e756e675f616e6465726572223b693a2d313b733a32363a22657468696b5f756e74657272696368745f67657374616c74656e223b693a2d313b733a32333a22657468696b5f616e646572655f65696e667565686c656e223b693a2d313b733a32333a226b756e73745f617566676162656e5f756d7365747a656e223b693a2d313b733a32303a226b756e73745f696465656e5f756d7365747a656e223b693a2d313b733a31363a226b756e73745f6265676569737465726e223b693a2d313b733a31343a226d7573696b5f72687974686d7573223b693a2d313b733a32313a226d7573696b5f6d7573696b7269636874756e67656e223b693a2d313b733a32373a226d7573696b5f6b75656e73746c65725f696e737472756d656e7465223b693a2d313b733a31363a226d7573696b5f6461727374656c6c656e223b693a2d313b733a31323a2273706f72745f726567656c6e223b693a2d313b733a33303a2273706f72745f616e737472656e67756e6773626572656974736368616674223b693a2d313b733a31353a2273706f72745f6b6f6e646974696f6e223b693a2d313b733a32353a2273706f72745f6265776567756e67737265706572746f697265223b693a2d313b7d693a363b613a373a7b733a31333a2267726164655f64657574736368223b693a2d313b733a31313a2267726164655f6d61746865223b693a2d313b733a32303a2267726164655f73616368756e7465727269636874223b693a2d313b733a31313a2267726164655f657468696b223b693a2d313b733a31313a2267726164655f6b756e7374223b693a2d313b733a31313a2267726164655f6d7573696b223b693a2d313b733a31313a2267726164655f73706f7274223b693a2d313b7d7d, NULL, '2020-11-03 22:23:45', 4, 0, 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `template_settings_value`
--

CREATE TABLE `template_settings_value` (
  `PK_Template_Settings_Value` int UNSIGNED NOT NULL,
  `FK_School_Template_Var` int UNSIGNED NOT NULL,
  `Value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `template_settings_value`
--

INSERT INTO `template_settings_value` (`PK_Template_Settings_Value`, `FK_School_Template_Var`, `Value`) VALUES
(21, 1, '2010-10-23'),
(22, 2, '2020-10-16'),
(23, 1, '1970-01-23'),
(24, 2, '2020-05-14'),
(25, 1, '2020-07-30'),
(26, 1, '2020-07-30'),
(27, 2, '1970-01-14'),
(28, 2, '2020-08-08'),
(29, 4, '1970-01-01'),
(30, 4, '2020-08-01'),
(31, 1, '2020-01-01'),
(32, 2, '1970-01-07'),
(33, 2, '2020-08-15'),
(34, 1, '2020-07-12'),
(35, 1, '1974-02-17'),
(36, 2, '1989-01-27'),
(37, 1, '1970-01-25'),
(38, 2, '1970-01-31'),
(39, 1, '1970-01-12'),
(40, 1, '2020-08-09'),
(41, 2, '2020-08-12'),
(42, 5, '2020/2021'),
(43, 8, '2006-06-12'),
(44, 9, '2006-06-21'),
(45, 10, '2006-08-09'),
(46, 4, '2020-06-09'),
(47, 5, '2020/2021'),
(48, 8, '2021-02-03'),
(49, 9, '2021-02-08'),
(50, 10, '2021-03-01');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `PK_User` int UNSIGNED NOT NULL,
  `FK_Role` int UNSIGNED NOT NULL,
  `FK_School` int UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `notes` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`PK_User`, `FK_Role`, `FK_School`, `username`, `password`, `notes`) VALUES
(1, 1, 1, 'demo', '$2b$10$gpW4xXmD66V5aAVGDuTvReQ3sOi8ZMuM7Lavx3gcNJrzmnEJ3p5WS', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_to_class`
--

CREATE TABLE `user_to_class` (
  `PK_User_To_Class` int UNSIGNED NOT NULL,
  `FK_User` int UNSIGNED NOT NULL,
  `FK_Class` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user_to_class`
--

INSERT INTO `user_to_class` (`PK_User_To_Class`, `FK_User`, `FK_Class`) VALUES
(30, 1, 53),
(31, 1, 54),
(32, 3, 55),
(33, 3, 56),
(34, 3, 57),
(35, 3, 58),
(36, 3, 59),
(37, 3, 60),
(38, 3, 61),
(39, 3, 62),
(40, 3, 63),
(41, 1, 64),
(42, 3, 65),
(43, 3, 65),
(44, 3, 66),
(45, 3, 67),
(46, 3, 68),
(47, 3, 69),
(48, 1, 70),
(49, 3, 71),
(50, 3, 72),
(51, 1, 73),
(52, 3, 74),
(53, 3, 75),
(54, 3, 76),
(55, 3, 77),
(56, 3, 78),
(57, 4, 79),
(58, 6, 80),
(59, 6, 81),
(60, 6, 82),
(61, 4, 83),
(62, 1, 84);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`PK_Absences`);

--
-- Indizes für die Tabelle `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`PK_Class`),
  ADD KEY `class_to_school_idx` (`FK_School`);

--
-- Indizes für die Tabelle `class_template_settings`
--
ALTER TABLE `class_template_settings`
  ADD PRIMARY KEY (`PK_Class_Template_Settings`),
  ADD UNIQUE KEY `cts_combined_unique` (`FK_Class`,`FK_Template_Settings_Value`,`FK_School_Template`),
  ADD KEY `fk_class_template_settings_1_idx` (`FK_Class`),
  ADD KEY `cts_to_tsv_idx` (`FK_Template_Settings_Value`),
  ADD KEY `cts_to_st_idx` (`FK_School_Template`);

--
-- Indizes für die Tabelle `modules_deleteme`
--
ALTER TABLE `modules_deleteme`
  ADD PRIMARY KEY (`PK_Modules`);

--
-- Indizes für die Tabelle `pinboard`
--
ALTER TABLE `pinboard`
  ADD PRIMARY KEY (`PK_Pinboard`);

--
-- Indizes für die Tabelle `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`PK_Role`);

--
-- Indizes für die Tabelle `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`PK_School`);

--
-- Indizes für die Tabelle `school_templates`
--
ALTER TABLE `school_templates`
  ADD PRIMARY KEY (`PK_School_Template`);

--
-- Indizes für die Tabelle `school_template_settings`
--
ALTER TABLE `school_template_settings`
  ADD PRIMARY KEY (`PK_School_Template_Settings`),
  ADD UNIQUE KEY `FK_S_FK_TSV_FK_TS` (`FK_School`,`FK_Template_Settings_Value`,`FK_School_Template`),
  ADD UNIQUE KEY `sts_combined_unique` (`FK_School`,`FK_Template_Settings_Value`,`FK_School_Template`),
  ADD KEY `sts_to_s_idx` (`FK_School`),
  ADD KEY `sts_to_tsv_idx` (`FK_Template_Settings_Value`),
  ADD KEY `sts_to_st_idx` (`FK_School_Template`);

--
-- Indizes für die Tabelle `school_template_to_school`
--
ALTER TABLE `school_template_to_school`
  ADD PRIMARY KEY (`PK_School_Template_To_School`),
  ADD KEY `school_template_to_school_to_school_idx` (`FK_School`),
  ADD KEY `fk_school_template_to_school_1_idx` (`FK_School_Template`);

--
-- Indizes für die Tabelle `school_template_vars`
--
ALTER TABLE `school_template_vars`
  ADD PRIMARY KEY (`PK_School_Template_Vars`),
  ADD UNIQUE KEY `unique_idx` (`Varname`,`FK_School_Template`),
  ADD KEY `stv_to_st_idx` (`FK_School_Template`);

--
-- Indizes für die Tabelle `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`PK_Session`),
  ADD KEY `session_to_school_idx` (`FK_School`),
  ADD KEY `session_to_user_idx` (`FK_User`);

--
-- Indizes für die Tabelle `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`PK_Student`),
  ADD KEY `student_to_school_idx` (`FK_School`),
  ADD KEY `student_to_class_idx` (`FK_Class`);

--
-- Indizes für die Tabelle `student_template_settings`
--
ALTER TABLE `student_template_settings`
  ADD PRIMARY KEY (`PK_Student_Template_Settings`),
  ADD KEY `stuts_to_student_idx` (`FK_Student`),
  ADD KEY `stuts_to_tsv_idx` (`FK_Template_Settings_Value`),
  ADD KEY `stuts_to_sts_idx` (`FK_School_Template`);

--
-- Indizes für die Tabelle `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`PK_Templates`),
  ADD KEY `templates_to_student_idx` (`FK_Student`),
  ADD KEY `templates_to_class_idx` (`FK_Class`),
  ADD KEY `templates_to_school_idx` (`FK_School`);

--
-- Indizes für die Tabelle `template_settings_value`
--
ALTER TABLE `template_settings_value`
  ADD PRIMARY KEY (`PK_Template_Settings_Value`),
  ADD KEY `tsv_to_stv_idx` (`FK_School_Template_Var`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`PK_User`),
  ADD KEY `user_to_role_idx` (`FK_Role`),
  ADD KEY `user_to_school_idx` (`FK_School`);

--
-- Indizes für die Tabelle `user_to_class`
--
ALTER TABLE `user_to_class`
  ADD PRIMARY KEY (`PK_User_To_Class`),
  ADD KEY `user_to_class_to_user_idx` (`FK_User`),
  ADD KEY `user_to_class_to_class_idx` (`FK_Class`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `absences`
--
ALTER TABLE `absences`
  MODIFY `PK_Absences` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `class`
--
ALTER TABLE `class`
  MODIFY `PK_Class` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT für Tabelle `class_template_settings`
--
ALTER TABLE `class_template_settings`
  MODIFY `PK_Class_Template_Settings` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT für Tabelle `modules_deleteme`
--
ALTER TABLE `modules_deleteme`
  MODIFY `PK_Modules` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `pinboard`
--
ALTER TABLE `pinboard`
  MODIFY `PK_Pinboard` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT für Tabelle `school`
--
ALTER TABLE `school`
  MODIFY `PK_School` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `school_templates`
--
ALTER TABLE `school_templates`
  MODIFY `PK_School_Template` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `school_template_settings`
--
ALTER TABLE `school_template_settings`
  MODIFY `PK_School_Template_Settings` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT für Tabelle `school_template_to_school`
--
ALTER TABLE `school_template_to_school`
  MODIFY `PK_School_Template_To_School` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT für Tabelle `school_template_vars`
--
ALTER TABLE `school_template_vars`
  MODIFY `PK_School_Template_Vars` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `session`
--
ALTER TABLE `session`
  MODIFY `PK_Session` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=773;

--
-- AUTO_INCREMENT für Tabelle `student`
--
ALTER TABLE `student`
  MODIFY `PK_Student` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT für Tabelle `student_template_settings`
--
ALTER TABLE `student_template_settings`
  MODIFY `PK_Student_Template_Settings` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `templates`
--
ALTER TABLE `templates`
  MODIFY `PK_Templates` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;

--
-- AUTO_INCREMENT für Tabelle `template_settings_value`
--
ALTER TABLE `template_settings_value`
  MODIFY `PK_Template_Settings_Value` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `PK_User` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `user_to_class`
--
ALTER TABLE `user_to_class`
  MODIFY `PK_User_To_Class` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_to_school` FOREIGN KEY (`FK_School`) REFERENCES `school` (`PK_School`);

--
-- Constraints der Tabelle `class_template_settings`
--
ALTER TABLE `class_template_settings`
  ADD CONSTRAINT `cts_to_s` FOREIGN KEY (`FK_Class`) REFERENCES `class` (`PK_Class`),
  ADD CONSTRAINT `cts_to_st` FOREIGN KEY (`FK_School_Template`) REFERENCES `school_templates` (`PK_School_Template`),
  ADD CONSTRAINT `cts_to_tsv` FOREIGN KEY (`FK_Template_Settings_Value`) REFERENCES `template_settings_value` (`PK_Template_Settings_Value`);

--
-- Constraints der Tabelle `school_template_settings`
--
ALTER TABLE `school_template_settings`
  ADD CONSTRAINT `sts_to_s` FOREIGN KEY (`FK_School`) REFERENCES `school` (`PK_School`),
  ADD CONSTRAINT `sts_to_st` FOREIGN KEY (`FK_School_Template`) REFERENCES `school_templates` (`PK_School_Template`),
  ADD CONSTRAINT `sts_to_tsv` FOREIGN KEY (`FK_Template_Settings_Value`) REFERENCES `template_settings_value` (`PK_Template_Settings_Value`);

--
-- Constraints der Tabelle `school_template_to_school`
--
ALTER TABLE `school_template_to_school`
  ADD CONSTRAINT `fk_school_template_to_school_1` FOREIGN KEY (`FK_School_Template`) REFERENCES `school_templates` (`PK_School_Template`),
  ADD CONSTRAINT `school_template_to_school_to_school` FOREIGN KEY (`FK_School`) REFERENCES `school` (`PK_School`);

--
-- Constraints der Tabelle `school_template_vars`
--
ALTER TABLE `school_template_vars`
  ADD CONSTRAINT `stv_to_st` FOREIGN KEY (`FK_School_Template`) REFERENCES `school_templates` (`PK_School_Template`);

--
-- Constraints der Tabelle `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_to_school` FOREIGN KEY (`FK_School`) REFERENCES `school` (`PK_School`),
  ADD CONSTRAINT `session_to_user` FOREIGN KEY (`FK_User`) REFERENCES `user` (`PK_User`);

--
-- Constraints der Tabelle `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_to_class` FOREIGN KEY (`FK_Class`) REFERENCES `class` (`PK_Class`),
  ADD CONSTRAINT `student_to_school` FOREIGN KEY (`FK_School`) REFERENCES `school` (`PK_School`);

--
-- Constraints der Tabelle `student_template_settings`
--
ALTER TABLE `student_template_settings`
  ADD CONSTRAINT `stuts_to_st` FOREIGN KEY (`FK_School_Template`) REFERENCES `school_templates` (`PK_School_Template`),
  ADD CONSTRAINT `stuts_to_student` FOREIGN KEY (`FK_Student`) REFERENCES `student` (`PK_Student`),
  ADD CONSTRAINT `stuts_to_tsv` FOREIGN KEY (`FK_Template_Settings_Value`) REFERENCES `template_settings_value` (`PK_Template_Settings_Value`);

--
-- Constraints der Tabelle `templates`
--
ALTER TABLE `templates`
  ADD CONSTRAINT `templates_to_class` FOREIGN KEY (`FK_Class`) REFERENCES `class` (`PK_Class`),
  ADD CONSTRAINT `templates_to_school` FOREIGN KEY (`FK_School`) REFERENCES `school` (`PK_School`),
  ADD CONSTRAINT `templates_to_student` FOREIGN KEY (`FK_Student`) REFERENCES `student` (`PK_Student`);

--
-- Constraints der Tabelle `template_settings_value`
--
ALTER TABLE `template_settings_value`
  ADD CONSTRAINT `tsv_to_stv` FOREIGN KEY (`FK_School_Template_Var`) REFERENCES `school_template_vars` (`PK_School_Template_Vars`);

--
-- Constraints der Tabelle `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_to_role` FOREIGN KEY (`FK_Role`) REFERENCES `role` (`PK_Role`),
  ADD CONSTRAINT `user_to_school` FOREIGN KEY (`FK_School`) REFERENCES `school` (`PK_School`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
