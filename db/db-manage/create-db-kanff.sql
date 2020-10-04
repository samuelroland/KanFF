-- --------------------------------------------------------
-- MySQL Workbench Synchronization
-- Generated: 2020-10-01
-- Project: KanFF
-- File: create-db-kanff.sql file for create the kanff database with the tables.
-- Creation date: 01.10.2020d
-- MLD source: MLD-KanFF-official.png v1.3
-- --------------------------------------------------------

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema kanff
-- -----------------------------------------------------
-- Database of KanFF application
DROP SCHEMA IF EXISTS `kanff` ;

-- -----------------------------------------------------
-- Schema kanff
--
-- Database of KanFF application
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kanff` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `kanff` ;

-- -----------------------------------------------------
-- Table `kanff`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`users` ;

CREATE TABLE IF NOT EXISTS `kanff`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(15) NOT NULL,
  `initials` VARCHAR(3) NOT NULL,
  `firstname` VARCHAR(100) NOT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `chat_link` VARCHAR(2000) NULL,
  `email` VARCHAR(254) NULL,
  `phonenumber` VARCHAR(20) NULL,
  `biography` VARCHAR(2000) NULL,
  `password` VARCHAR(255) NOT NULL,
  `inscription` DATETIME NOT NULL,
  `on_break` INT NOT NULL,
  `status` VARCHAR(200) NULL,
  `state` INT NOT NULL,
  `state_modifier_id` INT NULL,
  `state_modification_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `initials_UNIQUE` (`initials` ASC) VISIBLE,
  INDEX `fk_users_users1_idx` (`state_modifier_id` ASC) VISIBLE,
  CONSTRAINT `fk_users_users1`
    FOREIGN KEY (`state_modifier_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`groups` ;

CREATE TABLE IF NOT EXISTS `kanff`.`groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  `context` VARCHAR(1000) NULL,
  `prerequisite` VARCHAR(500) NULL,
  `email` VARCHAR(254) NULL,
  `image` VARCHAR(50) NULL,
  `restrict_access` TINYINT NOT NULL,
  `chat_link` VARCHAR(2000) NULL,
  `drive_link` VARCHAR(2000) NULL,
  `status` VARCHAR(200) NULL,
  `state` INT NOT NULL,
  `visibility` INT NOT NULL,
  `creator_id` INT NOT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
  INDEX `fk_groups_users1_idx` (`creator_id` ASC) VISIBLE,
  CONSTRAINT `fk_groups_users1`
    FOREIGN KEY (`creator_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`projects`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`projects` ;

CREATE TABLE IF NOT EXISTS `kanff`.`projects` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(70) NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  `goal` VARCHAR(1000) NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NULL,
  `state` INT NOT NULL,
  `archived` TINYINT NOT NULL,
  `importance` INT NOT NULL,
  `urgency` INT NOT NULL,
  `visible` TINYINT NOT NULL,
  `logbook_visible` TINYINT NOT NULL,
  `logbook_content` VARCHAR(500) NULL,
  `responsible_id` INT NULL,
  `manager_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
  INDEX `fk_projects_users1_idx` (`responsible_id` ASC) VISIBLE,
  INDEX `fk_projects_groups1_idx` (`manager_id` ASC) VISIBLE,
  CONSTRAINT `fk_projects_users1`
    FOREIGN KEY (`responsible_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_groups1`
    FOREIGN KEY (`manager_id`)
    REFERENCES `kanff`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`works`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`works` ;

CREATE TABLE IF NOT EXISTS `kanff`.`works` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(500) NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NOT NULL,
  `state` INT NOT NULL,
  `value` INT NOT NULL,
  `effort` INT NOT NULL,
  `visible` TINYINT NOT NULL,
  `open` TINYINT NOT NULL,
  `inbox` TINYINT NOT NULL,
  `repetitive` TINYINT NOT NULL,
  `need_help` INT NOT NULL,
  `creation_date` DATETIME NOT NULL,
  `project_id` INT NOT NULL,
  `creator_id` INT NOT NULL,
  `responsible_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_works_projects1_idx` (`project_id` ASC) VISIBLE,
  INDEX `fk_works_users1_idx` (`creator_id` ASC) VISIBLE,
  INDEX `fk_works_users2_idx` (`responsible_id` ASC) VISIBLE,
  CONSTRAINT `fk_works_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `kanff`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_works_users1`
    FOREIGN KEY (`creator_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_works_users2`
    FOREIGN KEY (`responsible_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`tasks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`tasks` ;

CREATE TABLE IF NOT EXISTS `kanff`.`tasks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `number` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `description` VARCHAR(2000) NULL,
  `deadline` DATETIME NULL,
  `state` INT NOT NULL,
  `urgency` INT NOT NULL,
  `type` INT NULL,
  `link` VARCHAR(2000) NULL,
  `completion_date` DATETIME NULL,
  `responsible_id` INT NULL,
  `creator_id` INT NOT NULL,
  `work_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number` ASC) VISIBLE,
  INDEX `fk_tasks_users_idx` (`responsible_id` ASC) VISIBLE,
  INDEX `fk_tasks_users1_idx` (`creator_id` ASC) VISIBLE,
  INDEX `fk_tasks_works1_idx` (`work_id` ASC) VISIBLE,
  CONSTRAINT `fk_tasks_users`
    FOREIGN KEY (`responsible_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tasks_users1`
    FOREIGN KEY (`creator_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tasks_works1`
    FOREIGN KEY (`work_id`)
    REFERENCES `kanff`.`works` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`competences`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`competences` ;

CREATE TABLE IF NOT EXISTS `kanff`.`competences` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `category` VARCHAR(50) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB
COMMENT = '					';


-- -----------------------------------------------------
-- Table `kanff`.`notifications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`notifications` ;

CREATE TABLE IF NOT EXISTS `kanff`.`notifications` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `type` INT NOT NULL,
  `link` VARCHAR(2000) NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`events`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`events` ;

CREATE TABLE IF NOT EXISTS `kanff`.`events` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(90) NOT NULL,
  `description` VARCHAR(2000) NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NOT NULL,
  `place` VARCHAR(200) NULL,
  `type` VARCHAR(30) NOT NULL,
  `link` VARCHAR(2000) NULL,
  `visibility_level` INT NOT NULL,
  `creator_id` INT NOT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `Uniqueevents` (`title` ASC, `end` ASC) VISIBLE,
  INDEX `fk_events_users1_idx` (`creator_id` ASC) VISIBLE,
  CONSTRAINT `fk_events_users1`
    FOREIGN KEY (`creator_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`own`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`own` ;

CREATE TABLE IF NOT EXISTS `kanff`.`own` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `competence_id` INT NOT NULL,
  `level` INT NOT NULL,
  INDEX `fk_users_has_competences_competences1_idx` (`competence_id` ASC) VISIBLE,
  INDEX `fk_users_has_competences_users1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_users_has_competences_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_competences_competences1`
    FOREIGN KEY (`competence_id`)
    REFERENCES `kanff`.`competences` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`suscribe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`suscribe` ;

CREATE TABLE IF NOT EXISTS `kanff`.`suscribe` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  `level` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_has_events_events1_idx` (`event_id` ASC) VISIBLE,
  INDEX `fk_users_has_events_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_users_has_events_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_events_events1`
    FOREIGN KEY (`event_id`)
    REFERENCES `kanff`.`events` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`get`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`get` ;

CREATE TABLE IF NOT EXISTS `kanff`.`get` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `notification_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `read` TINYINT NOT NULL,
  `reading_date` DATETIME NULL,
  `silence` TINYINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_notifications_has_users_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_notifications_has_users_notifications1_idx` (`notification_id` ASC) VISIBLE,
  CONSTRAINT `fk_notifications_has_users_notifications1`
    FOREIGN KEY (`notification_id`)
    REFERENCES `kanff`.`notifications` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notifications_has_users_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`participate`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`participate` ;

CREATE TABLE IF NOT EXISTS `kanff`.`participate` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `project_id` INT NOT NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NULL,
  `state` INT NOT NULL,
  INDEX `fk_groups_has_projects_projects1_idx` (`project_id` ASC) VISIBLE,
  INDEX `fk_groups_has_projects_groups1_idx` (`group_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `UniqueParticipation` (`group_id` ASC, `project_id` ASC) VISIBLE,
  CONSTRAINT `fk_groups_has_projects_groups1`
    FOREIGN KEY (`group_id`)
    REFERENCES `kanff`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_groups_has_projects_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `kanff`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`log` ;

CREATE TABLE IF NOT EXISTS `kanff`.`log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `description` VARCHAR(2000) NOT NULL,
  `date` DATETIME NOT NULL,
  `creation_date` DATETIME NOT NULL,
  `modification_date` DATETIME NULL,
  `visible` TINYINT NOT NULL,
  `user_id` INT NOT NULL,
  `project_id` INT NOT NULL,
  INDEX `fk_users_has_projects_projects1_idx` (`project_id` ASC) VISIBLE,
  INDEX `fk_users_has_projects_users1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_users_has_projects_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_projects_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `kanff`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`join`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`join` ;

CREATE TABLE IF NOT EXISTS `kanff`.`join` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `group_id` INT NOT NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NULL,
  `state` INT NOT NULL DEFAULT 1,
  `admin` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_has_groups_groups1_idx` (`group_id` ASC) VISIBLE,
  INDEX `fk_users_has_groups_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_users_has_groups_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_groups_groups1`
    FOREIGN KEY (`group_id`)
    REFERENCES `kanff`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanff`.`concern`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kanff`.`concern` ;

CREATE TABLE IF NOT EXISTS `kanff`.`concern` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `event_id` INT NOT NULL,
  `group_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_events_has_groups_groups1_idx` (`group_id` ASC) VISIBLE,
  INDEX `fk_events_has_groups_events1_idx` (`event_id` ASC) VISIBLE,
  CONSTRAINT `fk_events_has_groups_events1`
    FOREIGN KEY (`event_id`)
    REFERENCES `kanff`.`events` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_events_has_groups_groups1`
    FOREIGN KEY (`group_id`)
    REFERENCES `kanff`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
