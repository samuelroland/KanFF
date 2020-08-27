-- --------------------------------------------------------
-- MySQL Workbench Synchronization
-- Generated: 2020-08-25 17:17
-- Project: KanFF
-- File: create-db-Kanff.sql file for create the Kanff database with the tables.
-- Creation date: 09.05.2020
-- MLD source: MLD-KanFF-official.png v1.2
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour Kanff
DROP DATABASE IF EXISTS `Kanff`;
CREATE DATABASE IF NOT EXISTS `Kanff` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `Kanff`;

-- Listage de la structure de la table Kanff. competences
DROP TABLE IF EXISTS `competences`;
CREATE TABLE IF NOT EXISTS `competences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `category` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='					';

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. concern
DROP TABLE IF EXISTS `concern`;
CREATE TABLE IF NOT EXISTS `concern` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `group_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_has_groups_groups1_idx` (`group_id`),
  KEY `fk_events_has_groups_events1_idx` (`event_id`),
  CONSTRAINT `fk_events_has_groups_events1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  CONSTRAINT `fk_events_has_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. events
DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(90) COLLATE utf8_bin NOT NULL,
  `description` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `place` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(30) COLLATE utf8_bin NOT NULL,
  `link` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `visibility_level` int NOT NULL,
  `creator_id` int NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Uniqueevents` (`title`,`end`),
  KEY `fk_events_users1_idx` (`creator_id`),
  CONSTRAINT `fk_events_users1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. get
DROP TABLE IF EXISTS `get`;
CREATE TABLE IF NOT EXISTS `get` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notification_id` int NOT NULL,
  `user_id` int NOT NULL,
  `read` tinyint NOT NULL,
  `reading_date` datetime DEFAULT NULL,
  `silence` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_notifications_has_users_users1_idx` (`user_id`),
  KEY `fk_notifications_has_users_notifications1_idx` (`notification_id`),
  CONSTRAINT `fk_notifications_has_users_notifications1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`),
  CONSTRAINT `fk_notifications_has_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. groups
DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(200) COLLATE utf8_bin NOT NULL,
  `context` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(254) COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `restrict_access` tinyint NOT NULL,
  `chat_link` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `drive_link` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `status` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `state` int NOT NULL,
  `visibility` int NOT NULL,
  `creator_id` int NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_groups_users1_idx` (`creator_id`),
  CONSTRAINT `fk_groups_users1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. join
DROP TABLE IF EXISTS `join`;
CREATE TABLE IF NOT EXISTS `join` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `group_id` int NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `accepted` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_users_has_groups_groups1_idx` (`group_id`),
  KEY `fk_users_has_groups_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  CONSTRAINT `fk_users_has_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=634 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. log
DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `project_id` int NOT NULL,
  `description` varchar(2000) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  `context` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(45) COLLATE utf8_bin NOT NULL,
  `importance` int NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_has_projects_projects1_idx` (`project_id`),
  KEY `fk_users_has_projects_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_projects_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `fk_users_has_projects_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. notifications
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_bin NOT NULL,
  `type` int NOT NULL,
  `link` varchar(2000) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. own
DROP TABLE IF EXISTS `own`;
CREATE TABLE IF NOT EXISTS `own` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `competence_id` int NOT NULL,
  `level` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_has_competences_competences1_idx` (`competence_id`),
  KEY `fk_users_has_competences_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_competences_competences1` FOREIGN KEY (`competence_id`) REFERENCES `competences` (`id`),
  CONSTRAINT `fk_users_has_competences_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. participate
DROP TABLE IF EXISTS `participate`;
CREATE TABLE IF NOT EXISTS `participate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `project_id` int NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `reason_start` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `reason_end` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_groups_has_projects_projects1_idx` (`project_id`),
  KEY `fk_groups_has_projects_groups1_idx` (`group_id`),
  CONSTRAINT `fk_groups_has_projects_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  CONSTRAINT `fk_groups_has_projects_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. projects
DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_bin NOT NULL,
  `description` varchar(500) COLLATE utf8_bin NOT NULL,
  `goal` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `state` int NOT NULL,
  `importance` int NOT NULL,
  `urgency` int NOT NULL,
  `visible` tinyint NOT NULL,
  `logbook_visible` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. suscribe
DROP TABLE IF EXISTS `suscribe`;
CREATE TABLE IF NOT EXISTS `suscribe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `level` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_has_events_events1_idx` (`event_id`),
  KEY `fk_users_has_events_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_events_events1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  CONSTRAINT `fk_users_has_events_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. tasks
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` int NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `state` int NOT NULL,
  `urgency` int NOT NULL,
  `link` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `creator_id` int NOT NULL,
  `work_id` int NOT NULL,
  `completion_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_UNIQUE` (`number`),
  KEY `fk_tasks_users_idx` (`user_id`),
  KEY `fk_tasks_users1_idx` (`creator_id`),
  KEY `fk_tasks_works1_idx` (`work_id`),
  CONSTRAINT `fk_tasks_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_tasks_users1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_tasks_works1` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) COLLATE utf8_bin NOT NULL,
  `initials` varchar(3) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(100) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(100) COLLATE utf8_bin NOT NULL,
  `chat_link` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(254) COLLATE utf8_bin DEFAULT NULL,
  `phonenumber` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `biography` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `inscription` datetime NOT NULL,
  `status` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `state` int NOT NULL DEFAULT '9',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `initials_UNIQUE` (`initials`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table Kanff. works
DROP TABLE IF EXISTS `works`;
CREATE TABLE IF NOT EXISTS `works` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `state` int NOT NULL,
  `value` int NOT NULL,
  `effort` int NOT NULL,
  `visible` tinyint NOT NULL,
  `project_id` int NOT NULL,
  `creator_id` int NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_works_projects1_idx` (`project_id`),
  KEY `fk_works_users1_idx` (`creator_id`),
  CONSTRAINT `fk_works_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `fk_works_users1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
