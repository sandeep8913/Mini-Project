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
-- Database: `x`
--

-- --------------------------------------------------------

--
-- Table structure for table `slct`
--

CREATE TABLE `slct` (
  `year` varchar(1) NOT NULL,
  `sem` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slct`
--

INSERT INTO `slct` (`year`, `sem`) VALUES
('1', '1-1'),
('2', '2-1'),
('3', '3-1'),
('4', '4-1');

-- --------------------------------------------------------

--
-- Table structure for table `std`
--

CREATE TABLE `std` (
  `roll` text NOT NULL,
  `pass` text NOT NULL,
  `fee` int(7) NOT NULL DEFAULT 108000,
  `lib` int(7) NOT NULL DEFAULT 0,
  `fine` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `std`
--

INSERT INTO `std` (`roll`, `pass`, `fee`, `lib`, `fine`) VALUES
('20r11a04x1', '1231', 0, 0, 0),
('20r11a04x2', '1232', 0, 0, 0),
('20r11a05x1', '1231', 0, 0, 0),
('20r11a05x2', '1232', 0, 0, 0),
('21r11a04x1', '1231', 0, 0, 0),
('21r11a04x2', '1232', 0, 0, 0),
('21r11a05x1', '1231', 0, 0, 0),
('21r11a05x2', '1232', 1000, 3, 1000),
('21r15a04l1', '1231', 0, 0, 0),
('21r15a05l1', '1231', 0, 0, 0),
('22r11a04x1', '1231', 0, 0, 0),
('22r11a04x2', '1232', 0, 0, 0),
('22r11a05x1', '1231', 0, 0, 0),
('22r11a05x2', '1232', 0, 0, 0),
('22r15a04l1', '1231', 0, 0, 0),
('22r15a05l1', '1231', 0, 0, 0),
('23r11a04x1', '1231', 0, 0, 0),
('23r11a04x2', '1232', 0, 0, 0),
('23r11a05x1', '1231', 0, 0, 0),
('23r11a05x2', '1232', 0, 0, 0),
('23r15a04l1', '1231', 0, 0, 0),
('23r15a05l1', '1231', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `std`
--
ALTER TABLE `std`
  ADD PRIMARY KEY (`roll`(13));
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
