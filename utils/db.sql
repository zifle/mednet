SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mednet` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mednet` ;

-- -----------------------------------------------------
-- Table `mednet`.`mednet_medicine`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_medicine` (
  `medicine_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(30) NOT NULL ,
  `usage` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`medicine_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_symptom_types`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_symptom_types` (
  `symptom_types_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`symptom_types_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_symptoms`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_symptoms` (
  `symptoms_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `type` INT(11) UNSIGNED NOT NULL ,
  `title` VARCHAR(30) NOT NULL ,
  `description` VARCHAR(255) NULL ,
  PRIMARY KEY (`symptoms_id`) ,
  INDEX `fk_symptoms_1` (`type` ASC) ,
  CONSTRAINT `fk_symptoms_1`
    FOREIGN KEY (`type` )
    REFERENCES `mednet`.`mednet_symptom_types` (`symptom_types_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_users` (
  `users_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(70) NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `passhash` VARCHAR(77) NOT NULL ,
  PRIMARY KEY (`users_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_menu`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_menu` (
  `menu_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `parent` INT(11) UNSIGNED NULL DEFAULT 0 ,
  `slug` VARCHAR(20) NOT NULL ,
  `title` VARCHAR(20) NOT NULL ,
  `link` VARCHAR(255) NULL ,
  PRIMARY KEY (`menu_id`) ,
  INDEX `fk_menu_1` (`parent` ASC) ,
  CONSTRAINT `fk_menu_1`
    FOREIGN KEY (`parent` )
    REFERENCES `mednet`.`mednet_menu` (`menu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_pages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_pages` (
  `pages_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(50) NOT NULL ,
  `content` TEXT NOT NULL ,
  `template` VARCHAR(20) NOT NULL ,
  `footer` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`pages_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_pharmacies`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_pharmacies` (
  `pharmacies_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(20) NOT NULL ,
  `zipcode` INT(4) NOT NULL ,
  `longitude` VARCHAR(45) NULL ,
  `latitude` VARCHAR(45) NULL ,
  PRIMARY KEY (`pharmacies_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_illnesses`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_illnesses` (
  `illnesses_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(30) NOT NULL ,
  `latin_name` VARCHAR(30) NULL ,
  `description` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`illnesses_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_articles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_articles` (
  `articles_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NOT NULL ,
  `content` TEXT NOT NULL ,
  `teaser` VARCHAR(100) NULL ,
  `image` VARCHAR(255) NULL ,
  `symptom` INT(11) UNSIGNED NULL ,
  `medicine` INT(11) UNSIGNED NULL ,
  `pharmacy` INT(11) UNSIGNED NULL ,
  `illness` INT(11) UNSIGNED NULL ,
  `publish` DATETIME NOT NULL ,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`articles_id`) ,
  INDEX `fk_articles_1` (`medicine` ASC) ,
  INDEX `fk_articles_2` (`pharmacy` ASC) ,
  INDEX `fk_articles_3` (`illness` ASC) ,
  INDEX `fk_articles_4` (`symptom` ASC) ,
  CONSTRAINT `fk_articles_1`
    FOREIGN KEY (`medicine` )
    REFERENCES `mednet`.`mednet_medicine` (`medicine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_articles_2`
    FOREIGN KEY (`pharmacy` )
    REFERENCES `mednet`.`mednet_pharmacies` (`pharmacies_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_articles_3`
    FOREIGN KEY (`illness` )
    REFERENCES `mednet`.`mednet_illnesses` (`illnesses_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_articles_4`
    FOREIGN KEY (`symptom` )
    REFERENCES `mednet`.`mednet_symptoms` (`symptoms_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_doses`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_doses` (
  `doses_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `medicine` INT(11) UNSIGNED NOT NULL ,
  `text` VARCHAR(150) NOT NULL ,
  PRIMARY KEY (`doses_id`) ,
  INDEX `fk_doses_1` (`medicine` ASC) ,
  CONSTRAINT `fk_doses_1`
    FOREIGN KEY (`medicine` )
    REFERENCES `mednet`.`mednet_medicine` (`medicine_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_medicine_prices`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_medicine_prices` (
  `medicine_prices_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `medicine` INT(11) UNSIGNED NOT NULL ,
  `price` INT(11) NOT NULL ,
  `receipt_required` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 ,
  `quantity` INT(11) UNSIGNED NOT NULL DEFAULT 0 ,
  `quantity_type` VARCHAR(10) NOT NULL ,
  `doses` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`medicine_prices_id`) ,
  INDEX `fk_medicine_prices_1` (`medicine` ASC) ,
  CONSTRAINT `fk_medicine_prices_1`
    FOREIGN KEY (`medicine` )
    REFERENCES `mednet`.`mednet_medicine` (`medicine_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_symptom_visits`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_symptom_visits` (
  `symptom_visits_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `symptom` INT(11) UNSIGNED NOT NULL ,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`symptom_visits_id`) ,
  INDEX `fk_symptom_visits_1` (`symptom` ASC) ,
  CONSTRAINT `fk_symptom_visits_1`
    FOREIGN KEY (`symptom` )
    REFERENCES `mednet`.`mednet_symptoms` (`symptoms_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_medicine_visits`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_medicine_visits` (
  `medicine_visits_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `medicine` INT(11) UNSIGNED NOT NULL ,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`medicine_visits_id`) ,
  INDEX `fk_medicine_visits_1` (`medicine` ASC) ,
  CONSTRAINT `fk_medicine_visits_1`
    FOREIGN KEY (`medicine` )
    REFERENCES `mednet`.`mednet_medicine` (`medicine_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_illness_visits`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_illness_visits` (
  `illness_visits_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `illness` INT(11) UNSIGNED NOT NULL ,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`illness_visits_id`) ,
  INDEX `fk_illness_visits_1` (`illness` ASC) ,
  CONSTRAINT `fk_illness_visits_1`
    FOREIGN KEY (`illness` )
    REFERENCES `mednet`.`mednet_illnesses` (`illnesses_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_pharmacy_visits`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_pharmacy_visits` (
  `pharmacy_visits_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `pharmacy` INT(11) UNSIGNED NOT NULL ,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`pharmacy_visits_id`) ,
  INDEX `fk_pharmacy_visits_1` (`pharmacy` ASC) ,
  CONSTRAINT `fk_pharmacy_visits_1`
    FOREIGN KEY (`pharmacy` )
    REFERENCES `mednet`.`mednet_pharmacies` (`pharmacies_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_medicine_symptoms`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_medicine_symptoms` (
  `medicine` INT(11) UNSIGNED NOT NULL ,
  `symptom` INT(11) UNSIGNED NOT NULL ,
  PRIMARY KEY (`medicine`, `symptom`) ,
  INDEX `fk_medicine_symptoms_1` (`medicine` ASC) ,
  INDEX `fk_medicine_symptoms_2` (`symptom` ASC) ,
  CONSTRAINT `fk_medicine_symptoms_1`
    FOREIGN KEY (`medicine` )
    REFERENCES `mednet`.`mednet_medicine` (`medicine_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_medicine_symptoms_2`
    FOREIGN KEY (`symptom` )
    REFERENCES `mednet`.`mednet_symptoms` (`symptoms_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_user_medicine`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_user_medicine` (
  `user` INT(11) UNSIGNED NOT NULL ,
  `medicine` INT(11) UNSIGNED NOT NULL ,
  PRIMARY KEY (`user`, `medicine`) ,
  INDEX `fk_user_medicine_1` (`user` ASC) ,
  INDEX `fk_user_medicine_2` (`medicine` ASC) ,
  CONSTRAINT `fk_user_medicine_1`
    FOREIGN KEY (`user` )
    REFERENCES `mednet`.`mednet_users` (`users_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_medicine_2`
    FOREIGN KEY (`medicine` )
    REFERENCES `mednet`.`mednet_medicine` (`medicine_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_illness_symptoms`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_illness_symptoms` (
  `illness` INT(11) UNSIGNED NOT NULL ,
  `symptom` INT(11) UNSIGNED NOT NULL ,
  PRIMARY KEY (`illness`, `symptom`) ,
  INDEX `fk_illness_symptoms_1` (`illness` ASC) ,
  INDEX `fk_illness_symptoms_2` (`symptom` ASC) ,
  CONSTRAINT `fk_illness_symptoms_1`
    FOREIGN KEY (`illness` )
    REFERENCES `mednet`.`mednet_illnesses` (`illnesses_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_illness_symptoms_2`
    FOREIGN KEY (`symptom` )
    REFERENCES `mednet`.`mednet_symptoms` (`symptoms_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_user_illness`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_user_illness` (
  `user` INT(11) UNSIGNED NOT NULL ,
  `illness` INT(11) UNSIGNED NOT NULL ,
  PRIMARY KEY (`user`, `illness`) ,
  INDEX `fk_user_illness_1` (`user` ASC) ,
  INDEX `fk_user_illness_2` (`illness` ASC) ,
  CONSTRAINT `fk_user_illness_1`
    FOREIGN KEY (`user` )
    REFERENCES `mednet`.`mednet_users` (`users_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_illness_2`
    FOREIGN KEY (`illness` )
    REFERENCES `mednet`.`mednet_illnesses` (`illnesses_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_admin_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_admin_users` (
  `admin_users_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `login` VARCHAR(20) NOT NULL ,
  `passhash` VARCHAR(77) NOT NULL ,
  PRIMARY KEY (`admin_users_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mednet`.`mednet_ci_sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mednet`.`mednet_ci_sessions` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0' ,
  `ip_address` VARCHAR(45) NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(120) NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `user_data` TEXT NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `last_activity_idx` (`last_activity` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
