-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2022 at 02:17 PM
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
-- Database: `teaching`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_student_id` int(11) NOT NULL,
  `enrollment_subject_id` int(11) NOT NULL,
  `enrollment_started_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_student_id`, `enrollment_subject_id`, `enrollment_started_at`) VALUES
(4, 1, '2022-12-17'),
(5, 2, '2022-12-12'),
(13, 3, '2022-12-17'),
(14, 3, '2022-12-17');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_title` varchar(150) NOT NULL,
  `subject_code` varchar(100) NOT NULL,
  `subject_status` enum('ACTIVE','PENDED') NOT NULL DEFAULT 'ACTIVE',
  `subject_publisher` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_title`, `subject_code`, `subject_status`, `subject_publisher`) VALUES
(1, 'object oriented programming', 'CS-OOP', 'ACTIVE', 2),
(2, 'operating system', 'CS_OS', 'ACTIVE', 2),
(3, 'Genetic algorithms', 'CS_GA', 'ACTIVE', 12),
(5, 'desicion support', 'DS_DS', 'ACTIVE', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE `tutorials` (
  `tutorial_id` int(11) NOT NULL,
  `tutorial_subject_id` int(11) NOT NULL,
  `tutorial_publisher_id` int(11) NOT NULL,
  `tutorial_title` varchar(100) NOT NULL,
  `tutorial_uploaded_at` date NOT NULL DEFAULT current_timestamp(),
  `tutorial_type` enum('SLIDE','VIDEO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tutorials`
--

INSERT INTO `tutorials` (`tutorial_id`, `tutorial_subject_id`, `tutorial_publisher_id`, `tutorial_title`, `tutorial_uploaded_at`, `tutorial_type`) VALUES
(1, 1, 2, 'basics.pdf', '2022-12-03', 'SLIDE');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_number` varchar(11) NOT NULL,
  `user_image` varchar(100) NOT NULL,
  `user_type` enum('ADMIN','TEACHER','STUDENT') NOT NULL DEFAULT 'STUDENT',
  `user_status` enum('ACTIVE','PENDED') NOT NULL DEFAULT 'PENDED',
  `user_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_first_name`, `user_last_name`, `user_number`, `user_image`, `user_type`, `user_status`, `user_password`) VALUES
(1, 'ali', 'ashour', '01007346184', 'admin.jpg', 'ADMIN', 'ACTIVE', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(2, 'afaf', 'mohamed', '01119005218', 'teacher.jpg', 'TEACHER', 'ACTIVE', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(4, 'samah', 'ashour', '01093544836', '', 'STUDENT', 'ACTIVE', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(5, 'yousif', 'ashour', '01551489667', '', 'STUDENT', 'ACTIVE', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(12, 'ahmed', 'elshikh', '01234537890', 'teacher.jpg', 'TEACHER', 'ACTIVE', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(13, 'nady', 'emad', '01234567872', '', 'STUDENT', 'ACTIVE', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(14, 'twst', 'twstwd', '09123199801', '', 'STUDENT', 'ACTIVE', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_student_id`,`enrollment_subject_id`),
  ADD KEY `FK_ENROLLMENT_SUBJECT` (`enrollment_subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`),
  ADD KEY `FK_SUBJECT_TEACHER` (`subject_publisher`);

--
-- Indexes for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`tutorial_id`),
  ADD KEY `FK_TUTORIAL_PUBLISHER` (`tutorial_publisher_id`),
  ADD KEY `FK_TUTORIAL_SUBJECT` (`tutorial_subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_number` (`user_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `tutorial_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `FK_ENROLLMENT_STUDENT` FOREIGN KEY (`enrollment_student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ENROLLMENT_SUBJECT` FOREIGN KEY (`enrollment_subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `FK_SUBJECT_TEACHER` FOREIGN KEY (`subject_publisher`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD CONSTRAINT `FK_TUTORIAL_PUBLISHER` FOREIGN KEY (`tutorial_publisher_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TUTORIAL_SUBJECT` FOREIGN KEY (`tutorial_subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
