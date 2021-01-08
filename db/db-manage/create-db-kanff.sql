/**
 *  Project: KanFF
 *  File: create-db-kanff.sql file to create database structure of kanff
 *  Author: Samuel Roland
 *  Version date: 06.01.2021
 *  Version: v2.6
 *  MCD: MCD-KanFF-official.png v1.3
 *  MLD: MLD-KanFF-official.png v1.3
 *  Launchable by: restore-db-kanff.bat
 */

-- --------------------------------------------------------
-- MySQL Workbench Synchronization
-- Generated: 2020-10-01
-- Project: KanFF
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

DROP DATABASE `kanff`;
-- Listage de la structure de la base pour kanff
CREATE DATABASE IF NOT EXISTS `kanff` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `kanff`;

-- Listage de la structure de la table kanff. competences
CREATE TABLE IF NOT EXISTS `competences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `category` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='					';

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table kanff. concern
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

-- Listage de la structure de la table kanff. events
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

-- Listage de la structure de la table kanff. get
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

-- Listage de la structure de la table kanff. groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(1000) COLLATE utf8_bin NOT NULL,
  `context` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `prerequisite` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(254) COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `restrict_access` tinyint NOT NULL,
  `chat_link` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `drive_link` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `status` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `state` int NOT NULL,
  `visibility` int NOT NULL,
  `creator_id` int DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_groups_users1_idx` (`creator_id`),
  CONSTRAINT `fk_groups_users1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table kanff. join
CREATE TABLE IF NOT EXISTS `join` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `state` int NOT NULL DEFAULT '1',
  `admin` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_has_groups_groups1_idx` (`group_id`),
  KEY `fk_users_has_groups_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_users_has_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=539 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table kanff. log
CREATE TABLE IF NOT EXISTS `log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` varchar(2000) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime DEFAULT NULL,
  `visible` tinyint NOT NULL,
  `user_id` int DEFAULT NULL,
  `project_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_has_projects_projects1_idx` (`project_id`),
  KEY `fk_users_has_projects_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_projects_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_users_has_projects_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table kanff. notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_bin NOT NULL,
  `type` int NOT NULL,
  `link` varchar(2000) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table kanff. own
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

-- Listage de la structure de la table kanff. participate
CREATE TABLE IF NOT EXISTS `participate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `state` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UniqueParticipation` (`group_id`,`project_id`),
  KEY `fk_groups_has_projects_projects1_idx` (`project_id`),
  KEY `fk_groups_has_projects_groups1_idx` (`group_id`),
  CONSTRAINT `fk_groups_has_projects_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_groups_has_projects_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table kanff. projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8_bin NOT NULL,
  `description` varchar(1000) COLLATE utf8_bin NOT NULL,
  `goal` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `state` int NOT NULL,
  `archived` tinyint NOT NULL,
  `importance` int NOT NULL,
  `urgency` int NOT NULL,
  `visible` tinyint NOT NULL,
  `logbook_visible` tinyint NOT NULL,
  `logbook_content` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `responsible_id` int DEFAULT NULL,
  `manager_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_projects_users1_idx` (`responsible_id`),
  KEY `fk_projects_groups1_idx` (`manager_id`),
  CONSTRAINT `fk_projects_groups1` FOREIGN KEY (`manager_id`) REFERENCES `groups` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_projects_users1` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table kanff. suscribe
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

-- Listage de la structure de la table kanff. tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` int NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `state` int NOT NULL,
  `urgency` int NOT NULL,
  `type` int DEFAULT NULL,
  `link` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `completion_date` datetime DEFAULT NULL,
  `responsible_id` int DEFAULT NULL,
  `creator_id` int DEFAULT NULL,
  `work_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_UNIQUE` (`number`),
  KEY `fk_tasks_users_idx` (`responsible_id`),
  KEY `fk_tasks_users1_idx` (`creator_id`),
  KEY `fk_tasks_works1_idx` (`work_id`),
  CONSTRAINT `fk_tasks_users` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tasks_users1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tasks_works1` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=337 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table kanff. users
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
  `on_break` int NOT NULL,
  `status` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `state` int NOT NULL,
  `state_modifier_id` int DEFAULT NULL,
  `state_modification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `initials_UNIQUE` (`initials`),
  KEY `fk_users_users1_idx` (`state_modifier_id`),
  CONSTRAINT `fk_users_users1` FOREIGN KEY (`state_modifier_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table kanff. works
CREATE TABLE IF NOT EXISTS `works` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `state` int NOT NULL,
  `value` int NOT NULL,
  `effort` int NOT NULL,
  `visible` tinyint NOT NULL,
  `open` tinyint NOT NULL,
  `inbox` tinyint NOT NULL,
  `repetitive` tinyint NOT NULL,
  `need_help` int NOT NULL,
  `creation_date` datetime NOT NULL,
  `project_id` int NOT NULL,
  `creator_id` int DEFAULT NULL,
  `responsible_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_works_projects1_idx` (`project_id`),
  KEY `fk_works_users1_idx` (`creator_id`),
  KEY `fk_works_users2_idx` (`responsible_id`),
  CONSTRAINT `fk_works_projects1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_works_users1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_works_users2` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Les données exportées n'étaient pas sélectionnées.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
