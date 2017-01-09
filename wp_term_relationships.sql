-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 02, 2017 at 05:16 PM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wordpress_intro`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

CREATE TABLE IF NOT EXISTS `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 2, 0),
(1, 3, 0),
(4, 6, 0),
(6, 2, 0),
(37, 3, 0),
(45, 8, 0),
(45, 12, 0),
(46, 8, 0),
(67, 2, 0),
(106, 1, 0),
(199, 8, 0),
(199, 12, 0),
(199, 13, 0),
(206, 7, 0),
(207, 7, 0),
(208, 7, 0),
(209, 7, 0),
(210, 8, 0),
(210, 12, 0),
(210, 13, 0),
(218, 14, 0),
(219, 15, 0),
(220, 16, 0),
(221, 17, 0),
(222, 18, 0),
(223, 19, 0),
(224, 20, 0),
(225, 21, 0),
(226, 22, 0),
(227, 23, 0),
(228, 24, 0),
(229, 25, 0),
(230, 26, 0),
(231, 27, 0),
(232, 28, 0),
(233, 29, 0),
(270, 31, 0),
(271, 31, 0),
(272, 31, 0),
(273, 31, 0),
(274, 31, 0),
(275, 31, 0),
(276, 31, 0),
(277, 31, 0),
(278, 31, 0),
(279, 31, 0),
(288, 42, 0),
(289, 33, 0),
(289, 35, 0),
(289, 42, 0),
(291, 33, 0),
(291, 35, 0),
(291, 42, 0),
(292, 33, 0),
(292, 35, 0),
(292, 42, 0),
(294, 33, 0),
(294, 35, 0),
(294, 42, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
