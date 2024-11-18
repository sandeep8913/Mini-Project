-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2024 at 04:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbt3-1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cse`
--

CREATE TABLE `cse` (
  `roll` tinytext DEFAULT NULL,
  `ComputerNetworks` varchar(30) DEFAULT 'no',
  `ArtificialIntelligence` varchar(30) DEFAULT 'no',
  `oe1` varchar(30) DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cse`
--

INSERT INTO `cse` (`roll`, `ComputerNetworks`, `ArtificialIntelligence`, `oe1`) VALUES
('21r11a05x1', 'yes', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `ece`
--

CREATE TABLE `ece` (
  `roll` tinytext DEFAULT NULL,
  `sub1` varchar(30) DEFAULT 'no',
  `sub2` varchar(30) DEFAULT 'no',
  `oe2` varchar(30) DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ece`
--

INSERT INTO `ece` (`roll`, `sub1`, `sub2`, `oe2`) VALUES
('21r11a04x1', 'yes', 'yes', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cse`
--
ALTER TABLE `cse`
  ADD UNIQUE KEY `roll` (`roll`) USING HASH;

--
-- Indexes for table `ece`
--
ALTER TABLE `ece`
  ADD UNIQUE KEY `roll` (`roll`) USING HASH;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
