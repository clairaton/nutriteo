-- MySQL Script generated by MySQL Workbench
-- 04/03/15 14:29:24
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema nutriteo
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema nutriteo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `nutriteo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `nutriteo` ;

-- -----------------------------------------------------
-- Table `nutriteo`.`program`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`program` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`program` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`picture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`picture` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`picture` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `source` VARCHAR(255) NOT NULL,
  `type` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`user` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lastname` VARCHAR(45) NOT NULL,
  `firstname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `size` INT NOT NULL,
  `weight` INT NOT NULL,
  `sex` INT NOT NULL,
  `birthdate` DATETIME NOT NULL,
  `zipcode` VARCHAR(45) NULL,
  `creation_date` DATETIME NULL,
  `allergy_id` INT NULL,
  `diet_id` INT NULL,
  `program_id` INT NULL,
  `picture_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_program1_idx` (`program_id` ASC),
  INDEX `fk_user_picture1_idx` (`picture_id` ASC),
  CONSTRAINT `fk_user_program1`
    FOREIGN KEY (`program_id`)
    REFERENCES `nutriteo`.`program` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_picture1`
    FOREIGN KEY (`picture_id`)
    REFERENCES `nutriteo`.`picture` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`allergy`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`allergy` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`allergy` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`diet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`diet` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`diet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`nutriment_family`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`nutriment_family` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`nutriment_family` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`nutriment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`nutriment` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`nutriment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `unity` VARCHAR(45) NOT NULL,
  `nutriment_family_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_nutriment_nutriment_family1_idx` (`nutriment_family_id` ASC),
  CONSTRAINT `fk_nutriment_nutriment_family1`
    FOREIGN KEY (`nutriment_family_id`)
    REFERENCES `nutriteo`.`nutriment_family` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`food_family`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`food_family` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`food_family` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`food`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`food` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`food` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `picture_id` INT NOT NULL,
  `food_family_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_food_picture1_idx` (`picture_id` ASC),
  INDEX `fk_food_food_family1_idx` (`food_family_id` ASC),
  CONSTRAINT `fk_food_picture1`
    FOREIGN KEY (`picture_id`)
    REFERENCES `nutriteo`.`picture` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_food_food_family1`
    FOREIGN KEY (`food_family_id`)
    REFERENCES `nutriteo`.`food_family` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`food_nutriment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`food_nutriment` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`food_nutriment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `food_id` INT NOT NULL,
  `nutriment_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_food_nutriment_food1_idx` (`food_id` ASC),
  INDEX `fk_food_nutriment_nutriment1_idx` (`nutriment_id` ASC),
  CONSTRAINT `fk_food_nutriment_food1`
    FOREIGN KEY (`food_id`)
    REFERENCES `nutriteo`.`food` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_food_nutriment_nutriment1`
    FOREIGN KEY (`nutriment_id`)
    REFERENCES `nutriteo`.`nutriment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`nutriment_ref`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`nutriment_ref` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`nutriment_ref` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nutriment_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `weight` INT NOT NULL,
  `sex` INT NOT NULL,
  `age_min` INT NOT NULL,
  `age_max` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_age_nutriment_nutriment1_idx` (`nutriment_id` ASC),
  CONSTRAINT `fk_age_nutriment_nutriment1`
    FOREIGN KEY (`nutriment_id`)
    REFERENCES `nutriteo`.`nutriment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`nutriment_weight`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`nutriment_weight` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`nutriment_weight` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nutriment_id` INT NOT NULL,
  `weigth` INT NULL,
  `quantity` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_nutriment_weight_nutriment1_idx` (`nutriment_id` ASC),
  CONSTRAINT `fk_nutriment_weight_nutriment1`
    FOREIGN KEY (`nutriment_id`)
    REFERENCES `nutriteo`.`nutriment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`program_nutriment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`program_nutriment` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`program_nutriment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `program_id` INT NOT NULL,
  `nutriment_id` INT NOT NULL,
  `coeff` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_program_nutriment_program1_idx` (`program_id` ASC),
  INDEX `fk_program_nutriment_nutriment1_idx` (`nutriment_id` ASC),
  CONSTRAINT `fk_program_nutriment_program1`
    FOREIGN KEY (`program_id`)
    REFERENCES `nutriteo`.`program` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_program_nutriment_nutriment1`
    FOREIGN KEY (`nutriment_id`)
    REFERENCES `nutriteo`.`nutriment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`user_food`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`user_food` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`user_food` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `food_id` INT NOT NULL,
  `quantitfy` INT NOT NULL,
  `date_insert` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_food_user1_idx` (`user_id` ASC),
  INDEX `fk_user_food_food1_idx` (`food_id` ASC),
  CONSTRAINT `fk_user_food_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `nutriteo`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_food_food1`
    FOREIGN KEY (`food_id`)
    REFERENCES `nutriteo`.`food` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`intensity`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`intensity` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`intensity` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `level` INT NOT NULL,
  `coeff` FLOAT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`user_allergy`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`user_allergy` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`user_allergy` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `allergy_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_allergy_user_idx` (`user_id` ASC),
  INDEX `fk_user_allergy_allergy1_idx` (`allergy_id` ASC),
  CONSTRAINT `fk_user_allergy_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `nutriteo`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_allergy_allergy1`
    FOREIGN KEY (`allergy_id`)
    REFERENCES `nutriteo`.`allergy` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`food_allergy`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`food_allergy` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`food_allergy` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `food_id` INT NOT NULL,
  `allergy_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_food_allergy_food1_idx` (`food_id` ASC),
  INDEX `fk_food_allergy_allergy1_idx` (`allergy_id` ASC),
  CONSTRAINT `fk_food_allergy_food1`
    FOREIGN KEY (`food_id`)
    REFERENCES `nutriteo`.`food` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_food_allergy_allergy1`
    FOREIGN KEY (`allergy_id`)
    REFERENCES `nutriteo`.`allergy` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`food_diet_exclusion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`food_diet_exclusion` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`food_diet_exclusion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `food_id` INT NOT NULL,
  `diet_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_food_diet_exclusion_food1_idx` (`food_id` ASC),
  INDEX `fk_food_diet_exclusion_diet1_idx` (`diet_id` ASC),
  CONSTRAINT `fk_food_diet_exclusion_food1`
    FOREIGN KEY (`food_id`)
    REFERENCES `nutriteo`.`food` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_food_diet_exclusion_diet1`
    FOREIGN KEY (`diet_id`)
    REFERENCES `nutriteo`.`diet` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`user_diet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`user_diet` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`user_diet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `diet_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_diet_user1_idx` (`user_id` ASC),
  INDEX `fk_user_diet_diet1_idx` (`diet_id` ASC),
  CONSTRAINT `fk_user_diet_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `nutriteo`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_diet_diet1`
    FOREIGN KEY (`diet_id`)
    REFERENCES `nutriteo`.`diet` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`group` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `program_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_group_program1_idx` (`program_id` ASC),
  CONSTRAINT `fk_group_program1`
    FOREIGN KEY (`program_id`)
    REFERENCES `nutriteo`.`program` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`user_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`user_group` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`user_group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `group_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_group_user1_idx` (`user_id` ASC),
  INDEX `fk_user_group_group1_idx` (`group_id` ASC),
  CONSTRAINT `fk_user_group_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `nutriteo`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_group1`
    FOREIGN KEY (`group_id`)
    REFERENCES `nutriteo`.`group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`food_diet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`food_diet` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`food_diet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `food_id` INT NOT NULL,
  `diet_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_food_diet_food1_idx` (`food_id` ASC),
  INDEX `fk_food_diet_diet1_idx` (`diet_id` ASC),
  CONSTRAINT `fk_food_diet_food1`
    FOREIGN KEY (`food_id`)
    REFERENCES `nutriteo`.`food` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_food_diet_diet1`
    FOREIGN KEY (`diet_id`)
    REFERENCES `nutriteo`.`diet` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`activity`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`activity` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`activity` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `impact` VARCHAR(45) NOT NULL,
  `nutriment_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_activity_nutriment1_idx` (`nutriment_id` ASC),
  CONSTRAINT `fk_activity_nutriment1`
    FOREIGN KEY (`nutriment_id`)
    REFERENCES `nutriteo`.`nutriment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nutriteo`.`user_activity`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nutriteo`.`user_activity` ;

CREATE TABLE IF NOT EXISTS `nutriteo`.`user_activity` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `duration` INT NOT NULL,
  `activity_date` DATETIME NOT NULL,
  `user_id` INT NOT NULL,
  `activity_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_activity_user1_idx` (`user_id` ASC),
  INDEX `fk_user_activity_activity1_idx` (`activity_id` ASC),
  CONSTRAINT `fk_user_activity_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `nutriteo`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_activity_activity1`
    FOREIGN KEY (`activity_id`)
    REFERENCES `nutriteo`.`activity` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
