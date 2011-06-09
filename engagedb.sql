-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 07, 2011 at 09:08 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `engagedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tanswers`
--

CREATE TABLE IF NOT EXISTS `tanswers` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `ans1` varchar(11) DEFAULT NULL,
  `ans2` varchar(11) DEFAULT NULL,
  `ans3` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tanswers`
--


-- --------------------------------------------------------

--
-- Table structure for table `tmessages`
--

CREATE TABLE IF NOT EXISTS `tmessages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT NULL,
  `msg` text,
  `time` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `tmessages`
--



-- --------------------------------------------------------

--
-- Table structure for table `tpolls`
--

CREATE TABLE IF NOT EXISTS `tpolls` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `allowmulti` int(11) NOT NULL DEFAULT '0',
  `ans1` text,
  `ans2` text,
  `ans3` text,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tpolls`
--



-- --------------------------------------------------------

--
-- Table structure for table `ttopics`
--

CREATE TABLE IF NOT EXISTS `ttopics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ttopics`
--


