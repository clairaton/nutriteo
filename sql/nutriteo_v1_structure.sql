-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 17 Avril 2015 à 16:59
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Structure de la table `allergy`
--

CREATE TABLE IF NOT EXISTS `allergy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `diet`
--

CREATE TABLE IF NOT EXISTS `diet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `picture_id` int(11) NOT NULL DEFAULT '1',
  `food_family_id` int(11) NOT NULL,
  `priority` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_food_picture1_idx` (`picture_id`),
  KEY `fk_food_food_family1_idx` (`food_family_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1516 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `food_category`
--

CREATE TABLE IF NOT EXISTS `food_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `food_category_family`
--

CREATE TABLE IF NOT EXISTS `food_category_family` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `food_category_id` int(11) NOT NULL,
  `food_family_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_food_category_family_food_category1_idx` (`food_category_id`),
  KEY `fk_food_category_family_food_family1_idx` (`food_family_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `food_family`
--

CREATE TABLE IF NOT EXISTS `food_family` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1490 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52361 ;

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

-- --------------------------------------------------------

--
-- Structure de la table `lead`
--

CREATE TABLE IF NOT EXISTS `lead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_adress` varchar(89) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `nutriment`
--

CREATE TABLE IF NOT EXISTS `nutriment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `unity` varchar(45) NOT NULL,
  `nutriment_family_id` int(11) NOT NULL,
  `description` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nutriment_nutriment_family1_idx` (`nutriment_family_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Structure de la table `nutriment_family`
--

CREATE TABLE IF NOT EXISTS `nutriment_family` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `unity_ref` varchar(45) NOT NULL,
  `description` varchar(80) NOT NULL,
  `board_order` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=810 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1528 ;

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
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `allergy_id` int(11) DEFAULT NULL,
  `diet_id` int(11) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `picture_id` int(11) DEFAULT '3',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`),
  KEY `fk_user_program1_idx` (`program_id`),
  KEY `fk_user_picture1_idx` (`picture_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_activity`
--

CREATE TABLE IF NOT EXISTS `user_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `duration` int(11) NOT NULL,
  `activity_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `intensity_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_activity_user1_idx` (`user_id`),
  KEY `fk_user_activity_intensity1_idx` (`intensity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

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
  `quantity` int(11) NOT NULL,
  `date_insert` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_food_user1_idx` (`user_id`),
  KEY `fk_user_food_food1_idx` (`food_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=188 ;

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

-- --------------------------------------------------------

--
-- Structure de la table `user_objectives`
--

CREATE TABLE IF NOT EXISTS `user_objectives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nutriment_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_objectives` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_objectives_user1_idx` (`user_id`),
  KEY `fk_user_food_nutriment1_idx` (`nutriment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10395 ;

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
-- Contraintes pour la table `food_category_family`
--
ALTER TABLE `food_category_family`
  ADD CONSTRAINT `fk_food_category_family_food_category1` FOREIGN KEY (`food_category_id`) REFERENCES `food_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_food_category_family_food_family1` FOREIGN KEY (`food_family_id`) REFERENCES `food_family` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_user_activity_intensity1` FOREIGN KEY (`intensity_id`) REFERENCES `intensity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
