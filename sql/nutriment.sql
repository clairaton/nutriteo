-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 03 Avril 2015 à 14:20
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

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `nutriment`
--
ALTER TABLE `nutriment`
  ADD CONSTRAINT `fk_nutriment_nutriment_family1` FOREIGN KEY (`nutriment_family_id`) REFERENCES `nutriment_family` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
