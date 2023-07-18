-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2023 at 09:50 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `first_name`, `last_name`, `address`, `contact_no`, `email`, `password`) VALUES
(7, 'a', 'a', 'a', 'a', '1', 'a@gmail.com', '0cc175b9c0f1b6a831c399e269772661'),
(8, 'Neil Andrei', 'Neil Andrei', 'Monroyo', 'Bunganay, Boac, Marinduque', '09079610360', 'andreimonroyo0@gmail.com', '0cc175b9c0f1b6a831c399e269772661');

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `id` int(11) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `year` varchar(100) DEFAULT NULL,
  `photo_url` varchar(100) DEFAULT NULL,
  `partylist` varchar(100) DEFAULT NULL,
  `org_name` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `introduce_yourself` varchar(300) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `number_of_votes` int(100) DEFAULT 0,
  `exp_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `year` varchar(100) DEFAULT NULL,
  `photo_url` varchar(100) DEFAULT NULL,
  `partylist` varchar(100) DEFAULT NULL,
  `org_name` varchar(100) DEFAULT NULL,
  `introduce_yourself` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `year_and_section` varchar(100) DEFAULT NULL,
  `contact_no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `can_vote` varchar(100) DEFAULT NULL,
  `can_monitor` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `if_voted` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `username`, `first_name`, `last_name`, `address`, `student_id`, `course`, `year_and_section`, `contact_no`, `email`, `can_vote`, `can_monitor`, `password`, `if_voted`) VALUES
(1, 'a', 'a', 'a', 'a', 'a', 'a', 'a', '1', 'a@gmail.com', NULL, NULL, '0cc175b9c0f1b6a831c399e269772661', NULL),
(2, 'neil', 'neil andrei', 'monroyo', 'bunganay', '09079610360', 'BSIT', '3D', '09079610360', 'andreimonroyo0@gmail.com', 'ITSO', '', '0cc175b9c0f1b6a831c399e269772661', NULL),
(3, 'mark', 'mark', 'mark', 'mark', 'mark', 'mark', 'mark', '9', 'mark@gmail.com', NULL, NULL, '0cc175b9c0f1b6a831c399e269772661', NULL),
(4, 'q', 'q', 'q', 'q', 'q', 'industrial technology', 'q', '1', 'q@gmail.com', 'ETSO', NULL, '7694f4a66316e53c8cdd9d9954bd611d', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_org`
--

CREATE TABLE `student_org` (
  `id` int(11) NOT NULL,
  `name_of_org` varchar(100) NOT NULL,
  `college_of` varchar(100) NOT NULL,
  `adviser` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_org`
--

INSERT INTO `student_org` (`id`, `name_of_org`, `college_of`, `adviser`, `contact_no`, `email`, `password`) VALUES
(4, 'SICSSO', 'College of Information Computing Science', 'Mrs. Doreena Borja', '09079610360', 'doreenaborja@gmail.com', 'a'),
(5, 'ETSO', 'A', 'A', '1', 'A@gmail.com', '7fc56270e7a70fa81a5935b72eacbe29'),
(6, 'ITSO', 'A', 'A', '1', 'A@gmail.com', '7fc56270e7a70fa81a5935b72eacbe29'),
(7, 'ESO', 'a', 'a', '1', 'a@gmail.com', '0cc175b9c0f1b6a831c399e269772661'),
(8, 'SPcES', 'a', 'a', '1', 'a@gmail.com', '0cc175b9c0f1b6a831c399e269772661');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_org`
--
ALTER TABLE `student_org`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_org`
--
ALTER TABLE `student_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
