-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2024 at 04:08 AM
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
-- Database: `electives`
--

-- --------------------------------------------------------

--
-- Table structure for table `oe`
--

CREATE TABLE `oe` (
  `roll` tinytext DEFAULT NULL,
  `oe1` tinytext DEFAULT '-',
  `oe2` tinytext DEFAULT '-',
  `oe3` tinytext DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oe`
--

INSERT INTO `oe` (`roll`, `oe1`, `oe2`, `oe3`) VALUES
('21r11a05x1', '1', '3', '-'),
('21r11a05x2', '2', '3', '-'),
('21r11a05x3', '2', '4', '-'),
('22r15a05l1', '1', '4', '-'),
('20r11a05x1', '-', '-', '5');

-- --------------------------------------------------------

--
-- Table structure for table `oes`
--

CREATE TABLE `oes` (
  `id` tinytext DEFAULT NULL,
  `subject` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oes`
--

INSERT INTO `oes` (`id`, `subject`) VALUES
('1', 'oes1'),
('2', 'oes2'),
('3', 'oes3'),
('4', 'oes4'),
('5', 'oes5'),
('6', 'oes6'),
('7', 'oes7');

-- --------------------------------------------------------

--
-- Table structure for table `pe`
--

CREATE TABLE `pe` (
  `roll` tinytext DEFAULT NULL,
  `pe1` tinytext DEFAULT '-',
  `pe2` tinytext DEFAULT '-',
  `pe3` tinytext DEFAULT '-',
  `pe4` tinytext DEFAULT '-',
  `pe5` tinytext DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pe`
--

INSERT INTO `pe` (`roll`, `pe1`, `pe2`, `pe3`, `pe4`, `pe5`) VALUES
('21r11a05x1', '1', '3', '-', '-', '-'),
('21r11a05x2', '2', '3', '-', '-', '-'),
('21r11a05x3', '2', '4', '-', '-', '-'),
('20r11a05x1', '-', '-', '6', '8', '10'),
('22r15a05l1', '1', '4', '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pes`
--

CREATE TABLE `pes` (
  `id` tinytext DEFAULT NULL,
  `subject` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pes`
--

INSERT INTO `pes` (`id`, `subject`) VALUES
('1', 'pes1'),
('2', 'pes2'),
('3', 'pes3'),
('4', 'pes4'),
('5', 'pes5'),
('6', 'pes6'),
('7', 'pes7'),
('8', 'pes8'),
('9', 'pes9'),
('10', 'pes10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oe`
--
ALTER TABLE `oe`
  ADD UNIQUE KEY `roll` (`roll`) USING HASH;

--
-- Indexes for table `oes`
--
ALTER TABLE `oes`
  ADD UNIQUE KEY `id` (`id`) USING HASH;

--
-- Indexes for table `pe`
--
ALTER TABLE `pe`
  ADD UNIQUE KEY `roll` (`roll`) USING HASH;

--
-- Indexes for table `pes`
--
ALTER TABLE `pes`
  ADD UNIQUE KEY `id` (`id`) USING HASH;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
