-- MySQL Script generated by MySQL Workbench
-- ven. 21 oct. 2022 11:41:29
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema portfolio
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `portfolio` ;

-- -----------------------------------------------------
-- Schema portfolio
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `portfolio` DEFAULT CHARACTER SET utf8 ;
USE `portfolio` ;

-- -----------------------------------------------------
-- Table `portfolio`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `portfolio`.`user` ;

CREATE TABLE IF NOT EXISTS `portfolio`.`user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `is_admin` TINYINT(1) UNSIGNED NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `portfolio`.` article`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `portfolio`.` article` ;

CREATE TABLE IF NOT EXISTS `portfolio`.` article` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `text` TEXT(5000) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT PARENT_TIMESTAMP COMMENT 'Times stamp? 0?',
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`),
  UNIQUE INDEX `id article_UNIQUE` (`id` ASC),
  INDEX `fk_ article_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_ article_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `portfolio`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `portfolio`.`image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `portfolio`.`image` ;

CREATE TABLE IF NOT EXISTS `portfolio`.`image` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(2048) NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_image_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_image_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `portfolio`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `portfolio`.` article_has_image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `portfolio`.` article_has_image` ;

CREATE TABLE IF NOT EXISTS `portfolio`.` article_has_image` (
  ` article_id` INT UNSIGNED NOT NULL,
  ` article_user_id` INT UNSIGNED NOT NULL,
  `image_id` INT UNSIGNED NOT NULL,
  `image_user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (` article_id`, ` article_user_id`, `image_id`, `image_user_id`),
  INDEX `fk_ article_has_image_image1_idx` (`image_id` ASC, `image_user_id` ASC),
  INDEX `fk_ article_has_image_ article1_idx` (` article_id` ASC, ` article_user_id` ASC),
  CONSTRAINT `fk_ article_has_image_ article1`
    FOREIGN KEY (` article_id` , ` article_user_id`)
    REFERENCES `portfolio`.` article` (`id` , `user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ article_has_image_image1`
    FOREIGN KEY (`image_id` , `image_user_id`)
    REFERENCES `portfolio`.`image` (`id` , `user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
