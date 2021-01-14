# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 127.0.0.1 (MySQL 5.7.25)
# Base de données: architecture_web_tp1
# Temps de génération: 2019-08-11 14:34:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Display comments table
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) unsigned NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `created_at` date NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `todos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;

INSERT INTO `comments` (`task_id`, `created_by`, `created_at`, `comment`)
VALUES
	(1,2,'2020-09-10','Study also for the exam!'),
	(1,3,'2020-09-18','Yeah! I should do that too...'),
  (2,3,'2020-10-27','It looks like an interesting framework.'),
  (3,3,'2020-11-01','I think i am really getting the hang of this.'),
  (4,2,'2020-11-04','This is actually really useful!'),
  (4,3,'2020-11-04','Sure thing!');

/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;


# Display todos table
# ------------------------------------------------------------

DROP TABLE IF EXISTS `todos`;

CREATE TABLE `todos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(11) unsigned NOT NULL,
  `assigned_to` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` date NOT NULL,
  `due_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `assigned_to` (`assigned_to`),
  CONSTRAINT `todos_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `todos_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `todos` WRITE;
/*!40000 ALTER TABLE `todos` DISABLE KEYS */;

INSERT INTO `todos` (`created_by`, `assigned_to`, `title`, `description`, `created_at`, `due_date`)
VALUES
	(2,2,'Learn PHP','Learn the Web Dev class content','2020-09-05','2020-10-25'),
  (2,3,'Learn the Slim Framework','Read the Slim documentation','2020-10-25','2020-10-31'),
  (3,3,'Learn Twig','Read the Twig documentation','2020-10-31','2020-11-03'),
  (3,2,'Learn the MVC Architecture','Watch a tutorial about MVC, Slim in PHP','2020-11-03','2020-11-05');

/*!40000 ALTER TABLE `todos` ENABLE KEYS */;
UNLOCK TABLES;


# Display user table
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

/*username: root / password: root */;
/*username: adonis / password: adonis */;
/*username: mika / password: mika */;
INSERT INTO `users` (`id`, `username`, `password`)
VALUES
	(1,'root','$2y$10$xKhvUPEEi/MXFbYIDZJOAu/8V9HyujSYxp9Vo9OpJz0RNuMIo4Ls6'),
	(2,'adonis','$2y$10$j8.U4sS4up4P8GCWyBa/sucbMtxST2iLJfSuzMak99sB0q8WLqbSm'),
  (3,'mika','$2y$10$esNVoV7zIgfz8i.HW7aXgeu7wvwNVl58crLkES1J3Emd5pb2vvEnC');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
