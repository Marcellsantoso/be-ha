<?php

-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2015 at 08:53 AM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hulx_shirt1`
--

-- --------------------------------------------------------

--
-- Table structure for table `sp_input_file`
--

CREATE TABLE IF NOT EXISTS `sp_input_file` (
  `file_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_filename` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `file_url` text COLLATE utf8_unicode_ci NOT NULL,
  `file_author` bigint(20) unsigned NOT NULL,
  `file_size` bigint(20) unsigned NOT NULL,
  `file_date` datetime NOT NULL,
  `file_downloads` int(10) unsigned NOT NULL,
  `file_folder_id` bigint(20) unsigned NOT NULL,
  `file_ext` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `file_isi` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
