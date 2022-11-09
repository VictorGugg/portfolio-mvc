DROP SCHEMA IF EXISTS `portfolio`;
CREATE SCHEMA IF NOT EXISTS `portfolio` DEFAULT CHARACTER SET utf8 ;
USE `portfolio` ;

DROP TABLE IF EXISTS `portfolio`.`image` ;
CREATE TABLE IF NOT EXISTS `portfolio`.`image` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(2048) NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  PRIMARY KEY (`id`)
);


DROP TABLE IF EXISTS `portfolio`.`user` ;

CREATE TABLE IF NOT EXISTS `portfolio`.`user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `is_admin` TINYINT(1) UNSIGNED NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `portfolio`.`article` ;

CREATE TABLE IF NOT EXISTS `portfolio`.`article` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `text` TEXT(5000) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
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


DROP TABLE IF EXISTS `portfolio`.`article_has_image` ;

CREATE TABLE IF NOT EXISTS `portfolio`.`article_has_image` (
  `article_id` INT UNSIGNED NOT NULL,
  `article_user_id` INT UNSIGNED NOT NULL,
  `image_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`article_id`, `article_user_id`, `image_id`),
  INDEX `fk_article_has_image_image1_idx` (`image_id` ASC),
  INDEX `fk_article_has_image_ article1_idx` (`article_id` ASC, `article_user_id` ASC),
  CONSTRAINT `fk_article_has_image_article1`
    FOREIGN KEY (`article_id` , `article_user_id`)
    REFERENCES `portfolio`.`article` (`id` , `user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_has_image_image1`
    FOREIGN KEY (`image_id`)
    REFERENCES `portfolio`.`image` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
