-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2023 at 04:56 AM
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
-- Table structure for table `accomplishment_reports`
--

CREATE TABLE `accomplishment_reports` (
  `id` int(11) NOT NULL,
  `planned_activity` varchar(50) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `date_accomplished` varchar(50) NOT NULL,
  `budget` varchar(50) NOT NULL,
  `liquidations` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `name_of_org` varchar(50) NOT NULL,
  `date_submitted` varchar(50) DEFAULT NULL,
  `school_year` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accomplishment_reports`
--

INSERT INTO `accomplishment_reports` (`id`, `planned_activity`, `purpose`, `date_accomplished`, `budget`, `liquidations`, `remarks`, `name_of_org`, `date_submitted`, `school_year`, `status`) VALUES
(23, 'a', 'a', '2023-09-16', '1', 'IMG-6505175187f9b1.15958815.pdf', 'a', 'ETSO', '2023-09-16', '2022-2023', 'ongoing'),
(24, 'b', 'b', '2023-09-16', '1', 'IMG-6505175c674d99.23386176.pdf', 'b', 'ETSO', '2023-09-16', '2022-2023', 'ongoing'),
(25, 'intrams', 'a', '2023-12-25', '1000', 'IMG-650a955e139378.47690889.pdf', 'a', 'SICSSO', '2023-09-20', '2023-2024', 'ongoing');

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
  `status` varchar(50) NOT NULL DEFAULT 'activated',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `first_name`, `last_name`, `address`, `contact_no`, `email`, `status`, `password`) VALUES
(9, 'admin', 'main', 'admin', 'Tanza, Boac, Marinduque', '11111111111', 'admin@gmail.com', 'activated', '0cc175b9c0f1b6a831c399e269772661'),
(10, 'a', 'a', 'a', 'a', '1', 'a@gmail.com', 'deactivated', '0cc175b9c0f1b6a831c399e269772661'),
(11, '1', '1', '1', '1', '1', '1@gmail.com', 'activated', 'c4ca4238a0b923820dcc509a6f75849b');

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
  `introduce_yourself` longtext DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `number_of_votes` int(100) DEFAULT 0,
  `exp_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `position`, `first_name`, `last_name`, `year`, `photo_url`, `partylist`, `org_name`, `school_year`, `introduce_yourself`, `status`, `number_of_votes`, `exp_date`) VALUES
(310, 'President', '12', '12', 'first', 'IMG-6518ff831ddaa9.76566456.png', '1212', 'SICSSO', '2023-2024', ' 12', 'winner', 2, '2023-10-01T13:36'),
(311, 'Vice President', '21', '21', 'first', 'IMG-6518ff8d513e36.71613804.png', '21', 'SICSSO', '2023-2024', ' 21', 'winner', 3, '2023-10-01T13:36'),
(312, 'President', '44', '44', 'first', 'IMG-651904cb6e8f89.25223931.jpg', '4', 'SICSSO', '2023-2024', ' 44', 'deployed', 1, '2023-10-01T13:36'),
(313, 'President', '6', '6', 'first', 'IMG-651904d366c300.02171344.jpg', '6', 'SICSSO', '2023-2024', ' 6', 'deployed', 0, '2023-10-01T13:36'),
(314, 'President', '2', '2', 'first', 'IMG-651904dcdfa314.12210447.jpg', '2', 'SICSSO', '2023-2024', ' 2', 'deployed', 0, '2023-10-01T13:36');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`) VALUES
(16, 'BSIS'),
(17, 'Civil Engineering'),
(19, 'Computer Engineering'),
(20, 'Mechanical Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `id` int(11) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `year` varchar(100) DEFAULT NULL,
  `photo_url` varchar(100) DEFAULT NULL,
  `partylist` varchar(100) DEFAULT NULL,
  `org_name` varchar(100) DEFAULT NULL,
  `school_year` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `officers`
--

INSERT INTO `officers` (`id`, `position`, `first_name`, `last_name`, `year`, `photo_url`, `partylist`, `org_name`, `school_year`, `status`) VALUES
(141, 'President', 'a', 'a', 'first', 'IMG-650513fd0b46b7.07964422.png', 'a', 'ETSO', '2022-2023', NULL),
(142, 'President', 'andrei', 'monroyo', 'first', 'IMG-65080315771be3.52469214.jpg', 'a', 'SICSSO', '2022-2023', NULL),
(143, 'President', 'a', 'a', 'first', 'IMG-65080369ce03a1.40888141.jpg', 'a', 'SICSSO', '2022-2023', NULL),
(144, 'President', 'a', 'a', 'first', 'IMG-65082b8394a152.33117045.jpg', 'a', 'SICSSO', '2022-2023', NULL),
(145, 'Vice President', 'a', 'a', 'first', 'IMG-65082b8ce3cdb6.50759998.jpg', '2', 'SICSSO', '2022-2023', NULL),
(208, 'President', '234', '234', 'first', 'IMG-6515250b948b76.32636914.jpg', '243', 'SICSSO', '2025-2026', NULL),
(209, 'Vice President', '4', '23432', 'first', 'IMG-651525124fd837.99840284.jpg', '234', 'SICSSO', '2025-2026', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plan_of_activities`
--

CREATE TABLE `plan_of_activities` (
  `id` int(11) NOT NULL,
  `name_of_activity` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `venue` varchar(50) NOT NULL,
  `sponsors` varchar(50) NOT NULL,
  `nature_of_activity` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `beneficiaries` varchar(50) NOT NULL,
  `target_output` varchar(50) NOT NULL,
  `name_of_org` varchar(50) NOT NULL,
  `can_monitor` varchar(100) DEFAULT NULL,
  `date_submitted` varchar(50) DEFAULT NULL,
  `school_year` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plan_of_activities`
--

INSERT INTO `plan_of_activities` (`id`, `name_of_activity`, `date`, `venue`, `sponsors`, `nature_of_activity`, `purpose`, `beneficiaries`, `target_output`, `name_of_org`, `can_monitor`, `date_submitted`, `school_year`, `status`) VALUES
(27, 'a', '2023-09-02', 'a', 'a', 'a', 'a', 'a', 'a', 'SICSSO', NULL, '2023-09-02', '2023-2024', 'ongoing'),
(28, 'p', '2023-09-02', 'p', 'p', 'p', 'p', 'p', 'p', 'SICSSO', NULL, '2023-09-02', '2021-2022', 'ongoing'),
(31, 'a', '2023-09-16', 'a', 'a', 'a', 'a', 'a', 'a', 'ETSO', NULL, '2023-09-16', '2022-2023', 'ongoing'),
(32, 'b', '2023-09-16', 'b', 'b', 'b', 'b', 'b', 'b', 'ETSO', NULL, '2023-09-16', '2022-2023', 'ongoing'),
(34, 'Intrams', '2023-12-25', 'MSC', 'N/A', 'kahit ano', 'health', 'students', 'matambakan ng activities', 'SICSSO', NULL, '2023-09-20', '2023-2024', 'ongoing'),
(35, 'andrei', '2023-09-25', 'a', 'a', 'a', 'a', 'a', 'a', 'SICSSO', NULL, '2023-10-06', '2023-2024', 'ongoing'),
(36, 'intrams', '2023-11-08', 'MSC main campus', 'n/a', 'sports', 'for students to enjoy', 'students', 'awan haha', 'SICSSO', NULL, '2023-10-16', '2025-2026', 'submitted');

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
  `can_vote` varchar(100) DEFAULT ' ',
  `can_monitor` varchar(100) DEFAULT ' ',
  `can_see_result` varchar(100) DEFAULT ' ',
  `can_monitor_plan_of_activity` varchar(100) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'activated',
  `password` varchar(100) DEFAULT NULL,
  `if_voted` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `username`, `first_name`, `last_name`, `address`, `student_id`, `course`, `year_and_section`, `contact_no`, `email`, `can_vote`, `can_monitor`, `can_see_result`, `can_monitor_plan_of_activity`, `status`, `password`, `if_voted`) VALUES
(9, 'Neil Andrei', 'Neil Andrei', 'Monroyo', 'Bunganay, Boac, Marinduque', '20B0795', 'BSI/T', 'fourth', '09079610360', 'andreimonroyo0@gmail.com', '', '', 'SICSSO', NULL, 'activated', '0cc175b9c0f1b6a831c399e269772661', NULL),
(10, 'a', 'a', 'a', 'a', '1', 'a', 'first', '1', 'a@gmail.com', 'ETSO', ' ', ' ', NULL, 'activated', '0cc175b9c0f1b6a831c399e269772661', NULL),
(11, 'mang kanor', 'nailllll', 'monnnrooooyoo', 'bangbang', '111', 'di ko alam', '', '1', 'a@gmail.com', ' ', ' ', ' ', NULL, 'activated', NULL, NULL),
(12, 'q', 'q', 'q', 'q', 'q', 'q', 'q', '1', 'q@gmail.com', ' ', ' ', ' ', NULL, 'activated', NULL, NULL),
(13, 'andrei', 'andrei', 'monroyo', 'bunganay, boac, marinduque', 'a', 'a', 'a', '1', 'a@gmail.com', '', '', 'ETSO', NULL, 'activated', NULL, NULL),
(14, 'a', 'a', 'a', 'a', 'a', 'a', 'a', '1', 'a@gmail.com', '', '', 'ETSO', NULL, 'activated', '0cc175b9c0f1b6a831c399e269772661', NULL),
(15, 'marky', 'mark', 'manaog', 'bunganay, boac, marinduque', '20B0263', 'BSIT-Automotive', '4th', '01238721', 'mark@gmail.com', ' ', ' ', ' ', NULL, 'deactivated', NULL, NULL),
(16, '2', '2', '2', '2', '2', '2', '2', '2', '2@gmail.com', ' ', '', ' ', NULL, 'deactivated', 'c81e728d9d4c2f636f067f89cc14862c', NULL),
(17, '3', '3', '3', '3', '3', '3', 'first', '3', '3@gmail.com', ' ', '', ' ', NULL, 'activated', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', NULL),
(18, 'r', 'r', 'r', 'r', 'r', 'BSI/T', 'r', '1', 't@gmail.com', '', '', 'SICSSO', NULL, 'activated', '4b43b0aee35624cd95b910189b3dc231', NULL),
(19, '1', '1', '12', '2', '2', 'BSI/T', '1', '2', '2@gmail.com', 'SICSSO', ' ', ' ', NULL, 'activated', '0cc175b9c0f1b6a831c399e269772661', NULL),
(20, 'neil', 'neil andrei', 'monroyo', 'bunganay, boac, marinduque', '11111', 'BSI/T', 'first', '09079610360', 'andrei@gmail.com', 'SICSSO', '', 'SICSSO', NULL, 'activated', '0cc175b9c0f1b6a831c399e269772661', NULL);

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
  `status` varchar(50) NOT NULL DEFAULT 'activated',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_org`
--

INSERT INTO `student_org` (`id`, `name_of_org`, `college_of`, `adviser`, `contact_no`, `email`, `status`, `password`) VALUES
(14, 'SICSSO', 'CISC', 'Doreena magdangal', '09079610360', 'andreimonroyo@gmail.com', 'activated', '0cc175b9c0f1b6a831c399e269772661'),
(18, 'ENGSO', 'Engineering', 'kierven villuarell', '324293', 'kierven@gmail.com', 'activated', '0cc175b9c0f1b6a831c399e269772661');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accomplishment_reports`
--
ALTER TABLE `accomplishment_reports`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_of_activities`
--
ALTER TABLE `plan_of_activities`
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
-- AUTO_INCREMENT for table `accomplishment_reports`
--
ALTER TABLE `accomplishment_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `plan_of_activities`
--
ALTER TABLE `plan_of_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `student_org`
--
ALTER TABLE `student_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
