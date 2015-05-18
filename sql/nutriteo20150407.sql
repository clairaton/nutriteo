-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 07 Avril 2015 à 17:26
-- Version du serveur :  5.6.16
-- Version de PHP :  5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `nutriteo`
--

-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `impact` varchar(45) NOT NULL,
  `nutriment_family_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activity_nutriment_family1_idx` (`nutriment_family_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `activity`
--

INSERT INTO `activity` (`id`, `impact`, `nutriment_family_id`) VALUES
(4, '10', 1),
(5, '30', 2),
(6, '5', 3),
(9, '0', 4),
(10, '0', 5),
(11, '0', 6);

-- --------------------------------------------------------

--
-- Structure de la table `allergy`
--

CREATE TABLE IF NOT EXISTS `allergy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `allergy`
--

INSERT INTO `allergy` (`id`, `name`) VALUES
(1, 'gluten');

-- --------------------------------------------------------

--
-- Structure de la table `diet`
--

CREATE TABLE IF NOT EXISTS `diet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `diet`
--

INSERT INTO `diet` (`id`, `name`) VALUES
(1, 'vegetarien');

-- --------------------------------------------------------

--
-- Structure de la table `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `picture_id` int(11) NOT NULL DEFAULT '1',
  `food_family_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_food_picture1_idx` (`picture_id`),
  KEY `fk_food_food_family1_idx` (`food_family_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `food`
--

INSERT INTO `food` (`id`, `name`, `picture_id`, `food_family_id`) VALUES
(2, 'poisson pané, frit', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `food_allergy`
--

CREATE TABLE IF NOT EXISTS `food_allergy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `food_id` int(11) NOT NULL,
  `allergy_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_food_allergy_food1_idx` (`food_id`),
  KEY `fk_food_allergy_allergy1_idx` (`allergy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `food_allergy`
--

INSERT INTO `food_allergy` (`id`, `food_id`, `allergy_id`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `food_diet_exclusion`
--

CREATE TABLE IF NOT EXISTS `food_diet_exclusion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `food_id` int(11) NOT NULL,
  `diet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_food_diet_exclusion_food1_idx` (`food_id`),
  KEY `fk_food_diet_exclusion_diet1_idx` (`diet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `food_diet_exclusion`
--

INSERT INTO `food_diet_exclusion` (`id`, `food_id`, `diet_id`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `food_family`
--

CREATE TABLE IF NOT EXISTS `food_family` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `food_family`
--

INSERT INTO `food_family` (`id`, `name`) VALUES
(1, 'poisson');

-- --------------------------------------------------------

--
-- Structure de la table `food_nutriment`
--

CREATE TABLE IF NOT EXISTS `food_nutriment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `food_id` int(11) NOT NULL,
  `nutriment_id` int(11) NOT NULL,
  `nutriment_quantity` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_food_nutriment_food1_idx` (`food_id`),
  KEY `fk_food_nutriment_nutriment1_idx` (`nutriment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `food_nutriment`
--

INSERT INTO `food_nutriment` (`id`, `food_id`, `nutriment_id`, `nutriment_quantity`) VALUES
(1, 2, 10, 8.6),
(2, 2, 12, 15.3),
(3, 2, 13, 1.89),
(4, 2, 14, 3.94),
(5, 2, 17, 5.03),
(6, 2, 28, 1.52),
(7, 2, 29, 1.9),
(8, 2, 22, 0.106),
(9, 2, 21, 1.52),
(10, 2, 34, 30.6),
(11, 2, 31, 24.9),
(12, 2, 36, 104),
(13, 2, 37, 277),
(14, 2, 35, 0.152),
(15, 2, 33, 0.489),
(16, 2, 41, 0.397);

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `program_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_group_program1_idx` (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `intensity`
--

CREATE TABLE IF NOT EXISTS `intensity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `coeff` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `intensity`
--

INSERT INTO `intensity` (`id`, `level`, `name`, `coeff`) VALUES
(1, 1, 'normale', 1),
(2, 2, 'intensive', 2);

-- --------------------------------------------------------

--
-- Structure de la table `nutriment`
--

CREATE TABLE IF NOT EXISTS `nutriment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `unity` varchar(45) NOT NULL,
  `nutriment_family_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nutriment_nutriment_family1_idx` (`nutriment_family_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Contenu de la table `nutriment`
--

INSERT INTO `nutriment` (`id`, `name`, `unity`, `nutriment_family_id`) VALUES
(1, 'histidine', 'g', 1),
(2, 'isoleucine', 'g', 1),
(3, 'leucine', 'g', 1),
(4, 'lysine', 'g', 1),
(5, 'méthionine', 'g', 1),
(6, 'phénylalanine', 'g', 1),
(7, 'théonine', 'g', 1),
(8, 'tryptophane', 'g', 1),
(9, 'valine', 'g', 1),
(10, 'autres protéines', 'g', 1),
(11, 'fibres alimentaires', 'g', 2),
(12, 'autres glucides', 'g', 2),
(13, 'acides gras saturés', 'g', 3),
(14, 'acides gras monoinsaturés', 'g', 3),
(15, 'oméga6', 'g', 3),
(16, 'oméga3', 'g', 3),
(17, 'autres acides gras polyinsaturés', 'g', 3),
(18, 'cholestérol', 'mg', 3),
(19, 'eau', 'g', 4),
(20, 'vitamine A', 'ug', 5),
(21, 'Vitamine B1', 'mg', 5),
(22, 'Vitamine B2', 'mg', 5),
(23, 'Vitamine B5', 'mg', 5),
(24, 'Vitamine B6', 'mg', 5),
(25, 'Vitamine B9', '', 5),
(26, 'Vitamine B12', '', 5),
(27, 'Vitamine C', 'mg', 5),
(28, 'Vitamine D', 'ug', 5),
(29, 'Vitamine E', 'mg', 5),
(30, 'Vitamine K', 'ug', 5),
(31, 'Calcium', 'mg', 6),
(32, 'Cuivre', 'mg', 6),
(33, 'Fer', 'ug', 6),
(34, 'Magnésium', 'ug', 6),
(35, 'Manganèse', 'mg', 6),
(36, 'Phosphore', 'mg', 6),
(37, 'Potassium', 'mg', 6),
(38, 'Sélénium', 'ug', 6),
(39, 'Sodium', 'mg', 6),
(40, 'sel (équivalence sodium)', 'mg', 6),
(41, 'zinc', 'mg', 6);

-- --------------------------------------------------------

--
-- Structure de la table `nutriment_family`
--

CREATE TABLE IF NOT EXISTS `nutriment_family` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `nutriment_family`
--

INSERT INTO `nutriment_family` (`id`, `name`) VALUES
(1, 'protéines'),
(2, 'glucides'),
(3, 'lipides'),
(4, 'eaux'),
(5, 'vitamines'),
(6, 'minéraux');

-- --------------------------------------------------------

--
-- Structure de la table `nutriment_ref`
--

CREATE TABLE IF NOT EXISTS `nutriment_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nutriment_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `weight` int(11) NOT NULL,
  `sex` int(11) NOT NULL,
  `age_min` int(11) NOT NULL,
  `age_max` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_age_nutriment_nutriment1_idx` (`nutriment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=334 ;

--
-- Contenu de la table `nutriment_ref`
--

INSERT INTO `nutriment_ref` (`id`, `nutriment_id`, `quantity`, `weight`, `sex`, `age_min`, `age_max`) VALUES
(1, 10, 39, 60, 0, 15, 39),
(2, 10, 38.86, 60, 0, 15, 39),
(3, 10, 38.86, 60, 0, 15, 39),
(4, 10, 38.86, 60, 0, 15, 39),
(5, 10, 4, 4, 0, 15, 39),
(6, 10, 38, 60, 0, 15, 39),
(7, 12, 205, 60, 0, 15, 39),
(8, 13, 16, 60, 0, 15, 39),
(9, 14, 16, 60, 0, 15, 39),
(10, 18, 2, 60, 0, 15, 39),
(11, 15, 1, 60, 0, 15, 39),
(12, 16, 12, 60, 0, 15, 39),
(13, 17, 20, 60, 0, 15, 39),
(14, 11, 25, 60, 0, 15, 39),
(15, 19, 2700, 60, 0, 15, 39),
(16, 20, 700, 60, 0, 15, 39),
(17, 21, 1, 60, 0, 15, 39),
(18, 22, 1, 60, 0, 15, 39),
(19, 23, 5, 60, 0, 15, 39),
(20, 24, 1, 60, 0, 15, 39),
(21, 25, 400, 60, 0, 15, 39),
(22, 26, 2, 60, 0, 15, 39),
(23, 27, 75, 60, 0, 15, 39),
(24, 28, 5, 60, 0, 15, 39),
(25, 29, 15, 60, 0, 15, 39),
(26, 30, 90, 60, 0, 15, 39),
(27, 31, 1000, 60, 0, 15, 39),
(28, 32, 0, 60, 0, 15, 39),
(29, 33, 18, 60, 0, 15, 39),
(30, 34, 320, 60, 0, 15, 39),
(31, 35, 1, 60, 0, 15, 39),
(32, 36, 700, 60, 0, 15, 39),
(33, 37, 4700, 60, 0, 15, 39),
(34, 38, 55, 60, 0, 15, 39),
(35, 39, 1500, 60, 0, 15, 39),
(36, 40, 4100, 60, 0, 15, 39),
(37, 41, 8, 60, 0, 15, 39),
(38, 1, 0, 60, 0, 15, 39),
(39, 2, 1, 60, 0, 15, 39),
(40, 3, 2, 60, 0, 15, 39),
(41, 4, 1, 60, 0, 15, 39),
(42, 5, 0, 60, 0, 15, 39),
(43, 6, 1, 60, 0, 15, 39),
(44, 7, 0, 60, 0, 15, 39),
(45, 8, 0, 60, 0, 15, 39),
(46, 9, 1, 60, 0, 15, 39),
(47, 10, 38, 60, 0, 40, 54),
(48, 12, 195, 60, 0, 40, 54),
(49, 13, 13, 60, 0, 40, 54),
(50, 14, 13, 60, 0, 40, 54),
(51, 18, 0, 60, 0, 40, 54),
(52, 15, 1, 60, 0, 40, 54),
(53, 16, 12, 60, 0, 40, 54),
(54, 17, 20, 60, 0, 40, 54),
(55, 11, 25, 60, 0, 40, 54),
(56, 19, 2700, 60, 0, 40, 54),
(57, 20, 700, 60, 0, 40, 54),
(58, 21, 1, 60, 0, 40, 54),
(59, 22, 1, 60, 0, 40, 54),
(60, 23, 5, 60, 0, 40, 54),
(61, 24, 1, 60, 0, 40, 54),
(62, 25, 400, 60, 0, 40, 54),
(63, 26, 2, 60, 0, 40, 54),
(64, 27, 75, 60, 0, 40, 54),
(65, 28, 5, 60, 0, 40, 54),
(66, 29, 15, 60, 0, 40, 54),
(67, 30, 90, 60, 0, 40, 54),
(68, 31, 1000, 60, 0, 40, 54),
(69, 32, 0, 60, 0, 40, 54),
(70, 33, 18, 60, 0, 40, 54),
(71, 34, 320, 60, 0, 40, 54),
(72, 35, 1, 60, 0, 40, 54),
(73, 36, 700, 60, 0, 40, 54),
(74, 37, 4700, 60, 0, 40, 54),
(75, 38, 55, 60, 0, 40, 54),
(76, 39, 1500, 60, 0, 40, 54),
(77, 40, 4100, 60, 0, 40, 54),
(78, 41, 8, 60, 0, 40, 54),
(79, 1, 0, 60, 0, 40, 54),
(80, 2, 1, 60, 0, 40, 54),
(81, 3, 2, 60, 0, 40, 54),
(82, 4, 1, 60, 0, 40, 54),
(83, 5, 0, 60, 0, 40, 54),
(84, 6, 1, 60, 0, 40, 54),
(85, 7, 0, 60, 0, 40, 54),
(86, 8, 0, 60, 0, 40, 54),
(87, 9, 1, 60, 0, 40, 54),
(88, 10, 38, 60, 0, 55, 69),
(89, 12, 185, 60, 0, 55, 69),
(90, 13, 13, 60, 0, 55, 69),
(91, 14, 13, 60, 0, 55, 69),
(92, 18, 0, 60, 0, 55, 69),
(93, 15, 1, 60, 0, 55, 69),
(94, 16, 12, 60, 0, 55, 69),
(95, 17, 20, 60, 0, 55, 69),
(96, 11, 25, 60, 0, 55, 69),
(97, 19, 2700, 60, 0, 55, 69),
(98, 20, 700, 60, 0, 55, 69),
(99, 21, 1, 60, 0, 55, 69),
(100, 22, 1, 60, 0, 55, 69),
(101, 23, 5, 60, 0, 55, 69),
(102, 24, 1, 60, 0, 55, 69),
(103, 25, 400, 60, 0, 55, 69),
(104, 26, 2, 60, 0, 55, 69),
(105, 27, 75, 60, 0, 55, 69),
(106, 28, 5, 60, 0, 55, 69),
(107, 29, 15, 60, 0, 55, 69),
(108, 30, 90, 60, 0, 55, 69),
(109, 31, 1200, 60, 0, 55, 69),
(110, 32, 0, 60, 0, 55, 69),
(111, 33, 8, 60, 0, 55, 69),
(112, 34, 320, 60, 0, 55, 69),
(113, 35, 1, 60, 0, 55, 69),
(114, 36, 700, 60, 0, 55, 69),
(115, 37, 4700, 60, 0, 55, 69),
(116, 38, 55, 60, 0, 55, 69),
(117, 39, 1300, 60, 0, 55, 69),
(118, 40, 3500, 60, 0, 55, 69),
(119, 41, 8, 60, 0, 55, 69),
(120, 1, 0, 60, 0, 55, 69),
(121, 2, 1, 60, 0, 55, 69),
(122, 3, 2, 60, 0, 55, 69),
(123, 4, 1, 60, 0, 55, 69),
(124, 5, 0, 60, 0, 55, 69),
(125, 6, 1, 60, 0, 55, 69),
(126, 7, 0, 60, 0, 55, 69),
(127, 8, 0, 60, 0, 55, 69),
(128, 9, 1, 60, 0, 55, 69),
(129, 10, 38, 60, 0, 70, 160),
(130, 12, 179, 60, 0, 70, 160),
(131, 13, 13, 60, 0, 70, 160),
(132, 14, 13, 60, 0, 70, 160),
(133, 18, 0, 60, 0, 70, 160),
(134, 15, 1, 60, 0, 70, 160),
(135, 16, 12, 60, 0, 70, 160),
(136, 17, 20, 60, 0, 70, 160),
(137, 11, 21, 60, 0, 70, 160),
(138, 19, 2700, 60, 0, 70, 160),
(139, 20, 700, 60, 0, 70, 160),
(140, 21, 1, 60, 0, 70, 160),
(141, 22, 1, 60, 0, 70, 160),
(142, 23, 5, 60, 0, 70, 160),
(143, 24, 1, 60, 0, 70, 160),
(144, 25, 400, 60, 0, 70, 160),
(145, 26, 2, 60, 0, 70, 160),
(146, 27, 75, 60, 0, 70, 160),
(147, 28, 15, 60, 0, 70, 160),
(148, 29, 15, 60, 0, 70, 160),
(149, 30, 90, 60, 0, 70, 160),
(150, 31, 1200, 60, 0, 70, 160),
(151, 32, 0, 60, 0, 70, 160),
(152, 33, 8, 60, 0, 70, 160),
(153, 34, 320, 60, 0, 70, 160),
(154, 35, 1, 60, 0, 70, 160),
(155, 36, 700, 60, 0, 70, 160),
(156, 37, 4700, 60, 0, 70, 160),
(157, 38, 55, 60, 0, 70, 160),
(158, 39, 1200, 60, 0, 70, 160),
(159, 40, 3200, 60, 0, 70, 160),
(160, 41, 8, 60, 0, 70, 160),
(161, 1, 0, 60, 0, 70, 160),
(162, 2, 1, 60, 0, 70, 160),
(163, 3, 2, 60, 0, 70, 160),
(164, 4, 1, 60, 0, 70, 160),
(165, 5, 0, 60, 0, 70, 160),
(166, 6, 1, 60, 0, 70, 160),
(167, 7, 0, 60, 0, 70, 160),
(168, 8, 0, 60, 0, 70, 160),
(169, 9, 1, 60, 0, 70, 160),
(170, 10, 70, 80, 1, 15, 39),
(171, 12, 320, 80, 1, 15, 39),
(172, 13, 20, 80, 1, 15, 39),
(173, 14, 20, 80, 1, 15, 39),
(174, 18, 1, 80, 1, 15, 39),
(175, 15, 1, 80, 1, 15, 39),
(176, 16, 17, 80, 1, 15, 39),
(177, 17, 20, 80, 1, 15, 39),
(178, 11, 38, 80, 1, 15, 39),
(179, 19, 3700, 80, 1, 15, 39),
(180, 20, 900, 80, 1, 15, 39),
(181, 21, 1, 80, 1, 15, 39),
(182, 22, 1, 80, 1, 15, 39),
(183, 23, 5, 80, 1, 15, 39),
(184, 24, 1, 80, 1, 15, 39),
(185, 25, 400, 80, 1, 15, 39),
(186, 26, 2, 80, 1, 15, 39),
(187, 27, 90, 80, 1, 15, 39),
(188, 28, 5, 80, 1, 15, 39),
(189, 29, 15, 80, 1, 15, 39),
(190, 30, 120, 80, 1, 15, 39),
(191, 31, 1000, 80, 1, 15, 39),
(192, 32, 0, 80, 1, 15, 39),
(193, 33, 8, 80, 1, 15, 39),
(194, 34, 420, 80, 1, 15, 39),
(195, 35, 2, 80, 1, 15, 39),
(196, 36, 700, 80, 1, 15, 39),
(197, 37, 4700, 80, 1, 15, 39),
(198, 38, 55, 80, 1, 15, 39),
(199, 39, 1500, 80, 1, 15, 39),
(200, 40, 4100, 80, 1, 15, 39),
(201, 41, 11, 80, 1, 15, 39),
(202, 1, 0, 80, 1, 15, 39),
(203, 2, 1, 80, 1, 15, 39),
(204, 3, 3, 80, 1, 15, 39),
(205, 4, 2, 80, 1, 15, 39),
(206, 5, 1, 80, 1, 15, 39),
(207, 6, 2, 80, 1, 15, 39),
(208, 7, 1, 80, 1, 15, 39),
(209, 8, 0, 80, 1, 15, 39),
(210, 9, 2, 80, 1, 15, 39),
(211, 10, 70, 80, 1, 55, 69),
(212, 12, 260, 80, 1, 55, 69),
(213, 13, 20, 80, 1, 55, 69),
(214, 14, 20, 80, 1, 55, 69),
(215, 18, 4, 80, 1, 55, 69),
(216, 15, 1, 80, 1, 55, 69),
(217, 16, 14, 80, 1, 55, 69),
(218, 17, 20, 80, 1, 55, 69),
(219, 11, 30, 80, 1, 55, 69),
(220, 19, 3700, 80, 1, 55, 69),
(221, 20, 900, 80, 1, 55, 69),
(222, 21, 1, 80, 1, 55, 69),
(223, 22, 1, 80, 1, 55, 69),
(224, 23, 5, 80, 1, 55, 69),
(225, 24, 1, 80, 1, 55, 69),
(226, 25, 400, 80, 1, 55, 69),
(227, 26, 2, 80, 1, 55, 69),
(228, 27, 90, 80, 1, 55, 69),
(229, 28, 10, 80, 1, 55, 69),
(230, 29, 15, 80, 1, 55, 69),
(231, 30, 120, 80, 1, 55, 69),
(232, 31, 1200, 80, 1, 55, 69),
(233, 32, 0, 80, 1, 55, 69),
(234, 33, 8, 80, 1, 55, 69),
(235, 34, 420, 80, 1, 55, 69),
(236, 35, 2, 80, 1, 55, 69),
(237, 36, 700, 80, 1, 55, 69),
(238, 37, 4700, 80, 1, 55, 69),
(239, 38, 55, 80, 1, 55, 69),
(240, 39, 1300, 80, 1, 55, 69),
(241, 40, 3500, 80, 1, 55, 69),
(242, 41, 11, 80, 1, 55, 69),
(243, 1, 0, 80, 1, 55, 69),
(244, 2, 1, 80, 1, 55, 69),
(245, 3, 3, 80, 1, 55, 69),
(246, 4, 2, 80, 1, 55, 69),
(247, 5, 1, 80, 1, 55, 69),
(248, 6, 2, 80, 1, 55, 69),
(249, 7, 1, 80, 1, 55, 69),
(250, 8, 0, 80, 1, 55, 69),
(251, 9, 2, 80, 1, 55, 69),
(252, 10, 70, 80, 1, 40, 54),
(253, 12, 402, 80, 1, 40, 54),
(254, 13, 20, 80, 1, 40, 54),
(255, 14, 20, 80, 1, 40, 54),
(256, 18, 1, 80, 1, 40, 54),
(257, 15, 1, 80, 1, 40, 54),
(258, 16, 17, 80, 1, 40, 54),
(259, 17, 20, 80, 1, 40, 54),
(260, 11, 38, 80, 1, 40, 54),
(261, 19, 3700, 80, 1, 40, 54),
(262, 20, 900, 80, 1, 40, 54),
(263, 21, 1, 80, 1, 40, 54),
(264, 22, 1, 80, 1, 40, 54),
(265, 23, 5, 80, 1, 40, 54),
(266, 24, 1, 80, 1, 40, 54),
(267, 25, 400, 80, 1, 40, 54),
(268, 26, 2, 80, 1, 40, 54),
(269, 27, 90, 80, 1, 40, 54),
(270, 28, 5, 80, 1, 40, 54),
(271, 29, 15, 80, 1, 40, 54),
(272, 30, 120, 80, 1, 40, 54),
(273, 31, 1000, 80, 1, 40, 54),
(274, 32, 0, 80, 1, 40, 54),
(275, 33, 8, 80, 1, 40, 54),
(276, 34, 420, 80, 1, 40, 54),
(277, 35, 2, 80, 1, 40, 54),
(278, 36, 700, 80, 1, 40, 54),
(279, 37, 4700, 80, 1, 40, 54),
(280, 38, 55, 80, 1, 40, 54),
(281, 39, 1500, 80, 1, 40, 54),
(282, 40, 4100, 80, 1, 40, 54),
(283, 41, 11, 80, 1, 40, 54),
(284, 1, 0, 80, 1, 40, 54),
(285, 2, 1, 80, 1, 40, 54),
(286, 3, 3, 80, 1, 40, 54),
(287, 4, 2, 80, 1, 40, 54),
(288, 5, 1, 80, 1, 40, 54),
(289, 6, 2, 80, 1, 40, 54),
(290, 7, 1, 80, 1, 40, 54),
(291, 8, 0, 80, 1, 40, 54),
(292, 9, 2, 80, 1, 40, 54),
(293, 10, 70, 80, 1, 70, 160),
(294, 12, 372, 80, 1, 70, 160),
(295, 13, 20, 80, 1, 70, 160),
(296, 14, 20, 80, 1, 70, 160),
(297, 18, 4, 80, 1, 70, 160),
(298, 15, 1, 80, 1, 70, 160),
(299, 16, 14, 80, 1, 70, 160),
(300, 17, 20, 80, 1, 70, 160),
(301, 11, 30, 80, 1, 70, 160),
(302, 19, 3700, 80, 1, 70, 160),
(303, 20, 900, 80, 1, 70, 160),
(304, 21, 1, 80, 1, 70, 160),
(305, 22, 1, 80, 1, 70, 160),
(306, 23, 5, 80, 1, 70, 160),
(307, 24, 1, 80, 1, 70, 160),
(308, 25, 400, 80, 1, 70, 160),
(309, 26, 2, 80, 1, 70, 160),
(310, 27, 90, 80, 1, 70, 160),
(311, 28, 15, 80, 1, 70, 160),
(312, 29, 15, 80, 1, 70, 160),
(313, 30, 120, 80, 1, 70, 160),
(314, 31, 1200, 80, 1, 70, 160),
(315, 32, 0, 80, 1, 70, 160),
(316, 33, 8, 80, 1, 70, 160),
(317, 34, 420, 80, 1, 70, 160),
(318, 35, 2, 80, 1, 70, 160),
(319, 36, 700, 80, 1, 70, 160),
(320, 37, 4700, 80, 1, 70, 160),
(321, 38, 55, 80, 1, 70, 160),
(322, 39, 1200, 80, 1, 70, 160),
(323, 40, 3200, 80, 1, 70, 160),
(324, 41, 11, 80, 1, 70, 160),
(325, 1, 0, 80, 1, 70, 160),
(326, 2, 1, 80, 1, 70, 160),
(327, 3, 3, 80, 1, 70, 160),
(328, 4, 2, 80, 1, 70, 160),
(329, 5, 1, 80, 1, 70, 160),
(330, 6, 2, 80, 1, 70, 160),
(331, 7, 1, 80, 1, 70, 160),
(332, 8, 0, 80, 1, 70, 160),
(333, 9, 2, 80, 1, 70, 160);

-- --------------------------------------------------------

--
-- Structure de la table `nutriment_weight`
--

CREATE TABLE IF NOT EXISTS `nutriment_weight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nutriment_id` int(11) NOT NULL,
  `weigth` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nutriment_weight_nutriment1_idx` (`nutriment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `picture`
--

INSERT INTO `picture` (`id`, `source`, `type`) VALUES
(1, 'img/food/default.jpg', 1),
(2, 'img/food/poisson-pane.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `program`
--

CREATE TABLE IF NOT EXISTS `program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `program_nutriment`
--

CREATE TABLE IF NOT EXISTS `program_nutriment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `program_id` int(11) NOT NULL,
  `nutriment_id` int(11) NOT NULL,
  `coeff` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_program_nutriment_program1_idx` (`program_id`),
  KEY `fk_program_nutriment_nutriment1_idx` (`nutriment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(60) NOT NULL,
  `size` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `sex` int(11) NOT NULL,
  `birthdate` datetime NOT NULL,
  `zipcode` varchar(45) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `allergy_id` int(11) DEFAULT NULL,
  `diet_id` int(11) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `picture_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_program1_idx` (`program_id`),
  KEY `fk_user_picture1_idx` (`picture_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `lastname`, `firstname`, `email`, `password`, `size`, `weight`, `sex`, `birthdate`, `zipcode`, `creation_date`, `allergy_id`, `diet_id`, `program_id`, `picture_id`) VALUES
(3, 'nutriteo', 'nutriteo', 'test@nutriteo.fr', '$2y$10$zBNV7qmb6NN.hEkIza2Zj.TSzsqa6qkgE80JBzW2fiRM/zg4reiU6', 193, 93, 1, '2015-03-30 10:40:25', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_activity`
--

CREATE TABLE IF NOT EXISTS `user_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `duration` int(11) NOT NULL,
  `activity_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_activity_user1_idx` (`user_id`),
  KEY `fk_user_activity_activity1_idx` (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_allergy`
--

CREATE TABLE IF NOT EXISTS `user_allergy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `allergy_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_allergy_user_idx` (`user_id`),
  KEY `fk_user_allergy_allergy1_idx` (`allergy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_diet`
--

CREATE TABLE IF NOT EXISTS `user_diet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `diet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_diet_user1_idx` (`user_id`),
  KEY `fk_user_diet_diet1_idx` (`diet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_food`
--

CREATE TABLE IF NOT EXISTS `user_food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantitfy` int(11) NOT NULL,
  `date_insert` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_food_user1_idx` (`user_id`),
  KEY `fk_user_food_food1_idx` (`food_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_group_user1_idx` (`user_id`),
  KEY `fk_user_group_group1_idx` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `fk_activity_nutriment_family1` FOREIGN KEY (`nutriment_family_id`) REFERENCES `nutriment_family` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `fk_food_food_family1` FOREIGN KEY (`food_family_id`) REFERENCES `food_family` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_food_picture1` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `food_allergy`
--
ALTER TABLE `food_allergy`
  ADD CONSTRAINT `fk_food_allergy_allergy1` FOREIGN KEY (`allergy_id`) REFERENCES `allergy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_food_allergy_food1` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `food_diet_exclusion`
--
ALTER TABLE `food_diet_exclusion`
  ADD CONSTRAINT `fk_food_diet_exclusion_diet1` FOREIGN KEY (`diet_id`) REFERENCES `diet` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_food_diet_exclusion_food1` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `food_nutriment`
--
ALTER TABLE `food_nutriment`
  ADD CONSTRAINT `fk_food_nutriment_food1` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_food_nutriment_nutriment1` FOREIGN KEY (`nutriment_id`) REFERENCES `nutriment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `fk_group_program1` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `nutriment`
--
ALTER TABLE `nutriment`
  ADD CONSTRAINT `fk_nutriment_nutriment_family1` FOREIGN KEY (`nutriment_family_id`) REFERENCES `nutriment_family` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `nutriment_ref`
--
ALTER TABLE `nutriment_ref`
  ADD CONSTRAINT `fk_age_nutriment_nutriment1` FOREIGN KEY (`nutriment_id`) REFERENCES `nutriment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `nutriment_weight`
--
ALTER TABLE `nutriment_weight`
  ADD CONSTRAINT `fk_nutriment_weight_nutriment1` FOREIGN KEY (`nutriment_id`) REFERENCES `nutriment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `program_nutriment`
--
ALTER TABLE `program_nutriment`
  ADD CONSTRAINT `fk_program_nutriment_nutriment1` FOREIGN KEY (`nutriment_id`) REFERENCES `nutriment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_program_nutriment_program1` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_picture1` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_program1` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `fk_user_activity_activity1` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_activity_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_allergy`
--
ALTER TABLE `user_allergy`
  ADD CONSTRAINT `fk_user_allergy_allergy1` FOREIGN KEY (`allergy_id`) REFERENCES `allergy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_allergy_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_diet`
--
ALTER TABLE `user_diet`
  ADD CONSTRAINT `fk_user_diet_diet1` FOREIGN KEY (`diet_id`) REFERENCES `diet` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_diet_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_food`
--
ALTER TABLE `user_food`
  ADD CONSTRAINT `fk_user_food_food1` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_food_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `fk_user_group_group1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_group_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
