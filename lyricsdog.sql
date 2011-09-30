-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 30, 2011 at 09:56 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lyricsdog`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `alias` varchar(150) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `title`, `alias`, `created`) VALUES
(1, 'the cranberries', 'the cranberries', '2011-07-11 18:08:39'),
(2, 'slayer', 'slayer', '2011-07-11 18:11:57'),
(3, 'radiohead', 'radiohead', '2011-07-11 18:12:49'),
(4, '12 stones', '12 stones', '2011-09-30 21:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `lyrics`
--

CREATE TABLE IF NOT EXISTS `lyrics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search_engine_id` int(11) DEFAULT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `alias` varchar(150) DEFAULT NULL,
  `lyrics` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lyrics_artists` (`artist_id`),
  KEY `fk_lyrics_search_engines1` (`search_engine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `lyrics`
--


-- --------------------------------------------------------

--
-- Table structure for table `search_engines`
--

CREATE TABLE IF NOT EXISTS `search_engines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(150) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `search_engines`
--

INSERT INTO `search_engines` (`id`, `model_name`, `order`, `active`) VALUES
(1, 'EvilLyrics', 0, 0),
(2, 'Lyrdb', 0, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lyrics`
--
ALTER TABLE `lyrics`
  ADD CONSTRAINT `fk_lyrics_artists` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lyrics_search_engines1` FOREIGN KEY (`search_engine_id`) REFERENCES `search_engines` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
