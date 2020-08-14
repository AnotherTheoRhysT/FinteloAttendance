-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2020 at 06:00 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fintelo_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `desc` mediumtext DEFAULT NULL,
  `activity_title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `date`, `desc`, `activity_title`) VALUES
(1, '2020-08-13 15:31:21', 'This is the actiity description for the HTML acitivity', 'HTML'),
(2, '2020-08-13 15:31:21', 'This is the activity description for the CSS activity', 'CSS');

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `id` int(11) NOT NULL,
  `assignment_name` varchar(50) NOT NULL,
  `desc` mediumtext DEFAULT NULL,
  `file_dir` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_submitted` datetime DEFAULT current_timestamp(),
  `student_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`id`, `assignment_name`, `desc`, `file_dir`, `date_created`, `date_submitted`, `student_id`, `activity_id`) VALUES
(1, 'HTML', NULL, '/assignments/carmelhtml/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 1, 1),
(2, 'HTML', NULL, '/assignments/johnpaulhtml/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 2, 1),
(3, 'HTML', NULL, '/assignments/jonmelhtml/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 3, 1),
(4, 'HTML', NULL, '/assignments/katehtml/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 4, 1),
(5, 'HTML', NULL, '/assignments/katrinalhtml/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 5, 1),
(6, 'CSS', NULL, '/assignments/carmelcss/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 1, 2),
(7, 'CSS', NULL, '/assignments/johnpaulcss/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 2, 2),
(8, 'CSS', NULL, '/assignments/jonmelcss/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 3, 2),
(9, 'CSS', NULL, '/assignments/katecss/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 4, 2),
(10, 'CSS', NULL, '/assignments/katrinalcss/', '2020-08-13 15:55:35', '2020-08-13 23:55:35', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `group_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `first_name`, `last_name`, `middle_name`, `sex`, `group_number`) VALUES
(1, 'Carmel', 'Mende', NULL, 'F', 2),
(2, 'John Paul', 'Reambonanza', NULL, 'M', 2),
(3, 'Jon Mel', 'Marquez', NULL, 'M', 1),
(4, 'Kate', 'Abatayo', NULL, 'F', 1),
(5, 'Katrina', 'Hisoler', NULL, 'F', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `is_admin`, `email`) VALUES
(1, 'rhys', '1234', 1, 'rhyscabonita@gmail.com'),
(2, 'ernest', '1234', 1, 'ernest@gmail.com'),
(3, 'froia', '1234', 0, 'froia@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `assignment_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
