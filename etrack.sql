-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2024 at 02:11 PM
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
  `venue` varchar(100) DEFAULT NULL,
  `sponsors` varchar(100) DEFAULT NULL,
  `nature_of_activity` varchar(100) DEFAULT NULL,
  `beneficiaries` varchar(100) DEFAULT NULL,
  `target_output` varchar(100) DEFAULT NULL,
  `name_of_org` varchar(50) NOT NULL,
  `date_submitted` varchar(50) DEFAULT NULL,
  `school_year` varchar(50) DEFAULT NULL,
  `remark` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(50) NOT NULL DEFAULT 'draft',
  `evaluated` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accomplishment_reports`
--

INSERT INTO `accomplishment_reports` (`id`, `planned_activity`, `purpose`, `date_accomplished`, `budget`, `liquidations`, `remarks`, `venue`, `sponsors`, `nature_of_activity`, `beneficiaries`, `target_output`, `name_of_org`, `date_submitted`, `school_year`, `remark`, `status`, `evaluated`) VALUES
(78, 'HYDRO FEST', 'To give the awards for winners in intrams', '2024-02-01', '1000', 'IMG-65b8b10c0b2f09.88322758.pdf', '111', 'GRANDSTAND', 'SICSO Faculty', 'for Entertainment', 'Students, faculty members, others.', 'Successful and fun night', 'SICSSO', '2024-01-30', '2024-2025', '', 'draft', '');

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
  `current_school_year` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `first_name`, `last_name`, `address`, `contact_no`, `email`, `status`, `current_school_year`, `password`) VALUES
(9, 'admin', 'main', 'admin', 'Tanza, Boac, Marinduque', '09641784151', 'admin@gmail.com', 'activated', '2023-2024', 'fdb925312f05f3a4c4495ef8d2fb465a'),
(22, 'Neil Andrei', 'Neil Andrei', 'Monroyo', 'Bunganay, Boac, Marinduque', '09641784151', 'andreimonroyo@gmail.com', 'activated', '2023-2024', 'fdb925312f05f3a4c4495ef8d2fb465a');

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
  `max_winners` int(100) NOT NULL DEFAULT 1,
  `number_of_votes` int(100) DEFAULT 0,
  `exp_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `position`, `first_name`, `last_name`, `year`, `photo_url`, `partylist`, `org_name`, `school_year`, `introduce_yourself`, `status`, `max_winners`, `number_of_votes`, `exp_date`) VALUES
(548, 'President', 'a', 'a', 'first', 'IMG-659b8eef10b929.59856874.jpg', 'a', 'SENGSO', '2024-2025', ' a', 'deployed', 1, 23, '2024-01-08T15:59'),
(549, 'President', 'b', 'b', 'first', 'IMG-659b8ef9178516.03990964.jpg', 'b', 'SENGSO', '2024-2025', ' b', 'deployed', 1, 43, '2024-01-08T15:59'),
(550, 'President', 'Jospher', 'Luha', 'second', 'IMG-659f75e5707ec6.89279450.jpg', 'Sulong', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality.', 'winner', 1, 43, NULL),
(551, 'Vice President', 'John David', 'Nepomuceno', 'second', 'IMG-659f75fd8711c9.40337993.jpg', 'Sulong', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality.', 'winner', 1, 23, NULL),
(552, 'Secretary', 'Trishia', 'Natolla', 'second', 'IMG-659f760a812b14.87495599.jpg', 'Sulong', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality. ', 'winner', 1, 32, NULL),
(553, 'Treasurer', 'Jannelle', 'Atienza', 'second', 'IMG-659f7623b6d857.59556821.jpg', 'Sulong', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality.', 'winner', 1, 35, NULL),
(554, 'Auditor', 'Carl Angel', 'Urtal', 'second', 'IMG-659f777bdd3680.80022866.jpg', 'Sulong', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality.', 'winner', 1, 63, NULL),
(555, 'President', 'Kilbert', 'Villanueva', 'second', 'IMG-659f77d6e145b6.84383866.jpg', 'Mandin', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality. ', NULL, 1, 43, NULL),
(556, 'Vice President', 'John Raven', 'Mabutot', 'second', 'IMG-659f77fa560877.40057863.jpg', 'Sulong', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality.', 'winner', 1, 42, NULL),
(557, 'Secretary', 'Jallien Mae ', 'Resaba', 'second', 'IMG-659f7811e38369.97574731.jpg', 'Sulong', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality.', NULL, 1, 13, NULL),
(558, 'Auditor', 'Jamie', 'Solina', 'second', 'IMG-659f782182b328.02286730.jpg', 'Sulong', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality.', NULL, 1, 13, NULL),
(559, 'Auditor', 'Lynsey Miles', 'de Mesa', 'second', 'IMG-659f78405ab510.44972782.jpg', 'Sulong', 'SICSSO', '2024-2025', ' I\'m Jospher Luha from Tanza, Boac, Marinduque.\r\nI\'m a former Secretary of SICSSO.\r\nI envision SICSSO as a [briefly describe your vision for the organization]. Together, we can [mention a positive change or improvement you want to bring about]. I am not just asking for your vote; I am asking for your collaboration and support in turning this vision into reality.', NULL, 1, 63, NULL);

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
(20, 'Mechanical Engineering'),
(22, 'BSI/T'),
(23, 'Computer Science'),
(24, 'educ major in art'),
(25, 'a'),
(26, 'b'),
(27, 'c'),
(28, 'd'),
(29, 'f');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_of_activities`
--

CREATE TABLE `evaluation_of_activities` (
  `id` int(11) NOT NULL,
  `name_of_org` varchar(100) NOT NULL,
  `name_of_activity` varchar(150) NOT NULL,
  `questionnaire` varchar(250) NOT NULL,
  `five` int(11) NOT NULL,
  `four` int(11) NOT NULL,
  `three` int(11) NOT NULL,
  `two` int(11) NOT NULL,
  `one` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL DEFAULT '',
  `status` varchar(100) NOT NULL,
  `draft` varchar(100) NOT NULL,
  `exp_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `evaluation_of_activities`
--

INSERT INTO `evaluation_of_activities` (`id`, `name_of_org`, `name_of_activity`, `questionnaire`, `five`, `four`, `three`, `two`, `one`, `comment`, `status`, `draft`, `exp_date`) VALUES
(108, 'SICSSO', '', 'does the event happen on the set schedule?', 0, 0, 0, 0, 0, '', '', 'draft', NULL),
(109, 'SICSSO', '', 'does the event happen smoothly with no intervene?', 0, 0, 0, 0, 0, '', '', 'draft', NULL);

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
(334, 'President', 'Jaspher', 'Luha', 'fourth', 'IMG-659b6c6396a747.89065032.jpg', 'Mandin', 'SICSSO', '2024-2025', NULL),
(335, 'Vice President', 'John Raven', 'Mabutot', 'fourth', 'IMG-659b6c8a8b2870.58663769.jpg', 'Mandin', 'SICSSO', '2024-2025', NULL),
(336, 'Secretary', 'Jallien Mae', 'Resaba', 'fourth', 'IMG-659b6c9faac132.36908001.jpg', 'Mandin', 'SICSSO', '2024-2025', NULL),
(337, 'Treasurer', 'Jamie', 'Solina', 'fourth', 'IMG-659b6cae717369.52878082.jpg', 'Mandin', 'SICSSO', '2024-2025', NULL),
(338, 'Auditor', 'Lynsey Miles', 'De Mesa', 'fourth', 'IMG-659b6ccb2bbd95.71354656.jpg', 'Mandin', 'SICSSO', '2024-2025', NULL),
(339, 'Sargeant at Arms', 'Reynan', 'Yap', 'fourth', 'IMG-659b8ae69cdcb5.80901182.jpg', 'Mandin', 'SICSSO', '2024-2025', NULL),
(340, 'Muse', 'Lee-Ann', 'Monterey', 'fourth', 'IMG-659b8bca550143.50718560.jpg', 'Mandin', 'SICSSO', '2024-2025', NULL),
(341, 'Peace Officer', 'Neil Andrei', 'Monroyo', 'fourth', 'IMG-659b8c1489c506.66240350.jpg', 'Sulong', 'SICSSO', '2024-2025', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plan_of_activities`
--

CREATE TABLE `plan_of_activities` (
  `id` int(11) NOT NULL,
  `activity_code` varchar(100) NOT NULL,
  `name_of_activity` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `venue` varchar(50) NOT NULL,
  `sponsors` varchar(50) NOT NULL,
  `nature_of_activity` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `beneficiaries` varchar(50) NOT NULL,
  `target_output` varchar(50) NOT NULL,
  `budget` varchar(10) NOT NULL,
  `name_of_org` varchar(50) NOT NULL,
  `can_monitor` varchar(100) DEFAULT NULL,
  `date_submitted` varchar(50) DEFAULT NULL,
  `school_year` varchar(50) DEFAULT NULL,
  `remark` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(50) NOT NULL DEFAULT 'draft',
  `evaluated` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plan_of_activities`
--

INSERT INTO `plan_of_activities` (`id`, `activity_code`, `name_of_activity`, `date`, `venue`, `sponsors`, `nature_of_activity`, `purpose`, `beneficiaries`, `target_output`, `budget`, `name_of_org`, `can_monitor`, `date_submitted`, `school_year`, `remark`, `status`, `evaluated`) VALUES
(106, '001', 'HYDRO FEST', '2024-02-01', 'GRANDSTAND', 'SICSO Faculty', 'for Entertainment', 'To give the awards for winners in intrams', 'Students, faculty members, others.', 'Successful and fun night', '1000', 'SICSSO', 'BSIS,BSI/T', '2024-01-30', '2024-2025', '', 'accomplished', ''),
(107, '002', 'Ball night', '2024-02-08', 'Gymnasium ', 'asdf', 'asdf', 'To reunite every students ', 'Students, faculty members, others.', 'Improve mental and physical capability of each pla', '1000', 'SICSSO', 'BSIS,BSI/T', '2024-01-30', '2024-2025', '', 'returned', 'evaluated');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `student_id` varchar(100) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `year_and_section` varchar(100) DEFAULT NULL,
  `contact_no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `can_vote` varchar(100) DEFAULT ' ',
  `voted` varchar(50) NOT NULL DEFAULT '',
  `can_monitor` varchar(100) DEFAULT ' ',
  `can_see_result` varchar(100) DEFAULT ' ',
  `can_monitor_plan_of_activity` varchar(100) DEFAULT NULL,
  `can_evaluate` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'activated',
  `password` varchar(100) DEFAULT NULL,
  `if_voted` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `first_name`, `last_name`, `student_id`, `course`, `address`, `year_and_section`, `contact_no`, `email`, `username`, `can_vote`, `voted`, `can_monitor`, `can_see_result`, `can_monitor_plan_of_activity`, `can_evaluate`, `status`, `password`, `if_voted`) VALUES
(123, 'Neil', 'Monroyo', '20B079', 'BSIS', 'Bunganay, Boac, Marinduque', '1st', '09079610360', 'andreimonroyo0@gmail.com', NULL, ' ', '', ' ', ' ', NULL, '', 'activated', 'fdb925312f05f3a4c4495ef8d2fb465a', NULL),
(130, 'mark', 'manaog', '202020', 'automotive', 'bunganay, boac', '4th', '9641784151', 'mark@gmail.com', NULL, ' ', '', ' ', ' ', NULL, '', 'activated', 'cd41287b93a9317b6b2d1da8bec1def1', NULL),
(131, 'raffy', 'lamonte', '212121', 'automotive', 'bunganay, boac', '3rd', '9174344151', 'raffy@gmail.com', NULL, ' ', '', ' ', ' ', NULL, '', 'activated', 'cd41287b93a9317b6b2d1da8bec1def1', NULL),
(132, 'austin', 'espiritu', '222222', 'electrical', 'amoingon, boac', '1st', '9178344151', 'austin@gmail.com', NULL, ' ', '', ' ', ' ', NULL, '', 'activated', 'cd41287b93a9317b6b2d1da8bec1def1', NULL),
(133, 'daniel', 'janda', '232323', 'liad', 'masiga, gasan', '2nd', '9178344151', 'daniel@gmail.com', NULL, ' ', '', ' ', ' ', NULL, '', 'activated', 'cd41287b93a9317b6b2d1da8bec1def1', NULL),
(134, 'bryan', 'hizole', '221111', 'bsit', 'laylay, boac', '3rd', '9079610360', 'bryanjay@gmail.com', NULL, ' ', '', ' ', ' ', NULL, '', 'activated', 'cd41287b93a9317b6b2d1da8bec1def1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_org`
--

CREATE TABLE `student_org` (
  `id` int(11) NOT NULL,
  `name_of_org` varchar(100) NOT NULL,
  `full_name_of_org` varchar(200) NOT NULL,
  `college_of` varchar(100) NOT NULL,
  `adviser` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `course_covered` varchar(100) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'activated',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_org`
--

INSERT INTO `student_org` (`id`, `name_of_org`, `full_name_of_org`, `college_of`, `adviser`, `contact_no`, `email`, `course_covered`, `status`, `password`) VALUES
(33, 'SICSSO', 'School of Information and Computing Sciences Student Organization', 'Information and Computing Sciences', 'Mrs. Doreena Joy Borja', '09641784151', 'sics.msc@gmail.com', 'BSIS,BSI/T', 'activated', 'fdb925312f05f3a4c4495ef8d2fb465a'),
(34, 'SENGSO', 'School of Engineering Student Organization', 'Engineering', 'Mr. Nilo Buenaventura', '09641784151', 'sengso.msc@gmail.com', 'Civil Engineering,Computer Engineering,Mechanical Engineering', 'activated', 'fdb925312f05f3a4c4495ef8d2fb465a');

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
-- Indexes for table `evaluation_of_activities`
--
ALTER TABLE `evaluation_of_activities`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=560;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `evaluation_of_activities`
--
ALTER TABLE `evaluation_of_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;

--
-- AUTO_INCREMENT for table `plan_of_activities`
--
ALTER TABLE `plan_of_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `student_org`
--
ALTER TABLE `student_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
