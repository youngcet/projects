-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 07, 2020 at 06:46 PM
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
-- Table structure for table `pmail_accounts`
--

CREATE TABLE `gn_invoice_accounts` (
  `uuid` varchar(20) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `emailaddress` varchar(100) DEFAULT NULL,
  `pwd` varchar(500) DEFAULT NULL,
  `contact_number` varchar(13) DEFAULT NULL,
  `account_type` varchar(10) DEFAULT NULL,
  `account_number` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `trial_end_date` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--
-- Indexes for table `gn_invoice_accounts`
--
ALTER TABLE `gn_invoice_accounts`
  ADD KEY `uuid` (`uuid`),
  ADD KEY `emailaddress` (`emailaddress`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
