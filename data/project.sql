SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE `project` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `project`;

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_title` varchar(255) NOT NULL,
  `article_content` text NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  KEY `categorie_id` (`categorie_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

INSERT INTO `article` (`article_id`, `article_title`, `article_content`, `categorie_id`, `author_id`) VALUES
(5, 'test save', 'sdfgsdfg', 1, NULL),
(6, 'test save', 'sdfgsdfg', 1, NULL),
(7, 'test save', 'sdfgsdfg', 1, NULL),
(9, 'test save', 'sdfgsdfg', 1, 1),
(10, 'test save', 'sdfgsdfg', 1, 1),
(11, 'test save', 'sdfgsdfg', 1, 1),
(12, 'test save', 'sdfgsdfg', 1, 1),
(13, 'test save', 'sdfgsdfg', 1, 1),
(14, 'test save', 'sdfgsdfg', 1, 1),
(15, 'test save', 'sdfgsdfg', 1, 1),
(16, 'test save', 'sdfgsdfg', 1, 1),
(17, 'test save', 'sdfgsdfg', 1, 1),
(18, 'test save', 'sdfgsdfg', 1, 1),
(19, 'test save', 'sdfgsdfg', 1, 1),
(20, 'test save', 'sdfgsdfg', 1, 1),
(21, 'test save', 'sdfgsdfg', 1, 1),
(22, 'test save', 'sdfgsdfg', 1, 1),
(23, 'test save', 'sdfgsdfg', 1, 1),
(24, 'test save', 'sdfgsdfg', 1, 1),
(25, 'test save', 'sdfgsdfg', 1, 1),
(26, 'test save', 'sdfgsdfg', 1, 1),
(27, 'test save', 'sdfgsdfg', 1, 1),
(28, 'test save', 'sdfgsdfg', 1, 1),
(29, 'test save', 'sdfgsdfg', 1, 1),
(30, 'test save', 'sdfgsdfg', 1, 1),
(31, 'test save', 'sdfgsdfg', 1, 1),
(32, 'test save', 'sdfgsdfg', 1, 1),
(33, 'test save', 'sdfgsdfg', 1, 1),
(34, 'test save', 'sdfgsdfg', 1, 1),
(35, 'test save', 'sdfgsdfg', 1, 1),
(36, 'test save', 'sdfgsdfg', 1, 1),
(37, 'test save', 'sdfgsdfg', 1, 1),
(38, 'test save', 'sdfgsdfg', 1, 1),
(39, 'test save', 'sdfgsdfg', 1, 1),
(40, 'test save', 'sdfgsdfg', 1, 1),
(41, 'test save', 'sdfgsdfg', 1, 1),
(42, 'test save', 'sdfgsdfg', 1, 1),
(43, 'test save', 'sdfgsdfg', 1, 1),
(44, 'test save', 'sdfgsdfg', 1, 1),
(45, 'test save', 'sdfgsdfg', 1, 1),
(46, 'test save', 'sdfgsdfg', 1, 1),
(47, 'test save', 'sdfgsdfg', 1, 1),
(48, 'test save', 'sdfgsdfg', 1, 1),
(49, 'test save', 'sdfgsdfg', 1, 1),
(50, 'test save', 'sdfgsdfg', 1, 1),
(51, 'jklmjklm', 'jklmjklmkjlm', 2, 1),
(52, 'jklmjklmjklm', 'jklmjklmjklmjklmjklm', 3, 1),
(53, 'dfhdfghdfghdf', 'ghdfghdfghdfh', 3, 1);

CREATE TABLE IF NOT EXISTS `author` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_name` varchar(255) NOT NULL,
  `author_email` varchar(255) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `author` (`author_id`, `author_name`, `author_email`) VALUES
(1, 'Test', 'test@gmail.com');

CREATE TABLE IF NOT EXISTS `categorie` (
  `categorie_id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_name` varchar(255) NOT NULL,
  `categorie_parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`categorie_id`),
  KEY `categorie_parent_id` (`categorie_parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `categorie` (`categorie_id`, `categorie_name`, `categorie_parent_id`) VALUES
(1, 'Test', NULL),
(2, 'Test', NULL),
(3, 'Lorem', NULL);

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(200) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `user` (`user_id`, `user_login`, `user_password`) VALUES
(1, 'admin', '123456');


ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`categorie_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`author_id`) ON DELETE SET NULL;

ALTER TABLE `categorie`
  ADD CONSTRAINT `categorie_ibfk_1` FOREIGN KEY (`categorie_parent_id`) REFERENCES `categorie` (`categorie_id`);
