-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2024 at 03:55 AM
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
-- Database: `1-1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cse`
--

CREATE TABLE `cse` (
  `id` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cse`
--

INSERT INTO `cse` (`id`, `subject`, `date`, `time`) VALUES
('20ma11001', 'BasicEngineeringMathematics', '2024-07-01', '10:00:00'),
('20ph11003', 'AppliedPhysics', '2024-07-03', '10:00:00'),
('20cs11001', 'ProgrammingforProblemSolving-I', '2024-07-05', '10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ece`
--

CREATE TABLE `ece` (
  `id` tinytext DEFAULT NULL,
  `subject` tinytext DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ece`
--

INSERT INTO `ece` (`id`, `subject`, `date`, `time`) VALUES
('20en11001', 'English', '2024-07-01', '10:00:00'),
('20ma11001', 'Basic Engineering Mathematics', '2024-07-03', '10:00:00'),
('20ch11001', 'Chemistry', '2024-07-05', '10:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cse`
--
ALTER TABLE `cse`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ece`
--
ALTER TABLE `ece`
  ADD UNIQUE KEY `id` (`id`) USING HASH,
  ADD UNIQUE KEY `subject` (`subject`) USING HASH;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
