-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 07, 2020 at 06:47 PM
-- Server version: 5.6.45
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `permawer_p:rm@n3l!mk`
--

-- --------------------------------------------------------

--
-- Table structure for table `pmail_dashboard`
--

CREATE TABLE `gn_invoice_dashboard` (
  `account_number` varchar(10) NOT NULL,
  `January` int(11) NOT NULL,
  `February` int(11) NOT NULL,
  `March` int(11) NOT NULL,
  `April` int(11) NOT NULL,
  `May` int(11) NOT NULL,
  `June` int(11) NOT NULL,
  `July` int(11) NOT NULL,
  `August` int(11) NOT NULL,
  `September` int(11) NOT NULL,
  `October` int(11) NOT NULL,
  `November` int(11) NOT NULL,
  `December` int(11) NOT NULL,
  `totalMsgSent` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
