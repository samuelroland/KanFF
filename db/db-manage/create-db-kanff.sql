-- MySQL Workbench Synchronization
-- Generated: 2020-08-25 17:17
-- Project: KanFF
-- File: create-db-kanff.sql file for create the kanff database with the tables.
-- Creation date: 09.05.2020
-- MLD source: MLD-KanFF-official.png v1.2

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

ALTER SCHEMA `kanff`  DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_bin ;

CREATE TABLE IF NOT EXISTS `kanff`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(15) NOT NULL,
  `initials` VARCHAR(3) NOT NULL,
  `firstname` VARCHAR(100) NOT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `chat_link` VARCHAR(2000) NULL DEFAULT NULL,
  `email` VARCHAR(254) NULL DEFAULT NULL,
  `phonenumber` VARCHAR(20) NULL DEFAULT NULL,
  `biography` VARCHAR(2000) NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `inscription` DATETIME NOT NULL,
  `status` VARCHAR(200) NULL DEFAULT NULL,
  `state` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `initials_UNIQUE` (`initials` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(200) NOT NULL,
  `context` VARCHAR(200) NULL DEFAULT NULL,
  `email` VARCHAR(254) NULL DEFAULT NULL,
  `image` VARCHAR(50) NULL DEFAULT NULL,
  `restrict_access` TINYINT(4) NOT NULL,
  `chat_link` VARCHAR(2000) NULL DEFAULT NULL,
  `drive_link` VARCHAR(2000) NULL DEFAULT NULL,
  `status` VARCHAR(200) NULL DEFAULT NULL,
  `state` INT(11) NOT NULL,
  `visibility` INT(11) NOT NULL,
  `creator_id` INT(11) NOT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE,
  INDEX `fk_groups_users1_idx` (`creator_id` ASC) VISIBLE,
  CONSTRAINT `fk_groups_users1`
    FOREIGN KEY (`creator_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`projects` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(70) NOT NULL,
  `description` VARCHAR(500) NOT NULL,
  `goal` VARCHAR(500) NULL DEFAULT NULL,
  `start` DATETIME NULL DEFAULT NULL,
  `end` DATETIME NULL DEFAULT NULL,
  `state` INT(11) NOT NULL,
  `importance` INT(11) NOT NULL,
  `urgency` INT(11) NOT NULL,
  `visible` TINYINT(4) NOT NULL,
  `logbook_visible` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`works` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(200) NULL DEFAULT NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NOT NULL,
  `state` INT(11) NOT NULL,
  `value` INT(11) NOT NULL,
  `effort` INT(11) NOT NULL,
  `visible` TINYINT(4) NOT NULL,
  `project_id` INT(11) NOT NULL,
  `creator_id` INT(11) NOT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_works_projects1_idx` (`project_id` ASC) VISIBLE,
  INDEX `fk_works_users1_idx` (`creator_id` ASC) VISIBLE,
  CONSTRAINT `fk_works_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `kanff`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_works_users1`
    FOREIGN KEY (`creator_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`tasks` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `number` INT(11) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(2000) NULL DEFAULT NULL,
  `deadline` DATETIME NULL DEFAULT NULL,
  `state` INT(11) NOT NULL,
  `urgency` INT(11) NOT NULL,
  `link` VARCHAR(2000) NULL DEFAULT NULL,
  `user_id` INT(11) NULL DEFAULT NULL,
  `creator_id` INT(11) NOT NULL,
  `work_id` INT(11) NOT NULL,
  `completion_date` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number` ASC) VISIBLE,
  INDEX `fk_tasks_users_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_tasks_users1_idx` (`creator_id` ASC) VISIBLE,
  INDEX `fk_tasks_works1_idx` (`work_id` ASC) VISIBLE,
  CONSTRAINT `fk_tasks_users`
    FOREIGN KEY (`user_id`)
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`competences` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `category` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin
COMMENT = '					';

CREATE TABLE IF NOT EXISTS `kanff`.`notifications` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `type` INT(11) NOT NULL,
  `link` VARCHAR(2000) NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`events` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(90) NOT NULL,
  `description` VARCHAR(2000) NULL DEFAULT NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NOT NULL,
  `place` VARCHAR(200) NULL DEFAULT NULL,
  `type` VARCHAR(30) NOT NULL,
  `link` VARCHAR(2000) NULL DEFAULT NULL,
  `visibility_level` INT(11) NOT NULL,
  `creator_id` INT(11) NOT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `Uniqueevents` (`title` ASC, `end` ASC) VISIBLE,
  INDEX `fk_events_users1_idx` (`creator_id` ASC) VISIBLE,
  CONSTRAINT `fk_events_users1`
    FOREIGN KEY (`creator_id`)
    REFERENCES `kanff`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`own` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `competence_id` INT(11) NOT NULL,
  `level` INT(11) NOT NULL,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`suscribe` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `event_id` INT(11) NOT NULL,
  `level` INT(11) NULL DEFAULT NULL,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`get` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `notification_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `read` TINYINT(4) NOT NULL,
  `reading_date` DATETIME NULL DEFAULT NULL,
  `silence` TINYINT(4) NOT NULL,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`participate` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `group_id` INT(11) NOT NULL,
  `project_id` INT(11) NOT NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NULL DEFAULT NULL,
  `reason_start` VARCHAR(45) NULL DEFAULT NULL,
  `reason_end` VARCHAR(45) NULL DEFAULT NULL,
  INDEX `fk_groups_has_projects_projects1_idx` (`project_id` ASC) VISIBLE,
  INDEX `fk_groups_has_projects_groups1_idx` (`group_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `project_id` INT(11) NOT NULL,
  `description` VARCHAR(2000) NOT NULL,
  `date` DATETIME NOT NULL,
  `context` VARCHAR(200) NULL DEFAULT NULL,
  `type` VARCHAR(45) NOT NULL,
  `importance` INT(11) NOT NULL,
  `creation_date` DATETIME NOT NULL,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`join` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `group_id` INT(11) NOT NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NULL DEFAULT NULL,
  `accepted` INT(11) NOT NULL DEFAULT 1,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE TABLE IF NOT EXISTS `kanff`.`concern` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `event_id` INT(11) NOT NULL,
  `group_id` INT(11) NOT NULL,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
